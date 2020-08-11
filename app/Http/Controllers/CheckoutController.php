<?php

namespace App\Http\Controllers;

use App\Cart;
use App\User;
use App\Order;
use App\Course;
use App\CourseUser;
use App\CourseOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;

class CheckoutController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    

    public function index()
    {
        $user_id =  Auth::id();

        $user = User::with('profile')->where('id', $user_id)->first();
        $cart = Cart::with('course')->where('user_id',$user_id)->get();
        
        return view('checkout', [
            'cart' => $cart,
            'user' => $user,
        ]);
    }

    public function checkout(Request $request)
    {
        $user = $request->user(); // Auth::user()
        $user_id = Auth::id();
        $cart = Cart::where('user_id', $user_id)->get();

        DB::beginTransaction();
        try {
            $order = Order::create([
                        'user_id' => $user_id,
                        'status' => 'pending',
                    ]);

           // $cart = Cart::where('user_id', $user_id)->get();
            $total = 0;
            foreach ($cart as $item) {
                CourseOrder::create([
                    'order_id' => $order->id,
                    'course_id' => $item->course_id,
                    'price' => $item->price,
                ]);
                $total += $item->price;
                
            }
            $returnName = 'checkout';
            DB::commit(); 

            return $this->paypal($order, $total , $returnName);

           /* Cart::where('user_id', $user_id)->delete();
            Cookie::queue(Cookie::make('cart_id', '', -60));

            foreach ($cart as $item) {
            $this->registerCourse($item->course_id);
            }*/

            return redirect()
                    ->route('course.showUserCourse')
                    ->with('success', __('Order #:id created and completed', ['id' => $order->id]));


        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }
    public function buynow(Request $request)
    {
        $user_id = Auth::id();
        $course_id = $request->course_id;

        DB::beginTransaction();
        try {
            $course = Course::findOrFail($course_id);
            $order = Order::create([
                        'user_id' => $user_id,
                        'status' => 'pending',
                    ]);

                CourseOrder::create([
                    'order_id' => $order->id,
                    'course_id' => $course->id,
                    'price' => $course->price,
                ]);
                $total = $course->price;
                $returnName = 'buynow';

            DB::commit(); 

            session()->put('course_id', $course->id);
            return $this->paypal($order, $total , $returnName);

            return redirect()
                    ->route('course.showCourse', [$course->id]);


        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }

    protected function paypal(Order $order, $total , $returnName)
    {
        $client = $this->payaplClient();
        $request = new OrdersCreateRequest();
        $request->prefer('return=representation');
        $request->body = [
                            "intent" => "CAPTURE",
                            "purchase_units" => [[
                                "reference_id" => $order->id,
                                "amount" => [
                                    "value" => $total,
                                    "currency_code" => "USD"
                                ]
                            ]],
                            "application_context" => [
                                "cancel_url" => url(route('paypal.cancel')),
                                "return_url" => $returnName == 'checkout' ? url(route('paypal.return')) : url(route('paypal.buynow.return')) 
                            ] 
                        ];
            try {
                $response = $client->execute($request);
                if ($response->statusCode == 201) {

                    session()->put('paypal_order_id', $response->result->id);
                    session()->put('order_id', $order->id);

                    foreach ($response->result->links as $link) {
                        if ($link->rel == 'approve') {
                            return redirect()->away($link->href);
                        }
                    }
                }
    
            } catch (Throwable $e) {
                return $e->getMessage();
            }
          return 'Unknown Error! ' . $response->statusCode;    

    }

    protected function payaplClient()
    {
        $config = config('services.paypal');
        $env = new SandboxEnvironment($config['client_id'], $config['client_secret']);
        $client = new PayPalHttpClient($env);

        return $client;
    }

    public function paypalReturn()
    {
        $paypal_order_id = session()->get('paypal_order_id');
        $request = new OrdersCaptureRequest($paypal_order_id);
        $request->prefer('return=representation');
        try {
            $response = $this->payaplClient()->execute($request);

            if ($response->statusCode == 201) {
                if (strtoupper($response->result->status) == 'COMPLETED') {
                    $id = session()->get('order_id');

                    $order = Order::findOrFail($id);
                    $order->status = 'completed';
                    $order->save();

                    session()->forget(['order_id', 'paypal_order_id']);

                    $cart = Cart::where('user_id', Auth::id())->get();
                    
                    foreach ($cart as $item) {
                    $this->registerCourse($item->course_id);
                    }
                    
                    Cart::where('user_id', Auth::id())->delete();
                    Cookie::queue(Cookie::make('cart_id', '', -60));
        
                    //event(new OrderCompleted());

                    return redirect()
                        ->route('course.showUserCourse')
                        ->with('success', __('Order #:id created and completed', ['id' => $order->id]));
                }
            }
        } catch (Throwable $e) {
            return $e->getMessage();
        }

    }

    public function paypalBuynowReturn()
    {
        $paypal_order_id = session()->get('paypal_order_id');
        $request = new OrdersCaptureRequest($paypal_order_id);
        $request->prefer('return=representation');
        try {
            $response = $this->payaplClient()->execute($request);

            if ($response->statusCode == 201) {
                if (strtoupper($response->result->status) == 'COMPLETED') {
                    $id = session()->get('order_id');

                    $order = Order::findOrFail($id);
                    $order->status = 'completed';
                    $order->save();

                    session()->forget(['order_id', 'paypal_order_id']);

                    $course_id = session()->get('course_id');
                    $this->registerCourse($course_id);
        
                    //event(new OrderCompleted());

                    return redirect()
                    ->route('course.showCourse', [$course_id]);
                }
            }
        } catch (Throwable $e) {
            return $e->getMessage();
        }

    }

    public function paypalCancel()
    {
        $id = session()->get('order_id');
        $order = Order::findOrFail($id);
        $order->status = 'canceled';
        $order->save();

        return redirect()
                ->route('course.showUserCourse')
                ->with('success', __('Order #:id created and completed', ['id' => $order->id]));

    }

    public function registerCourse($id)
    {
        $user_id = Auth::id();
        DB::beginTransaction();
        try {

            CourseUser::create([
                'user_id' => $user_id,
                'course_id' => $id,
            ]);

            DB::table('users_permissions')->insertOrIgnore([
                ['user_id' => $user_id, 'permission' => 'courses.getStudent'],
            ]);
          
            DB::commit();
        } catch (Throwable $e) {
                DB::rollBack();
                return $e->getMessage();
        }


    }

}

<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Course;
use Ramsey\Uuid\Uuid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class CartController extends Controller
{
    public function index()
    {
        $user_id = Auth::id();

        $cart = Cart::with('course')
            ->where('id', $this->getCartId())
            ->when($user_id, function($query, $user_id) {
                $query->where('user_id', $user_id)->orWhereNull('user_id');
            })
            ->get();
        return view('cart', [
            'cart' => $cart,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'course_id' => 'required|int|exists:courses,id',
        ]);

        $course = Course::findOrFail($request->post('course_id'));

        Cart::updateOrCreate([
            'id' => $this->getCartId(),
            'user_id' => Auth::id(),
            'course_id' => $course->id,
        ], [
            'price' => $course->price,
        ]);

        return redirect()
            ->route('cart')
            ->with('success', __('Course :name added to cart!', [
                'name' => $course->title,
            ]));
    }

    public function delete(Request $request,  $id)
    {

         Cart::where('id', $id)->where('course_id', $request->course_id)->delete();
            
        return response()->json(['success'=>"Item removed Successfully."]);

    }

    protected function getCartId()
    {
        $request = request();
        $id = $request->cookie('cart_id');
        if (!$id) {
            $uuid = Uuid::uuid1();
            $id = $uuid->toString();
            Cookie::queue(Cookie::make('cart_id', $id, 43800));
        }
        
        return $id;
    }
}

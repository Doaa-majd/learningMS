<?php

namespace App\Http\Controllers\Admin;

use App\Course;
use App\Lecture;
use App\Section;
use App\CourseUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny',Course::class);
        $courses = [];
        if(Auth::user()->type == 'admin'){
         $courses = Course::join('categories', 'categories.id', '=', 'courses.category_id')
            ->select('courses.*', 'categories.name as category_name','categories.id as category_id')
            ->paginate(3);
        }

        if(Auth::user()->type == 'instructor'){
          $courses = Course::with('category')->whereHas('courseUsers', function($q)
            {
                $q->where('user_id', Auth::id())
                ->where('user_status', 'instructor');
            })->paginate(3);
        }

        return view('admin.courses.index')->with('courses',$courses);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create',Course::class);
        return view('admin.courses.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create',Course::class);

        $this->checkRequest($request);

       /* $image_path = null;
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $image = $request->file('image');
            $image_path = $image->store('courses', 'images');
        }*/

        if($request->img64){
           // $request->img64 will return like data:image/png;base64,iVBORw0KGgoA.... so to get extention
                $name = time().'.' . explode('/', explode(':', substr($request->img64, 0, strpos($request->img64, ';')))[1])[1];
                \Image::make($request->img64)->save(public_path('images/courses/').$name);
        }

        $data = $request->except(['image','img64']);  //except file input and hidden input for base64
        $data['image'] = 'courses/'.$name; //pass converted img path after encoded
        //return dd($data);

        DB::beginTransaction();
        try {
            $course = Course::create($data);
            
            $section = Section::create([
                'name' => 'Introduction',
                'course_id' => $course->id,
            ]);
            Lecture::create([
                'name' => 'Introduction',
                'video' => 'yourvideo.mp4',
                'course_id' => $course->id,
                'section_id' => $section->id,
            ]);
            
            CourseUser::create([
                'user_id' => Auth::id(),
                'course_id' => $course->id,
                'user_status' =>'instructor',
            ]);
            
            DB::commit();

            return Redirect::route('admin.courses.show',$course->id )
            ->with('alert.success', "Course ({$course->title}) created!");

        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    } 

    protected function checkRequest(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255|min:3',
            'sub_title' => 'required|string|max:255|min:6',
            'category_id' => 'required|int|exists:categories,id',
            'languge' => 'required|string|max:50|min:3',
            'price' => 'required|numeric|min:0',
            'image' => 'image',
            'status' => 'required|string|in:published,draft',
            'description' => 'required|string|max:1500|min:10',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Course $course)
    {
       // $course = Course::where('id', '=' ,$id)->first();
       $this->authorize('view', $course);
        return view('admin.courses.show')->with('course',$course);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Course $course)
    {
        //$course = Course::findOrFail($id);
        $this->authorize('update', $course);

        $this->checkRequest($request);

        $data = $request->except(['image','img64']); 
        if($request->img64){
            // $request->img64 will return like data:image/png;base64,iVBORw0KGgoA.... so to get extention
                 $name = time().'.' . explode('/', explode(':', substr($request->img64, 0, strpos($request->img64, ';')))[1])[1];
                 \Image::make($request->img64)->save(public_path('images/courses/').$name);
                 $data['image'] = 'courses/'.$name; 
                
                $courseImg = public_path('images/').$course->image;
                if(file_exists($courseImg)){
                    @unlink($courseImg);
                }

         } else{
            $data['image'] = $course->image; 
         }
         $course->update($data);


        return Redirect::route('admin.courses.show',$course->id )
        ->with('alert.success', "Course ({$course->title}) Updated!");
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course $course)
    {
       //$course = Course::findOrFail($id);
       $this->authorize('delete', $course);
       $course->delete();
        if ($course->image) {
            //unlink(public_path('images/' . $product->image));
            Storage::disk('images')->delete($course->image);
        }
        return response()->json(['url'=>url('/admin/courses')]);
    }

}

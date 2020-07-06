<?php

namespace App\Http\Controllers\Admin;

use App\Course;
use App\Lecture;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class LectureController extends Controller
{
    public function content($id)
    {
        //$course = Course::where('id', '=' ,$id)->first();

        $course = Course::where('id', '=' ,$id)->with('sections.lectures')->first();
        //return $course;
        return view('admin.courses.content')->with('course',$course);
    }

    public function store(Request $request){
        
        $request->validate([
            'name' => 'required|string|max:255|min:3',
            'course_id' => 'required|numeric|exists:courses,id',
            'section_id' => 'required|numeric|exists:sections,id',
        ]);

        $data = $request->except(['video']); 
        if($request->video){

            if (preg_match('/^data:video\/(\w+);base64,/', $request->video)) { //check if type video
                $name = 'Course-'.$request->course_id.'-'.$request->name.'.' . explode('/', explode(':', substr($request->video, 0, strpos($request->video, ';')))[1])[1];
                $videoData = substr($request->video, strpos($request->video, ',') + 1);
            
                $videoData = base64_decode($videoData);
                Storage::disk('videos')->put($name, $videoData);
                //dd("stored");
            }
        }
        $data['video'] = $name;
        $lecture = Lecture::create($data);

        return response()->json(['success'=>"Lecture Created successfully.", 'lecture' => $lecture]);


    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|min:3',
        ]);

        $lecture = Lecture::findOrFail($request->lecture_id);

        if($request->video){

            if (preg_match('/^data:video\/(\w+);base64,/', $request->video)) { //check type of video
                $name = 'Course-'.$lecture->course_id.'-'.$request->name.'.' . explode('/', explode(':', substr($request->video, 0, strpos($request->video, ';')))[1])[1];
                $videoData = substr($request->video, strpos($request->video, ',') + 1);
            
                $videoData = base64_decode($videoData);
                Storage::disk('videos')->put($name, $videoData);

                $oldVideo = public_path('videos/').$lecture->video;
                if(file_exists($oldVideo)){
                    @unlink($oldVideo);
                }

            }
        }else{
            $name = $lecture->video;
        }

        $lecture->update([
            'name' => $request->name,
            'video' => $name,
            ]);

        return response()->json(['success'=>"Lecture Updated successfully.", 'lecture' => $lecture]);        
    }

    public function delete($id)
    {
       $lecture = Lecture::findOrFail($id);
       $lecture->delete();

       $video_path = public_path('videos/').$lecture->video;
        if(file_exists($video_path)){
            @unlink($video_path);
        }
       
        return response()->json('Lecture Deleted ');
    }

}

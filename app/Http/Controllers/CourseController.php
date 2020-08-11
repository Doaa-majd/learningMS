<?php

namespace App\Http\Controllers;

use App\User;
use App\Course;
use App\Rating;
use App\Lecture;
use App\Profile;
use App\CourseUser;
use App\LectureUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    public function show($id)
    {
       $course = Course::where('id' ,$id)->with('category','sections.lectures')->first();
       $instructor = Profile::where('user_id', $course->courseUsers[0]->user_id )->first();

        return view('courses.show', [
            'course' => $course,
            'instructor' => $instructor,
        ]);
    }

    public function showUserCourse()
    {
       $courses =  Course::whereHas('courseUsers', function($q)
                {
                    $q->where('user_id', Auth::id());
                })->get();

        return view('courses.showAllCourses', [
            'courses' => $courses,
        ]);  
    }


    public function enrollCourse($id)
    {//show course when user click enroll course --action for the first time.
        
        $course = $this->getCourse($id);

        $video_path= $course->sections[0]->lectures[0]->video;

        $rate = $this->getCourseRate($course->rating);

        $instructor = Profile::where('user_id', $course->courseUsers[0]->user_id )->first();

        $user_id = Auth::id();

        DB::beginTransaction();
        try {

            CourseUser::create([
                'user_id' => $user_id,
                'course_id' => $course->id,
            ]);

            DB::table('users_permissions')->insertOrIgnore([
                ['user_id' => $user_id, 'permission' => 'courses.getStudent'],
            ]);
          
            DB::commit();
        } catch (Throwable $e) {
                DB::rollBack();
                return view('courses.show', [
                    'course' => $course,
                ]);
           throw $e;
        }


        return view('courses.showCourse', [
            'course' => $course,
            'video_path' => $video_path,
            'rating' => $rate,
            'instructor' => $instructor,
        ]);
    }

    public function showCourse(Course $course)
    { // show course when go to course button clicked -- not enroll button
        $this->authorize('StudentView', $course);

       return $this->getCourseInfo($course->id);

    }

    public function showLecture($cid, $lid)
    {// when user click on lectures links

        return $this->getCourseInfo($cid, $lid);
    }

    public function getCourseInfo($course_id, $lecture_id = 0)
    {
        $course = $this->getCourse($course_id);
        
        if($lecture_id)
        {
            // get video path for Lecture by it's id
            $lecture = Lecture::where('id' ,$lecture_id)->first();
            $video_path= $lecture->video;
        }else{
            // get the first video path to show by default 
            $video_path= $course->sections[0]->lectures[0]->video;

        }

        //  for rating section
        $rate = $this->getCourseRate($course->rating);
      
        // get instructor info 
         $instructor = Profile::where('user_id', $course->courseUsers[0]->user_id )->first();

        return view('courses.showCourse', [
            'course' => $course,
            'video_path' => $video_path,
            'rating' => $rate,
            'instructor' => $instructor,
        ]);
    }

    public function getCourse($course_id)
    {
        return $course = Course::where('id' ,$course_id)
                    ->with('category', 'rating','questions','sections.lectures')
                    ->with(['courseUsers' => function($query) {
                        $query->where('user_status', 'instructor');
                    }])->first();
    }

    public function getCourseRate($course_rating)
    {
        $ratting_array = [];
        foreach($course_rating as $key => $ratting)
        {
            $ratting_array[$key] = $ratting->rating_num; // to store rating number in array
        }
         $count = count($course_rating);
        $rate = array_count_values($ratting_array); // count occurance of each element in array

        foreach($rate as $key => $ratting)
        {
            $rate[$key] = floor( $ratting / $count * 100 ); // override the rate array with percentage  
        }
        
        return $rate;
    }

    public function completeLecture(Request $request)
    {
        $course_id = $request->course_id;
        LectureUser::create([
            'user_id' => Auth::id(),
            'course_id' => $course_id,
            'lecture_id' => $request->lecture_id,
        ]);

        $progress = User::userProgress($course_id);

        return response()->json(['success'=>"Lecture completed.", 'progress' => $progress]);

    }

    public function uncompleteLecture(Request $request)
    {
        $course_id = $request->course_id;
        $lecture_id = $request->lecture_id;

        LectureUser::where('user_id' , Auth::id())
        ->where('course_id', $course_id)
        ->where('lecture_id', $lecture_id)
        ->delete();

        $progress = User::userProgress($course_id);

        return response()->json(['success'=>"Lecture uncompleted.", 'progress' => $progress]);
    }

    public function rating(Request $request)
    {
        $request->validate([
            'rating_num' => 'required|int|between:1,5',
            'course_id' => 'required|int|exists:courses,id',
        ]);

        Rating::updateOrCreate([
            'user_id' => Auth::id(),
            'course_id' => $request->course_id,
        ], [
            'rating_num' => $request->rating_num,
        ]);

        return response()->json(['success'=>" rating inserted successfully."]);
    }
    
    public function courseCategory($id)
    {
        $courses = Course::where('category_id' ,$id)->get();
        return view('courses.showAllCourses', [
            'courses' => $courses,
        ]);  
    }
}

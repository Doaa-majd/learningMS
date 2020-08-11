<?php

namespace App;

use App\Section;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'title' , 'sub_title' ,'category_id' ,'image', 'languge' ,'description' ,'price', 'status'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id','id');
    }    

    public function sections()
    {
        return $this->hasMany(Section::class, 'course_id','id');
    }

    public function lectures()
    {
        return $this->hasMany(Lecture::class, 'course_id','id');
    }

    public function courseUsers()
    {
        return $this->hasMany(CourseUser::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'course_users');
    }

    public function questions()
    {
        return $this->hasMany(Question::class, 'course_id','id');
    }

    public function rating()
    {
        return $this->hasMany(Rating::class);
    }

    // return the user id of course instructor
    // to test by CoursePolicy 
    public function getUserInstructorId($course_id)
    {
        $course_user =  CourseUser::where('course_id', $course_id)->where('user_status', 'instructor')->first();
       if ($course_user){
        return $course_user->user_id;
     }else{
         return 0;
     }
    }
    public function getUserStudentId($course_id)
    {
       $course_user = CourseUser::where('course_id', $course_id)->where('user_id', Auth::id())->first();
       if ($course_user){
          return $course_user->user_id;
       }else{
           return 0;
       }

    }

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'course_orders')
            ->using(CourseOrder::class)
            ->withPivot([
                'price'
            ]);
    }

    public function orderedCourses()
    {
        return $this->hasMany(CourseOrder::class);
    }


}

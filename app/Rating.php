<?php

namespace App;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $guarded = [];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public static function getCoursRate($course_id)
    {
       $rating= Rating::where('course_id', $course_id)->avg('rating_num');
        return number_format($rating , 1, '.', '');
    }
    


}

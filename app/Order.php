<?php

namespace App;

use App\User;
use App\Course;
use App\CourseOrder;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = [];

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_orders')
            ->using(CourseOrder::class)
            ->withPivot([
                'price'
            ])
            ->as('course_orders');
    }

    public function coursesOrder()
    {
        return $this->hasMany(CourseOrder::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

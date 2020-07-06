<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    protected $fillable = [
        'name' , 'course_id'
    ];

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id','id');
    }

    public function lectures()
    {
        return $this->hasMany(Lecture::class, 'section_id','id');
    }
}

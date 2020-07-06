<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lecture extends Model
{
    protected $fillable = [
        'name' , 'course_id', 'section_id', 'video','file'
    ];

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id','id');
    }

    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id','id');
    }



}

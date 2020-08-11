<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $guarded = [];

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id','id');
    }

    public function replies()
    {
        return $this->hasMany(Question::class, 'parent_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

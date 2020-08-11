<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class LectureUser extends Pivot
{
    protected $guarded = [];

    protected $table = 'lecture_users';
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function course()
    {
        return $this->belongsTo(Lecture::class);
    }
}

<?php

namespace App;

use App\Section;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'title' , 'sub_title' ,'category_id' ,'image', 'languge' ,'description' ,'price', 'status'
    ];

    public function sections()
    {
        return $this->hasMany(Section::class, 'course_id','id');
    }

    public function lectures()
    {
        return $this->hasMany(Lecture::class, 'course_id','id');
    }
}

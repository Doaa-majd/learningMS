<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'type',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function courseUsers()
    {
        return $this->hasMany(CourseUser::class);
    }

    public function lectureUsers()
    {
        return $this->hasMany(LectureUser::class);
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_users');
    }

    public static function userProgress($course_id)
    {
        $course_LectureNo = Course::where('id' ,$course_id)->withCount('lectures')->first()->lectures_count;
        $completed_LectureNo = LectureUser::where('user_id' , Auth::id())->where('course_id', $course_id)->get()->Count();
        return $completed_LectureNo / $course_LectureNo * 100;
    }

    public function questions()
    {
        return $this->hasMany(Question::class, 'user_id','id');
    }

    public function hasPermission($name)
    {
        return DB::table('users_permissions')
                ->where('user_id', $this->id)
                ->where('permission', $name)
                ->count();
    }

    public function profile()
    {
        return $this->hasOne(Profile::class, 'user_id', 'id')->withDefault();
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function cart()
    {
        return $this->hasMany(Cart::class);
    }
}

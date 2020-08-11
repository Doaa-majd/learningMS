<?php

namespace App\Policies;

use App\Course;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class CoursePolicy
{
    use HandlesAuthorization;


    public function before(User $user, $ability)
    {
        if ($user->type == 'admin') {
            return true;
        }
    }

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermission('courses.index');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\Course  $course
     * @return mixed 
     */
    public function view(User $user, Course $course)
    {
        if ($course->getUserInstructorId($course->id) != $user->id) {
            return Response::deny('You are not the course instructor!');
        }
        return $user->hasPermission('courses.view');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\Course  $course
     * @return mixed 
     */
    public function StudentView(User $user, Course $course)
    {
        if ($course->getUserStudentId($course->id) != $user->id) {
            return Response::deny('Enroll to show this course !');
        }
        return $user->hasPermission('courses.getStudent');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermission('courses.create');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\Course  $course
     * @return mixed
     */
    public function update(User $user, Course $course)
    {
        if ($course->getUserInstructorId($course->id) != $user->id) {
            return Response::deny('You are not the course instructor!');
        }
        return $user->hasPermission('courses.edit');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Course  $course
     * @return mixed
     */
    public function delete(User $user, Course $course)
    {
        if ($course->getUserInstructorId($course->id) != $user->id) {
            return Response::deny('You are not the course instructor!');
        }
        return $user->hasPermission('courses.delete');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\Course  $course
     * @return mixed
     */
    public function restore(User $user, Course $course)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Course  $course
     * @return mixed
     */
    public function forceDelete(User $user, Course $course)
    {
        //
    }
}

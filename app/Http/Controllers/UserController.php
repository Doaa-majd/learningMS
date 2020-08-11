<?php

namespace App\Http\Controllers;

use App\User;
use App\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{
    public function becomeInstructor()
    {
        return view('users.becomeInstructor');
    }

    public function store(Request $request)
    {
        $request->validate([
            'fname' => 'required|string|max:255|min:3',
            'lname' => 'required|string|max:255|min:3',
            'interests' => 'required|string|max:255|min:3',
            'level' => 'required|string|max:255|min:6',
            'bio' => 'required|string|max:1500|min:10',
        ]);

        $user_id = Auth::id();

        DB::beginTransaction();
        try {
                // Change user type 
                $user = User::findOrFail($user_id);
                $user->type = 'instructor' ;
                $user->save(); 

                // give user type instructor new permissions to create courses
                DB::table('users_permissions')->insertOrIgnore([
                    ['user_id' => $user_id, 'permission' => 'courses.create'],
                    ['user_id' => $user_id, 'permission' => 'courses.delete'],
                    ['user_id' => $user_id, 'permission' => 'courses.edit'],
                    ['user_id' => $user_id, 'permission' => 'courses.index'],
                    ['user_id' => $user_id, 'permission' => 'courses.view'],
                    ['user_id' => $user_id, 'permission' => 'courses.getStudent'],
                ]);

                //insert instructor info to profile table
                Profile::create([
                    'user_id' => $user_id,
                    'fname' => $fname,
                    'lname' => $lname,
                    'interests' => $request->interests,
                    'level' => $request->level,
                    'bio' => $request->bio,
                ]);
            
                DB::commit();

                return Redirect::route('admin.courses.index');

            } catch (Throwable $e) {
                    DB::rollBack();
                    return view('courses.show', [
                        'course' => $course,
                    ]);
            throw $e;
            }

    }
}

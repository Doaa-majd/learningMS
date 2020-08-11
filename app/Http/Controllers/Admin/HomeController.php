<?php

namespace App\Http\Controllers\Admin;

use App\Course;
use App\User;
use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        $courses = Course::count();
        $users = User::count();
        $categories = Category::count();

        return view('admin.dashboard')
                ->with(['courses' => $courses,
                        'users' => $users,
                        'categories' => $categories,
        ]);
    }

}

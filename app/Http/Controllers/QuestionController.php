<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Question;

class QuestionController extends Controller
{

    public function __construct()
    {
       $this->middleware('auth');
    }

    public function add(Request $request){
        
        $request->validate([
            'question' => 'required|string|max:255|min:5',
           // 'user_id' => 'required|int|exists:users,id',
            'course_id' => 'required|int|exists:courses,id',
        ]);

        $question = Question::create([
            'question' => $request->question,
            'user_id' => Auth::id(),
            'course_id' => $request->course_id,
        ]);

        return response()->json(['success'=>"Question Created successfully.",
         'question' => $question,
         'user' => Auth::user()->name,
         ]);

    }

    public function update(Request $request)
    {
        $request->validate([
            'question' => 'required|string|max:255|min:5',
        ]);

        $question = Question::findOrFail($request->question_id);
        $question->update([
            'question' => $request->question,
        ]);

        return response()->json(['success'=>"Question updated successfully.",
         'question' => $question,
         ]);

    }

    public function delete(Request $request)
    {
        $question = Question::findOrFail($request->question_id);
       $question->delete();
       
        return response()->json('question Deleted ');
    }
}

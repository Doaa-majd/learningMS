<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Question;

class QuestionController extends Controller
{
    
    public function index()
    {

        $questions = Question::with('course', 'user')->get();


        return view('admin.questions.index')->with('questions',$questions);
    }

    public function update(Request $request)
    {
        $request->validate([
            'question' => 'required|string|max:255|min:5',
        ]);

        $question = Question::findOrFail($request->id);
        $question->update([
            'question' => $request->question,
        ]);

        return response()->json(['success'=>"Question updated successfully."]);

    }

    public function delete($id)
    {
        $question = Question::findOrFail($id);
       $question->delete();
       
        return response()->json('question Deleted ');
    }

}

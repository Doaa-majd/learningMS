<?php

namespace App\Http\Controllers\Admin;

use App\Section;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SectionController extends Controller
{
    public function store(Request $request){
        
        $request->validate([
            'name' => 'required|string|max:255|min:3',
        ]);

        $section = Section::create([
            'name' => $request->name,
            'course_id' => $request->course_id,
        ]);
        return response()->json(['success'=>"Section Created successfully.", 'section' => $section]);

    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|min:3',
        ]);

        $section = Section::findOrFail($request->section_id);
        $section->update(['name' => $request->name]);

         return response()->json('Section Updated');
        
    }

    public function delete($id)
    {
       $section = Section::findOrFail($id);
       $section->delete();
       
        return response()->json('Section Deleted ');
    }
}

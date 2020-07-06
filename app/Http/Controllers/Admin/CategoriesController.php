<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class CategoriesController extends Controller
{
    public function index()
    {
        //return DB::table('categories')->orderBy('created_at','DESC')->get();

        $categories = Category::leftJoin('categories as parents', 'parents.id', '=', 'categories.parent_id')
            ->select('categories.*', 'parents.name as parent_name')
            ->paginate(3);

       // $categories = Category::orderBy('id', 'ASC')->get();
        return view('admin.categories.index')->with('categories',$categories);
    }

    public function show($id)
    {
       /* return [
            'data' => DB::table('categories')->where('id', '=' ,$id)->first(),
        ];*/

       // return DB::table('categories')->where('id', '=' ,$id)->get();
        return Category::where('id', '=' ,$id)->get();

    }

    public function create()
    {
        return view('admin.categories.create');

    }

    public function store(Request $request)
    {
        $this->checkRequest($request);
        Category::create([
            'name' => $request->name,
            'parent_id' => $request->post('parent_id'),
            'status' => $request->input('status'),
        ]);
        return redirect()
        ->route('admin.categories.index')
        ->with('alert.success', "Category \"{$request->name}\" created");

        /* DB::table('categories')->insert([
             'name' => 'category1',
             'status' => 'published',
             'parent_id' => null,
             'created_at' => Date('Y-m-d H:i:s'),
             'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
         ]);

         return DB::table('categories')->get();*/
    }
    public function edit($id)
    {
        $catEdit = Category::findOrFail($id);
      //  dd($catEdit);
        return view('admin.categories.edit',[
            'category' => $catEdit,
        ]);

    }

    public function update(Request $request , $id)
    {
        $this->checkRequest($request,$id);
        $category = Category::findOrFail($id);
        $category->update($request->all());
        return redirect()
        ->route('admin.categories.index')
        ->with('alert.success', "Category \"{$category->name}\" updated");
    }

    public function delete($id)
    {
       // Category::where('id', $id)->delete();
        $category = Category::findOrFail($id);
        $category->delete();
        return redirect()
        ->route('admin.categories.index')
        ->with('alert.success', "Category \"{$category->name}\" deleted");
    }

    public function deleteAll(Request $request)
    {
        $ids = $request->ids;
        $table = $request->table;
        DB::table($table)->whereIn('id',explode(",",$ids))->delete();
        
        return response()->json(['success'=>"Products Deleted successfully."]);
    }

    protected function checkRequest(Request $request, $except = 0)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                'min:3',
                'unique:categories,name,'. $except,
            ],
            'parent_id' => [
                'nullable',
                'int',
                'exists:categories,id',
            ],
            'status' => [
                'required',
                'string',
                'in:published,draft',
            ],

        ]);
    }
}

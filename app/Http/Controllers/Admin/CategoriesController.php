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
        $this->authorize('viewAny',  Category::class);
        //return DB::table('categories')->orderBy('created_at','DESC')->get();

        $categories = Category::leftJoin('categories as parents', 'parents.id', '=', 'categories.parent_id')
            ->select('categories.*', 'parents.name as parent_name')
            ->paginate(5);

       // $categories = Category::orderBy('id', 'ASC')->get();
        return view('admin.categories.index')->with('categories',$categories);
    }

    public function show(Category $category)
    {
       /* return [
            'data' => DB::table('categories')->where('id', '=' ,$id)->first(),
        ];*/

       // return DB::table('categories')->where('id', '=' ,$id)->get();
       $this->authorize('view', $category);

        //return Category::where('id', '=' ,$id)->get();
        return $category;

    }

    public function create()
    {
        $this->authorize('create', Category::class);

        return view('admin.categories.create');

    }

    public function store(Request $request)
    {
        $this->authorize('create', Category::class);

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
    public function edit(Category $category)
    {
        $this->authorize('update', $category);
        //$catEdit = Category::findOrFail($id);
        return view('admin.categories.edit',[
            'category' => $category,
        ]);

    }

    public function update(Request $request , Category $category)
    {
        $this->authorize('update', $category);
        $this->checkRequest($request, $category->id);
       // $category = Category::findOrFail($id);
        $category->update($request->all());
        return redirect()
        ->route('admin.categories.index')
        ->with('alert.success', "Category \"{$category->name}\" updated");
    }

    public function delete(Category $category)
    {
        $this->authorize('delete', $category);
       // $category = Category::findOrFail($id);
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

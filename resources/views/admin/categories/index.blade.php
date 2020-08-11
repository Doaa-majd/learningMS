@extends('layouts.admin')
@section('title', config('app.name'))
@section('content')

@if (session()->has('alert.success'))
<div class="alert alert-success">
  {{session('alert.success')}}
</div>
@endif

<div class="d-flex">
  <h2 class="h3 mb-4 text-gray-800">All Categories</h2>
  <div class="ml-auto">
    <a href="{{ route('admin.categories.create')}}" class="btn btn-outline-info btn-sm">Create New Category</a>
  </div>
</div>
<div class="action">
  <input type="checkbox" id="master">
  <a href="#" class="delete_all mb-2" data-table="categories" data-url="{{ route('admin.categories.deleteAll')}}">Delete</a>
</div>
<table class="table mt-3">
  <tr>
    <th width="50px"></th>
    <th>No</th>
    <th>Name</th>
    <th>Parent Category</th> 
    <th>Status</th>
    <th>Created At</th>
    <th>Action</th>
  </tr>
  @foreach($categories as $key => $category)
  <tr>
    <td><input type="checkbox" class="sub_chk" data-id="{{$category->id}}"></td>
    <td>{{ ++$key }}</td>
    <td>{{$category->name}}</td>
    <td>{{$category->parent_name}}</td>
    <td>{{$category->status}}</td>
    <td>{{$category->created_at}}</td>
    <td>
      <div class="d-flex">
        <a href="{{ route('admin.categories.edit', [$category->id])}}" class="btn btn-outline-success mr-1 btn-sm">Edit</a> 
        <form method="post" action="{{ route('admin.categories.delete', [$category->id])}}">
            @csrf
            @method('delete')
            <button type="submit" class="btn btn-outline-danger btn-sm">Delete</button>
        </form>
      </div>
    </td>
  </tr>
  @endforeach

</table>
{{ $categories->links() }}

@endsection
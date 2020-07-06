@extends('layouts.admin')
@section('title', config('app.name'))
@section('content')

@if (session()->has('alert.success'))
<div class="alert alert-success">
  {{session('alert.success')}}
</div>
@endif

<div class="d-flex">
  <h2 class="h3 mb-4 text-gray-800">All Courses</h2>
  <div class="ml-auto">
    <a href="{{ route('admin.courses.create')}}" class="btn btn-outline-primary btn-sm">Create New Course</a>
  </div>
</div>
<div class="action">
  <input type="checkbox" id="master">
  <a href="#" class="delete_all mb-2" data-table="courses" data-url="{{ route('admin.categories.deleteAll')}}">Delete</a>

  <div class="float-right d-flex mb-3">
    <button href="#" id="filter-btn" class="btn btn-outline-secondary mr-3 w-100"><i class="fa fa-filter" aria-hidden="true"></i> Filter</button>
    <input type="search" class="form-control" placeholder="Search">
  </div>
  <div class="clearfix"></div>
</div>
<div class="filter">
  <div class="card mb-4 py-3 ">
    <div class="card-body">

      <form class="">
        <div class="filter-row d-flex">
          <div class="mr-4">Price</div>
          <div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" id="free">
                <label class="form-check-label" for="free">
                  Free
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" id="paid">
                <label class="form-check-label" for="paid">
                  Paid
                </label>
              </div>
          </div>
      </div>
      
      <div class="filter-row d-flex">
          <div class="mr-4">Category</div>
          <div>
            <select class="custom-select">
              <option value="">-- select --</option>
              @foreach(App\Category::all() as $cat)
              <option value="{{$cat->id}}">{{$cat->name}}</option>
              @endforeach
            </select> 
          </div>
      </div>
      
        <div class="filter-row d-flex">
          <div class="mr-4">Status</div>
          <div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" id="published">
                <label class="form-check-label" for="published">
                  Published
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" id="draft">
                <label class="form-check-label" for="draft">
                  Draft
                </label>
              </div>
          </div>
      </div>
      </form>

    </div>
  </div>
</div>
<table class="table mt-3">
  <tr>
    <th width="50px"></th>
    <th>No</th>
    <th>Image</th>
    <th width="200px">Title</th>
    <th width="300px">Sub Title</th>
    <th>Category</th> 
    <th>Status</th>
    <th>Created At</th>
  </tr>
  @foreach($courses as $key => $course)
  <tr class="item-row">
    <td><input type="checkbox" class="sub_chk" data-id="{{$course->id}}"></td>
    <td>{{ ++$key }}</td>
    <td><img height="60" src="{{ asset('images/' . $course->image) }}"></td>
    <td class="show-{{$course->id}}"><div>{{$course->title}}</div>
      <div class="list-action mt-5" style="display:none">
        <a href="#" data-url="{{ route('admin.courses.destroy', [$course->id])}}" class="btn btn-outline-danger mr-1 btn-sm delete-course"> <i class="fas fa-trash"></i></a>
        <a href="{{ route('admin.courses.show', [$course->id])}}" class="btn btn-outline-success mr-1 btn-sm"><i class="fas fa-eye"></i></a>
      </div>
    </td>
    <td>{{$course->sub_title}}</td>
    <td>{{$course->category_name}}</td>
    <td>{{$course->status}}</td>
    <td>{{$course->created_at->diffForHumans()}}</td>
  </tr>
  
  @endforeach

</table>
{{ $courses->links() }}

@endsection
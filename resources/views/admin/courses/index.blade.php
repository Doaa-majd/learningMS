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
    <a href="{{ route('admin.courses.create')}}" class="btn btn-outline-info btn-sm">Create New Course</a>
  </div>
</div>
<div class="action">
  <input type="checkbox" id="master">
  <a href="#" class="delete_all mb-2" data-table="courses"
    data-url="{{ route('admin.categories.deleteAll')}}">Delete</a>


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
      <td class="show-{{$course->id}}">
        <div>{{$course->title}}</div>
        <div class="list-action mt-5" style="display:none">
          <a href="#" data-url="{{ route('admin.courses.destroy', [$course->id])}}"
            class="btn btn-outline-danger mr-1 btn-sm delete-course"> <i class="fas fa-trash"></i></a>
          <a href="{{ route('admin.courses.show', [$course->id])}}" class="btn btn-outline-success mr-1 btn-sm"><i
              class="fas fa-eye"></i></a>
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
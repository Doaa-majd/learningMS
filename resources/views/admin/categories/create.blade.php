@extends('layouts.admin')
@section('content')
{{--
@if ($errors->any())
  @foreach($errors->all() as $error)
    <div class="alert alert-danger">
      {{$error}}
    </div>
  @endforeach
@endif
--}}
<h2 class="text-center">Create Category</h2>
<div class="mx-auto mt-5" style="width: 500px;">
<form action="{{ route('admin.categories.store')}}" method="post">
    @csrf
    <div class="form-group">
        <label for="name">Category Name</label>
    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" id="name" placeholder="Enter Name Here">
        @error('name')
          <p class="text-danger">{{ $message }}</p>
        @enderror
      </div>

<div class="form-group">
    <select id="parent-cat" name="parent_id" class="custom-select @error('parent_id') is-invalid @enderror">
        <option value="">No Parent</option>

        @foreach(App\Category::all() as $category)
        <option @if ($category->id == old('parent_id')) selected @endif value="{{$category->id}}">{{$category->name}}</option>
        @endforeach

      </select> 
      @error('parent_id')
          <p class="text-danger">{{ $message }}</p>
        @enderror
    </div>

      <div class="form-check">
        <input class="form-check-input" type="radio" name="status" id="published" value="published" @if (old('status', 'published') == 'published') checked @endif>
        <label class="form-check-label" for="published">
            Published
        </label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="radio" name="status" id="draft" value="draft" @if (old('status') == 'draft') checked @endif>
        <label class="form-check-label" for="draft">
          Draft
        </label>
      </div>
      @error('status')
          <p class="text-danger">{{ $message }}</p>
        @enderror
    <button type="submit" class="btn btn-primary mt-4">Add</button>
  </form> 
</div>
@endsection

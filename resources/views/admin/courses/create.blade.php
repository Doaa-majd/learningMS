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
<h2 class="text-center">Create Course</h2>
<div class="mx-auto mt-5 mb-5"  style="width: 700px;"> 
<form action="{{ route('admin.courses.store')}}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="form-group row">
        <label for="title" class="col-sm-2 col-form-label">Course Title</label>
        <div class="col-sm-10">
          <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" id="title" placeholder="Enter title ">
        </div>
        @error('title')
          <p class="text-danger">{{ $message }}</p>
        @enderror
    </div>

    <div class="form-group row">
      <label for="sub_title" class="col-sm-2 col-form-label">Sub Title</label>
      <div class="col-sm-10">
       <input type="text" class="form-control @error('sub_title') is-invalid @enderror" name="sub_title" value="{{ old('sub_title') }}" id="sub_title" placeholder="Enter sub title">
      </div>
       @error('sub_title')
        <p class="text-danger">{{ $message }}</p>
      @enderror
  </div>

  <div class="form-group row">
    <label class="col-sm-2 col-form-label">Category</label>
    <div class="col-sm-10">
        <select id="category_id" name="category_id" class="custom-select @error('category_id') is-invalid @enderror">
            <option value="">-- Select Category --</option>

            @foreach(App\Category::all() as $category)
            <option @if ($category->id == old('category_id')) selected @endif value="{{$category->id}}">{{$category->name}}</option>
            @endforeach

        </select>
   </div> 
        @error('category_id')
            <p class="text-danger">{{ $message }}</p>
          @enderror
  </div>
  <div class="form-group row">
    <label class="col-sm-2 col-form-label">Language</label>
    <div class="col-sm-10">
          <select id="lang" name="languge" class="custom-select @error('languge') is-invalid @enderror">
              <option value="">-- Select language --</option>
              <option @if (old('languge')=='English') selected @endif value="English">English</option>
              <option @if (old('languge')=='Arabic') selected @endif value="Arabic">Arabic</option>
          </select> 
    </div>
        @error('languge')
            <p class="text-danger">{{ $message }}</p>
          @enderror
    </div>
    <div class="form-group row">
      <label for="price" class="col-sm-2 col-form-label">Price</label>
      <div class="col-sm-10">
         <input type="text" class="form-control @error('price') is-invalid @enderror" name="price" value="{{ old('price') }}" id="price" placeholder="price">
      </div>
     @error('price')
        <p class="text-danger">{{ $message }}</p>
      @enderror
    </div>
    <div class="form-group row">
      <label for="description" class="col-sm-2 col-form-label">Description</label>
      <div class="col-sm-10">
        <textarea class="form-control" id="description" value="{{ old('description') }}" name="description" @error('description') is-invalid @enderror" rows="2"></textarea>
      </div>
      @error('description')
        <p class="text-danger">{{ $message }}</p>
      @enderror
    </div>

    <fieldset class="form-group">
      <div class="row">
        <legend class="col-form-label col-sm-2 pt-0">Status</legend>
        <div class="col-sm-10">
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
        </div>
      </div>
    </fieldset>
      @error('status')
          <p class="text-danger">{{ $message }}</p>
        @enderror

    <div class="custom-file d-flex">
      <div>
      <input type="file" style="width: 500px" class="custom-file-input @error('image') is-invalid @enderror" name="image" id="customFile">
      <label style="width: 500px" class="custom-file-label" for="customFile">Choose image</label>
      </div>
      <div class="ml-3">
      <img height="100" id="course-img" src="#" alt="course image here" />
      </div>
      <input type="hidden" name="img64" id="img64" value="">

    </div>
    @error('image')
          <p class="text-danger">{{ $message }}</p>
    @enderror


    <button type="submit" class="btn btn-primary mt-4">Add</button>
  </form> 
</div>
@endsection

@section('js')
<script src="{{ asset('js/trumbowyg/trumbowyg.min.js') }}"></script>
<script>
  $('#description').trumbowyg();

  function readURL(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    
    reader.onload = function(e) {
      $('#course-img').attr('src', e.target.result);
      $('#img64').attr('value', e.target.result);

    }
    
    reader.readAsDataURL(input.files[0]); // convert to base64 string
  }
}

$("#customFile").change(function() {
  readURL(this);
});
</script>
@endsection

@section('css')
<link href="{{ asset('js/trumbowyg/ui/trumbowyg.min.css') }}" rel="stylesheet">
@endsection
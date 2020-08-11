@extends('layouts.admin')
@section('title', config('app.name'))
@section('content')


<div class="d-flex">
  <h2 class="h3 mb-4 text-gray-800">All Questions</h2>
  <div class="ml-auto">
  </div>
</div>

<table class="table mt-3">
  <tr>
    <th>No</th>
    <th>Question</th>
    <th>In coures</th> 
    <th>Asked by</th>
    <th>Created At</th>
    <th>Action</th>
  </tr>
  @foreach($questions as $key => $question)
  <tr>
    <td>{{ ++$key }}</td>
    <td class="question-body-{{$question->id}}">{{$question->question}}</td>
    <td> <a href="{{route('course.showCourse', [$question->course->id])}}" class="">
      {{$question->course->title}}</a>
    </td>
    <td>{{$question->user->name}}</td>
    <td>{{$question->created_at}}</td>
    <td>
      <div class="d-flex">
      <a href="#" data-toggle="modal" data-target="#question" data-id="{{$question->id}}" data-question="{{$question->question}}" class="btn btn-outline-success mr-1 btn-sm edit-question">Edit</a> 
      <a href="#" data-url="{{ route('admin.questions.delete', [$question->id])}}"  class="btn btn-outline-danger btn-sm delete-question">Delete</a> 
  
      </div>
    </td>
  </tr>
  @endforeach

</table>

<div class="modal fade" id="question" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title edit" id="exampleModalLabel" >Edit question</h5>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      
      <div class="modal-body">
          <div class="form-group row">
              <label for="title" class="col-sm-2 col-form-label">Question</label>
              <div class="col-sm-10">
                <textarea class="form-control question-text" id="question" value="" name="question" rows="2"> </textarea>
                <input type="hidden" class="question_id" id="question_id" value="">
              </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <a data-url="{{ route('admin.questions.update')}}" class="btn btn-primary update-question">Update</a>

      </div>
  
    </div>
  </div>
</div>

@endsection

@section('js')
<script src="{{ asset('js/question.js') }}"></script>
@endsection
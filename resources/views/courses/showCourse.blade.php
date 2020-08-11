@extends('layouts.front')
@section('content')

<section class="grey page-title" style="padding: 15px 0">
    <div class="container">
        <div class="row">
            <div class="col-md-6 text-left">
                <h1> {{ $course->title }} </h1>
            </div>
        </div>
    </div>
</section>

<div class="white video-section">
    <div class="row">
        <div id="course-left-sidebar" class="col-md-9">
            <video width="100%" height="100%" controls>
                <source src="{{ asset('videos/'. $video_path) }}" type="video/mp4">
                <source src="#" type="video/ogg">
                Your browser does not support the video tag.
            </video>
        </div>
        <div class="col-md-3 course-lectures-right">
            <div class="accordion-widget">
                <div class="accordion-toggle-2">
                    <div class="panel-group" id="accordion">
                        @foreach($course->sections as $key => $section)

                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <div class="panel-title">
                                    <a class="accordion-toggle collapsed" data-toggle="collapse"
                                        data-parent="#accordion1" href="#{{$key}}" aria-expanded="false">
                                        <h3>{{$section->name}} <i class="indicator fa fa-plus"></i></h3>
                                    </a>
                                </div>
                            </div>
                            <div id="{{$key}}" class="panel-collapse collapse" style="height: 0px;"
                                aria-expanded="false">
                                <div class="panel-body">
                                    @foreach($section->lectures as $lecture)
                                    <input type="checkbox" class="lecture-complete"
                                        data-url="{{ route('course.completeLecture')}}" data-cid="{{$course->id}}"
                                        data-lid="{{$lecture->id}}" @if(App\LectureUser::where('user_id' ,
                                        Auth::id())->where('lecture_id', $lecture->id)->first())checked @endif> <i
                                        class="fa fa-play-circle"></i> <a
                                        href="{{ route('course.showLecture', [$course->id , $lecture->id])}}">{{$lecture->name}}</a>
                                    <hr>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8 overview">
            <div class="tabbed-widget">
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#home">Overview</a></li>
                    <li><a data-toggle="tab" href="#menu1">Q&A</a></li>
                    <li><a data-toggle="tab" href="#menu2">Progress</a></li>
                    <li><a data-toggle="tab" href="#menu3">Rating</a></li>

                </ul>
                <div class="tab-content">
                    <div id="home" class="tab-pane fade in active" style="overflow: hidden">
                        <h3> Description </h3>
                        <p class="more c-description">{!! $course->description !!}</p>

                        <div class="course-instructor">
                            <h3> Instructor </h3>
                            <div class="d-flex">
                                <div class="instructor-img">
                                    <img class="alignleft img-circle" height="100"
                                        src="{{ asset('front-assets/upload/xstudent_01.png.pagespeed.ic.756JwMcqdq.png') }}"
                                        alt="">
                                </div>
                                <div class="bio">
                                    <h2> {{ $instructor->fname . ' '. $instructor->lname }} </h2>
                                    <span> {{ $instructor->interests}} </span>
                                    <p class="c-description"> {{ $instructor->bio }} </p>
                                </div>
                            </div>
                        </div>

                        <div class="course-rating">
                            <h3> Student feedback </h3>

                            <div class="course-feedback">
                                @php
                                $course_rating = App\Rating::getCoursRate($course->id) ;
                                @endphp
                                <div class="course-rating text-center">
                                    <h1> {{$course_rating }} </h1>
                                    <span> Course Rating </span>
                                </div>
                            </div>
                            <div class="rating-progress">
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar"
                                        style="width: {{ $rating['5'] ?? 0 }}%;">
                                    </div>
                                </div>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar"
                                        style="width: {{ $rating['4'] ?? 0 }}%;">
                                    </div>
                                </div>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar"
                                        style="width: {{ $rating['3'] ?? 0 }}%;">
                                    </div>
                                </div>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar"
                                        style="width: {{ $rating['2'] ?? 0 }}%;">
                                    </div>
                                </div>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar"
                                        style="width: {{ $rating['1'] ?? 0 }}%;">
                                    </div>
                                </div>
                            </div>
                            <div class="star-rate">
                                <div class="star"><span><i class="fa fa-star"></i><i class="fa fa-star"></i><i
                                            class="fa fa-star"></i><i class="fa fa-star"></i><i
                                            class="fa fa-star"></i></span> {{ $rating['5'] ?? 0 }}%</div>
                                <div class="star"><span><i class="fa fa-star"></i><i class="fa fa-star"></i><i
                                            class="fa fa-star"></i><i class="fa fa-star"></i><i
                                            class="fa fa-star-o"></i></span> {{ $rating['4'] ?? 0 }}%</div>
                                <div class="star"><span><i class="fa fa-star"></i><i class="fa fa-star"></i><i
                                            class="fa fa-star"></i><i class="fa fa-star-o"></i><i
                                            class="fa fa-star-o"></i></span> {{ $rating['3'] ?? 0 }}%</div>
                                <div class="star"><span><i class="fa fa-star"></i><i class="fa fa-star"></i><i
                                            class="fa fa-star-o"></i><i class="fa fa-star-o"></i><i
                                            class="fa fa-star-o"></i></span> {{ $rating['2'] ?? 0 }}%</div>
                                <div class="star"><span><i class="fa fa-star"></i><i class="fa fa-star-o"></i><i
                                            class="fa fa-star-o"></i><i class="fa fa-star-o"></i><i
                                            class="fa fa-star-o"></i></span> {{ $rating['1'] ?? 0 }}%</div>

                            </div>

                        </div>

                    </div>

                    <div id="menu1" class="tab-pane fade list-questions">
                        <h3> Your Question </h3>
                        <a href="#" class="add-question-btn">Add Question </a>
                        <div class="question-user"><span> Ask as {{Auth::user()->name}} </span></div>
                        <div class="add-question">
                            <textarea class="question-area" rows="2" cols="70"></textarea>
                            <div class="ask-button"><a class="btn btn-primary ask" data-url="{{ route('question.add')}}"
                                    data-cid="{{$course->id}}" href="#">Ask</a></div>
                        </div>

                        @foreach($course->questions as $question)
                        <div class="well">
                            <div class="media">
                                <div class="media-body">
                                    <h4 class="media-heading">
                                        {{App\User::where('id', $question->user_id)->first()->name}} </h4>
                                    <p class="question-body-{{$question->id}}"> {{ $question->question}} </p>
                                    <div class="update-question-{{$question->id}} update-question">
                                        <textarea class="updated-question" rows="2"
                                            cols="70"> {{ $question->question}} </textarea>
                                        <div>
                                            <a href="#" class="update-q" data-url="{{ route('question.update')}}"
                                                data-qid="{{$question->id}}"> Update </a>
                                        </div>
                                    </div>
                                    <div
                                        class="question-action @if ($question->user_id != Auth::id()) hide-action @endif">
                                        <a href="#" class="edit-question" data-qid="{{$question->id}}"> Edit </a>
                                        <a href="#" class="delete-q" data-url="{{ route('question.delete')}}"
                                            data-qid="{{$question->id}}">Delete</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @php
                    $progress = App\User::userProgress($course->id);
                    @endphp
                    <div id="menu2" class="tab-pane fade">
                        <div class="progress-title"> your progress: <span> {{ $progress }}% </span></div>
                        <div class="teacher-skills">
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" style="width: {{ $progress }}%;">
                                    <span class="sr-only">Yor Progress {{$progress}}%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="menu3" class="tab-pane fade">
                        <div class="container">
                            @php
                            $rating = App\Rating::where('course_id',$course->id)->where('user_id', Auth::id())->first();
                            if($rating)
                            {
                            $rating = $rating->rating_num;
                            }
                            @endphp
                            <input type="hidden" value="{{$course->id}}" data-url="{{ route('course.rating')}}"
                                class="course-id">
                            <h1>Rate this course</h1>
                            <span class="star-rating star-5">
                                <input type="radio" name="rating" value="1" @if ($rating==1) checked @endif><i></i>
                                <input type="radio" name="rating" value="2" @if ($rating==2) checked @endif><i></i>
                                <input type="radio" name="rating" value="3" @if ($rating==3) checked @endif><i></i>
                                <input type="radio" name="rating" value="4" @if ($rating==4) checked @endif><i></i>
                                <input type="radio" name="rating" value="5" @if ($rating==5) checked @endif><i></i>
                            </span>
                            <br><br>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    @endsection

    @section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('front-assets/css/showCourse.css') }}" />
    @endsection

    @section('js')
    <script src="{{ asset('front-assets/js/showCourse.js') }}"></script>
    @endsection
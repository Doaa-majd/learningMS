@extends('layouts.front')
@section('content')

<section class="grey page-title">
    <div class="container">
        <div class="row">
            <div class="col-md-6 text-left">
                <h1>{{$course->title}}</h1>
            </div>

        </div>
    </div>
</section>
<section class="white section">
    <div class="container">
        <div class="row">
            <div id="course-left-sidebar" class="col-md-4">
                <div class="course-image-widget">
                    <img src="{{ asset('images/' . $course->image) }} " alt="" class="img-responsive">
                </div>
                <div class="course-meta">
                    <p class="course-category">Category : <a href="course-list.html"> {{$course->category->name}} </a>
                    </p>
                    <hr>
                    <div class="rating">
                        @php
                        $rating = floor(App\Rating::getCoursRate($course->id)) ;
                        @endphp
                        <p>Reviews : &nbsp;
                            @for ($i = 0; $i < $rating; $i++) <i class="fa fa-star"></i>
                                @endfor

                                <a title="" href="#reviews">&nbsp; ( {{$rating}} )</a></p>
                    </div>
                    <hr>
                    <p class="course-student">Students : @php echo App\CourseUser::where('course_id', $course->id
                        )->count(); @endphp Members </p>
                    <hr>
                    <p class="course-time">Length : @php echo App\Lecture::where('course_id', $course->id )->count();
                        @endphp Videos </p>
                    <hr>
                    <p class="course-prize">Prize : <i class="fa fa-trophy"></i> <i class="fa fa-certificate"></i> <i
                            class="fa fa-shield"></i></p>
                    <hr>
                    <p class="course-instructors">Instructor : {{ $instructor->fname .' '. $instructor->lname}} </p>
                </div>
                <div class="course-button" style="background-color: #5f687d">
                    @php $showButton = true; @endphp
                    @auth
                    @if(App\CourseUser::where('user_id', Auth::id())->where('course_id',$course->id)->first())
                    <a href="{{route('course.showCourse', [$course->id])}}" class="btn btn-primary btn-block">Go To
                        Course</a>
                    @php $showButton = false; @endphp
                    @endif
                    @endauth
                    @if ($showButton)
                    <!-- user not enroll in this course before -->
                    @if(App\Course::where('id',$course->id)->first()->price == 0)
                    <form action="{{route('course.enrollCourse', [$course->id])}}" method="post">
                        @csrf
                        <button type="submit" class="btn btn-primary btn-block">Enroll</button>
                    </form>
                    @elseif(App\Cart::where('user_id', Auth::id())->where('course_id',$course->id)->first())
                    <a href="{{route('cart')}}" class="btn btn-primary btn-block">Go To Cart</a>
                    <form action="{{route('buynow')}}" method="post">
                        <input type="hidden" name="course_id" value="{{ $course->id }}">
                        @csrf
                        <button type="submit" class="btn btn-primary btn-block" style="margin-top: 2px">Buy now</button>
                    </form>
                    @else
                    <form action="{{route('cart')}}" method="post">
                        <input type="hidden" name="course_id" value="{{ $course->id }}">
                        @csrf
                        <button type="submit" class="btn btn-primary btn-block">Add To Cart</button>
                    </form>
                    <form action="{{route('buynow')}}" method="post">
                        <input type="hidden" name="course_id" value="{{ $course->id }}">
                        @csrf
                        <button type="submit" class="btn btn-primary btn-block" style="margin-top: 2px">Buy now</button>
                    </form>

                    @endif
                    @endif
                </div>
            </div>
            <div id="course-content" class="col-md-8">
                <div class="course-description">
                    <div class="course-header">
                        <h3 class="course-title"> {{$course->title}} </h3>
                        <h4> {{ $course->sub_title }} </h4>

                        <small>Created By: <span>In</span> </small>
                        <small>Last Updated: <span> {{$course->updated_at}} </span> </small>
                        <small>Language: <span> {{$course->languge}} </span> </small>
                    </div>
                    <p class="more more-description">{!! $course->description !!}</p>
                </div>
                <div class="course-table">
                    <h4>Course Content</h4>
                    <table class="table">
                        <tbody>
                            @foreach($course->sections as $section)

                            <tr class="c-section">
                                <td colspan="4">{{$section->name}}</td>
                            </tr>

                            @foreach($section->lectures as $lecture)
                            <tr>
                                <td><i class="fa fa-play-circle"></i></td>
                                <td><span>{{$lecture->name}}</span></td>
                                <td></td>
                                <td></td>
                            </tr>
                            @endforeach
                            @endforeach

                        </tbody>
                    </table>
                </div>
                <hr class="invis" style="border-color: #3f4451 ">

                <div class="other-courses">
                    <img src=" {{ asset('front-assets/images/xothers.png.pagespeed.ic.BLyi2PaMRC.png') }} " alt=""
                        class="">
                </div>
            </div>
        </div>
        <hr class="invis">
        <div id="owl-featured" class="owl-custom">
            @php $courses = App\Course::where('category_id', $course->category->id)->limit(5)->get(); @endphp
            @foreach ($courses as $course)
            <div class="owl-featured">
                <div class="shop-item-list entry">
                    <div class="">
                        <img src="{{ asset('images/' . $course->image) }}" alt="">
                        <div class="magnifier">
                        </div>
                    </div>
                    <div class="shop-item-title clearfix">
                        <h4><a href="{{ route('course.show', [$course->id])}}">{{$course->title}}</a></h4>
                        <div class="shopmeta">
                            <span class="pull-left">{{$course->price ? $course->price . '$' : 'Free'}} </span>
                            <div class="rating pull-right">
                                @php
                                $c_rating = floor(App\Rating::getCoursRate($course->id)) ;
                                @endphp
                                <p>
                                    @if (! $c_rating)
                                    <i class="fa fa-star-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i>
                                    @else
                                    @for ($i = 0; $i < $c_rating; $i++)
                                     <i class="fa fa-star"></i>
                                    @endfor
                                    @endif
                            </div>
                        </div>
                    </div>
                    <div class="visible-buttons">
                       
                        <a title="Read More" href="{{ route('course.show', [$course->id])}}"><span
                                class="fa fa-search"></span></a>
                    </div>
                </div>
            </div>
            @endforeach


        </div>
    </div>
</section>

@endsection
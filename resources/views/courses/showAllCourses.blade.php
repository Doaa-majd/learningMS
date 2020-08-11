@extends('layouts.front')
@section('content')

<section class="grey page-title">
    <div class="container">
        <div class="row">
            <div class="col-md-6 text-left">
                <h1>Course List Page</h1>
            </div>
            <div class="col-md-6 text-right">
                <div class="bread">
                    <ol class="breadcrumb">
                        <li><a href="#">Home</a></li>
                        <li><a href="#">Courses</a></li>
                        <li class="active">Course List</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="white section">
    <div class="container">
        <div class="row course-list">
            @foreach($courses as $course)

            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="shop-item-list entry">
                    <div class="">
                        <img src="{{ asset('images/' . $course->image) }}" alt="">
                        <div class="magnifier">
                        </div>
                    </div>
                    <div class="shop-item-title clearfix">
                        <h4><a href="{{ route('course.show', [$course->id])}}">{{$course->title}}</a></h4>
                        <div class="shopmeta">
                            <span class="pull-left">12 Student</span>
                            <div class="rating pull-right">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                            </div>
                        </div>
                    </div>
                    <div class="visible-buttons">
                        <a title="Add to Cart" href="page-shop-cart.html"><span
                                class="fa fa-cart-arrow-down"></span></a>
                        <a title="Read More" href="course-single.html"><span class="fa fa-search"></span></a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
       
    </div>
</section>

@endsection
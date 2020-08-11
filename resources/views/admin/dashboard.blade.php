@extends('layouts.admin')
@section('title', 'Admin Dashboard')
@section('content')

<div class="row">

    <!-- No of Categories -->
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Categories NO:</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800"> {{ $categories }} </div>
            </div>
            <div class="col-auto">
              <i class="fas fa-list-ul fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- No of Users  -->
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-success shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-success text-uppercase mb-1"> Users NO:</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800"> {{ $users }} </div>
            </div>
            <div class="col-auto">
              <i class="fas fa-users fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- No of courses -->
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-warning shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Courses NO:</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800"> {{ $courses }} </div>
            </div>
            <div class="col-auto">
              <i class="fas fa-video fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection

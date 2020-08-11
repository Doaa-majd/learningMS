@extends('layouts.front')
@section('content')


<div class="container">
    <div class="row">
            <div class="edit-profile">
                <div class="instuctor-profile">
                    <h2>Additional info</h2>
                    <form role="form" action="{{ route('user.store') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label>First Name </label>
                            <input type="text" class="form-control @error('fname') is-invalid @enderror" name="fname" value="{{ old('fname') }}" placeholder="Ahmed">
                                @error('fname')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                        </div>
                        <div class="form-group">
                            <label>Last Name </label>
                            <input type="text" class="form-control @error('lname') is-invalid @enderror" name="lname" value="{{ old('lname') }}" placeholder="Fox">
                                @error('lname')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                        </div>
                        <div class="form-group">
                            <label>your teaching interests </label>
                            <input type="text" class="form-control @error('interests') is-invalid @enderror" name="interests" value="{{ old('interests') }}" placeholder="ex: web development">
                                @error('interests')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                        </div>
                        <div class="form-group">
                            <label>Your knowledge level</label>
                            <input type="text" class="form-control @error('level') is-invalid @enderror" name="level" value="{{ old('level') }}" placeholder="ex:Teaching for expert level">
                                @error('level')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                        </div>
                        <div class="form-group">
                            <label>Bio</label>
                            <textarea name="bio" class="form-control @error('bio') is-invalid @enderror" rows="4" cols="50"></textarea>  
                            @error('bio')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                      </div>

                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
</div>
@endsection
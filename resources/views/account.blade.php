@extends('layouts.master')

@section('title')
    Account
@endsection

@section('content')
	@include('includes.message-block')
    <section class="row new-post">
        <div class="col-lg-6 l-md-6 col-sm-12 col-md-offset-3">
            <header><h3>Your Account</h3></header>
            <form action="{{ route('editaccount') }}" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="first_name">First Name</label>
                    <input type="text" name="first_name" class="form-control" value="{{ $user->first_name }}" id="first_name">
                </div>
                <div class="form-group">
                    <label for="image">Image (only .jpg)</label>
                    <input type="file" name="image" class="form-control" id="image">
                </div>
                <button type="submit" class="btn btn-primary">Save Account</button>
                <input type="hidden" value="{{ Session::token() }}" name="_token">
            </form>
        </div>
    </section>
    @if (Storage::disk('local')->has($user->first_name . '-' . $user->id . '.jpg'))
        <section class="row new-post">
            <div class="col-lg-6 l-md-6 col-sm-12 col-md-offset-3 thumbnail">
                <img src="{{ route('account-image', ['filename' => $user->first_name . '-' . $user->id . '.jpg']) }}" alt="Account image" class="img-responsive">
            </div>
        </section>
    @else
		<section class="row new-post">
            <div class="col-lg-6 l-md-6 col-sm-12 col-md-offset-3 thumbnail">
				<img alt="No image" src="{{ route('account-image', ['filename' => 'no_image.jpg']) }}" class="img-responsive">
            </div>
        </section>
	@endif
@endsection

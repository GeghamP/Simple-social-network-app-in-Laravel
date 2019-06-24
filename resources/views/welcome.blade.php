@extends('layouts.master')

@section('title')
	Welcome!
@endsection

@section('content')
	@include('includes.message-block')
	<div class = "row">
		<div class = "col-lg-6 col-md-6 col-sm-12">
			<h3>Sign up</h3>
			<form action = "{{ route('signup') }}" method = "post">
				<div class = "form-group {{ $errors->has('email') ? 'has-error' : null }}">
					<label for = "email1">Your E-Mail</label>
					<input class = "form-control" type = "email" name = "email" id = "email1" value = "{{ Request::old('email') }}">
				</div>
				<div class = "form-group {{ $errors->has('first_name') ? 'has-error' : null }}">
					<label for = "first_name1">Your First Name</label>
					<input class = "form-control" type = "text" name = "first_name" id = "first_name1" value = "{{ Request::old('first_name') }}">
				</div>
				<div class = "form-group {{ $errors->has('password') ? 'has-error' : null }}">
					<label for = "password1">Your Password</label>
					<input class = "form-control" type = "password" name = "password" id = "password1">
				</div>
				<button type = "submit" class = "btn btn-primary">Submit</button>
				<input type = "hidden" name = "_token" value = "{{ Session::token() }}">
			</form>
		</div>
		<div class = "col-lg-6 col-md-6 col-sm-12">
			<h3>Sign in</h3>
			<form action = "{{ route('signin') }}" method = "post">
				<div class = "form-group {{ $errors->has('email2') ? 'has-error' : null }}">
					<label for = "email2">Your E-Mail</label>
					<input class = "form-control" type = "email" name = "email2" id = "email2" value = "{{ Request::old('email2	') }}">
				</div>

				<div class = "form-group form-group {{ $errors->has('password2') ? 'has-error' : null }}">
					<label for = "password2">Your Password</label>
					<input class = "form-control" type = "password" name = "password2" id = "password2">
				</div>
				<button type = "submit" class = "btn btn-primary">Submit</button>
				<input type = "hidden" name = "_token" value = "{{ Session::token() }}">
			</form>
		</div>
	</div>
@endsection
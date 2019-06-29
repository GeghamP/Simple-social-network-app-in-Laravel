@extends('layouts.master')

@section('title')
	{{ Auth::user()->first_name }}
@endsection

@section('content')
	@include('includes.message-block')
	<section class = "row new-post">
		<div class = "col-lg-6 col-md-6 col-sm-12 col-md-offset-3">
			<header><h3>What do you have to say?</h3></header>
			<form action = "{{ route('create-post') }}" method = "post">
				<div class = "form-group">
					<textarea class = "form-control" name = "body" id = "new-post" rows = "5" placeholder = "your post here"></textarea>
				</div>
				<button class = "btn btn-primary" type = "submit">Submit post</button>
				<input type = "hidden" name = "_token" value = {{ Session::token() }}>
			</form>
		</div>
	</section>
	
	<section class = "row posts">
		<div class = "col-lg-6 col-md-6 col-sm-12 col-md-offset-3">
			<header><h3>Whatever people say</h3></header>
			@foreach( $posts as $post )
				<article class = "post" data-postid = "{{ $post->id }}">
					<p class = "bost-body-text">{{ $post->body }}</p>
				
					<div class = "info">
						Posted by {{ $post->user->first_name }} on {{ $post->created_at->format('d/M/Y h:m:s') }} 
					</div>
					<div class = "interaction">
						<a href = "#" class = "like" >
							<i class = "{{ App\Http\Controllers\PostController::verifyStatus($post,'like') }}"></i>
						</a> |
						<a href = "#" class = "dislike" >
							<i class = "{{ App\Http\Controllers\PostController::verifyStatus($post,'dislike') }}"></i>
						</a>  
						@if(Auth::user() == $post->user)
							|
							<a href = "#" class = "edit-post">Edit</a> |
							<a href = "#" class = "delete-post">Delete</a> |
						@endif	
						<input id ="post-tools-token" type = "hidden" name = "_token" value = "{{ Session::token() }}">
					</div> 
				</article>
			@endforeach
		</div>
	</section>

	<div id="edit_modal" tabindex="-1"  class="modal fade" role="dialog">
		<div class="modal-dialog">
    
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Edit Post</h4>
				</div>
				<div class="modal-body">
					<form method = "post" id = "edit_form">
						<div class = "form-group">
							<label for = "post_text"></label>
							<textarea class = "form-control" id = "post_text" name = "post_text" rows = "5"></textarea>	
							<input id ="post-edit-token" type = "hidden" name = "_token" value = "{{ Session::token() }}">
						</div>
					</form>
				</div>
				<div class="modal-footer">
					<button id = "save_post" type="button" class="btn btn-primary" data-dismiss="modal">Save</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>
      
		</div>
	</div>

@stop
@if( $errors->any() )
	<div class = "row">
		<div class = "col-lg-6 col-md-6 col-sm-12  col-md-offset-3 alert alert-danger">
			<ul style = "list-style: none; padding: 0;">
				@foreach($errors->all() as $error)
					<li>{{ $error }}</li>
				@endforeach
			</ul>
		</div>
	</div>
		
@endif

@if( Session::has('message') )
	<div class = "row">
		<div class = "col-lg-6 col-md-6 col-sm-12  col-md-offset-3 alert alert-success">
			{{ Session::get('message') }}
		</div>
	</div>
		
@endif
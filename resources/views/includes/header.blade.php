<header>
	<nav class="navbar navbar-default">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href = "{{ route('dashboard') }}">Your profile</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				@if(Auth::user())
					<ul class = "nav navbar-nav navbar-right">
						@if (Storage::disk('local')->has(Auth::user()->first_name . '-' . Auth::user()->id . '.jpg'))
							<li><img class = "img-circle" src = "{{ route('account-image', ['filename' => Auth::user()->first_name . '-' . Auth::user()->id . '.jpg']) }}" width = "50px" height = "60px"></img></li>
						@endif
						<li><a href = "{{ route('account') }}">Account</a></li>
						<li><a href = " {{ route('logout') }} ">Logout</a></li>
					</ul>	
				@endif
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>
</header>
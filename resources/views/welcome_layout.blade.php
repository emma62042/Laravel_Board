{{--每頁都要出現的東西--}}
<!DOCTYPE html>
<html lang="tw">
	<head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <!-- 掛載CSS樣式 -->
        <link rel="stylesheet" href="/css/rwd_table.css"/>
	    <link rel="stylesheet" href="/bootstrap-4.4.1-dist/css/bootstrap.min.css"/>

	    <!-- 掛載JS樣式 -->
	    <script src="https://code.jquery.com/jquery.js"></script>
	    <script src="/bootstrap-4.4.1-dist/js/bootstrap.min.js"></script>
	    <script src="/bootstrap-4.4.1-dist/js/bootstrap.js"></script>
        @yield("title")
    </head>
	<body>
		<div class="container">
			{{--最上排登入登出--}}
			<div class="sign d-flex justify-content-end">
				<ul class="list-inline">
					@if(session("login_id"))
						<li class="list-inline-item">welcome {{ session("login_name") }} (id = {{ session("login_id") }})</li>
						<li class="list-inline-item">
							<button class="btn btn-dark"  onclick="location.href='{{ action('WelcomeController@logout') }}'">
								Logout
							</button>
						</li>
					@else
						<li class="list-inline-item">
							<button class="btn btn-primary"  onclick="location.href='{{ action('WelcomeController@loginView') }}'">
								Login
							</button>
						</li>
					@endif
				</ul>
			</div>

			{{--center 88 留言板 大看板--}}
			<div class="jumbotron">
				<a class="display-4 text-decoration-none text-reset" href="/welcome">CENTER 88 留言板</a>
			</div>

			{{--導覽列--}}
			<nav class="navbar navbar-expand-lg navbar-light bg-light">
    			<a class="navbar-brand">留言板</a>
    			{{--搜尋功能--}}
    			<form class="form-inline mr-auto" action="" method="get">
	    			<input type="hidden" name="action" value="searchlist">
					<input class="form-control mr-sm-2" type="search" placeholder="Search" name="input" value="<?php if(isset($_GET["input"])){echo $_GET["input"];} ?>">
					<button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
				</form>
				{{--會員功能:新增留言/非會員:未登入留言--}}
    			@if(session("login_id"))
					<a class="navbar-brand">會員專區</a>
					<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		    			<span class="navbar-toggler-icon"></span>
		    		</button>
		    		<div class="collapse navbar-collapse flex-grow-0" id="navbarSupportedContent">
		            	<ul class="navbar-nav text-right">
		        			<li class="nav-item"><a class="nav-link" href="welcome/create">新增留言</a></li>
		                </ul>
		            </div>
		        @else
		        	<div class="collapse navbar-collapse flex-grow-0" id="navbarSupportedContent">
		            	<ul class="navbar-nav text-right">
		        			<li class="nav-item"><a class="nav-link" href="welcome/create">未登入留言</a></li>
		                </ul>
		            </div>
				@endif
			</nav>

			{{--一些alert，顯示在content上面--}}
			@if(isset($success) && $success != '')
		      	<div class="alert alert-success" role="alert" style="text-align:center; margin:5px;">
		          	<span>
		          		{!! (isset($success) && $success != '') ?$success :'' !!}
		          	</span>
		        </div>	
		    @endif
		    @if(isset($fail) && $fail != '')
		        <div class="alert alert-danger" role="alert" style="text-align:center; margin:5px;">
		          	<span>
		          		{!! (isset($fail) && $fail != '') ?$fail :'' !!}
		          	</span>
		        </div>
		    @endif

		    {{--主要顯示區間content--}}	
			<div class="content">
				@yield("content")
	    	</div>
	    </div>
	</body>
</html>
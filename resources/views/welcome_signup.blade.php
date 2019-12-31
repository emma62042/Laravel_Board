{{--註冊畫面--}}
@extends("welcome_layout")

@section("title")
    <title>TestSignup</title>
@endsection
@section("content")
  	<h2 style="text-align:center;">Signup註冊</h2>

  	{{--註冊表單--}}
  	<form name="form1" method="post" action="{{ action('WelcomeController@signup') }}">
      	<input name="_token" type="hidden" value="{{ csrf_token() }}">
      	<div class="row justify-content-md-center">
	        <table class="table table-striped table-bordered col col-md-6">
		      	<tr>
		        	<th>帳號</th>
		        	<td>
		        		<input class="form-control" type="text" name="id" value="{{ isset($id) ? $id : '' }}" required>
		        	</td>
		        </tr>
		        <tr>
		        	<th>密碼</th>
		        	<td>
		        		<input class="form-control" type="password" name="password" required>
		        	</td>
		        </tr>
		        <tr>
		        	<th>確認密碼</th>
		        	<td>
		        		<input class="form-control" type="password" name="ck_password" placeholder="請再輸入一次密碼" required>
		        	</td>
		        </tr>
		        <tr>
		        	<th>暱稱</th>
		        	<td>
		        		<input class="form-control" type="text" name="UserName" value="{{ isset($UserName) ? $UserName : '' }}" required>
		        	</td>
		        </tr>
		        <tr>
		        	<th>E-mail</th>
		        	<td>
		        		<input class="form-control" type="text" name="UserEmail" value="{{ isset($UserEmail) ? $UserEmail : '' }}" required>
		        	</td>
		        </tr>
		        <tr>
		        	<td colspan="2" align="center">
		        		<button class="btn btn-secondary" type="submit" >註冊</button>
		        	</td>
		        </tr>
	      	</table>
	    </div>
	</form>     
@endsection
{{--新增/修改留言畫面--}}
@extends("welcome_layout")

@section("title")
   <title>TestCreate</title>
@endsection

@section("content")
   <h2 class="display-4" style="text-align:center; margin-bottom:30px;">{{ isset($update) ? "Update" : "Create" }} Msg</h2>

   {{--留言輸入框，修改留言時會秀出之前的留言--}}
   <form name="form1" method="post" action="{{ ($id != '') ? action('WelcomeController@update', ['id'=>$id]) : 'new_a_msg' }}">
      <input name="_token" type="hidden" value="{{ csrf_token() }}">
      <input name="_method" type="hidden" value="put">
      <div class="form-group row">
         <label for="Title" class="col-sm-2 col-form-label">Title</label>
         <div class="col-sm-10">
            <input type="text" class="form-control" name="Title" placeholder="請輸入標題" value="{{ isset($update) ?  isset($title) ? $title : '' : old('Title') }}">
         </div>
      </div>
      <div class="form-group row">
         <label for="Msg" class="col-sm-2 col-form-label">Msg</label>
         <div class="col-sm-10">
            <textarea type="text" class="form-control" name="Msg" style="height:100px;" placeholder="請輸入留言" >{{ isset($update) ? isset($msg) ? $msg : "" : old("Msg")}}</textarea>
         </div>
      </div>
         <div class="form-group row">
         <div class="col-sm-12 d-flex justify-content-end">
            <button type="submit" class="btn btn-primary">Save</button>
         </div>
      </div>
      
      {{--輸出ERROR ALERT--}}
      @if($errors->any())
         <div class="alert alert-danger">
            <ul class="list-unstyled">
               @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
               @endforeach
            </ul>
         </div>
      @endif
   </form>     
@endsection

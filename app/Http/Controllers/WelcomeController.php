<?php
/**
 * 使用者資料建立
 * @author center69-陳煜珊
 * @history
 * 	    center69-陳煜珊 2019/06/05 增加註解及驗證
 *      center88-吳宜芬 2019/12/31 修改及增加註解
 * ----------------------------------------------------------------
 */
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use App\Services\Users; 
use App\Services\Boards;

class WelcomeController extends Controller
{
    /**
     * index 畫面
     * @param $request
     * @return  view:index.blade.php
     *          1.login_id、login_name:登入有id跟name
     *          2.dataList:全部留言
     *          3.success、fail:如果有成功或失敗的alert，用model傳出
     */
    public function index(Request $request){
        #param
        $view = "welcome_index";
        #取得資料表的資料
        //取出全部的留言
        $dataList = Boards::findAll();//way 1-自行定義的查詢function
        //要用哪一種都可以，依照自己的需求選擇
        //$dataList = DB::select("UserName", "UserEmail")->get();//way2-使用Laravel的SQL ORM方法
        //$dataList = DB::table("Users")->get();
        //$dataList = DB::all();//way3-使用Laravel的ORM方法
        //print_r($dataList);
        //die;
        #傳遞到顯示的blade
        $model["login_id"] = $request->session()->get("login_id");
        $model["login_name"] = $request->session()->get("login_name");
        $model["success"] = $request->session()->get("success"); //取得session中回傳來的訊息
        $model["fail"] = $request->session()->get("fail"); //取得session中回傳來的訊息
        $model["dataList"] = $dataList;
        return view($view, $model);
    }
    
    /**
     * create ->edit
     * @param $request
     * @return  送到edit
     *          1.$request:目前都沒有
     *          2.不帶key值(用來判斷新增或修改)
     */
    public function create(Request $request) {
        return $this->edit($request, null);//null=>create 沒有key，所以不需要帶入值
    }
    
    /**
     * index 畫面
     * @param $request
     * @return  view:index.blade.php
     *          1.login_id、login_name:登入有id跟name
     *          2.dataList:全部留言
     *          3.success、fail:如果有成功或失敗的alert，用model傳出
     */
    public function edit(Request $request, $key) {
        #param
        $view = "welcome_create";
        //$data = new Users();
        
        /*
         * 這塊程式保留給各位去思考
         * 提示1:要能知道現在是從新增還是修改
         * 提示2:要如何讓新增跟修改在同一頁面顯示，而不會壞掉
         * 提示3:新增的時候，new一個物件給它
         */
        
        #傳遞到顯示的blade
        $model["id"] = $key;
        if ($key != NULL) {
            $data = Boards::findMsg($key);
            $model["update"] = "update";
            $model["title"] = $data->title;
            $model["msg"] = $data->msg;
        }
        return view($view, $model);
    }
    
    /**
     * save
     * @param $request, $id
     * @return $msg
     * 
     */
    public function update(Request $request, $key) {
        #取得傳遞過來的資料
        request()->validate([
            "Title"=>["required", "min:3", "max:255"],
            "Msg"=>["required", "min:3"]
        ]);
        $title = ($request->has("Title")) ?$request->input("Title") :NULL;
        $msg = ($request->has("Msg")) ?$request->input("Msg") :NULL;
        
        #builder
        if($key == "new_a_msg"){
            $data = new Boards();
        }else{ 
            $data = Boards::find($key);
        }
        
        #put data
        if($title != "" && $msg != ""){
            //$data->update(["title"=>$title,"msg"=>$msg]);
            $data->title = $title;
            $data->msg = $msg;
            $data->user_id = $request->session()->has("login_id") ? $request->session()->get("login_id") : 3 ;
        }
        
        #save
        $data->save(); //新增和修改的儲存ORM相同
        
        #傳遞到顯示的blade
        if($key == "new_a_msg"){
            $model["success"] = "Create Finish!";
        }else{
            $model["success"] = "Edit Finish!";
        }
        return Redirect::to("welcome")->with($model); //放$model到session裡
    }
    
//     public function delete(Request $request) { //要收到他傳過來的東西
//         $data = Boards::find($request->input("msg_id"));
//         $data->delete();
//         //DB::delete("delete from todos where id= ?", [$request->id]);
//         return Redirect::to("welcome"); //回到首頁的網址
//     }
    
    public function destroy(Request $request, $key) { //要收到他傳過來的東西
        $data = Boards::find($key);
        $data->delete();
        $model["success"] = "Delete Success!";
        //DB::delete("delete from todos where id= ?", [$request->id]);
        return Redirect::to("welcome")->with($model); //回到首頁的網址
    }
    
    public function loginView() {
        return view("welcome_login");
    }
    
    /**
             * 註解
     */
    public function login(Request $request) { //要收到他傳過來的東西
        $view = "welcome_login";
        $data = Users::login($request);
        if($data){
            $model["success"] = "login success!";
            //$request->session()->forget("login_id");
            $request->session()->put("login_id", $data->id);
            $request->session()->put("login_name", $data->UserName);
            return Redirect::to("welcome")->with($model);
        }else{
            $model["fail"] = "login fail! 帳號或密碼不相符";
        }
        return view($view, $model);
        //DB::delete("delete from todos where id= ?", [$request->id]);
    }

    public function logout(Request $request) { //要收到他傳過來的東西
        $request->session()->forget("login_id", "login_name");
        $model["success"] = "logout success!";
        return Redirect::to("welcome")->with($model);
        //DB::delete("delete from todos where id= ?", [$request->id]);
    }
    
    public function signupView() {
        return view("welcome_signup");
    }
    
    public function signup(Request $request) { //要收到他傳過來的東西
        $view = "welcome_signup";
        $check = Users::idCheck($request);
        if($check == NULL && $request->input("password") == $request->input("ck_password")){
            $data = new Users();
            $data->id = $request->input("id");
            $data->password = $request->input("password");
            $data->UserName = $request->input("UserName");
            $data->UserEmail = $request->input("UserEmail");
            $data->save();
            $model["success"] = "signup success!<br/>請登入↗";
            return Redirect::to("welcome")->with($model);
        }else{
            $model["fail"] = "signup fail!";
            if($check != NULL){
                $model["fail"] .= "<br/>帳號已被使用";
            }
            if($request->input("password") != $request->input("ck_password")){
                $model["fail"] .= "<br/>確認密碼不相符";
            }
        }
        return view($view, $model);
        //DB::delete("delete from todos where id= ?", [$request->id]);
    }


}

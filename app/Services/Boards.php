<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Services\BaseModel;
use App\Services\Users;

class Boards extends BaseModel {
    protected $connection = "TestDb";
    protected $primaryKey = "msg_id";
    protected $table = "Boards";
    protected $fillable = [	"msg_id", "title", "msg", "user_id", "created_at", "updated_at",];//指定了可以被批量賦值的欄位(不一定要加)
    
    public $incrementing = true; //primaryKey非自動遞增設為false
    public $timestamps = true; //時間戳記非自動產生設定為false
    
    /**
     *  查詢資料表的所有資料
     * @abstract 思考看看，加上查詢的條件應該要如何寫
     * @author center69-陳煜珊
     * @return $dataList
     */
    public static function findAll(){
        $data = DB::table("Boards")
        ->join("Users", "Users.id", "=", "Boards.user_id")
        ->select("msg_id", "title", "msg", "Boards.created_at", "Boards.updated_at", "UserName");
        
        return $data->get();
    }
    public static function findMsg($msg_id){
        $data = DB::table("Boards")
        ->select("title", "msg")
        ->where("msg_id", $msg_id);
        return $data->first();
    }
    
}

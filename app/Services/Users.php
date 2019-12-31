<?php

namespace app\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\BaseModel;

class Users extends BaseModel {
    protected $connection = "TestDb";
    protected $primaryKey = "id";
    protected $table = "Users";
    protected $fillable = [	"id","UserName","UserEmail", "created_at", "updated_at",];//指定了可以被批量賦值的欄位(不一定要加)
    //$fillable would give you protection there 防止使用者直接改himl的input欄位造成id跳號，不在$fillable裡但是被create那會ignore, 用在Boards::create()
    
    public $incrementing = true; //primaryKey非自動遞增設為false
    public $timestamps = true; //時間戳記非自動產生設定為false
    
    /**
     *  查詢資料表的所有資料
     * @abstract 思考看看，加上查詢的條件應該要如何寫
     * @author center69-陳煜珊
     * @return $dataList
     */
    public static function findAll(){
        $data = DB::table("Users")
        ->select("id", "UserName", "UserEmail");
        
        return $data->get();
    }
    public static function login(Request $request){
        $data = DB::table("Users")
                ->where("id", "=", $request->id)
                ->where("password", "=", $request->password);
        return $data->first();
    }
    public static function idCheck(Request $request){
        $data = DB::table("Users")
        ->where("id", "=", $request->id);
        
        return $data->first();
    }
    
}
?>

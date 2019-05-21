<?php
namespace App\Http\Controllers\Goods;
use Illuminate\Http\Request;
use App\Model\GoodsModel;
use Illuminate\Support\Facades\Redis;
use App\Http\Controllers\Controller;
class GoodsController extends Controller{
    public function goods(){
        $data=GoodsModel::get();
        if($data){
            return json_encode(['code'=>0,'msg'=>'查询成功','data'=>$data]);
        }else{
            return json_encode(['code'=>1,'msg'=>'出错了']);
        }
    }
    public function goodsall(Request $request){
        $goods_id=$request->input('goods_id');
        $data=GoodsModel::where('goods_id',$goods_id)->first();
        if($data){
            return json_encode(['code'=>0,'msg'=>'查询成功','arr'=>$data]);
        }else{
            return json_encode(['code'=>1,'msg'=>'出错了']);
        }
    }
}
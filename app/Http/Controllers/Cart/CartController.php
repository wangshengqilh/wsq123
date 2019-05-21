<?php
namespace App\Http\Controllers\Cart;
use Illuminate\Http\Request;
use App\Model\CartModel;
use App\Model\OrderModel;
use Illuminate\Support\Facades\Redis;
use App\Http\Controllers\Controller;
class CartController extends Controller{
    public function addcart(Request $request){
        $uid=$request->input('uid');
        $price=$request->input('price');
        $goods_id=$request->input('goods_id');
        if(empty($uid)){
            return json_encode(['code'=>1,'msg'=>'您还没有登录，请先登录']);
        }else{
            $cartinfo=[
                'goods_id'=>$goods_id,
                'num'=>1,
                'add_time'=>time(),
                'uid'=>$uid,
                'total'=>$price
            ];
            $arr=CartModel::insert($cartinfo);
            if($arr){
                return json_encode(['code'=>0,'msg'=>'加入购物车成功']);
            }else{
                return json_encode(['code'=>1,'msg'=>'加入购物车失败']);
            }
        }
    }
    public function cartshow(Request $request){
        $uid=$request->input('uid');
        if(empty($uid)){
            return json_encode(['code'=>1,'msg'=>'您还没有登录，请先登录']);
        }else{
            $data=CartModel::where('uid',$uid)->join('p_goods','p_cart.goods_id','=','p_goods.goods_id')->get();
            if($data){
                return json_encode(['code'=>0,'msg'=>'查询成功','data'=>$data]);
            }else{
                return json_encode(['code'=>1,'msg'=>'购物车没有商品']);
            }
        }
    }
    public function order(Request $request){
        $uid=$request->input('uid');
        $goods_id =$request->input('goods_id');
        $id =$request->input('id');
        $order_amount=$request->input('order_amount');
        $order_sn = 'CRM'.rand(100,999).time();
        $time=time();
        if(empty($uid)){
            return json_encode(['code'=>2,'msg'=>'您还没有登录，请先登录吧']);
        }else{
            $data=[
                'uid'=>$uid,
                'id'=>$id,
                'goods_id'=>$goods_id,
                'order_amount'=>$order_amount,
                'add_time'=>$time,
                'order_sn'=>$order_sn
            ];
            $arr=OrderModel::insert($data);
            if($arr){
                return json_encode(['code'=>0,'msg'=>'添加成功'],256);
            }else{
                return json_encode(['code'=>1,'msg'=>'添加失败']);
            }
        }
    }
    public function ordershow(Request $request){
        $uid=$request->input('uid');
        $arr=OrderModel::where('uid',$uid)->get();
        if($arr){
            return json_encode(['code'=>0,'msg'=>'查询成功','arr'=>$arr]);
        }else{
            return json_encode(['code'=>1,'msg'=>'你还没有数据']);
        }
    }
}
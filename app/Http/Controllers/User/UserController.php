<?php
namespace App\Http\Controllers\User;
use Illuminate\Http\Request;
use App\Model\UserModel;
use Illuminate\Support\Facades\Redis;
use App\Http\Controllers\Controller;
class UserController extends Controller{
    public function regs(){
        $data=file_get_contents('php://input');
        $res=base64_decode($data);
        $pub=openssl_get_publickey("file://".storage_path('app/key/pub.pem'));
        openssl_public_decrypt($res,$arr,$pub);
        $arrs=json_decode($arr,true);
        dump($arrs);
        $pass1 = $arrs['pass1'];
        $pass2 = $arrs['pass2'];
        if($pass1 !== $pass2){
            die("密码不一致");
        }
        $where=[
            'nick_name'=>$arrs['name']
        ];
        $email=UserModel::where($where)->first();
        if($email){
            die('已经有了');
        }
        $b=[
            'nick_name'=>$arrs['name'],
            'pass'=>$arrs['pass1'],
            'email'=>$arrs['email']
        ];
        $reg=UserModel::insert($b);
        if($reg){
//            header("Refresh:3;url=http://wsq.96myshop.cn/use/log");
            echo '注册成功';
        }else{
            echo '注册失败';
        }
    }
    public function logs(){
        $data=file_get_contents('php://input');
        $arr=base64_decode($data);
        $pub=openssl_get_publickey("file://".storage_path('app/key/pub.pem'));
        openssl_public_decrypt($arr,$res,$pub);
        $a=json_decode($res,true);
        $name=$a['name'];
        $pass=$a['pass'];
        $u=UserModel::where(['nick_name'=>$name])->first();
//        dump($u);die;
        if($u){
            if($pass==$u['pass']){
                $token = substr(md5(time().mt_rand(1,99999)),10,10);
                setcookie('token',$token,time()+604800,'/','',false,true);
                $redis_key = 'log';
                $number=Redis::set($redis_key,$token);
                Redis::expire($redis_key, 604800);
                $a=Redis::get($redis_key);
                dump($a);
                echo "登录成功";
            }else{
                echo "密码不正确";
                header("Refresh:2;url=http://wsq.96myshop.cn/use/log");
            }
        }else{
            echo "没有此用户";
            header("Refresh:2;url=http://wsq.96myshop.cn/use/log");
        }
    }
}
<?php
namespace App\Http\Controllers\User;
use Illuminate\Http\Request;
use App\Model\UserModel;
use Illuminate\Support\Facades\Redis;
use App\Http\Controllers\Controller;
class UsersController extends Controller{
    public function reg(Request $request){
        $name=$request->input('name');
        $pass1=$request->input('pass1');
        $pass2=$request->input('pass2');
        $email=$request->input('email');
        $data=[
            'name'=>$name,
            'pass1'=>$pass1,
            'pass2'=>$pass2,
            'email'=>$email
        ];
        $data=json_encode($data,256);
        $url='http://wsq1.96myshop.cn/reg';
        //初始化URL
        $ch = curl_init();
        //设置抓取的url
        curl_setopt($ch, CURLOPT_URL, $url);
        //设置post方式提交
        curl_setopt($ch, CURLOPT_POST, 1);
        //传值
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        //返回结果不输入
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //响应头
        curl_setopt($ch,CURLOPT_HTTPHEADER,['Content-type:text/plain']);
        //获取抛出错误
        $num=curl_errno($ch);
        if($num>0){
            echo 'curl错误码：'.$num;exit;
        }
        //发起请求
        curl_exec($ch);
        //关闭并释放资源
        curl_close($ch);
    }
    public function login(Request $request){
        $name=$request->input('name');
        $pass=$request->input('pass');
        $data=[
          'name'=>$name,
          'pass'=>$pass
        ];
        $data=json_encode($data,256);
        $url='http://wsq1.96myshop.cn/login';
        //初始化URL
        $ch = curl_init();
        //设置抓取的url
        curl_setopt($ch, CURLOPT_URL, $url);
        //设置post方式提交
        curl_setopt($ch, CURLOPT_POST, 1);
        //传值
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        //返回结果不输入
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //响应头
        curl_setopt($ch,CURLOPT_HTTPHEADER,['Content-type:text/plain']);
        //获取抛出错误
        $num=curl_errno($ch);
        if($num>0){
            echo 'curl错误码：'.$num;exit;
        }
        //发起请求
        curl_exec($ch);
        //关闭并释放资源
        curl_close($ch);
    }

    public function center(){
        $token=$_GET['token'];
        $uid=$_GET['uid'];
        $na=UserModel::where('uid',$uid)->first();
        $json_ns=json_encode($na);
        return $json_ns;
    }
}
<?php
namespace App\Http\Controllers\Openssl;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
class JieController extends Controller{
    public function jie(Request $request){
        $name=$request->input('name');
        $pass=$request->input('pass');
        if (empty($name) || empty($pass)){
            $response=[
                'status' =>500,
                'msg' => '账号或密码不能为空'
            ];
        }else{
            $response=[
                'status' =>200,
                'msg' => '登录成功'
            ];
        }
        $data=[
            'name'=>$name,
            'pass'=>$pass
        ];
        $data=json_encode($data);
        $this->ssl($data);
        $url='http://wsq.96myshop.cn/fa';
        //初始化URL
        $ch = curl_init();
        //设置抓取的url
        curl_setopt($ch, CURLOPT_URL, $url);
        //设置post方式提交
        curl_setopt($ch, CURLOPT_POST, 1);
        //传值
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        //返回结果不输入
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //执行命令
        $response = curl_exec($ch);
        $response=json_encode($response,256);
        return $response;
    }
    public function ssl($data)
    {
        $key='123';
        $iv=mt_rand(111111,999999).'zxcvbnmqwe';    #固定16位的随机字符串
        $enc_str=openssl_encrypt($data,'AES-128-CBC',$key,OPENSSL_RAW_DATA ,$iv);
        echo $enc_str;
        echo "<hr>";
        $dec_str=openssl_decrypt($enc_str,'AES-128-CBC',$key,OPENSSL_RAW_DATA,$iv);
        echo $dec_str;
    }
    public function feis(){
        $data=file_get_contents('php://input');
        $arr=base64_decode($data);
        $pub=openssl_get_publickey("file://".storage_path('app/key/pub.pem'));
        openssl_public_decrypt($arr,$res,$pub);
        echo $res;
    }
    public function jies(){
        $data=file_get_contents('php://input');
        $res=base64_decode($data);
        $key='1234';
        $iv='1234567890qazwsx';
        $arr=openssl_decrypt($res,'AES-128-CBC',$key,OPENSSL_RAW_DATA,$iv);
        echo $arr;
    }
    public function yans(){
        $sign=$_GET['sign'];
        $data=file_get_contents('php://input');
        if(empty($sign) || empty($data)){
            echo '错误';
        }
        $arr=base64_decode($sign);
        $pub=openssl_get_publickey("file://".storage_path('app/key/pub.pem'));
        $verify=openssl_verify($data,$arr,$pub);
        echo $data;
        if($verify!=1){
            die('验签失败');
        }else{
            echo '成功';
        }
    }
}
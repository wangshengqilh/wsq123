<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Redis;

use Closure;


class Token
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $token=Redis::get('logs');
        $ui=Redis::get('ui');
//        $to=$request->input('token');
//        $uid=$request->input('uid');
        $to=$_GET['token'];
        $uid=$_GET['uid'];
        if($to!=$token || $uid!=$ui){
            $response = [
                'code' => 1111,
                'msg' => '验证不通过'
            ];
            return json_encode($response,256);
        }
        return $next($request);
    }
}
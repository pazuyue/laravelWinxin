<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/23
 * Time: 15:01
 */

namespace App\Http\Controllers\WeiXin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

define("TOKEN","yueguang");

class GetMsgController extends Controller
{
    public function getmsg(Request $request){
        $signature = $request["signature"];
        $timestamp = $request["timestamp"];
        $nonce = $request["nonce"];
        $echoStr = $request["echostr"];

        $tmpArr = array(TOKEN,$timestamp,$nonce);
        sort($tmpArr,SORT_STRING);
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );
        if( $signature == $tmpStr )
        {
            echo $echoStr;
        }
        else
            echo "Error";

        exit;
    }
}


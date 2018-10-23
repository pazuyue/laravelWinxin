<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/23
 * Time: 15:01
 */

define("TOKEN","yueguang");

$signature = $_GET["signature"];
$timestamp = $_GET["timestamp"];
$nonce = $_GET["nonce"];
$echoStr = $_GET["echostr"];

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

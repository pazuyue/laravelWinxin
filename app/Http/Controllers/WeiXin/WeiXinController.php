<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/23
 * Time: 16:04
 */
namespace App\Http\Controllers\WeiXin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class WeiXinController extends Controller
{

    public function getOpenid(Request $request){

    }

    /**
     * 获取code
     */
    public function actionGetCode()
    {
        $response_type = 'code';
        $scope = 'snsapi_userinfo';

        $url = 'https://open.weixin.qq.com/connect/oauth2/authorize?';
        $url .= 'appid=wx98e276bea8ddeca5';
        $url .= '&redirect_uri=' . urlencode('193.112.109.76/Oauth.php');
        $url .= '&response_type=code';

        $url .= '&scope=snsapi_userinfo';
        $url .= '&#wechat_redirect';

        return redirect($url);

    }

}
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
        $url = 'https://open.weixin.qq.com/connect/oauth2/authorize?';
        $url .= 'appid=wx98e276bea8ddeca5';
        $url .= '&redirect_uri=' . urlencode('http://193.112.109.76/Oauth.php');
        $url .= '&response_type=code';

        $url .= '&scope=snsapi_userinfo';
        $url .= '&#wechat_redirect';

        return redirect()->away($url);
    }

    /**
     * 判断是否关注
     */
    public function actionsubscribe(){
        $token='14_nkrjAsGQlvYE4HuNXtW8UtfsnrsTqR6haun7NUAmuTiAgznmr_H26FZhNaFSku4OX010n6TgYZWDsHXVVmZBam85NeNtmpYmCouycvMGNBE';
        $openid='oPuK51SdvJnSnBVoiaIPpce0ebvE';
        $subscribe_msg = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=$token&openid=$openid";
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,$subscribe_msg);
        curl_setopt($ch,CURLOPT_HEADER,0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        $data = curl_exec($ch);
        $data = json_decode($data,true);
        curl_close($ch);
        dump($data);
    }

    /**
     * 获取access_token
     */
    public function actionGettoken()
    {
        $url = 'https://api.weixin.qq.com/sns/oauth2/access_token?';
        $url .= 'appid=wx98e276bea8ddeca5';
        $url .= '&secret=84415899ceb3c77b58364d2468023cf7';
        $url .= '&code=061fS4V50YZnPJ1g3mV50fFWU50fS4Vi';
        $url .= '&grant_type=authorization_code';


        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_HEADER,0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        $data = curl_exec($ch);
        $data = json_decode($data,true);
        curl_close($ch);
        dump($data);

        $access_token = $data['access_token'];
        $openid = $data['openid'];
        $get_user_info_url = 'https://api.weixin.qq.com/sns/userinfo?access_token='.$access_token.'&openid='.$openid.'&lang=zh_CN';

        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,$get_user_info_url);
        curl_setopt($ch,CURLOPT_HEADER,0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        $res = curl_exec($ch);
        curl_close($ch);
        $res = json_decode($res,true);
    }



}
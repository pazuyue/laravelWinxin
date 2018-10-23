<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/23
 * Time: 16:04
 */

namespace App\Http\Controllers\WeiXin;

use App\Http\Controllers\Controller;

class WeiXinController extends Controller
{
    public function __construct(){
        $config = config('weixin');
        $appid =$config['appid'];
        $secret =$config['secret'];
    }

    private function curlGet($url)
    {
        //初始化
        $curl = curl_init();
        //设置抓取的url

        curl_setopt($curl, CURLOPT_URL, $url);
        //设置头文件的信息作为数据流输出
        curl_setopt($curl, CURLOPT_HEADER, 0);
        //设置获取的信息以文件流的形式返回，而不是直接输出。
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        //执行命令
        $data = curl_exec($curl);
        //关闭URL请求
        curl_close($curl);
        //显示获得的数据
        return $data;
    }

    private function curlPost($url, $post_data)
    {
        //初始化
        $curl = curl_init();
        //设置抓取的url
        curl_setopt($curl, CURLOPT_URL, $url);
        //设置头文件的信息作为数据流输出
        curl_setopt($curl, CURLOPT_HEADER, 0);
        //设置获取的信息以文件流的形式返回，而不是直接输出。
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        //设置post方式提交
        curl_setopt($curl, CURLOPT_POST, 1);
        //设置post数据
        /* $post_data = array(
             "username" => "coder",
             "password" => "12345"
         );*/
        curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);
        //执行命令
        $data = curl_exec($curl);
        //关闭URL请求
        curl_close($curl);
        //显示获得的数据
        print_r($data);
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
    public function actionsubscribe()
    {
        $token = $this->getAccessToken();

        $openid = 'oPuK51SdvJnSnBVoiaIPpce0ebvE';
        $subscribe_msg = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=$token&openid=$openid";
        $subscribe = json_decode($this->curlGet($subscribe_msg));
        dump($subscribe);
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
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        $data = curl_exec($ch);
        $data = json_decode($data, true);
        curl_close($ch);
        dump($data);

        $access_token = $data['access_token'];
        $openid = $data['openid'];
        $get_user_info_url = 'https://api.weixin.qq.com/sns/userinfo?access_token=' . $access_token . '&openid=' . $openid . '&lang=zh_CN';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $get_user_info_url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        $res = curl_exec($ch);
        curl_close($ch);
        $res = json_decode($res, true);
    }

    public function getAccessToken()
    {

        $url_get ="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$this->appid}&secret={$this->secret}";
        $json = $this->curlGet($url_get);
        $json = json_decode($json);
        if (isset($json->errmsg)) {
            dump('获取access_token发生错误：错误代码' . $json->errcode . ',微信返回错误信息：' . $json->errmsg);
            return "";
        }
        return $json->access_token;
    }

    public function responseMsg(){
        /*
        获得请求时POST:XML字符串
        不能用$_POST获取，因为没有key
         */
        $xml_str = $GLOBALS['HTTP_RAW_POST_DATA'];
        if(empty($xml_str)){
            die('');
        }
        if(!empty($xml_str)){
            // 解析该xml字符串，利用simpleXML
            libxml_disable_entity_loader(true);
            //禁止xml实体解析，防止xml注入
            $request_xml = simplexml_load_string($xml_str, 'SimpleXMLElement', LIBXML_NOCDATA);

            //判断该消息的类型，通过元素MsgType
            return $request_xml;
        }
    }


}
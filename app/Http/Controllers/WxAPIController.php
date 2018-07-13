<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use RequestAPI;
use WxTimeSend;
use WxConfigModel;

class WxAPIController extends Controller
{
    public function get_access_token()
    {

        $WxTimeSend = new WxTimeSend;
        $WxTimeSend->args_check();

        if ($WxTimeSend->is_err) {
            echo $WxTimeSend->format_error_msg();
            exit;
        }

        $WxConfigModel =  WxConfigModel::get_instance();

        // 先获得 access token
        $res = json_decode(RequestAPI::_request($WxConfigModel->get_wx_send_tmp_token_url(),
            ['appid'=>$WxConfigModel->get_wx_appId(), 'secret'=>$WxConfigModel->get_wx_appSecret(),'grant_type'=>'client_credential'],'wx_access_token'),true);
        $access_token = $res['access_token'];
        $template_url = $WxTimeSend->get_request_url()."?access_token={$access_token}";

        echo RequestAPI::_request($template_url,$WxTimeSend->format_return_param(),'','POST');

//        echo json_encode($template_url);
    }

    public function test()
    {
        echo "Test Page",PHP_EOL;
        $WxConfigModel =  WxConfigModel::get_instance();
        echo $WxConfigModel->get_wx_appSecret();
    }
}

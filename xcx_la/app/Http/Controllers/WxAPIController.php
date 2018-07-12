<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use RequestAPI;
use WxTimeSend;

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

        $wx_info = config('wxInfo.wx_app_info');
        $url_config = config('wxInfo.wx_request_url');
        $token_url = $url_config['access_token'];

        $res = json_decode(RequestAPI::_request($token_url, ['appid'=>$wx_info['appId'], 'secret'=>$wx_info['appSecret'],'grant_type'=>'client_credential'],'wx_access_token'),true);
        $access_token = $res['access_token'];
        $template_url = $WxTimeSend->get_request_url()."?access_token={$access_token}";

        echo RequestAPI::_request($template_url,$WxTimeSend->format_return_param(),'','POST');

//        echo json_encode($template_url);
    }

    public function test()
    {
        echo "Test Page";
    }
}

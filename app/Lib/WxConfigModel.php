<?php
/**
 * Created by PhpStorm.
 * User: lzx
 * Date: 2018/7/13
 * Time: 17:53
 * wx配置获取模型
 */

use Illuminate\Support\Facades\Config;

class WxConfigModel
{
    public static $_instance;

    private $_config;

    const WX_APP_ID_INFO = 'wx_app_info';
    const WX_REQUEST_URL = 'wx_request_url';
    const WX_TMP_ID      = 'wx_template_id';

    public static function get_instance()
    {
        if (!isset(self::$_instance)) {
            self::$_instance = new self;
        }

        return self::$_instance;
    }

    private function __construct()
    {
        $this->_config = config('wxInfo');
    }

    // 基本微信的信息数组
    public function get_wxInfo()
    {
        return $this->_config;
    }

    // 我的appId
    public function get_wx_appId()
    {
        return $this->_config[self::WX_APP_ID_INFO]['appId'];
    }

    // app密匙
    public function get_wx_appSecret()
    {
        return $this->_config[self::WX_APP_ID_INFO]['appSecret'];
    }

    // 请求发送模板需要的 access token 地址
    public function get_wx_send_tmp_token_url()
    {
        return $this->_config[self::WX_REQUEST_URL]['access_token'];
    }

    // 获取模板地址
    public function get_wx_send_tmp_url()
    {
        return $this->_config[self::WX_REQUEST_URL]['template'];
    }

    // 获取模板 ID
    public function get_wx_send_tmp_id()
    {
        return $this->_config[self::WX_TMP_ID]['user_crontab_tmp_id'];
    }
}
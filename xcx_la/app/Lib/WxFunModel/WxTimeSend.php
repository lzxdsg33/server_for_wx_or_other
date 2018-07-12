<?php

/**
 * Created by PhpStorm.
 * User: lzx
 * Date: 2018/7/8 0008
 * Time: 13:50
 * 定时发送类
 */

use Illuminate\Support\Facades\Config;

class WxTimeSend
{
    const ERRCODE_NO_TOUSER = 101;   // 缺少 touser 参数的错误码
    const ERRCODE_NO_FORMID = 102;   // 缺少 formid 参数的错误码

    private $_request_url;
    private $_tmp_id;
    private $_param;
    private $_is_err;
    private $_error_array;

    public function __construct()
    {
        $this->_request_url = config('wxInfo.wx_request_url')['template'];
        $this->_tmp_id = config('wxInfo.wx_template_id')['user_crontab_tmp_id'];
        $this->_param = [
            'touser' => '',
            'template_id' => '',
            'form_id'  => '',
            'page'    => '',
            'data'    => '',
            'color'   => '',
            'emphasis_keyword' => ''
        ];
        $this->_error_array = ['errcode'=>0, 'errmsg'=>'error'];
        $this->is_err = false;
    }

    public function args_check()
    {
        if ( !isset($_GET['touser']) ) {
            $this->_error_array['errcode'] = self::ERRCODE_NO_TOUSER;
            $this->_error_array['errmsg'] = 'touser is unset';
            $this->is_err = true;
        }
        if ( !isset($_GET['formId']) ) {
            $error_array['errcode'][] = self::ERRCODE_NO_FORMID;
            $error_array['errmsg'] = 'formId is unset';
            $this->is_err = true;
        }
    }

    public function is_error()
    {
        return $this->_is_err;
    }

    public function format_error_msg()
    {
        return json_encode($this->_error_array);
    }

    public function format_return_param()
    {
        $this->_param['touser']      = $_GET['touser'];
        $this->_param['template_id'] = $_GET['template_id'];
        $this->_param['form_id']     = $_GET['formId'];
        $this->_param['data']        = ['keyword1' => ['value'=>date('Y-m-d h:i:s', $_SERVER['REQUEST_TIME'])], 'keyword2'=> ['value'=>'测试地点']];
        return $this->_param;
    }

    public function get_request_url()
    {
        return $this->_request_url;
    }
}
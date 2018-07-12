<?php
/**
 * Created by PhpStorm.
 * User: lzx
 * Date: 2018/7/1 0001
 * Time: 17:30
 * 微信小程序配置
 */
return [
    // 微信 个人ID 与 密匙
    'wx_app_info' => [
        'appId'    => 'wx34d04079a30915b9',
        'appSecret' => '1e1308583fcadcef9c8d5c317154e1b3',
    ],

    // 微信 各种请求地址
    'wx_request_url' => [
        // access_token url
        'access_token' => 'https://api.weixin.qq.com/cgi-bin/token',
        // 推送模板 url
        'template'     => 'https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send',
    ]
];
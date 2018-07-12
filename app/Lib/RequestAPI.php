<?php

class RequestAPI
{
    public static function _request($url, $params='', $request_for='' ,$mode='GET', $timeout=20)
    {
        // 创建一个cURL资源
        $ch = curl_init();

        // 设置URL和相应的选项

        // 设置持续时间
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);

        curl_setopt($ch, CURLOPT_HEADER, 0);

        // 返回文件流
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        if ($request_for == 'wx_access_token') {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);//跳过证书验证
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        }

        // post模式
        if (strtoupper($mode) == 'POST') {
            curl_setopt($ch, CURLOPT_POST, true);

            if (is_array($params)) {
                $data = json_encode($params);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json;charset=utf-8','Content-Length:' . strlen($data)));
            } else {
                curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
            }
        } else {
            // get模式
            if (is_array($params)) {
                $url .= (strpos($url, '?') === false ? '?' : '&') . http_build_query($params);
            } else {
                $url .= (strpos($url, '?') === false ? '?' : '&') . $params;
            }
        }

        curl_setopt($ch, CURLOPT_URL, $url);

        // 抓取URL并把它传递给浏览器
        $result = curl_exec($ch);
        $errno = curl_errno($ch);
        if ($errno) {
            $result = json_encode(['error'=>1, 'error_info'=>$errno]);
        }
        // 关闭cURL资源，并且释放系统资源
        curl_close($ch);
        return $result;
    }

}
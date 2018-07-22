<?php

namespace App\Http\Controllers;

use RequestAPI;
use WxTimeSend;
use WxConfigModel;

use Illuminate\Support\Facades\URL;
class WxAPIController extends Controller
{
    public function get_access_token()
    {

        $WxTimeSend = new WxTimeSend;
        $WxTimeSend->args_check();

        if ( $WxTimeSend->is_error() ) {
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
//        echo "Test Page",PHP_EOL;
//        $output = shell_exec('python.exe D:\pytest\image_add_font.py');
//        system('C:\Users\Administrator.PC-20171011CEDK\AppData\Local\Programs\Python\Python37\python.exe D:\pytest\image_add_font.py -dp 1 -ip D:\pytest\image\huangtu_15.jpg -op D:\pytest\image -c 狂干一条街 ');
//        exec('python D:\pytest\a.py',$array,$ret);
//        var_dump($array);
//        echo("ret is $ret");
//        echo RequestAPI::_request('http://www.whistlalk.com/wx_upload',array(),'','POST');
//        echo public_path();
        // 输出图片前不能有输出,ob_clean()清空就可以显示图片了！！！！
//        ob_clean();
//        header('Content-type: image/jpg');
        $dst_path = storage_path().'\huangtu_22.jpg';
        $src_path = storage_path().'\lanaya.jpg_20180721162814.jpg';
//创建图片的实例
        $dst = imagecreatefromstring(file_get_contents($dst_path));
        $black = imagecolorallocate($dst, 0,0, 0);
        imagefttext($dst, 18, 0, 234, 475, $black, 'C:\Windows\Fonts\msyh.ttf', 'test');
        list($dst_w, $dst_h, $dst_type) = getimagesize($dst_path);
        echo $dst_w;
//        switch ($dst_type) {
//            case 1://GIF
//                header('Content-Type: image/gif');
//                imagegif($dst);
//                break;
//            case 2://JPG
//                header('Content-Type: image/jpeg');
//                imagejpeg($dst);
//                break;
//            case 3://PNG
//                header('Content-Type: image/png');
//                imagepng($dst);
//                break;
//            default:
//                break;
//        }
        imagedestroy($dst);
    }
}

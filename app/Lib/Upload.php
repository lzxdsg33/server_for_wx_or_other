<?php
/**
 * Created by PhpStorm.
 * User: lzx
 * Date: 2018/7/15 0015
 * Time: 17:33
 * 处理上传文件的模块
 */
use Illuminate\Http\Request;

class Upload
{
    private $_file;
    private $_is_err = false;
    private $_error_msg;
    private $_user_name;

    private $_file_type_array = array(
        'jpg', 'jpeg', 'png', 'gif', 'txt', // 暂时这几个个
    );

    const UNVERIFY_FILE_ERROR     = 'unverify file have upload';
    const FILE_TYPE_ERROR         = 'illegal file type as : ';
    const UPLOAD_FILE_ERROR       = 'upload file faile !';

    public function __construct(Request $request)
    {
        $this->init_error_msg();

        $this->_file = $request->file('file');
        $this->_user_name = $request->input('user');

        // 看文件是否有问题
        $this->verify();
        if ( !$this->is_error() ) {
            $ext = $this->_file->getClientOriginalExtension(); //文件扩展名
            if( !in_array($ext, $this->_file_type_array) ) {
                $this->record_error(self::FILE_TYPE_ERROR.$ext);
                return;
            }
            if ( !$this->set_output($ext) ) {
                $this->record_error(self::UPLOAD_FILE_ERROR);
                return;
            }
        }
    }

    private function is_error()
    {
        return $this->_is_err;
    }

    private function verify()
    {
        if( !$this->_file->isValid() ) {
            $this->_is_err = true;
        }
    }

    private function init_error_msg()
    {
        $this->_is_err = true;
        $this->_error_msg = array(
            'error'  => 0,
            'err_msg' => '',
        );
    }

    private function record_error($msg)
    {
        $this->_error_msg['error'] = 1;
        $this->_error_msg['err_msg'][] = $msg;
    }

    private function set_output($ext)
    {
        $path = '/tmp/data/uploads/images/'.$this->_user_name;
        $file_name = date("YmdHis",time()).'-'.uniqid().".".$ext;

        File::isDirectory($path) or File::makeDirectory($path, 0777, true, true);
        return $this->_file->move($path,$file_name);
    }

    public function format_res_info()
    {
        return json_encode($this->_error_msg);
    }
}
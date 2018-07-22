<?php
/**
 * Created by PhpStorm.
 * User: lzx
 * Date: 2018/7/15 0015
 * Time: 17:33
 * 处理上传文件的模块
 */
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class Upload
{
    private $_file;
    private $_is_err = false;
    private $_error_msg;
    private $_user_name;
    private $_file_name;
    private $_ext;

    private $_file_type_array = array(
        'jpg', 'jpeg', 'png', 'gif', 'txt', // 暂时这几个个
    );

    const UNVERIFY_FILE_ERROR     = 'unverify file have upload';
    const FILE_TYPE_ERROR         = 'illegal file type as : ';
    const UPLOAD_FILE_ERROR       = 'upload file faile !';
    const USER_ERROR              = 'no user name';

    const UPLOAD_COMPLETE         = 'Upload Success !';

    public function __construct()
    {
        $this->init_error_msg();

        if($this->verify()) {

            if (!isset($_POST['userName'])) {
                $this->record_error(self::USER_ERROR.__LINE__);
                return;
            } else {
                $this->_user_name = $_POST['userName'];
            }

            if( !in_array($this->_ext, $this->_file_type_array) ) {
                $this->record_error(self::FILE_TYPE_ERROR.$this->_ext.__LINE__);
                return;
            }
            if ( !$this->is_error() ) {
                if ( !$this->set_output() ) {
                    $this->record_error(self::UPLOAD_FILE_ERROR.__LINE__);
                    return;
                }
            } else {
                $this->record_error($this->_error_msg['err_msg'].__LINE__);
                return;
            }

        } else {
            $this->record_error(self::UNVERIFY_FILE_ERROR.__LINE__);
        }

    }

    public function is_error()
    {
        return $this->_is_err;
    }

    private function init_error_msg()
    {
        $this->_is_err = false;
        $this->_error_msg = array(
            'error'  => 0,
            'err_msg' => self::UPLOAD_COMPLETE,
        );
    }

    private function verify()
    {
        if(!empty($_FILES['pic'])) {
            if ($_FILES['pic']['tmp_name'] == 'error' ) {
                $this->record_error(self::FILE_TYPE_ERROR);
                return false;
            }
            $this->_file      = $_FILES['pic']['tmp_name'];
            $this->_file_name = $_FILES['pic']['name'];

            $tmp       = explode('.',$_FILES['pic']['name']);
            $this->_ext= $tmp[count($tmp)-1];
            return true;
        }
        return false;
    }

    private function record_error($msg)
    {
        $this->_is_err = true;
        $this->_error_msg['error'] = 1;
        $this->_error_msg['err_msg'] = $msg;
    }

    private function set_output()
    {
        // linux
//        $path = storage_path().'/uploads/'.$this->_user_name;
        // windows
        $path = storage_path().'/'.$this->_user_name;
        $file_name = $path.'/'.date("YmdHis",time())."_".$this->_file_name;

        if(!is_dir($path)) {
            mkdir($path,0777);
        }

        // 文件绝对路径
        $this->_error_msg['file_name'] = $file_name;
        // 文件目录
        $this->_error_msg['file_path'] = $path;
        return move_uploaded_file($this->_file, $file_name);
    }

    public function get_res_info()
    {
        return $this->_error_msg;
    }

    public function format_res_info()
    {
        return json_encode($this->_error_msg);
    }
}
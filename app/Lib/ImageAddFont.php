<?php

/**
 * Created by PhpStorm.
 * User: lzx
 * Date: 2018/7/22 0022
 * Time: 17:12
 * 图片添加文字
 */
class ImageAddFont
{
    // 文字内容
    public $content;

    // 图片的实例
    private $_img;
    // 图片高
    private $_height;
    // 图片宽
    private $_weight;
    // 图片类型
    private $_type;
    // 字体大小
    private $_font_size;
    // 旋转
    private $_roll;
    // 字体
    private $_font;
    // 字体颜色
    private $_color;
    private $_x;
    private $_y;

    private $_color_map = array(
        'cherry' => array(240,20,110),
        'default'=> array(0,0,0),    // black
        'red'    => array(255,0,0),
        'blue' => array(0,0,255),
    );

    private $_font_map = array(
        'default' => 'C:\Windows\Fonts\msyh.ttf',
    );

    function __construct($path, $content)
    {
        // 内容
        $this->content = $content;
        // 获取图片的 宽高 文件类型
        list($this->_weight, $this->_height, $this->_type) = getimagesize($path);
        // 图片实例
        $this->_img  = imagecreatefromstring(file_get_contents($path));
        // 初始化属性
        $this->init();
    }

    // 设置文字位置
    public function set_position($x=250, $y=475)
    {
        $this->_x = $x;
        $this->_y = $y;
    }

    // 设置文字旋转
    public function set_roll($roll=0)
    {
        $this->_roll = $roll;
    }

    // 设置文字大小
    public function set_font_size($size=18)
    {
        $this->_font_size = $size;
    }

    // 设置文字字体
    public function set_font($font='default')
    {
        $this->_font = $this->_font_map[$font];
    }

    // 设置字体颜色
    public function set_font_color($color='cherry')
    {
        if(!isset($this->_color_map[$color])) {
            $_color = $this->_color_map['default'];
        } else {
            $_color = $this->_color_map[$color];
        }

        $this->_color = imagecolorallocate($this->_img, $_color[0], $_color[1], $_color[2]);
    }

    // 添加内容
    public function set_content($content='null')
    {
        $this->content = $content;
    }

    // 图片输出
    public function output()
    {
        // "字体大小", "旋转", "左边距","上边距", "字体颜色", "字体文件名称", "插入文本内容"
        imagefttext($this->_img, $this->_font_size, $this->_roll, $this->_x, $this->_y, $this->_color, $this->_font, $this->content);
        switch ($this->_type) {
            case 1://GIF
                header('Content-Type: image/gif');
                imagegif($this->_img);
                break;
            case 2://JPG
                header('Content-Type: image/jpeg');
                imagejpeg($this->_img);
                break;
            case 3://PNG
                header('Content-Type: image/png');
                imagepng($this->_img);
                break;
            default:
                break;
        }
        // 销毁图片
        imagedestroy($this->_img);
    }

    private function init()
    {
        $this->set_font();
        $this->set_font_color();
        $this->set_font_size();
        $this->set_position();
        $this->set_roll();
    }
}
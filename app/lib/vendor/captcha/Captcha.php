<?php

/**
 * @link      http://www.giantnet.cn/
 * @copyright Copyright (c) 2016
 * @version   Beta 1.0
 * @author    kevin <xuwenhu369@163.com>
 */

namespace lib\vendor\captcha;

/**
 * Class ValidateCode
 * 图片验证码
 */
class Captcha
{

    /**
     * @var string 随机因子
     */
    private $charset = 'abcdefghkmnprstuvwxyzABCDEFGHKMNPRSTUVWXYZ23456789';

    /**
     * @var string 验证码
     */
    private $code;

    /**
     * @var int 验证码最小长度
     */
    private $minlen = 0;

    /**
     * @var int 验证码最大长度
     */
    private $maxlen = 0;

    /**
     * @var int 验证码长度
     */
    private $codelen = 4;

    /**
     * @var int 验证码图片宽度
     */
    private $width = 130;

    /**
     * @var int 验证码图片高度
     */
    private $height = 50;

    /**
     * @var 图形资源句柄
     */
    private $img;

    /**
     * @var string 指定的字体文件, 注意字体路径要写对，否则显示不了图片
     */
    private $font = 'elephant.ttf';

    /**
     * @var int 指定字体大小
     */
    private $fontsize = 20;

    /**
     * @var 指定字体颜色
     */
    private $fontcolor;

    /**
     * @var string 指定背景色
     */
    private $backcolor = '';

    /**
     * ValidateCode constructor. 构造方法初始化
     */
    public function __construct($config = []) {
        if (!empty($config)) {
            foreach ($config as $k => $c) {
                if (isset($this->$k)) {
                    $this->$k = $c;
                }
            }
        }
        if ($this->minlen > 0 && $this->maxlen > 0) {
            $this->codelen = rand($this->minlen, $this->maxlen);
        }
        $this->font = dirname(__FILE__) . '/font/' . $this->font;
    }

    /**
     * @param $colour  色值
     *
     * @return array|bool
     */
    private function hex2rgb($colour) {
        if ($colour[0] == '#') {
            $colour = substr($colour, 1);
        }
        if (strlen($colour) == 6) {
            list($r, $g, $b) = [$colour[0] . $colour[1], $colour[2] . $colour[3], $colour[4] . $colour[5]];
        }
        elseif (strlen($colour) == 3) {
            list($r, $g, $b) = [$colour[0] . $colour[0], $colour[1] . $colour[1], $colour[2] . $colour[2]];
        }
        else {
            list($r, $g, $b) = [t_rand(157, 255), mt_rand(157, 255), mt_rand(157, 255)];
        }

        return [hexdec($r), hexdec($g), hexdec($b)];
    }

    /**
     * 生成随机码
     */
    private function createCode() {
        $_len = strlen($this->charset) - 1;
        for ($i = 0; $i < $this->codelen; $i++) {
            $this->code .= $this->charset[mt_rand(0, $_len)];
        }
    }

    /**
     * 生成背景
     */
    private function createBg() {
        $this->img = imagecreatetruecolor($this->width, $this->height);
        if (!empty($this->backcolor)) {
            $rgb = $this->hex2rgb($this->backcolor);
            $color = imagecolorallocate($this->img, $rgb[0], $rgb[1], $rgb[2]);
        }
        else {
            $color = imagecolorallocate($this->img, mt_rand(157, 255), mt_rand(157, 255), mt_rand(157, 255));
        }
        imagefilledrectangle($this->img, 0, $this->height, $this->width, 0, $color);
    }

    /**
     * 生成文字
     */
    private function createFont() {
        $_x = $this->width / $this->codelen;
        for ($i = 0; $i < $this->codelen; $i++) {
            $this->fontcolor = imagecolorallocate($this->img, mt_rand(0, 156), mt_rand(0, 156), mt_rand(0, 156));
            imagettftext($this->img, $this->fontsize, mt_rand(-30, 30), $_x * $i + mt_rand(1, 5), $this->height / 1.4, $this->fontcolor, $this->font, $this->code[$i]);
        }
    }

    /**
     * 生成计算类文字
     */
    private function createQuestion() {
        $a = rand(0, 99);
        $b = rand(0, 9);
        $c = rand(0, 1);
        $arr = ['+', '--'];
        $alg = $arr[$c];

        $this->code = $alg == "+" ? ($a + $b) : ($a - $b);

        $_s = $a . $alg . $b . ' = ?';
        $_x = $this->width / $this->codelen;
        $this->fontcolor = imagecolorallocate($this->img, mt_rand(0, 156), mt_rand(0, 156), mt_rand(0, 156));
        imagettftext($this->img, $this->fontsize, mt_rand(-10, 5), 10, $this->height / 1.4, $this->fontcolor, $this->font, $_s);
    }

    /**
     * 生成线条、雪花
     */
    private function createLine() {
        //线条
        for ($i = 0; $i < 6; $i++) {
            $color = imagecolorallocate($this->img, mt_rand(0, 156), mt_rand(0, 156), mt_rand(0, 156));
            imageline($this->img, mt_rand(0, $this->width), mt_rand(0, $this->height), mt_rand(0, $this->width), mt_rand(0, $this->height), $color);
        }
        //雪花
        for ($i = 0; $i < 100; $i++) {
            $color = imagecolorallocate($this->img, mt_rand(200, 255), mt_rand(200, 255), mt_rand(200, 255));
            imagestring($this->img, mt_rand(1, 5), mt_rand(0, $this->width), mt_rand(0, $this->height), '*', $color);
        }
    }

    /**
     * 输出图片
     */
    private function outPut() {
        header('Content-type:image/png');
        imagepng($this->img);
        imagedestroy($this->img);
    }

    /**
     * 对外生成普通验证码
     */
    public function getImg() {
        $this->createBg();
        $this->createCode();
        $this->createLine();
        $this->createFont();
        $this->outPut();
    }

    /**
     * 对外生成计算类验证码
     */
    public function getReckonImg() {
        $this->createBg();
        $this->createQuestion();
        $this->outPut();
    }

    /**
     * @return string 获取验证码
     */
    public function getCode() {
        return strtolower($this->code);
    }

}

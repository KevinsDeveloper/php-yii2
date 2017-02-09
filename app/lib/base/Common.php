<?php

/**
 * @Copyright (C) 2015
 * @Author kevin
 * @Version  1.0
 */

namespace lib\components;

use Yii;

/**
 * 公共基础方法类
 * Class Common
 * @package lib\components
 */
class Common
{

    /**
     * @desc 生成加密TOKEN
     * @param type $key 标识码
     * @return type
     */
    public static function createToken($key)
    {
        return Yii::$app->encrypt->encode($key) . '@@' . uniqid();
    }

    /**
     * @desc 解开用户Token
     * @param type $token
     * @return type
     */
    public static function undoToken($token)
    {
        $token_array = explode("@@", $token);
        $id = Yii::$app->encrypt->decode($token_array[0]);
        return intval($id);
    }

    /**
     * 生成卡片
     * @param  int $uid
     * @return int
     */
    public static function cardNumber($uid)
    {
        return (88000000 + $uid);
    }

    /**
     * 获取随机数方法
     * @access public
     * @return void
     */
    public static function randomkeys($length = 8)
    {
        $key = "";
        $pattern = '1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLOMNOPQRSTUVWXYZ';
        for ($i = 0; $i < $length; $i++) {
            $key .= $pattern{mt_rand(0, 62)};    //生成php随机数
        }
        return $key;
    }

    /**
     * 生成唯一字符串
     * @return string
     */
    public static function uniqueGuid()
    {
        $charid = strtoupper(md5(uniqid(mt_rand(), true)));
        $uuid = substr($charid, 0, 8) . substr($charid, 8, 4) . substr($charid, 12, 4) . substr($charid, 16, 4) . substr($charid, 20, 12);
        return $uuid;
    }

    /**
     * 用户加密
     * @param type $keys 字符串
     * @return type
     */
    public static function encryption($keys)
    {
        return md5($keys . SAFE_KEY);
    }

    /**
     * 是否为非负的浮点数
     * @param  [type] $value
     * @return bool
     */
    public static function floatNumber($value)
    {
        return preg_match('/^\d+(\.\d+)?$/', $value) ? TRUE : FALSE;
    }

    /**
     * 非四舍五入取取小数点
     * @param type $number
     * @return type
     */
    public static function floor_money_format($number, $num = 2)
    {
        $number = floor($number * 100) / 100;
        return number_format($number, $num, '.', '');
    }

    /**
     * 格式化金额
     * @param type $number
     * @param type $type
     * @return type
     */
    public static function formatMoney($number, $type = 4)
    {
        return number_format($number, $type, ".", "");
    }

    /**
     * 返回错误信息
     * @param type $array
     * @return type
     */
    public static function modelMessage($array)
    {
        if (count($array) <= 0) {
            return;
        }
        $msg = '';
        if (!is_array($array)) {
            return $array;
        }
        foreach ($array as $val) {
            $msg .= isset($val[0]) ? $val[0] : $val;
        }
        return $msg;
    }

    /**
     * 检查输入的是否为数字
     * @param  $val
     * @return bool true false
     */
    public static function isNumber($val)
    {
        if (preg_match("/^[0-9]+$/", $val)) {
            return true;
        }
        return false;
    }

    /**
     * 获取时间错
     */
    public static function get_microtime()
    {
        list($usec, $sec) = explode(" ", microtime());
        return ((float) $usec + (float) $sec);
    }

    /**
     * 检查输入的是否为手机号
     * @param  $val
     * @return bool true false
     */
    public static function isMobile($val)
    {
        //该表达式可以验证那些不小心把连接符“-”写出“－”的或者下划线“_”的等等
        if (preg_match("/^13[0-9]{1}[0-9]{8}$|14[0-9]{1}[0-9]{8}$|15[0-9]{1}[0-9]{8}$|17[0-9]{1}[0-9]{8}$|18[0-9]{1}[0-9]{8}$|17[0-9]{1}[0-9]{8}$/", $val)) {
            return true;
        }
        return false;
    }

    /**
     * 检查输入的是否为邮编
     * @param  $val
     * @return bool true false
     */
    public static function isPostcode($val)
    {
        if (preg_match("/^[0-9]{4,6}$/", $val)) {
            return true;
        }
        return false;
    }

    /**
     * 邮箱地址合法性检查
     * @param  $val
     * @param  $domain
     * @return bool true false
     */
    public static function isEmail($val, $domain = "")
    {
        if (!$domain) {
            if (preg_match("/^[a-z0-9-_.]+@[\da-z][\.\w-]+\.[a-z]{2,4}$/i", $val)) {
                return true;
            }
            else {
                return false;
            }
        }
        if (preg_match("/^[a-z0-9-_.]+@" . $domain . "$/i", $val)) {
            return true;
        }
        else {
            return false;
        }
    }

    /**
     * 验证身份证号
     * @param $vStr
     * @return bool
     */
    public static function isCreditNo($vStr)
    {
        $vCity = array(
            '11', '12', '13', '14', '15', '21', '22',
            '23', '31', '32', '33', '34', '35', '36',
            '37', '41', '42', '43', '44', '45', '46',
            '50', '51', '52', '53', '54', '61', '62',
            '63', '64', '65', '71', '81', '82', '91'
        );

        if (!preg_match('/^([\d]{17}[xX\d]|[\d]{15})$/', $vStr)) {
            return false;
        }

        if (!in_array(substr($vStr, 0, 2), $vCity)) {
            return false;
        }

        $vStr = preg_replace('/[xX]$/i', 'a', $vStr);
        $vLength = strlen($vStr);

        if ($vLength == 18) {
            $vBirthday = substr($vStr, 6, 4) . '-' . substr($vStr, 10, 2) . '-' . substr($vStr, 12, 2);
        }
        else {
            $vBirthday = '19' . substr($vStr, 6, 2) . '-' . substr($vStr, 8, 2) . '-' . substr($vStr, 10, 2);
        }

        if (date('Y-m-d', strtotime($vBirthday)) != $vBirthday) {
            return false;
        }
        if ($vLength == 18) {
            $vSum = 0;

            for ($i = 17; $i >= 0; $i--) {
                $vSubStr = substr($vStr, 17 - $i, 1);
                $vSum += (pow(2, $i) % 11) * (($vSubStr == 'a') ? 10 : intval($vSubStr, 11));
            }

            if ($vSum % 11 != 1) {
                return false;
            }
        }

        return true;
    }

    /**
     * 姓名昵称合法性检查，只能输入中文英文
     * @param  $val 被检查内容
     * @return bool true false
     */
    public static function isName($val)
    {
        if (preg_match("/^[\x80-\xffa-zA-Z0-9]{3,60}$/", $val)) {
            return true;
        }
        return false;
    }

    /**
     * 检查字符串长度是否符合要求(仅限于数字)
     * @param  int $val
     * @param  int $min 最小长度
     * @param  int $max 最大长度
     * @return bool true false
     */
    public static function isNumLength($val, $min, $max)
    {
        $theelement = trim($val);
        if (preg_match("/^[0-9]{" . $min . "," . $max . "}$/", $val)) {
            return true;
        }
        return false;
    }

    /**
     * 检查字符串长度是否符合要求(仅限于阿拉伯字母)
     * @param  string $val
     * @param  int $min 最小长度
     * @param  int $max 最大长度
     * @return bool true false
     */
    public static function isEngLength($val, $min, $max)
    {
        $theelement = trim($val);
        if (preg_match("/^[a-zA-Z]{" . $min . "," . $max . "}$/", $val)) {
            return true;
        }
        return false;
    }

    /**
     * 检查输入是否为英文
     * @param  string $theelement
     * @return bool true false
     */
    public static function isEnglish($theelement)
    {
        if (preg_match("/^[A-Za-z]+$/", $theelement)) {
            return false;
        }
        return true;
    }

    /**
     * 检查是否输入为汉字
     * @param  string $sInBuf
     * @return bool true false
     */
    public static function isChinese($val)
    {
        if (preg_match("/^[\x{4e00}-\x{9fa5}]+$/u", $val)) {
            return true;
        }
        return false;
    }

    /**
     * 检查输入值是否为合法人民币格式
     * @param  float $val
     * @return bool true false
     */
    public static function isMoney($val)
    {
        if (preg_match("/^(-?\d+)(\.\d+)?/", $val)) {
            return true;
        }
        if (preg_match("/^[0-9]{1,}\.[0-9]{1,4}$/", $val)) {
            return true;
        }
        return false;
    }

    /**
     * 检查输入IP是否符合要求
     * @param  string $val
     * @return bool true false
     */
    public static function isIp($val)
    {
        return (bool) ip2long($val);
    }

    /**
     * 如果元素值中包含除字母和数字a-zA-Z0-9_以外的其他字符，则返回FALSE
     * @param  string $str 被验证内容
     * @return bool
     * @author Alisa
     */
    public static function isAlpha_numeric($str)
    {
        return (!preg_match("/^([a-zA-Z0-9_])+$/i", $str)) ? FALSE : TRUE;
    }

    /**
     * 如果元素值中包含除字母/数字/下划线/破折号以外的其他字符，则返回FALSE
     * @param  string $str
     * @return bool true false
     */
    public static function alpha_dash($str)
    {
        return (!preg_match("/^([-a-z0-9_-])+$/i", $str)) ? FALSE : TRUE;
    }

    /**
     * 检查是否是合法URL
     * @param  [type]  $url
     * @return boolean
     */
    public static function isUrl($url)
    {
        return (!preg_match('/http:\/\/[\w.]+[\w\/]*[\w.]*\??[\w=&\+\%]*/is', $url)) ? FALSE : TRUE;
    }

    /**
     * 判断密码是否合法
     * @param  [type]  $pass
     * @return boolean
     */
    public static function isPassword($pass)
    {
        return (preg_match('/^[a-zA-Z0-9]{6,20}$/', $pass)) ? TRUE : FALSE;
    }

    /**
     * 汇率兑换
     * @param  int $type 1人民币兑换美元    2美元兑换人民币
     * @param  float $money 金额
     * @param  float $rate 汇率
     * @return float
     */
    public static function changeRates($type = 1, $money, $rate)
    {
        if ($rate == 0) {
            return $money;
        }

        if ($type == 1) {
            return self::format_money($money / $rate, 4);
        }
        else if ($type == 2) {
            return self::format_money($money * $rate, 4);
        }
        else {
            return 0;
        }
    }

    /**
     * 非四舍五入取取小数点
     * @param type $number
     * @return type
     */
    public static function format_money($number, $num = 2)
    {
        $number = floor($number * 100) / 100;
        return number_format($number, $num, '.', '');
    }

    /**
     * 隐藏部分信息
     * @param  string  $card_code
     * @param  integer $num
     * @return string
     */
    public static function getCardCode($card_code = '', $num = 4)
    {
        if (strlen($card_code) <= $num) {
            return $card_code;
        }
        $max = (strlen($card_code) - $num);
        $string = '';
        for ($i = 0; $i < $max; $i++) {
            $string .= "*";
        }
        return $string . substr($card_code, -$num, $num);
    }

    /**
     * 获取客户端IP地址
     * @return array
     */
    public static function clientIp()
    {
        $unknown = 'unknown';
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARDED_FOR'] && strcasecmp($_SERVER['HTTP_X_FORWARDED_FOR'], $unknown)) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        elseif (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], $unknown)) {
            $ip = $_SERVER['REMOTE_ADDR'];
        } /* 处理多层代理的情况 或者使用正则方式：$ip = preg_match("/[\d\.]{7,15}/", $ip, $matches) ? $matches[0] : $unknown; */
        if (strpos($ip, ',') > 0) {
            $arrip = explode(',', $ip);
            $ip = $arrip[0];
        }
        return ['address' => '', 'ip' => $ip];
    }

    /**
     * 截取字符串
     * @param string $str 字符串
     * @param int $start 开始
     * @param int $length 截取长度
     * @param string $charset 要转换格式代码 utf-8（默认）、gb2312、gbk、big5
     * @param int $suffix 附加省略号
     * @access public
     * @author navy <navy_zhuhai@sina.com>
     * @return string
     */
    public function substr_ext($str, $start = 0, $length, $charset = "utf-8", $suffix = "...")
    {
        $str = str_replace(PHP_EOL, '\n', $str);
        $str = str_replace(array("/r/n", "/r", '\n', "/n", '&emsp;', "&nbsp;"), "", $str);
        $str = strip_tags($str);
        if (function_exists("mb_substr")) {
            $cart_str = mb_substr($str, $start, $length, $charset);
            if (strlen($str) / 3 > $length) {
                return $cart_str . $suffix;
            }
            return $cart_str;
        }
        elseif (function_exists('iconv_substr')) {
            $cart_str = iconv_substr($str, $start, $length, $charset);
            if (strlen($str) / 3 > $length) {
                return $cart_str . $suffix;
            }
            return $cart_str;
        }
        $re['utf-8'] = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
        $re['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
        $re['gbk'] = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
        $re['big5'] = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
        preg_match_all($re[$charset], $str, $match);
        $slice = join("", array_slice($match[0], $start, $length));
        if (strlen($str) / 3 > $length) {
            return $slice . $suffix;
        }
        return $slice;
    }

    /**
     * 是否有截取字符长度
     * @param string $str 格式参数
     * @return string
     */
    public function Is_formartbr($str, $length, $charset = "utf-8", $suffix = "...")
    {
        $res = false;
        if (!empty($str)) {
            $str = str_replace(PHP_EOL, '\n', $str);
            $str = str_replace(array("/r/n", "/r", '\n', "/n", '&emsp;', "&nbsp;"), "", $str);
            $str = strip_tags($str);
            if (!empty($length)) {
                if (strlen($str) / 3 > $length) {
                    $res = true;
                }
            }
        }
        return $res;
    }

    /**
     * 生成随机密码
     * @param  void
     * @return String
     */
    public static function CreatePassword()
    {
        return $password = 'KFD' . mt_rand(100000, 999999);
    }

    /**
     * xml文件转数组
     * @param  string $xml xml文档
     * @return array
     */
    public static function xml_to_array($xml)
    {
        $reg = "/<(\w+)[^>]*>([\\x00-\\xFF]*)<\\/\\1>/";
        if (preg_match_all($reg, $xml, $matches)) {
            $count = count($matches[0]);
            for ($i = 0; $i < $count; $i++) {
                $subxml = $matches[2][$i];
                $key = $matches[1][$i];
                if (preg_match($reg, $subxml)) {
                    $arr[$key] = self::xml_to_array($subxml);
                }
                else {
                    $arr[$key] = $subxml;
                }
            }
        }
        return $arr;
    }

    /**
     * 二维数组根据某个字段排序
     * @param array $arr 需要排序的数组
     * @param string $sortField 排序的字段
     * @return array
     */
    public static function ArrSort($arr, $sortField, $order = 'asc')
    {
        $data = array();
        $pro = array();
        foreach ($arr as $key => $val) {
            $pro[] = $val[$sortField];
        }

        if ($order == 'asc') {
            array_multisort($pro, SORT_ASC, $arr);
        }
        else {
            array_multisort($pro, SORT_DESC, $arr);
        }

        return $arr;
    }

}

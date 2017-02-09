<?php

namespace admin\components;

class Base
{

    /**
     * @desc 生成唯一字符串
     * @return string
     */
    public static function uniqueGuid()
    {
        $charid = strtoupper(md5(uniqid(mt_rand(), true)));
        $uuid = substr($charid, 0, 8) . substr($charid, 8, 4) . substr($charid, 12, 4) . substr($charid, 16, 4) . substr($charid, 20, 12);
        return $uuid;
    }

    /**
     * 返回model错误信息
     * @param $error
     * @return string
     */
    public static function modelError($error)
    {
        $return = 'Error:';
        if (empty($error)) {
            return $return;
        }
        foreach ($error as $v) {
            if (is_array($v)) {
                $return .= $v[0] . '<br>';
            }
            else {
                $return .= $v . '<br>';
            }
        }

        return $return;
    }

}

<?php

namespace lib\vendor\resque;


class Logger
{
    const LEVEL_PROFILE = 0;
    const LEVEL_INFO    = 1;
    const LEVEL_WARNING = 2;
    const LEVEL_ERROR   = 3;

    /**
     * 需要记录的日志级别
     * @var int
     */
    public static $level = self::LEVEL_WARNING;

    /**
     * 日志目录
     * @var string
     */
    public static $path = '';

    private static $levelMap = [
        self::LEVEL_PROFILE => 'PROFILE',
        self::LEVEL_INFO => 'INFO',
        self::LEVEL_WARNING => 'WARNING',
        self::LEVEL_ERROR => 'ERROR'
    ];

    public static function profile($log, $category = 'System')
    {
        self::log($log, $category, self::LEVEL_PROFILE);
    }

    public static function info($log, $category = 'System')
    {
        self::log($log, $category, self::LEVEL_INFO);
    }

    public static function warning($log, $category = 'System')
    {
        self::log($log, $category, self::LEVEL_WARNING);
    }

    public static function error($log, $category = 'System')
    {
        self::log($log, $category, self::LEVEL_ERROR);
    }

    public static function log($log, $category = 'System', $level = self::LEVEL_WARNING)
    {
        if ($level >= static::$level) {
            $levelText = isset(self::$levelMap[$level]) ? self::$levelMap[$level] : 'WARNING';
            $content = '[' . strftime('%T %Y-%m-%d') . '] [' .$levelText . '] [' . $category . '] ' . $log . PHP_EOL;

            if (self::$path != ''){
                if(!is_dir(self::$path)) {
                    mkdir(self::$path, 0666, true);
                }
                file_put_contents(self::$path . '/queue-' . date('Y-m-d') . '.log', $content, FILE_APPEND);
            } elseif (php_sapi_name() == 'cli') {
                fwrite(STDOUT, $content);
            }
        }
    }
}
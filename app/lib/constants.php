<?php

/**
 * @copyright Copyright (c) 2017
 * @version  Beta 1.0
 * @author kevin
 */

/**
 * 常量设置
 */
defined('DS') or define('DS', DIRECTORY_SEPARATOR);
defined('LIB') or define('LIB', dirname(__FILE__));

/**
 * 配置路径
 */
defined('CONFIG_DIR') or define('CONFIG_DIR', LIB . DS . 'config' . DS);
defined('CONFIG_DATA') or define('CONFIG_DATA', LIB . DS . 'data' . DS);

/**
 * 安全秘钥
 */
defined('SAFE_KEY') or define('SAFE_KEY', '2yD09jK717NU3OgDAS2brZ3mqzrfO1xE5A41jrG20FoxmKixZ3IPNuMDXD4OCAxS');
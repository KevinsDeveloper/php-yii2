<?php

namespace lib\vendor\resque\redis;

if (!class_exists('RedisException', false)) {
    class RedisException extends \Exception
    {
    }
} else {
    class RedisException extends \RedisException
    {
    }
}
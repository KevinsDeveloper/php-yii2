<?php
/**
 * 短信发送作业类
 * @author lk
 */
namespace users\queue\job;


use lib\components\sms\SmsFactory;
use lib\components\sms\Sms as SmsProvider;
use lib\vendor\resque\Logger;
use InvalidArgumentException;

/* @property array $args */
class Sms
{
    /**
     * 作业执行入口函数
     */
    public function perform()
    {
        Logger::info('job begin', __METHOD__);
        $args = $this->args;
        $this->validate();
        $sms = SmsFactory::makeProvider($args['channel'], $args['scenes'], $args['type']);
        if (!($sms instanceof SmsProvider)) {
            throw new \Exception('Error while new sms provider');
        }
        $resp = $sms->send($args['mobile'], $args['params']);
        Logger::info('job complete: ' . print_r($resp, true), __METHOD__);
    }

    private function validate()
    {
        $args = $this->args;
        if (!isset($args['channel'])) {
            throw new InvalidArgumentException('Must supplied the parameter: channel.');
        } elseif (!isset($args['scenes'])) {
            throw new InvalidArgumentException('Must supplied the parameter: scenes.');
        } elseif (!isset($args['type'])) {
            throw new InvalidArgumentException('Must supplied the parameter: type.');
        } elseif (!isset($args['mobile'])) {
            throw new InvalidArgumentException('Must supplied the parameter: mobile.');
        } elseif (!isset($args['params'])) {
            throw new InvalidArgumentException('Must supplied the parameter: params.');
        }
    }
}
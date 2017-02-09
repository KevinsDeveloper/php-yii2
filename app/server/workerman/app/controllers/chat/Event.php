<?php

/**
 * This file is part of workerman.
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the MIT-LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @author walkor<walkor@workerman.net>
 * @copyright walkor<walkor@workerman.net>
 * @link http://www.workerman.net/
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */
/**
 * 用于检测业务代码死循环或者长时间阻塞等问题
 * 如果发现业务卡死，可以将下面declare打开（去掉//注释），并执行php start.php reload
 * 然后观察一段时间workerman.log看是否有process_timeout异常
 */
//declare(ticks=1);

/**
 * 聊天主逻辑
 * 主要是处理 onMessage onClose 
 */
use \GatewayWorker\Lib\Gateway;
use yii\helpers\Json;

class Event
{

    /**
     * 有消息时
     * @param int $client_id
     * @param mixed $message
     */
    public static function onMessage($client_id, $message)
    {
        //file_put_contents(APPROOT.'/runtime/pub.txt', 'message:' . print_r($message,true) . PHP_EOL, FILE_APPEND);
        // debug
        echo "client:{$_SERVER['REMOTE_ADDR']}:{$_SERVER['REMOTE_PORT']} gateway:{$_SERVER['GATEWAY_ADDR']}:{$_SERVER['GATEWAY_PORT']}  client_id:$client_id session:" . json_encode($_SESSION) . " onMessage:" . $message . "\n";

        // 客户端传递的是json数据
        
        $message_data = json_decode($message, true);

        if (!$message_data) {
            return;
        }

        // 根据类型执行不同的业务
        switch ($message_data['type']) {
            // 客户端回应服务端的心跳...
            case 'pong':
                if (isset($_SESSION['room_id'])) {
                    //获取所有当前聊天池内所有client
                    $all_client = Gateway::getAllClientInfo($_SESSION['room_id']);
                    $counts = count($all_client);
                    return Gateway::sendToGroup($_SESSION['room_id'], Json::encode(['pong' => ['counts' => $counts, 'client_list' => $all_client]]));
                }
                return;
            // 客户端登录 message格式: {type:login, name:xx, room_id:1} ，添加到客户端，广播给所有客户端xx进入聊天室
            case 'login':

                // 判断是否有房间号,非法请求 ...
                if (!isset($message_data['room_id'])) {
                    throw new \Exception("\$message_data['room_id'] not set. client_ip:{$_SERVER['REMOTE_ADDR']} \$message:$message");
                    return Gateway::sendToCurrentClient(Json::encode(['login' => ['status' => 0, 'message' => '房间参数错误']]));
                }
                // 组成数据  
                $socketData = $message_data;
                $socketData['client_id'] = $client_id;
                $socketData['client_ip'] = $_SERVER['REMOTE_ADDR'];
                $socketData['client_time'] = time();
                //游客user_id 未加密....  user_id 不再加密处理， mod by hanke 2016-6-2 10:44
                //$user_id = $message_data['group_id'] == 5 ? $message_data['user_id'] : \lib\components\Password::Decrypt($message_data['user_id']);
                $user_id = $message_data['user_id'];
                $socketData['user_id'] = $user_id;
                echo "start uid:{$message_data['user_id']} decode user_id:{$user_id}\n";
                //判断当前用户是否被踢出房间
                $lockData = \app\mod\UserMod::isLockUser($user_id, $message_data['room_id']);
                if ($lockData['status'] == 1) {
                    $new_message = [
                        'type'      => 'login',
                        'status'    => 0,
                        'client_id' => $client_id,
                        'message'   => '你已被踢出房间'
                    ];
                    return Gateway::sendToCurrentClient(Json::encode(['login' => $new_message]));
                }
                $new_message = \app\handler\UserHandler::login($socketData);
                //echo " rs data:" . $new_message . "\n";
                //此user_id 为正常uid
                $_SESSION['token'] = $message_data['token'];
                // 把房间号昵称写入session中
                $_SESSION['room_id'] = $message_data['room_id'];
                $_SESSION['room_type'] = $message_data['room_type'];
                $_SESSION['name'] = htmlspecialchars($message_data['name']);
                //此uid 为加密uid
                $_SESSION['encode_user_id'] = $message_data['user_id'];
                $_SESSION['user_id'] = $user_id;
                $_SESSION['group_id'] = $message_data['group_id'];
                $_SESSION['face'] = $message_data['face'];
                echo "login uid:{$_SESSION['user_id']}\n";
                // 返回当前在线用户列表
                return Gateway::sendToCurrentClient($new_message);
            // 客户端发言 message: {type:say, to_client_id:xx, message:xx}
            case 'say':
                // 非法请求
                if (!isset($_SESSION['room_id'])) {
                    throw new \Exception("{$_SESSION['room_id']} not set client_ip:{$_SERVER['REMOTE_ADDR']}");
                }
                $message_data['user_id'] = $_SESSION['user_id'];
                $message_data['encode_user_id'] = $_SESSION['encode_user_id'];
                $message_data['name'] = $_SESSION['name'];
                $message_data['room_id'] = $_SESSION['room_id'];
                $message_data['room_type'] = $_SESSION['room_type'];
                $message_data['group_id'] = $_SESSION['group_id'];
                $message_data['client_id'] = $client_id;
                ///\Yii::error(print_r($message_data,true));
                //\Yii($message_data);
                $retData = \app\handler\ChatHandler::pub($message_data);

                return;
            case 'check':
                //审核操作
                // 判断是否有房间号,非法请求
                if (!isset($_SESSION['room_id'])) {
                    throw new \Exception("\$_SESSION['room_id'] not set. client_ip:{$_SERVER['REMOTE_ADDR']} \$message:$message");
                }
                $user_id = $_SESSION['user_id'];
                $group_id = $_SESSION['group_id'];
                //当前登录非管理员或者 客服 不允许审核
                if (!in_array($group_id, [2, 4])) {
                    return Gateway::sendToCurrentClient(json_encode(['check' => ['status' => 0, 'message' => '无权审核操作']]));
                }
                $retData = \app\mod\ChatRecordMod::verifyRecord($message_data['id'], $user_id);
                return Gateway::sendToGroup($_SESSION['room_id'], json_encode(['check' => $retData]));
            case 'delete':
                //删除消息操作
                // 判断是否有房间号,非法请求
                if (!isset($_SESSION['room_id'])) {
                    throw new \Exception("\$_SESSION['room_id'] not set. client_ip:{$_SERVER['REMOTE_ADDR']} \$message:$message");
                }
                $user_id = $_SESSION['user_id'];
                $group_id = $_SESSION['group_id'];
                //当前登录非管理员或者 客服 不允许审核
                if (!in_array($group_id, [2, 4])) {
                    return Gateway::sendToCurrentClient(json_encode(['delete' => ['status' => 0, 'message' => '无权删除操作']]));
                }
                $retData = \app\mod\ChatRecordMod::delRecord($message_data['id'], $user_id);
                return Gateway::sendToGroup($_SESSION['room_id'], json_encode(['delete' => $retData]));
            case 'gag':
                //禁言用户
                // 判断是否有房间号,非法请求
                if (!isset($_SESSION['room_id'])) {
                    throw new \Exception("\$_SESSION['room_id'] not set. client_ip:{$_SERVER['REMOTE_ADDR']} \$message:$message");
                }
                //当前登录非管理员或者 客服 不允许禁言操作
                $group_id = $_SESSION['group_id'];
                if (!in_array($group_id, [2, 4])) {
                    return Gateway::sendToCurrentClient(json_encode(['delete' => ['status' => 0, 'message' => '无权禁言操作']]));
                }
                $message_data = array_merge($_SESSION, $message_data);
                $retData = \app\handler\UserHandler::gagUser($message_data);
                return;
            //return Gateway::sendToGroup($_SESSION['room_id'] , json_encode(['gag' =>$retData ]));
            case 'ungag':
                //解禁用户
                // 判断是否有房间号,非法请求
                if (!isset($_SESSION['room_id'])) {
                    throw new \Exception("\$_SESSION['room_id'] not set. client_ip:{$_SERVER['REMOTE_ADDR']} \$message:$message");
                }
                return;
            case 'lock':
                //踢人
                // 判断是否有房间号,非法请求
                if (!isset($_SESSION['room_id'])) {
                    throw new \Exception("\$_SESSION['room_id'] not set. client_ip:{$_SERVER['REMOTE_ADDR']} \$message:$message");
                }
                //当前登录非管理员或者 客服 不允许踢人操作
                $group_id = $_SESSION['group_id'];
                if (!in_array($group_id, [2, 4])) {
                    return Gateway::sendToCurrentClient(json_encode(['delete' => ['status' => 0, 'message' => '无权踢人操作']]));
                }
                $message_data = array_merge($_SESSION, $message_data);
                $retData = \app\handler\UserHandler::lockUser($message_data);
                return;
            case 'shield':
                //屏蔽某人
                // 判断是否有房间号,非法请求
                if (!isset($_SESSION['room_id'])) {
                    throw new \Exception("\$_SESSION['room_id'] not set. client_ip:{$_SERVER['REMOTE_ADDR']} \$message:$message");
                }
                if (in_array($message_data['group_id'], [2, 3, 4])) {
                    return Gateway::sendToCurrentClient(json_encode(['delete' => ['status' => 0, 'message' => '只能屏蔽普通用户']]));
                }
                $message_data['to_group_id'] = $message_data['group_id'];
                $message_data = array_merge($_SESSION, $message_data);
                $retData = \app\handler\UserHandler::shieldUser($message_data);
                return;
            case 'private':
                //私聊  
                if (!isset($_SESSION['user_id'])) {
                    throw new \Exception("\$_SESSION['user_id'] not set. client_ip:{$_SERVER['REMOTE_ADDR']} \$message:$message");
                }
                $message_data['client_id'] = $client_id;
                $message_data = array_merge($_SESSION, $message_data);
                $toJson = \app\handler\PrivatesHandler::sendMsg($message_data);
                //echo "return s json:" . $toJson . "\n";
                return;
            case 'private-read':
                //阅读消息
                $ret = \app\handler\PrivatesHandler::readPrivate($_SESSION['user_id'], $message_data['to_user_id'], $message_data['pmid']);
                return;
            case 'private-detail':
                //私聊详情
                if (!isset($_SESSION['user_id'])) {
                    throw new \Exception("\$_SESSION['user_id'] not set. client_ip:{$_SERVER['REMOTE_ADDR']} \$message:$message");
                }
                $message_data['client_id'] = $client_id;
                $message_data = array_merge($_SESSION, $message_data);
                $page = isset($message_data['page']) ? $message_data['page'] : 1;
                $ret = \app\handler\PrivatesHandler::getPrivateMsg($_SESSION['user_id'], $message_data['pmid'], $message_data['to_user_id'], $page);
                //echo "ret private-detail page:".$ret['page']; 
                return Gateway::sendToCurrentClient($ret);
            case 'private-close':
                $ret = \app\handler\PrivatesHandler::closePrivate($_SESSION['user_id'], $message_data['to_user_id'], $message_data['pmid']);
                break;
            case 'broadcast-time':
                //观看直播时长
                echo $client_id . "=>client_id | name:{$_SESSION['name']} | uid : {$_SESSION['user_id']}\n";
                //echo "close:" . Gateway::closeClient('7f00000108fe00000007') ."\n";
                if (!isset($_SESSION['user_id'])) {
                    //throw new \Exception("user not set. client_ip:{$_SERVER['REMOTE_ADDR']} \n message:$message");
                    echo "user is not fonud!\n";
                    return Gateway::sendToCurrentClient(Json::encode(['login' => ['status' => 0, 'message' => '用户未登录']]));
                }
                $message_data['client_id'] = $client_id;
                //$message_data = array_merge($_SESSION, $message_data);
                //$message_data['user_id'] = isset($message_data['to_user_id']) ? $message_data['to_user_id'] : $_SESSION['user_id'];
                $message_data['user_id'] = $_SESSION['user_id'];
                $ret = \app\handler\UserHandler::addBroadcastTime($message_data);
                break;
            case 'useronline-time':
                //用户在线时长统计 
                if (!isset($_SESSION['user_id'])) {
                    echo "user is not fonud!\n";
                    return Gateway::sendToCurrentClient(Json::encode(['login' => ['status' => 0, 'message' => '用户未登录']]));
                }
                $message_data['client_id'] = $client_id;
                $message_data['user_id'] = $_SESSION['user_id'];
                $ret = \app\handler\UserHandler::addOnlineTime($message_data);
                break;
            case 'chat-record':
                //房间聊天历史记录
                if (!isset($message_data['room_id'])) {
                    return Gateway::sendToCurrentClient(Json::encode(['chat-record' => ['status' => 0, 'message' => '未设置房间']]));
                }
                $message_data['client_id'] = $client_id;
                $message_data['user_id'] = $_SESSION['user_id'];
                $message_data['page'] = $message_data['page'] ? $message_data['page'] : 1;
                $chat = \app\handler\ChatHandler::getChatList($message_data);
                $new_message['type'] = $message_data['type'];
                $new_message['status'] = 1;
                $new_message['client_id'] = $client_id;
                $new_message['chat_list'] = $chat;
                return Gateway::sendToCurrentClient(Json::encode(['chat-record' => $new_message]));
                break;
        }
    }

    /**
     * 当客户端断开连接时
     * @param integer $client_id 客户端id
     */
    public static function onClose($client_id)
    {
        // debug
        echo "client:{$_SERVER['REMOTE_ADDR']}:{$_SERVER['REMOTE_PORT']} gateway:{$_SERVER['GATEWAY_ADDR']}:{$_SERVER['GATEWAY_PORT']}  client_id:$client_id onClose:''\n";

        // 从房间的客户端列表中删除
        if (isset($_SESSION['room_id'])) {
            $room_id = $_SESSION['room_id'];
            $new_message = array('type' => 'logout', 'client_id' => $client_id, 'from_name' => $_SESSION['name'], 'time' => date('Y-m-d H:i:s'));

            // 退出socket
            // echo \app\mod\ChatMod::closeSocket(['client_id' => $client_id, 'room_id' => $room_id, 'type' => 'logout']);
            // Gateway::sendToGroup($room_id, json_encode($new_message));
            $socketData['type'] = 'logout';
            $socketData['name'] = $_SESSION['name'];
            $socketData['room_id'] = $_SESSION['room_id'];
            $socketData['user_id'] = $_SESSION['user_id'];
            $socketData['client_id'] = $client_id;
            \app\handler\UserHandler::logout($socketData);
            //return Gateway::sendToGroup($room_id, \app\handler\UserHandler::logout($socketData));
        }
    }

}

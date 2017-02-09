<?php
/**
 * Author: yimpor
 * Date: 2017/1/13    20:03
 * Description:
 */

namespace admin\modules\content\controllers;


use Yii;
use admin\components\BaseController;
use yii\helpers\Json;

class UploaderController extends BaseController
{
    public $enableCsrfValidation = false;

    /**
     * 初始化
     * @author kevin
     */
    public function init()
    {
        parent::init();
    }

    /**
     * 上传文件
     * @author kevin
     * @return string
     */
    public function actionIndex()
    {
        if (empty($_FILES) || empty($_FILES['file']) || !is_array($_FILES['file']))
        {
            return Json::encode(['state' => 'error', 'message' => '请选择要上传的文件']);
        }
        $file = Yii::$app->upload->uploadFile($_FILES['file'], true);
        $return['status'] = $file === true ? 1 : 0;
        $return['url'] = \yii::$app->upload->_file_name;
        $return['info'] = $file ? \yii::t('app', 'uploadSuccess') : \yii::$app->upload->_errors;

        return Json::encode($return);
    }

    /**
     * 编辑器上传图片
     * @author kevin
     * @return string
     */
    public function actionEditer()
    {
        if (empty($_FILES) || empty($_FILES['imgFile']) || !is_array($_FILES['imgFile']))
        {
            return Json::encode(['state' => 'error', 'message' => '请选择要上传的文件']);
        }
        foreach ($_FILES['imgFile'] as $file)
        {
            $files = is_array($file) ? $_FILES['imgFile'] : array($_FILES['imgFile']);
        }
        foreach ($files as $simplefile)
        {
            Yii::$app->upload->uploadFile($simplefile, true);
            if (Yii::$app->upload->_errors)
            {
                return Json::encode(array('error' => 1, 'message' => Yii::$app->upload->_errors));
            }
            return Json::encode(array('error' => 0, 'url' => Yii::$app->upload->_show_name));
        }
    }

    /**
     * 获取下载目录所有文件
     * @author kevin
     * @return string
     * @throws \yii\web\HttpException
     */
    public function actionFilejson()
    {
        //根目录路径，可以指定绝对路径
        $root_path = UPLOADS;
        //根目录URL，可以指定绝对路径
        $root_url = Yii::$app->params['setting']['uploadUrl'].'/';
        //图片扩展名
        $ext_arr = array('gif', 'jpg', 'jpeg', 'png', 'bmp');

        $dir_name = Yii::$app->request->get("dir", "");
        if (!in_array($dir_name, array('', 'files', 'image', 'thumb', 'users')))
        {
            throw new \yii\web\HttpException(500, "Invalid Directory name.");
        }
        if ($dir_name !== '')
        {
            $root_path .= $dir_name . "/";
            $root_url .= $dir_name . "/";
            if (!file_exists($root_path))
            {
                mkdir($root_path);
            }
        }
        //根据path参数，设置各路径和URL
        $path = \Yii::$app->request->get('path', '');
        if (empty($path))
        {
            $current_path = realpath($root_path) . '/';
            $current_url = $root_url;
            $current_dir_path = '';
            $moveup_dir_path = '';
        }
        else
        {
            $current_path = realpath($root_path) . '/' . $path;
            $current_url = $root_url . $path;
            $current_dir_path = $path;
            $moveup_dir_path = preg_replace('/(.*?)[^\/]+\/$/', '$1', $current_dir_path);
        }
        //排序形式，name or size or type
        $order = strtolower(\Yii::$app->request->get('order', 'name'));
        if (preg_match('/\.\./', $current_path))
        {
            throw new \yii\web\HttpException(500, 'Access is not allowed.');
        }
        //最后一个字符不是/
        if (!preg_match('/\/$/', $current_path))
        {
            throw new \yii\web\HttpException(500, 'Parameter is not valid.');
        }
        //目录不存在或不是目录
        if (!file_exists($current_path) || !is_dir($current_path))
        {
            throw new \yii\web\HttpException(500, 'Directory does not exist.');
        }
        $file_list = array();
        if ($handle = opendir($current_path))
        {
            $i = 0;
            while (false !== ($filename = readdir($handle)))
            {
                if ($filename{0} == '.')
                {
                    continue;
                }
                $file = $current_path . $filename;
                if (is_dir($file))
                {
                    $file_list[$i]['is_dir'] = true; //是否文件夹
                    $file_list[$i]['has_file'] = (count(scandir($file)) > 2); //文件夹是否包含文件
                    $file_list[$i]['filesize'] = 0; //文件大小
                    $file_list[$i]['is_photo'] = false; //是否图片
                    $file_list[$i]['filetype'] = ''; //文件类别，用扩展名判断
                }
                else
                {
                    $file_list[$i]['is_dir'] = false;
                    $file_list[$i]['has_file'] = false;
                    $file_list[$i]['filesize'] = filesize($file);
                    $file_list[$i]['dir_path'] = '';
                    $file_ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                    $file_list[$i]['is_photo'] = in_array($file_ext, $ext_arr);
                    $file_list[$i]['filetype'] = $file_ext;
                }
                $file_list[$i]['filename'] = $filename; //文件名，包含扩展名
                $file_list[$i]['datetime'] = date('Y-m-d H:i:s', filemtime($file)); //文件最后修改时间
                $i++;
            }
            closedir($handle);
        }

        //相对于根目录的上一级目录
        $result['moveup_dir_path'] = $moveup_dir_path;
        //相对于根目录的当前目录
        $result['current_dir_path'] = $current_dir_path;
        //当前目录的URL
        $result['current_url'] = $current_url;
        //文件数
        $result['total_count'] = count($file_list);
        //文件列表数组
        $result['file_list'] = $file_list;
        return Json::encode($result);
    }

}
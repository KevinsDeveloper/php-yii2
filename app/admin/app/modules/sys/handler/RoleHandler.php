<?php
/**
 * Author: yimpor
 * Date: 2017/1/12    15:20
 * Description:
 */

namespace admin\modules\sys\handler;

use admin\models\DbAdminMenu;
use Yii;
use yii\helpers\VarDumper;

class RoleHandler
{

    /**
     * Get list of application routes
     * @return array
     */
    public static function getAppRoutes($module = null)
    {
        if ($module === null) {
            $module = Yii::$app;
        } elseif (is_string($module)) {
            $module = Yii::$app->getModule($module);
        }
//        $key = [__METHOD__, $module->getUniqueId()];
//        $cache = Configs::instance()->cache;
//        if ($cache === null || ($result = $cache->get($key)) === false) {
            $result = [];
            self::getRouteRecursive($module, $result);
//            if ($cache !== null) {
//                $cache->set($key, $result, Configs::instance()->cacheDuration, new TagDependency([
//                    'tags' => self::CACHE_TAG,
//                ]));
//            }
//        }

        return $result;
    }

    /**
     * Get route(s) recursive
     * @param \yii\base\Module $module
     * @param array $result
     */
    protected static function getRouteRecursive($module, &$result)
    {
        $token = "Get Route of '" . get_class($module) . "' with id '" . $module->uniqueId . "'";
        Yii::beginProfile($token, __METHOD__);
        try {
            foreach ($module->getModules() as $id => $child) {
                if (($child = $module->getModule($id)) !== null) {
                    self::getRouteRecursive($child, $result);
                }
            }
            foreach ($module->controllerMap as $id => $type) {
                self::getControllerActions($type, $id, $module, $result);
            }

            $namespace = trim($module->controllerNamespace, '\\') . '\\';
            self::getControllerFiles($module, $namespace, '', $result);
            $all = '/' . ltrim($module->uniqueId, '/');
            $mInfo = DbAdminMenu::find()->where(['url' => $all])->one();
            if(isset($mInfo->id)){
                $result[$module->uniqueId]['id'] = $mInfo->id;
                $result[$module->uniqueId]['pid'] = 0;
                $result[$module->uniqueId]['url'] = $all;
                $result[$module->uniqueId]['title'] = $mInfo->title;
//                    'id' => ,
//                    'url' => $all,
//                    'name' => $mInfo->title,
//                ];
            }

        } catch (\Exception $exc) {
            Yii::error($exc->getMessage(), __METHOD__);
        }
        Yii::endProfile($token, __METHOD__);
    }

    /**
     * Get list controller under module
     * @param \yii\base\Module $module
     * @param string $namespace
     * @param string $prefix
     * @param mixed $result
     * @return mixed
     */
    protected static function getControllerFiles($module, $namespace, $prefix, &$result)
    {
        $path = Yii::getAlias('@' . str_replace('\\', '/', $namespace), false);
        $token = "Get controllers from '$path'";
        Yii::beginProfile($token, __METHOD__);
        try {
            if (!is_dir($path)) {
                return;
            }
            foreach (scandir($path) as $file) {
                if ($file == '.' || $file == '..') {
                    continue;
                }
                if (is_dir($path . '/' . $file) && preg_match('%^[a-z0-9_/]+$%i', $file . '/')) {
                    self::getControllerFiles($module, $namespace . $file . '\\', $prefix . $file . '/', $result);
                } elseif (strcmp(substr($file, -14), 'Controller.php') === 0) {
                    $baseName = substr(basename($file), 0, -14);
                    $name = strtolower(preg_replace('/(?<![A-Z])[A-Z]/', ' \0', $baseName));
                    $id = ltrim(str_replace(' ', '-', $name), '-');
                    $className = $namespace . $baseName . 'Controller';
                    if (strpos($className, '-') === false && class_exists($className) && is_subclass_of($className, 'yii\base\Controller')) {
                        self::getControllerActions($className, $prefix . $id, $module, $result);
                    }
                }
            }
        } catch (\Exception $exc) {
            Yii::error($exc->getMessage(), __METHOD__);
        }
        Yii::endProfile($token, __METHOD__);
    }

    /**
     * Get list action of controller
     * @param mixed $type
     * @param string $id
     * @param \yii\base\Module $module
     * @param string $result
     */
    protected static function getControllerActions($type, $id, $module, &$result)
    {
        $token = "Create controller with cofig=" . VarDumper::dumpAsString($type) . " and id='$id'";
        Yii::beginProfile($token, __METHOD__);
        try {
            /* @var $controller \yii\base\Controller */
            $controller = Yii::createObject($type, [$id, $module]);
            $all = "/{$controller->uniqueId}/index";
            $mInfo = DbAdminMenu::find()->where(['url' => $all])->one();
            self::getActionRoutes($controller, $module, $mInfo, $result);
            if(isset($mInfo->id)){
                $result[$module->uniqueId]['parentid'][$mInfo->id]['id'] = $mInfo->id;
                $result[$module->uniqueId]['parentid'][$mInfo->id]['pid'] = $mInfo->pid;
                $result[$module->uniqueId]['parentid'][$mInfo->id]['url'] = $all;
                $result[$module->uniqueId]['parentid'][$mInfo->id]['title'] = '┣ ' . $mInfo->title;

//                $a[$controller->uniqueId] = [
//                    'id' => $mInfo->id,
//                    'url' => $all,
//                    'name' => $mInfo->title
//                    ];
//                array_merge($result[$module->uniqueId]['child'],$a);
//                foreach($result as $val){
//                    print_r($val);
//                    $val['child'] = $a;
//
//                }
//                print_r($result);
//                print_r($a);
            }
//            $result[$all] = $all;
        } catch (\Exception $exc) {
            Yii::error($exc->getMessage(), __METHOD__);
        }
        Yii::endProfile($token, __METHOD__);
    }

    /**
     * Get route of action
     * @param \yii\base\Controller $controller
     * @param array $result all controller action.
     */
    protected static function getActionRoutes($controller, $module, $mInfo, &$result)
    {
        $token = "Get actions of controller '" . $controller->uniqueId . "'";
        Yii::beginProfile($token, __METHOD__);
        try {
            $prefix = '/' . $controller->uniqueId . '/';
            foreach ($controller->actions() as $id => $value) {
                $result[$prefix . $id] = $prefix . $id;
            }
            $class = new \ReflectionClass($controller);
            foreach ($class->getMethods() as $method) {
                $name = $method->getName();
                $func  = new \ReflectionMethod($controller,$name);
                $tmp   = $func->getDocComment();
                preg_match_all('/Description:(.*?)\n/',$tmp,$tmp);

                if ($method->isPublic() && strpos($name, 'action') === 0 && $name !== 'actions' && stripos($controller->uniqueId, 'site/') === false && stripos($controller->uniqueId, 'gii/') === false) {
                    $name = strtolower(preg_replace('/(?<![A-Z])[A-Z]/', ' \0', substr($name, 6)));
                    $id = $prefix . ltrim(str_replace(' ', '-', $name), '-');
                    $result[$module->uniqueId]['parentid'][$mInfo->id]['parentid'][] = [
                        'id' => $mInfo->id,
                        'pid' => $mInfo->id,
                        'url' => $id,
                        'title' => isset($tmp[1][0])?trim($tmp[1][0]):'',
                    ];

                }
            }
        } catch (\Exception $exc) {
            Yii::error($exc->getMessage(), __METHOD__);
        }
        Yii::endProfile($token, __METHOD__);
    }
}
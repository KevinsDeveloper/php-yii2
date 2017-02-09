<?php
/**
 * Author: Yimpor
 * Date: 2017/1/10
 * Time: 14:19
 * Description: 菜单权限相关功能助手
 */
namespace admin\modules\sys\handler;

use admin\models\DbAdminPower;
use Yii;
use admin\models\DbAdminMenu;

class MenuHandler
{
    /**
     * 获取所有菜单
     * @author kevin
     * @param array $power 权限组
     * @return array
     */
    public static function getMenuID($wh = '', $power = [])
    {
        $MenuModel = new DbAdminMenu();
        $return = [];
        $where = !empty($power)?['url' => $power]:['status' => 1];
        $adminMenu = $MenuModel -> find() -> where($where)->andWhere($wh) -> orderBy("orderby ASC") -> all();
        if (empty($adminMenu))
        {
            return $return;
        }
        foreach ($adminMenu as $powers)
        {
            if ($powers->pid == 0)
            {
                $menus = $powers->toArray();
                $menus['parentid'] = self::getPid($powers->id, $adminMenu);
                $return[] = $menus;
            }
        }
        return $return;
    }

    /**
     * 获取子栏目
     * @author kevin
     * @param $id   上级栏目ID
     * @param $adminPower   栏目数据
     * @return array
     */
    public static function getPid($id, $adminMenu)
    {
        $return = [];
        foreach ($adminMenu as $menu)
        {
            if ($menu->pid == $id)
            {
                $menu->title = '┣ ' . $menu->title;
                $menus = $menu->toArray();
                $return[$menu->id] = $menus;
            }
        }
        return $return;
    }

    /**
     * 获取栏目数据
     * @author kevin
     * @param $pidData  栏目结合数据
     * @return array
     */
    public static function getPageList($pidData)
    {
        $return = [];
        if (empty($pidData))
        {
            return $return;
        }
        foreach ($pidData as $data)
        {
            $pdata = [];
            if (!empty($data['parentid']))
            {
                $pdata = $data['parentid'];
                unset($data['parentid']);
            }
            $return[] = $data;
            if (!empty($pdata))
            {
                foreach ($pdata as $p)
                {
                    $return[] = $p;
                }
            }
        }
        return $return;
    }

    /**
     * 返回Downlist数据
     * @author kevin
     * @param $pidData  栏目数据
     * @return mixed
     */
    public static function getDropDownList($pidData)
    {
        $return[0] = '==顶级栏目==';
        if (empty($pidData))
        {
            return $return;
        }
        foreach ($pidData as $data)
        {
            $return[$data['id']] = $data['title'];
            if (!empty($data['parentid']))
            {
                foreach ($data['parentid'] as $k => $v)
                {
                    if ($v['status'] == 1)
                    {
                        $return[$k] = $v['title'];
                    }
                }
            }
        }
        return $return;
    }
    /**
     * 获取所有得动作权限
     * @author kevin
     * @param array $admin 登录管理员
     * @return array
     */
    public static function getActions($admin = [])
    {
        $return = [];
        $adminPower = DbAdminPower::find()->where(['role_id'=>$admin->group_id])->all();
        if (empty($adminPower))
        {
            return $return;
        }
        foreach ($adminPower as $power)
        {
            $return[$power->id] = $power->url;
        }
        return $return;
    }

    /**
     * Author: Yimpor
     * Date: 2017年1月11日 14:37:29
     * Description: 获取所有角色组
     * @return array
     */
    public static function getRoleGroups()
    {
        $return = [];
        $roleGroup = \admin\models\DbAdminRole::findAll(['status' => 1]);
        if (empty($roleGroup))
        {
            return $return;
        }
        foreach ($roleGroup as $role)
        {
            $return[$role->id] = $role->role_name;
        }
        return $return;
    }

    /**
     * 获取所有菜单动作
     * @author kevin
     * @return array
     */
    public static function getMenuAll()
    {
        $return = [];
        $adminMenu = DbAdminMenu::find()->where(['status' => 1])->orderBy("id ASC")->all();
        if (empty($adminMenu))
        {
            return $return;
        }
        foreach ($adminMenu as $menu)
        {
            if ($menu->pid == 0)
            {
                $return[$menu->id]['id'] = $menu->id;
                $return[$menu->id]['pid'] = $menu->pid;
                $return[$menu->id]['title'] = $menu->title;
                $return[$menu->id]['url'] = $menu->url;
                $return[$menu->id]['parentid'] = self::getMenuOne($menu->id, $adminMenu);
            }
        }
        return $return;
    }

    /**
     * 获取ID下的菜单
     * @author kevin
     * @param $id   菜单ID
     * @param $adminPower   所有菜单
     * @return array
     */
    public static function getMenuOne($id, $adminMenu)
    {
        $return = [];
        foreach ($adminMenu as $menu)
        {
            if ($menu->pid == $id)
            {
                $return[$menu->id]['id'] = $menu->id;
                $return[$menu->id]['pid'] = $menu->pid;
                if($menu ->rank == 1){
                    $return[$menu->id]['title'] = '┣ ' .$menu->title;
                }else{
                    $return[$menu->id]['title'] = '┣ ' .$menu->title;
                }

                $return[$menu->id]['url'] = $menu->url;
                $return[$menu->id]['parentid'] = self::getMenuOne($menu->id, $adminMenu);
            }
        }
        return $return;
    }
}
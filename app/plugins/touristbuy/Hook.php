<?php
// +----------------------------------------------------------------------
// | ShopXO 国内领先企业级B2C免费开源电商系统
// +----------------------------------------------------------------------
// | Copyright (c) 2011~2099 http://shopxo.net All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( https://opensource.org/licenses/mit-license.php )
// +----------------------------------------------------------------------
// | Author: Devil
// +----------------------------------------------------------------------
namespace app\plugins\touristbuy;

use app\plugins\touristbuy\service\Service;
use app\service\PluginsService;
use app\service\UserService;

/**
 * 游客购买 - 钩子入口
 * @author   Devil
 * @blog     http://gong.gg/
 * @version  0.0.1
 * @datetime 2016-12-01T21:51:08+0800
 */
class Hook
{
    // 模块、控制器、方法
    private $module_name;
    private $controller_name;
    private $action_name;
    private $mca;

    /**
     * 应用响应入口
     * @author   Devil
     * @blog     http://gong.gg/
     * @version  1.0.0
     * @datetime 2019-02-09T14:25:44+0800
     * @param    [array]                    $params [输入参数]
     */
    public function handle($params = [])
    {
        // 是否后端钩子
        if(!empty($params['hook_name']))
        {
            // 当前模块/控制器/方法
            $this->module_name = RequestModule();
            $this->controller_name = RequestController();
            $this->action_name = RequestAction();
            $this->mca = $this->module_name.$this->controller_name.$this->action_name;

            $ret = DataReturn(MyLang('handle_noneed'), 0);
            switch($params['hook_name'])
            {
                // 顶部登录入口/登录信息
                case 'plugins_view_header_navigation_top_left' :
                    $ret = $this->LoginNavTopHtml($params);
                    break;

                // 用户登录页面顶部
                case 'plugins_view_user_login_inside_reg_bottom' :
                case 'plugins_view_user_login_inside_reg_bottom' :
                    $ret = $this->UserLoginInfoHtml($params);
                    break;

                // header代码
                case 'plugins_common_header' :
                    $ret = $this->Style($params);
                    break;

                // 导航链接
                case 'plugins_service_navigation_header_handle' :
                $ret = $this->NavTitle($params);
                    break;

                // 系统运行开始
                case 'plugins_service_system_begin' :
                    if($this->module_name != 'admin')
                    {
                        $ret = $this->SystemBegin($params);
                    }
                    break;
            }
            return $ret;

        // 默认返回视图
        } else {
            return '';
        }
    }

    /**
     * 系统运行开始
     * @author   Devil
     * @blog    http://gong.gg/
     * @version 1.0.0
     * @date    2019-03-18
     * @desc    description
     * @param    [array]          $params [输入参数]
     */
    public function SystemBegin($params = [])
    {
        // 是否开启默认游客
        if(MyInput('pluginsname') != 'touristbuy' && $this->module_name == 'index' && $this->mca != 'indexuserlogout')
        {
            $ret = PluginsService::PluginsData('touristbuy');
            if($ret['code'] == 0 && isset($ret['data']['is_default_tourist']) && $ret['data']['is_default_tourist'] == 1)
            {
                $user = UserService::LoginUserInfo();
                if(empty($user))
                {
                    $is_tips = (isset($ret['data']['is_auto_login_tips']) && $ret['data']['is_auto_login_tips'] == 1) ? 1 : 0;
                    die(header('location:'.PluginsHomeUrl('touristbuy', 'index', 'login', array_merge($params['params'], ['is_tips'=>$is_tips, 'to_url'=>urlencode(__MY_VIEW_URL__)]))));
                }
            }
        }
        return DataReturn(MyLang('handle_noneed'), 0);
    }

    /**
     * css
     * @author   Devil
     * @blog     http://gong.gg/
     * @version  1.0.0
     * @datetime 2019-02-06T16:16:34+0800
     * @param    [array]          $params [输入参数]
     */
    public function NavTitle($params = [])
    {
        if(!empty($params['header']) && is_array($params['header']))
        {
            // 获取应用数据
            $ret = PluginsService::PluginsData('touristbuy');
            if($ret['code'] == 0 && !empty($ret['data']['application_name']))
            {
                $params['header'][] = [
                    'id'                    => 0,
                    'pid'                   => 0,
                    'name'                  => $ret['data']['application_name'],
                    'url'                   => PluginsHomeUrl('touristbuy', 'index', 'index'),
                    'data_type'             => 'custom',
                    'is_show'               => 1,
                    'is_new_window_open'    => 0,
                    'items'                 => [],
                ];
            }
        }
    }

    /**
     * css
     * @author   Devil
     * @blog     http://gong.gg/
     * @version  1.0.0
     * @datetime 2019-02-06T16:16:34+0800
     * @param    [array]          $params [输入参数]
     */
    public function Style($params = [])
    {
        return '<style type="text/css">
                    .plugins-touristbuy-nav-top { color: #FF5722; }
                </style>';
    }

    /**
     * 前端顶部小导航展示登入
     * @author   Guoguo
     * @blog     http://gadmin.cojz8.com
     * @version  1.0.0
     * @datetime 2019年3月14日
     * @param    [array]          $params [输入参数]
     */
    public function UserLoginInfoHtml($params = [])
    {
        // 获取已登录用户信息，已登录则不展示入口
        $user = UserService::LoginUserInfo();
        if(empty($user))
        {
            // 当前窗口登录父级
            $is_parent = ($this->module_name.$this->controller_name.$this->action_name == 'indexusermodallogininfo') ? 1 : 0;

            // 获取应用数据
            $ret = PluginsService::PluginsData('touristbuy');
            $login_name = empty($ret['data']['login_name']) ? '游客' : $ret['data']['login_name'];
            return '<b class="line-column">|</b>
                    <a href="'.PluginsHomeUrl('touristbuy', 'index', 'login', ['is_parent'=>$is_parent]).'" class="am-btn-xs am-color-gray">'.$login_name.'</a>';
        }
        return '';
    }

    /**
     * 前端顶部小导航展示登入
     * @author   Guoguo
     * @blog     http://gadmin.cojz8.com
     * @version  1.0.0
     * @datetime 2019年3月14日
     * @param    [array]          $params [输入参数]
     */
    public function LoginNavTopHtml($params = [])
    {
        // 获取已登录用户信息，已登录则不展示入口
        $user = UserService::LoginUserInfo();
        if(empty($user))
        {
            // 获取应用数据
            $ret = PluginsService::PluginsData('touristbuy');
            $login_name = empty($ret['data']['login_name']) ? '游客' : $ret['data']['login_name'];
            return '<a href="'.PluginsHomeUrl('touristbuy', 'index', 'login').'" class="plugins-touristbuy-nav-top am-margin-left-xs">'.$login_name.'</a>';
        }
        return '';
    }
}
?>
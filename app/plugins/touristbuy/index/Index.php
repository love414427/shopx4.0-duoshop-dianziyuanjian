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
namespace app\plugins\touristbuy\index;

use app\plugins\touristbuy\service\Service;
use app\service\SeoService;
use app\service\PluginsService;
use app\service\SystemService;

/**
 * 游客购买 - 前端独立页面入口
 * @author   Devil
 * @blog     http://gong.gg/
 * @version  0.0.1
 * @datetime 2016-12-01T21:51:08+0800
 */
class Index
{
    /**
     * 订单查询入口
     * @author   Devil
     * @blog     http://gong.gg/
     * @version  1.0.0
     * @datetime 2019-03-15T23:51:50+0800
     * @param   [array]          $params [输入参数]
     */
    public function Index($params = [])
    {
        $ret = PluginsService::PluginsData('touristbuy');
        if($ret['code'] == 0)
        {
            MyViewAssign('data', $ret['data']);
            MyViewAssign('home_seo_site_title', SeoService::BrowserSeoTitle('订单查询', 1));
            return MyView('../../../plugins/view/touristbuy/index/index/index');
        } else {
            return $ret['msg'];
        }
    }

    /**
     * 订单详情
     * @author   Devil
     * @blog     http://gong.gg/
     * @version  1.0.0
     * @datetime 2019-03-15T23:51:50+0800
     * @param   [array]          $params [输入参数]
     */
    public function Detail($params = [])
    {
        // 请求参数
        $ret = Service::OrderDetail($params);
        if($ret['code'] == 0)
        {
            MyViewAssign('data', $ret['data']);
            MyViewAssign('home_seo_site_title', SeoService::BrowserSeoTitle('订单详情', 1));

            // 参数
            MyViewAssign('params', $params);
            return MyView('../../../plugins/view/touristbuy/index/index/detail');
        } else {
            MyViewAssign('msg', $ret['msg']);
            return MyView('public/tips_error');
        }
    }

    /**
     * 游客登录
     * @author   Devil
     * @blog     http://gong.gg/
     * @version  1.0.0
     * @datetime 2019-03-15T22:31:29+0800
     * @param   [array]          $params [输入参数]
     */
    public function Login($params = [])
    {
        $ret = Service::TouristReg();
        if($ret['code'] == 0)
        {
            // 是否指定url地址
            $to_url = empty($params['to_url']) ? SystemService::HomeUrl() : urldecode($params['to_url']);

            // 是否不提示
            if(isset($params['is_tips']) && $params['is_tips'] == 0)
            {
                return MyRedirect($to_url);
            }

            // 成功提示
            return MyView('public/login_success', [
                'home_url'   => $to_url,
                'msg'        => $ret['msg'],
                'data'       => $ret['data'],
                'is_parent'  => isset($params['is_parent']) ? $params['is_parent'] : 0,
                'is_header'  => 0,
                'is_footer'  => 0,
                'is_home'    => 0,
            ]);
        } else {
            MyViewAssign('msg', $ret['msg']);
            return MyView('public/tips_error');
        }
    }
}
?>
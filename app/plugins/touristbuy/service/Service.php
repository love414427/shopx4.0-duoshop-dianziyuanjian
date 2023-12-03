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
namespace app\plugins\touristbuy\service;

use think\facade\Db;
use app\service\UserService;
use app\service\OrderService;
use app\service\PluginsService;

/**
 * 问答系统服务层
 * @author   Devil
 * @blog     http://gong.gg/
 * @version  0.0.1
 * @datetime 2016-12-01T21:51:08+0800
 */
class Service
{
    /**
     * 游客注册
     * @author   Devil
     * @blog    http://gong.gg/
     * @version 1.0.0
     * @date    2018-12-03
     * @desc    description
     * @param   [array]          $params [输入参数]
     */
    public static function TouristReg($params = [])
    {
        // 获取登录用户
        $user = UserService::LoginUserInfo();
        if(!empty($user))
        {
            return DataReturn('已登录，请先退出', -1);
        }

        // 是否有登录纪录
        $tourist_user_id = MySession('tourist_user_id');
        if(!empty($tourist_user_id))
        {
            $user = UserService::UserInfo('id', $tourist_user_id);
            if(!empty($user))
            {
                // 用户登录
                return UserService::UserLoginHandle($tourist_user_id, $params);
            }
            MySession('tourist_user_id', null);
        }

        // 获取应用数据
        $ret = PluginsService::PluginsData('touristbuy');
        $nickname = empty($ret['data']['nickname']) ? '游客' : $ret['data']['nickname'];
        $nickname = $nickname.'-'.RandomString(6);

        // 游客数据
        $salt = GetNumberCode(6);
        $data = [
            'username'      => $nickname,
            'nickname'      => $nickname,
            'status'        => 0,
            'salt'          => $salt,
            'pwd'           => LoginPwdEncryption($nickname, $salt),
            'add_time'      => time(),
            'upd_time'      => time(),
        ];

        // 数据添加
        $ret = UserService::UserInsert($data, ['nickname'=>$nickname, 'pwd'=>$nickname]);
        if($ret['code'] == 0)
        {
            // 单独存储用户id
            MySession('tourist_user_id', $ret['data']['user_id']);

            // 用户登录session纪录
            if(UserService::UserLoginRecord($ret['data']['user_id']))
            {
                return DataReturn(MyLang('login_success'), 0, $ret['data']);
            }
        }
        return DataReturn('登录失败', -100);
    }

    /**
     * 订单详情
     * @author   Devil
     * @blog     http://gong.gg/
     * @version  1.0.0
     * @datetime 2019-03-15T23:51:50+0800
     * @param   [array]          $params [输入参数]
     */
    public static function OrderDetail($params = [])
    {
        // 请求参数
        $p = [
            [
                'checked_type'      => 'empty',
                'key_name'          => 'order_no',
                'error_msg'         => '请输入订单号',
            ],
            [
                'checked_type'      => 'empty',
                'key_name'          => 'name',
                'error_msg'         => '请输入姓名',
            ],
            [
                'checked_type'      => 'empty',
                'key_name'          => 'tel',
                'error_msg'         => '请输入电话',
            ],
        ];
        $ret = ParamsChecked($params, $p);
        if($ret !== true)
        {
            return DataReturn($ret, -1);
        }

        // 收件信息查询
        $oid = Db::name('OrderAddress')->where(['name'=>$params['name'], 'tel'=>$params['tel']])->order('id desc')->value('order_id');
        if(empty($oid))
        {
            return DataReturn('收件人或电话有误', -1);
        }

        // 条件
        $where = [
            ['is_delete_time', '=', 0],
            ['order_no', '=', $params['order_no']],
            ['id', '=', $oid],
        ];

        // 获取列表
        $data_params = [
            'm'         => 0,
            'n'         => 1,
            'where'     => $where,
        ];
        $data = OrderService::OrderList($data_params);
        if(!empty($data['data'][0]))
        {
            return DataReturn('success', 0, $data['data'][0]);
        }
        return DataReturn(MyLang('no_data'), -1);
    }
}
?>
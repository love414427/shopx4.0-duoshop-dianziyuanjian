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
namespace app\plugins\wallet\form\admin;

use think\facade\Db;
use app\plugins\wallet\service\BaseService;

/**
 * 钱包余额提现动态表单
 * @author  Devil
 * @blog    http://gong.gg/
 * @version 1.0.0
 * @date    2020-05-16
 * @desc    description
 */
class Cash
{
    // 基础条件
    public $condition_base = [];

    /**
     * 入口
     * @author  Devil
     * @blog    http://gong.gg/
     * @version 1.0.0
     * @date    2020-05-16
     * @desc    description
     * @param   [array]           $params [输入参数]
     */
    public function Run($params = [])
    {
        return [
            // 基础配置
            'base' => [
                'key_field'     => 'id',
                'is_search'     => 1,
            ],
            // 表单配置
            'form' => [
                [
                    'label'         => '用户信息',
                    'view_type'     => 'module',
                    'view_key'      => 'lib/module/user',
                    'grid_size'     => 'sm',
                    'is_sort'       => 1,
                    'search_config' => [
                        'form_type'             => 'input',
                        'form_name'             => 'user_id',
                        'where_type_custom'     => 'in',
                        'where_value_custom'    => 'WhereValueUserInfo',
                        'placeholder'           => '请输入用户名/昵称/手机/邮箱',
                    ],
                ],
                [
                    'label'         => '提现单号',
                    'view_type'     => 'field',
                    'view_key'      => 'cash_no',
                    'is_sort'       => 1,
                    'width'         => 200,
                    'search_config' => [
                        'form_type'         => 'input',
                    ],
                ],
                [
                    'label'              => '状态',
                    'view_type'          => 'field',
                    'view_key'           => 'status_name',
                    'is_sort'            => 1,
                    'width'              => 120,
                    'is_round_point'     => 1,
                    'round_point_key'    => 'status',
                    'round_point_style'  => [1=>'success', 2=>'danger'],
                    'search_config'      => [
                        'form_type'         => 'select',
                        'form_name'         => 'status',
                        'where_type'        => 'in',
                        'data'              => BaseService::ConstData('cash_status_list'),
                        'data_key'          => 'value',
                        'data_name'         => 'name',
                        'is_multiple'       => 1,
                    ],
                ],
                [
                    'label'         => '提现金额(元)',
                    'view_type'     => 'field',
                    'view_key'      => 'money',
                    'is_sort'       => 1,
                    'search_config' => [
                        'form_type'         => 'section',
                        'is_point'          => 1,
                    ],
                ],
                [
                    'label'         => '提现平台',
                    'view_type'     => 'field',
                    'view_key'      => 'bank_name',
                    'is_sort'       => 1,
                    'search_config' => [
                        'form_type'         => 'input',
                        'where_type'        => 'like',
                    ],
                ],
                [
                    'label'         => '提现姓名',
                    'view_type'     => 'field',
                    'view_key'      => 'bank_username',
                    'is_sort'       => 1,
                    'search_config' => [
                        'form_type'         => 'input',
                        'where_type'        => 'like',
                    ],
                ],
                [
                    'label'         => '提现账号',
                    'view_type'     => 'field',
                    'view_key'      => 'bank_accounts',
                    'is_sort'       => 1,
                    'search_config' => [
                        'form_type'         => 'input',
                        'where_type'        => 'like',
                    ],
                ],
                [
                    'label'         => '打款金额(元)',
                    'view_type'     => 'field',
                    'view_key'      => 'pay_money',
                    'is_sort'       => 1,
                    'search_config' => [
                        'form_type'         => 'section',
                        'is_point'          => 1,
                    ],
                ],
                [
                    'label'         => '打款时间',
                    'view_type'     => 'field',
                    'view_key'      => 'pay_time_time',
                    'search_config' => [
                        'form_type'         => 'datetime',
                    ],
                ],
                [
                    'label'         => '备注',
                    'view_type'     => 'field',
                    'view_key'      => 'msg',
                    'is_sort'       => 1,
                    'grid_size'     => 'sm',
                    'text_truncate' => 2,
                    'is_popover'    => 1,
                    'search_config' => [
                        'form_type'         => 'input',
                        'where_type'        => 'like',
                    ],
                ],
                [
                    'label'         => '申请时间',
                    'view_type'     => 'field',
                    'view_key'      => 'add_time_time',
                    'search_config' => [
                        'form_type'         => 'datetime',
                    ],
                ],
                [
                    'label'         => '更新时间',
                    'view_type'     => 'field',
                    'view_key'      => 'upd_time_time',
                    'search_config' => [
                        'form_type'         => 'datetime',
                    ],
                ],
                [
                    'label'         => MyLang('operate_title'),
                    'view_type'     => 'operate',
                    'view_key'      => '../../../plugins/view/wallet/admin/cash/module/operate',
                    'align'         => 'center',
                    'fixed'         => 'right',
                ],
            ],
            // 数据配置
            'data'  => [
                'table_name'            => 'PluginsWalletCash',
                'data_handle'           => 'BaseService::CashListHandle',
            ],
        ];
    }

    /**
     * 用户信息条件处理
     * @author  Devil
     * @blog    http://gong.gg/
     * @version 1.0.0
     * @date    2020-06-26
     * @desc    description
     * @param   [string]          $value    [条件值]
     * @param   [array]           $params   [输入参数]
     */
    public function WhereValueUserInfo($value, $params = [])
    {
        if(!empty($value))
        {
            // 获取用户 id
            $ids = Db::name('User')->where('number_code|username|nickname|mobile|email', 'like', '%'.$value.'%')->column('id');

            // 避免空条件造成无效的错觉
            return empty($ids) ? [0] : $ids;
        }
        return $value;
    }
}
?>
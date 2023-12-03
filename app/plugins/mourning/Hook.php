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
namespace app\plugins\mourning;

use app\plugins\mourning\service\BaseService;

/**
 * 哀悼 - 钩子入口
 * @author   Devil
 * @blog     http://gong.gg/
 * @version  0.0.1
 * @datetime 2019-08-11T21:51:08+0800
 */
class Hook
{
    /**
     * 应用响应入口
     * @author   Devil
     * @blog     http://gong.gg/
     * @version  1.0.0
     * @datetime 2019-08-11T14:25:44+0800
     * @param    [array]          $params [输入参数]
     */
    public function handle($params = [])
    {
        // 钩子名称
        $ret = '';
        if(!empty($params['hook_name']))
        {
            switch($params['hook_name'])
            {
                // header
                case 'plugins_common_header' :
                    $ret = $this->CommonStyle($params);
                    break;

                // 首页接口数据
                case 'plugins_service_base_data_return_api_index_index' :
                    $ret = $this->IndexResultHandle($params);
                    break;
            }
        }
        return $ret;
    }

    /**
     * 首页接口数据
     * @author  Devil
     * @blog    http://gong.gg/
     * @version 1.0.0
     * @date    2021-01-06
     * @desc    description
     * @param   [array]           $params [输入参数]
     */
    private function IndexResultHandle($params = [])
    {
        // 配置数据
        $data = BaseService::ConfigData();
        if(!empty($data) && isset($data['is_app']) && $data['is_app'] == 1)
        {
            $params['data']['plugins_mourning_data'] = 1;
        }
    }

    /**
     * 内容
     * @author  Devil
     * @blog    http://gong.gg/
     * @version 1.0.0
     * @date    2020-02-13
     * @desc    description
     * @param   [array]           $params [输入参数]
     */
    private function CommonStyle($params = [])
    {
        // 配置数据
        $data = BaseService::ConfigData();
        if(empty($data))
        {
            return '';
        }

        // 当前模块/控制器/方法
        $module_name = RequestModule();
        $controller_name = RequestController();
        $action_name = RequestAction();

        // 整站有效
        if($module_name.$controller_name.$action_name != 'indexindexindex')
        {
            if(!isset($data['is_all']) || $data['is_all'] != 1)
            {
                return '';
            }
        }

        // 灰度值
        $grayscale = empty($data['grayscale']) ? 100 : intval($data['grayscale']);

        // css
        return '<style type="text/css">html{overflow-y:scroll;filter:progid:DXImageTransform.Microsoft.BasicImage(grayscale=1);-webkit-filter: grayscale('.$grayscale.'%);}</style>';
    }
}
?>
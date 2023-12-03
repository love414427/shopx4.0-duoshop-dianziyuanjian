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
namespace app\plugins\mourning\service;

use think\facade\Db;
use app\service\PluginsService;

/**
 * 哀悼 - 基础服务层
 * @author  Devil
 * @blog    http://gong.gg/
 * @version 1.0.0
 * @date    2019-09-24
 * @desc    description
 */
class BaseService
{
    /**
     * 基础配置信息保存
     * @author  Devil
     * @blog    http://gong.gg/
     * @version 1.0.0
     * @date    2019-12-24
     * @desc    description
     * @param   [array]          $params [输入参数]
     */
    public static function BaseConfigSave($params = [])
    {
        return PluginsService::PluginsDataSave(['plugins'=>'mourning', 'data'=>$params]);
    }
    
    /**
     * 基础配置信息
     * @author  Devil
     * @blog    http://gong.gg/
     * @version 1.0.0
     * @date    2019-12-24
     * @desc    description
     * @param   [boolean]          $is_cache [是否缓存中读取]
     */
    public static function BaseConfig($is_cache = true)
    {
        return PluginsService::PluginsData('mourning', null, $is_cache);
    }

    /**
     * 有效配置信息
     * @author  Devil
     * @blog    http://gong.gg/
     * @version 1.0.0
     * @date    2021-11-11
     * @desc    description
     */
    public static function ConfigData()
    {
        // 配置
        $ret = self::BaseConfig();

        // 开始时间
        if(!empty($ret['data']['time_start']))
        {
            if(strtotime($ret['data']['time_start']) > time())
            {
                return '';
            }
        }

        // 结束时间
        if(!empty($ret['data']['time_end']))
        {
            if(strtotime($ret['data']['time_end']) < time())
            {
                return '';
            }
        }

        return $ret['data'];
    }
}
?>
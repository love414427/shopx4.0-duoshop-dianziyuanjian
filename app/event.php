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

// 应用行为扩展定义文件
return array (
  'listen' => 
  array (
    'plugins_service_users_center_left_menu_handle' => 
    array (
      0 => 'app\\plugins\\wallet\\Hook',
    ),
    'plugins_service_header_navigation_top_right_handle' => 
    array (
      0 => 'app\\plugins\\wallet\\Hook',
    ),
    'plugins_service_user_register_end' => 
    array (
      0 => 'app\\plugins\\wallet\\Hook',
    ),
    'plugins_layout_service_url_value_begin' => 
    array (
      0 => 'app\\plugins\\wallet\\Hook',
    ),
    'plugins_layout_service_pages_list' => 
    array (
      0 => 'app\\plugins\\wallet\\Hook',
    ),
    'plugins_service_const_data' => 
    array (
      0 => 'app\\plugins\\wallet\\Hook',
    ),
    'plugins_service_payment_buy_list' => 
    array (
      0 => 'app\\plugins\\wallet\\Hook',
    ),
    'plugins_service_buy_group_goods_handle' => 
    array (
      0 => 'app\\plugins\\newuserreduction\\Hook',
    ),
    'plugins_service_system_begin' => 
    array (
      0 => 'app\\plugins\\touristbuy\\Hook',
    ),
    'plugins_common_header' => 
    array (
      0 => 'app\\plugins\\touristbuy\\Hook',
      1 => 'app\\plugins\\homemiddleadv\\Hook',
      2 => 'app\\plugins\\commongobacktop\\Hook',
    ),
    'plugins_view_header_navigation_top_left' => 
    array (
      0 => 'app\\plugins\\touristbuy\\Hook',
    ),
    'plugins_view_user_login_inside_reg_bottom' => 
    array (
      0 => 'app\\plugins\\touristbuy\\Hook',
    ),
    'plugins_service_navigation_header_handle' => 
    array (
      0 => 'app\\plugins\\touristbuy\\Hook',
    ),
    'plugins_view_home_floor_top' => 
    array (
      0 => 'app\\plugins\\homemiddleadv\\Hook',
    ),
    'plugins_service_base_data_return_api_index_index' => 
    array (
      0 => 'app\\plugins\\homemiddleadv\\Hook',
    ),
    'plugins_view_common_bottom' => 
    array (
      0 => 'app\\plugins\\commongobacktop\\Hook',
    ),
    'plugins_common_page_bottom' => 
    array (
      0 => 'app\\plugins\\commongobacktop\\Hook',
    ),
  ),
);
?>
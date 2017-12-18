<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Sat, 10 Dec 2011 06:46:54 GMT
 */

if (!defined('NV_MAINFILE')) {
    die('Stop!!!');
}

if (!nv_function_exists('nv_block_snow_effect')) {

    function nv_block_config_snow_effect($module, $data_block, $lang_block)
    {
        global $global_config, $site_mods;

        if (file_exists(NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/tdfoss/global.snow_effect.tpl')) {
            $block_theme = $global_config['module_theme'];
        } else {
            $block_theme = 'default';
        }

        $xtpl = new XTemplate('global.snow_effect.tpl', NV_ROOTDIR . '/themes/' . $block_theme . '/modules/tdfoss');
        $xtpl->assign('LANG', $lang_block);
        $xtpl->assign('DATA', $data_block);

        $xtpl->parse('config');
        return $xtpl->text('config');
    }

    function nv_block_config_snow_effect_submit($module, $lang_block)
    {
        global $nv_Request, $site_mods;

        $return = array();
        $return['error'] = array();
        $return['config'] = array();
        $return['config']['minsize'] = $nv_Request->get_int('config_minsize', 'post', 10);
        $return['config']['maxsize'] = $nv_Request->get_int('config_maxsize', 'post', 20);
        $return['config']['newon'] = $nv_Request->get_int('config_newon', 'post', 500);
        $return['config']['flakecolor'] = $nv_Request->get_title('config_flakecolor', 'post', '#FFFFFF');
        return $return;
    }

    function nv_block_snow_effect($block_config)
    {
        global $module_info, $site_mods, $global_config;

        if (file_exists(NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/tdfoss/global.snow_effect.tpl')) {
            $block_theme = $global_config['module_theme'];
        } else {
            $block_theme = 'default';
        }

        $xtpl = new XTemplate('global.snow_effect.tpl', NV_ROOTDIR . '/themes/' . $block_theme . '/modules/tdfoss');
        $xtpl->assign('TEMPLATE', $block_theme);
        $xtpl->assign('DATA', $block_config);

        $xtpl->parse('main');
        return $xtpl->text('main');
    }
}

if (defined('NV_SYSTEM')) {
    $content = nv_block_snow_effect($block_config);
}
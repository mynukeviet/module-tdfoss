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

if (!nv_function_exists('nv_block_google_adsense')) {

    function nv_block_config_google_adsense($module, $data_block, $lang_block)
    {
        global $global_config, $site_mods;

        if (file_exists(NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/tdfoss/global.call_phone.tpl')) {
            $block_theme = $global_config['module_theme'];
        } else {
            $block_theme = 'default';
        }

        $xtpl = new XTemplate('global.google_adsense.tpl', NV_ROOTDIR . '/themes/' . $block_theme . '/modules/tdfoss');
        $xtpl->assign('LANG', $lang_block);
        $xtpl->assign('DATA', $data_block);

        $xtpl->parse('config');
        return $xtpl->text('config');
    }

    function nv_block_config_google_adsense_submit($module, $lang_block)
    {
        global $nv_Request, $site_mods;

        $return = array();
        $return['error'] = array();
        $return['config'] = array();
        $return['config']['idclient'] = $nv_Request->get_title('config_idclient', 'post', '');
        $return['config']['idslot'] = $nv_Request->get_title('config_idslot', 'post', '');
        $return['config']['width'] = $nv_Request->get_int('config_width', 'post', 0);
        $return['config']['height'] = $nv_Request->get_int('config_height', 'post', 0);
        return $return;
    }

    function nv_block_google_adsense($block_config)
    {
        global $module_info, $site_mods, $global_config;

        if (file_exists(NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/tdfoss/global.google_adsense.tpl')) {
            $block_theme = $global_config['module_theme'];
        } else {
            $block_theme = 'default';
        }

        $xtpl = new XTemplate('global.google_adsense.tpl', NV_ROOTDIR . '/themes/' . $block_theme . '/modules/tdfoss');
        $xtpl->assign('TEMPLATE', $block_theme);
        $xtpl->assign('CONFIG', $block_config);

        if (!empty($block_config['width']) && !empty($block_config['height'])) {
            $xtpl->parse('main.size');
        } else {
            $xtpl->parse('main.auto');
        }

        $xtpl->parse('main');
        return $xtpl->text('main');
    }
}

if (defined('NV_SYSTEM')) {
    $content = nv_block_google_adsense($block_config);
}
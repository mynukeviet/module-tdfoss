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

if (!nv_function_exists('nv_block_call_phone')) {

    function nv_block_config_call_phone($module, $data_block, $lang_block)
    {
        global $global_config, $site_mods;

        $mod_upload = $site_mods[$module]['module_upload'];

        if (file_exists(NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/tdfoss/global.call_phone.tpl')) {
            $block_theme = $global_config['module_theme'];
        } else {
            $block_theme = 'default';
        }

        $array_position = array(
            'left' => $lang_block['position_left'],
            'right' => $lang_block['position_right']
        );

        $xtpl = new XTemplate('global.call_phone.tpl', NV_ROOTDIR . '/themes/' . $block_theme . '/modules/tdfoss');
        $xtpl->assign('LANG', $lang_block);
        $xtpl->assign('DATA', $data_block);

        foreach ($array_position as $index => $value) {
            $ck = $index == $data_block['position'] ? 'checked="checked"' : '';
            $xtpl->assign('POSITION', array(
                'index' => $index,
                'value' => $value,
                'checked' => $ck
            ));
            $xtpl->parse('config.position');
        }

        $xtpl->parse('config');
        return $xtpl->text('config');
    }

    function nv_block_config_call_phone_submit($module, $lang_block)
    {
        global $nv_Request, $site_mods;

        $return = array();
        $return['error'] = array();
        $return['config'] = array();
        $return['config']['phone'] = $nv_Request->get_int('config_phone', 'post', '');
        $return['config']['position'] = $nv_Request->get_title('config_position', 'post', 'right');
        $return['config']['position_x'] = $nv_Request->get_int('config_position_x', 'post', 50);
        $return['config']['position_y'] = $nv_Request->get_int('config_position_y', 'post', 15);
        return $return;
    }

    function nv_block_call_phone($block_config)
    {
        global $module_info, $site_mods, $global_config;

        $module = $block_config['module'];
        $mod_upload = $site_mods[$module]['module_upload'];

        if (file_exists(NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/tdfoss/global.call_phone.tpl')) {
            $block_theme = $global_config['module_theme'];
        } else {
            $block_theme = 'default';
        }

        if (!empty($block_config['phone_icon']) and file_exists(NV_ROOTDIR . '/' . NV_UPLOADS_DIR . '/' . $mod_upload . '/' . $block_config['phone_icon'])) {
            $block_config['phone_icon'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $mod_upload . '/' . $block_config['phone_icon'];
        } else {
            $block_config['phone_icon'] = NV_BASE_SITEURL . 'themes/' . $block_theme . '/images/tdfoss/phone-icon.png';
        }

        if (empty($block_config['phone']) || empty($block_config['phone_icon'])) return '';

        $xtpl = new XTemplate('global.call_phone.tpl', NV_ROOTDIR . '/themes/' . $block_theme . '/modules/tdfoss');
        $xtpl->assign('TEMPLATE', $block_theme);
        $xtpl->assign('CONFIG', $block_config);

        $xtpl->parse('main');
        return $xtpl->text('main');
    }
}

if (defined('NV_SYSTEM')) {
    $content = nv_block_call_phone($block_config);
}
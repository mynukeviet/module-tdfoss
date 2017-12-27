<?php

/**
 * @Project NUKEVIET 4.x
 * @Author TDFOSS.,LTD (contact@tdfoss.vn)
 * @Copyright (C) 2017 TDFOSS.,LTD. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Wed, 27 Dec 2017 08:46:54 GMT
 */

if (!defined('NV_MAINFILE')) {
    die('Stop!!!');
}

if (!nv_function_exists('nv_block_fb_fanpage')) {

    function nv_block_config_fb_fanpage($module, $data_block, $lang_block)
    {
        global $global_config, $site_mods;

        if (file_exists(NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/tdfoss/global.fb_fanpage.tpl')) {
            $block_theme = $global_config['module_theme'];
        } else {
            $block_theme = 'default';
        }

        $array_tabs = array(
            'timeline' => 'timeline',
            'events' => 'events',
            'messages' => 'messages'
        );

        $data_block['ck_small_header'] = $data_block['small_header'] ? 'checked="checked"' : '';
        $data_block['ck_container_width'] = $data_block['container_width'] ? 'checked="checked"' : '';
        $data_block['ck_hide_cover'] = $data_block['hide_cover'] ? 'checked="checked"' : '';
        $data_block['ck_show_facepile'] = $data_block['show_facepile'] ? 'checked="checked"' : '';

        $xtpl = new XTemplate('global.fb_fanpage.tpl', NV_ROOTDIR . '/themes/' . $block_theme . '/modules/tdfoss');
        $xtpl->assign('LANG', $lang_block);
        $xtpl->assign('DATA', $data_block);

        foreach ($array_tabs as $tabs) {
            $ck = $tabs == $data_block['tabs'] || in_array($tabs, $data_block['tabs']) ? 'checked="checked"' : '';
            $xtpl->assign('TABS', array(
                'index' => $tabs,
                'checked' => $ck
            ));
            $xtpl->parse('config.tabs');
        }

        $xtpl->parse('config');
        return $xtpl->text('config');
    }

    function nv_block_config_fb_fanpage_submit($module, $lang_block)
    {
        global $nv_Request, $site_mods;

        $return = array();
        $return['error'] = array();
        $return['config'] = array();
        $return['config']['href'] = $nv_Request->get_title('config_href', 'post', 'https://www.facebook.com/tdfoss.vn');
        $return['config']['tabs'] = $nv_Request->get_array('config_tabs', 'post');
        $return['config']['width'] = $nv_Request->get_int('config_width', 'post', 340);
        $return['config']['height'] = $nv_Request->get_int('config_height', 'post', 500);
        $return['config']['small_header'] = $nv_Request->get_int('config_small_header', 'post', 0);
        $return['config']['container_width'] = $nv_Request->get_int('config_container_width', 'post', 1);
        $return['config']['hide_cover'] = $nv_Request->get_int('config_hide_cover', 'post', 0);
        $return['config']['show_facepile'] = $nv_Request->get_int('config_show_facepile', 'post', 1);
        return $return;
    }

    function nv_block_fb_fanpage($block_config)
    {
        global $module_info, $site_mods, $global_config;

        if (file_exists(NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/tdfoss/global.fb_fanpage.tpl')) {
            $block_theme = $global_config['module_theme'];
        } else {
            $block_theme = 'default';
        }

        $block_config['small_header'] = $block_config['small_header'] ? true : false;
        $block_config['container_width'] = $block_config['container_width'] ? true : false;
        $block_config['hide_cover'] = $block_config['hide_cover'] ? true : false;
        $block_config['show_facepile'] = $block_config['show_facepile'] ? true : false;
        $block_config['tabs'] = implode(',', $block_config['tabs']);

        $xtpl = new XTemplate('global.fb_fanpage.tpl', NV_ROOTDIR . '/themes/' . $block_theme . '/modules/tdfoss');
        $xtpl->assign('TEMPLATE', $block_theme);
        $xtpl->assign('DATA', $block_config);

        $xtpl->parse('main');
        return $xtpl->text('main');
    }
}

if (defined('NV_SYSTEM')) {
    $content = nv_block_fb_fanpage($block_config);
}
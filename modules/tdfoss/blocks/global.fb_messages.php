<?php

/**
 * @Project NUKEVIET 4.x
 * @Author nvsystems (adminwmt@gmail.com)
 * @Copyright (C) 2014 VINADES ., JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Jun 26, 2016 11:34:27 AM
 */
if (!defined('NV_MAINFILE')) die('Stop!!!');

if (!nv_function_exists('nv_fb_chat')) {

    function nv_fb_messages_config($module, $data_block, $lang_block)
    {
        global $lang_global, $selectthemes;

        $html = '<div class="form-group">';
        $html .= '<label class="control-label col-sm-6">Pageid</label>';
        $html .= '<div class="col-sm-18"><input type="text" class="form-control" name="config_page_id" value="' . $data_block['page_id'] . '"></div>';
        $html .= '</div>';
        $html .= '<div class="form-group">';
        $html .= '<label class="control-label col-sm-6">' . $lang_block['logged_in_greeting'] . ':</label>';
        $html .= '<div class="col-sm-18"><input type="text" class="form-control" name="config_logged_in_greeting" value="' . $data_block['logged_in_greeting'] . '"></div>';
        $html .= '</div>';
        $html .= '<div class="form-group">';
        $html .= '<label class="control-label col-sm-6">' . $lang_block['logged_out_greeting'] . ':</label>';
        $html .= '<div class="col-sm-18"><input type="text" class="form-control" name="config_logged_out_greeting" value="' . $data_block['logged_out_greeting'] . '"></div>';
        $html .= '</div>';
        return $html;
    }

    function nv_fb_messages_submit()
    {
        global $nv_Request;

        $return = array();
        $return['error'] = array();
        $return['config']['page_id'] = $nv_Request->get_title('config_page_id', 'post');
        $return['config']['logged_in_greeting'] = $nv_Request->get_title('config_logged_in_greeting', 'post');
        $return['config']['logged_out_greeting'] = $nv_Request->get_title('config_logged_out_greeting', 'post');

        return $return;
    }

    /**
     * nv_fb_messages()
     *
     * @param mixed $block_config
     * @return
     */
    function nv_fb_messages($block_config)
    {
        global $global_config, $lang_global;

        if (file_exists(NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/tdfoss/global.fb_messages.tpl')) {
            $block_theme = $global_config['module_theme'];
        } elseif (file_exists(NV_ROOTDIR . '/themes/' . $global_config['site_theme'] . '/modules/tdfoss/global.fb_messages.tpl')) {
            $block_theme = $global_config['site_theme'];
        } else {
            $block_theme = 'default';
        }

        $xtpl = new XTemplate('global.fb_messages.tpl', NV_ROOTDIR . '/themes/' . $block_theme . '/modules/tdfoss');
        $xtpl->assign('LANG', $lang_global);
        $xtpl->assign('NV_BASE_SITEURL', NV_BASE_SITEURL);
        $xtpl->assign('CONFIG', $block_config);
        $xtpl->parse('main');
        return $xtpl->text('main');
    }
}

if (defined('NV_SYSTEM')) {
    $content = nv_fb_messages($block_config);
}

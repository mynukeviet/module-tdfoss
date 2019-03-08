<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Sun, 04 May 2014 12:41:32 GMT
 */
if (!defined('NV_MAINFILE')) {
    die('Stop!!!');
}

if (!nv_function_exists('nv_block_code')) {

    function nv_block_code_config($module, $data_block, $lang_block)
    {
        if (empty($data_block['filename'])) {
            $data_block['filename'] = 'block_code_' . md5(NV_CURRENTTIME) . '.txt';
        }

        if (file_exists(NV_ROOTDIR . '/' . NV_FILES_DIR . '/' . $data_block['filename'])) {
            $code = file_get_contents(NV_ROOTDIR . '/' . NV_FILES_DIR . '/' . $data_block['filename']);
        } else {
            $code = '';
        }

        $html = '';
        $html .= '<div class="form-group">';
        $html .= '<label class="control-label col-sm-6">Code</label>';
        $html .= '<div class="col-sm-18"><textarea name="config_code" class="form-control" style="height: 300px">' . $code . '</textarea></div>';
        $html .= '</div>';
        $html .= '<input type="hidden" name="config_filename" value="' . $data_block['filename'] . '" />';
        return $html;
    }

    function nv_block_code_submit($module, $lang_block)
    {
        global $nv_Request;

        $return = array();
        $return['error'] = array();
        $return['config'] = array();

        $filename = $nv_Request->get_title('config_filename', 'post', 'block_code_' . md5(NV_CURRENTTIME));
        file_put_contents(NV_ROOTDIR . '/' . NV_FILES_DIR . '/' . $filename, $_POST['config_code']);
        $return['config']['filename'] = $filename;

        return $return;
    }

    function nv_block_code($block_config)
    {
        global $global_config, $my_footer;

        if (file_exists(NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/tdfoss/global.code.tpl')) {
            $block_theme = $global_config['module_theme'];
        } elseif (file_exists(NV_ROOTDIR . '/themes/' . $global_config['site_theme'] . '/modules/tdfoss/code.social.tpl')) {
            $block_theme = $global_config['site_theme'];
        } else {
            $block_theme = 'default';
        }

        $xtpl = new XTemplate('global.code.tpl', NV_ROOTDIR . '/themes/' . $block_theme . '/modules/tdfoss');

        if (!empty($block_config['filename']) && file_exists(NV_ROOTDIR . '/' . NV_FILES_DIR . '/' . $block_config['filename'])) {
            $code = file_get_contents(NV_ROOTDIR . '/' . NV_FILES_DIR . '/' . $block_config['filename']);
            $xtpl->assign('CODE', $code);
        }

        $xtpl->parse('main');
        return $xtpl->text('main');
    }
}

if (defined('NV_SYSTEM')) {
    $content = nv_block_code($block_config);
}

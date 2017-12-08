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
        if (file_exists(NV_ROOTDIR . '/' . NV_ASSETS_DIR . '/block_code.txt')) {
            $code = file_get_contents(NV_ROOTDIR . '/' . NV_ASSETS_DIR . '/block_code.txt');
        } else {
            $code = '';
        }

        $html = '<tr>';
        $html .= '	<td>Code</td>';
        $html .= '	<td><textarea name="config_code" class="form-control" style="height: 300px">' . $code . '</textarea></td>';
        $html .= '</tr>';
        return $html;
    }

    function nv_block_code_submit($module, $lang_block)
    {
        global $nv_Request;

        $code = $_POST['config_code'];
        file_put_contents(NV_ROOTDIR . '/' . NV_ASSETS_DIR . '/block_code.txt', $code);
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

        if (file_exists(NV_ROOTDIR . '/' . NV_ASSETS_DIR . '/block_code.txt')) {
            $code = file_get_contents(NV_ROOTDIR . '/' . NV_ASSETS_DIR . '/block_code.txt');
            $xtpl->assign('CODE', $code);
        }

        $xtpl->parse('main');
        return $xtpl->text('main');
    }
}

if (defined('NV_SYSTEM')) {
    $content = nv_block_code($block_config);
}

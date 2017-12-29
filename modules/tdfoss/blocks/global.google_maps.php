<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2014 VINADES ., JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Jan 17, 2011 11:34:27 AM
 */

if (!defined('NV_MAINFILE')) die('Stop!!!');

if (!nv_function_exists('nv_google_maps')) {

    function nv_google_maps_config($module, $data_block, $lang_block)
    {
        global $lang_global, $selectthemes;

        // Find language file
        if (file_exists(NV_ROOTDIR . '/themes/' . $selectthemes . '/language/' . NV_LANG_INTERFACE . '.php')) {
            include NV_ROOTDIR . '/themes/' . $selectthemes . '/language/' . NV_LANG_INTERFACE . '.php';
        }

        $html = '<tr>';
        $html .= '<td>' . $lang_global['company_name'] . '</td>';
        $html .= '<td><input type="text" class="form-control" name="config_company_name" value="' . $data_block['company_name'] . '"></td>';
        $html .= '</tr>';
        $html .= '<tr>';
        $html .= '<td>' . $lang_global['company_address'] . '</td>';
        $html .= '<td>';
        $html .= '<div class="row">';
        $html .= '<div class="col-xs-24">';
        $html .= '<input type="text" class="form-control" name="config_company_address" id="config_company_address" value="' . $data_block['company_address'] . '">';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '<div id="config_company_maparea">';
        $html .= '<div id="config_company_mapcanvas" style="margin-top:10px;" class="form-group"></div>';
        $html .= '<div class="row form-group">';
        $html .= '<div class="col-xs-6">';
        $html .= '<div class="input-group">
				  	<span class="input-group-addon">L</span>
				  	<input type="text" class="form-control" name="config_company_mapcenterlat" id="config_company_mapcenterlat" value="' . $data_block['company_mapcenterlat'] . '" readonly="readonly">
				  </div>';
        $html .= '</div>';
        $html .= '<div class="col-xs-6">';
        $html .= '<div class="input-group">
				  	<span class="input-group-addon">N</span>
				  	<input type="text" class="form-control" name="config_company_mapcenterlng" id="config_company_mapcenterlng" value="' . $data_block['company_mapcenterlng'] . '" readonly="readonly">
				  </div>';
        $html .= '</div>';
        $html .= '<div class="col-xs-6">';
        $html .= '<div class="input-group">
				  	<span class="input-group-addon">L</span>
				  	<input type="text" class="form-control" name="config_company_maplat" id="config_company_maplat" value="' . $data_block['company_maplat'] . '" readonly="readonly">
				  </div>';
        $html .= '</div>';
        $html .= '<div class="col-xs-6">';
        $html .= '<div class="input-group">
				  	<span class="input-group-addon">N</span>
				  	<input type="text" class="form-control" name="config_company_maplng" id="config_company_maplng" value="' . $data_block['company_maplng'] . '" readonly="readonly">
				  </div>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '<div class="row">';
        $html .= '<div class="col-xs-12">';
        $html .= '<div class="input-group">
				  	<span class="input-group-addon">Z</span>
				  	<input type="text" class="form-control" name="config_company_mapzoom" id="config_company_mapzoom" value="' . $data_block['company_mapzoom'] . '" readonly="readonly">
				  </div>';
        $html .= '</div>';
        $html .= '<div class="col-xs-12">';
        $html .= '<button class="btn btn-default" onclick="modalShow(\'' . $lang_block['cominfo_map_guide_title'] . '\',\'' . $lang_block['cominfo_map_guide_content'] . '\');return!1;">' . $lang_block['cominfo_map_guide_title'] . '</button>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</td>';
        $html .= '</tr>';
        $html .= '<tr class="hide">';
        $html .= '<td colspan="2"><script type="text/javascript">$.getScript("' . NV_BASE_SITEURL . 'themes/' . $selectthemes . '/js/block.global.google_maps.js");</script></td>';
        $html .= '</tr>';

        return $html;
    }

    function nv_google_maps_submit()
    {
        global $nv_Request;

        $return = array();
        $return['error'] = array();
        $return['config']['appid'] = $nv_Request->get_title('config_appid', 'post');
        $return['config']['company_name'] = $nv_Request->get_title('config_company_name', 'post');
        $return['config']['company_address'] = $nv_Request->get_title('config_company_address', 'post');
        $return['config']['company_mapcenterlat'] = $nv_Request->get_float('config_company_mapcenterlat', 'post', 20.984516000000013);
        $return['config']['company_mapcenterlng'] = $nv_Request->get_float('config_company_mapcenterlng', 'post', 105.79547500000001);
        $return['config']['company_maplat'] = $nv_Request->get_float('config_company_maplat', 'post', 20.984516000000013);
        $return['config']['company_maplng'] = $nv_Request->get_float('config_company_maplng', 'post', 105.79547500000001);
        $return['config']['company_mapzoom'] = $nv_Request->get_int('config_company_mapzoom', 'post', 17);

        return $return;
    }

    /**
     * nv_menu_theme_default_footer()
     *
     * @param mixed $block_config
     * @return
     */
    function nv_google_maps($block_config)
    {
        global $global_config, $lang_global;

        $block_config['appid'] = $global_config['googleMapsAPI'];

        if (empty($block_config['appid'])) {
            return '';
        }

        if (file_exists(NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/tdfoss/global.google_maps.tpl')) {
            $block_theme = $global_config['module_theme'];
        } elseif (file_exists(NV_ROOTDIR . '/themes/' . $global_config['site_theme'] . '/modules/tdfoss/global.google_maps.tpl')) {
            $block_theme = $global_config['site_theme'];
        } else {
            $block_theme = 'default';
        }

        $xtpl = new XTemplate('global.google_maps.tpl', NV_ROOTDIR . '/themes/' . $block_theme . '/modules/tdfoss');
        $xtpl->assign('LANG', $lang_global);
        $xtpl->assign('DATA', $block_config);

        $xtpl->parse('main');
        return $xtpl->text('main');
    }
}

if (defined('NV_SYSTEM')) {
    $content = nv_google_maps($block_config);
}

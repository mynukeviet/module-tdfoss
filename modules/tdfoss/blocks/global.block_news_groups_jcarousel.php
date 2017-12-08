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

if (!nv_function_exists('nv_resize_crop_images')) {

    function nv_resize_crop_images($img_path, $width, $height, $module_name = '', $id = 0)
    {
        $new_img_path = str_replace(NV_ROOTDIR, '', $img_path);
        if (file_exists($img_path)) {
            $imginfo = nv_is_image($img_path);
            $basename = basename($img_path);
            $basename = preg_replace('/^\W+|\W+$/', '', $basename);
            $basename = preg_replace('/[ ]+/', '_', $basename);
            $basename = strtolower(preg_replace('/\W-/', '', $basename));
            if ($imginfo['width'] > $width or $imginfo['height'] > $height) {
                $basename = preg_replace('/(.*)(\.[a-zA-Z]+)$/', $module_name . '_' . $id . '_\1_' . $width . '-' . $height . '\2', $basename);
                if (file_exists(NV_ROOTDIR . '/' . NV_TEMP_DIR . '/' . $basename)) {
                    $new_img_path = NV_BASE_SITEURL . NV_TEMP_DIR . '/' . $basename;
                } else {
                    $img_path = new NukeViet\Files\Image($img_path, NV_MAX_WIDTH, NV_MAX_HEIGHT);

                    $thumb_width = $width;
                    $thumb_height = $height;
                    $maxwh = max($thumb_width, $thumb_height);
                    if ($img_path->fileinfo['width'] > $img_path->fileinfo['height']) {
                        $width = 0;
                        $height = $maxwh;
                    } else {
                        $width = $maxwh;
                        $height = 0;
                    }

                    $img_path->resizeXY($width, $height);
                    $img_path->cropFromCenter($thumb_width, $thumb_height);
                    $img_path->save(NV_ROOTDIR . '/' . NV_TEMP_DIR, $basename);
                    if (file_exists(NV_ROOTDIR . '/' . NV_TEMP_DIR . '/' . $basename)) {
                        $new_img_path = NV_BASE_SITEURL . NV_TEMP_DIR . '/' . $basename;
                    }
                }
            }
        }
        return $new_img_path;
    }
}

if (!nv_function_exists('nv_block_news_groups_jcarousel')) {

    function nv_block_config_news_groups_jcarousel($module, $data_block, $lang_block)
    {
        global $db_config, $nv_Cache, $site_mods;

        $html = $block = '';

        $html .= "<tr>";
        $html .= "	<td>" . $lang_block['module'] . "</td>";
        $html .= "	<td><select name=\"config_module_name\" id=\"config_module_name\" class=\"w200 form-control\">\n";
        $sql = "SELECT title, module_data, custom_title FROM " . $db_config['prefix'] . "_" . NV_LANG_DATA . "_modules WHERE module_file = 'news'";
        $list = $nv_Cache->db($sql, 'title', $module);
        foreach ($list as $l) {
            $sel = ($data_block['module_name'] == $l['title']) ? ' selected' : '';
            $html .= "<option value=\"" . $l['title'] . "\" " . $sel . ">" . $l['custom_title'] . "</option>\n";
            $block .= nv_news_groups_get_blocklist($l['title']);
        }

        $html .= "	</select>";
        $html .= "	<div style='display: none'>" . $block . "</div>";
        $html .= "	</td>\n";
        $html .= "</tr>";

        $html .= '<script type="text/javascript">';
        $html .= '	$("#div-blockid").html( $("#select_" + $(\'#config_module_name\').val() ).html() ).find("select").attr("name", "config_blockid");';
        $html .= '	$("#config_module_name").change(function() {';
        $html .= '		$("#div-blockid").html("<img src=\'' . NV_BASE_SITEURL . NV_ASSETS_DIR . '/images/load_bar.gif\' />").html( $("#select_" + $(this).val() ).html() ).find("select").attr("name", "config_blockid");';
        $html .= '	});';
        $html .= '</script>';

        $html .= '<tr>';
        $html .= '<td>' . $lang_block['blockid'] . '</td>';
        $html .= '<td id="div-blockid"></td>';
        $html .= '</tr>';
        $html .= '<tr>';
        $html .= '<td>' . $lang_block['title_length'] . '</td>';
        $html .= '<td><input type="text" class="form-control w200" name="config_title_length" size="5" value="' . $data_block['title_length'] . '"/></td>';
        $html .= '</tr>';
        $html .= '<tr>';
        $html .= '<td>' . $lang_block['numrow'] . '</td>';
        $html .= '<td><input type="text" class="form-control w200" name="config_numrow" size="5" value="' . $data_block['numrow'] . '"/></td>';
        $html .= '</tr>';
        return $html;
    }

    function nv_news_groups_get_blocklist($module)
    {
        global $site_mods, $data_block, $nv_Cache, $lang_block;

        $html = '';
        $html .= '<div id="select_' . $module . '">';
        $html .= '<select class="form-control w200">';
        $html .= '<option value="0">---' . $lang_block['blockid_c'] . '---</option>';
        $sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $site_mods[$module]['module_data'] . '_block_cat ORDER BY weight ASC';
        $list = $nv_Cache->db($sql, '', $module);
        foreach ($list as $l) {
            $html .= '<option value="' . $l['bid'] . '" ' . (($data_block['blockid'] == $l['bid']) ? ' selected="selected"' : '') . '>' . $l['title'] . '</option>';
        }
        $html .= '</select>';
        $html .= '</div>';

        return $html;
    }

    function nv_block_config_news_groups_jcarousel_submit($module, $lang_block)
    {
        global $nv_Request;
        $return = array();
        $return['error'] = array();
        $return['config'] = array();
        $return['config']['blockid'] = $nv_Request->get_int('config_blockid', 'post', 0);
        $return['config']['numrow'] = $nv_Request->get_int('config_numrow', 'post', 0);
        $return['config']['title_length'] = $nv_Request->get_int('config_title_length', 'post', 0);
        $return['config']['module_name'] = $nv_Request->get_title('config_module_name', 'post', 'news');
        return $return;
    }

    function nv_block_news_groups_jcarousel($block_config)
    {
        global $module_array_cat, $module_info, $site_mods, $module_config, $global_config, $nv_Cache, $db;

        $module = $block_config['module_name'];

        if (empty($module) or empty($block_config['blockid'])) return '';

        $show_no_image = $module_config[$module]['show_no_image'];
        $blockwidth = $module_config[$module]['blockwidth'];

        $db->sqlreset()
            ->select('t1.id, t1.catid, t1.title, t1.alias, t1.homeimgfile, t1.homeimgthumb,t1.hometext,t1.publtime')
            ->from(NV_PREFIXLANG . '_' . $site_mods[$module]['module_data'] . '_rows t1')
            ->join('INNER JOIN ' . NV_PREFIXLANG . '_' . $site_mods[$module]['module_data'] . '_block t2 ON t1.id = t2.id')
            ->where('t2.bid= ' . $block_config['blockid'] . ' AND t1.status= 1')
            ->order('t2.weight ASC')
            ->limit($block_config['numrow']);
        $list = $nv_Cache->db($db->sql(), '', $module);

        if (!empty($list)) {
            if (file_exists(NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/tdfoss/block_groups_jcarousel.tpl')) {
                $block_theme = $global_config['module_theme'];
            } else {
                $block_theme = 'default';
            }
            $xtpl = new XTemplate('block_groups_jcarousel.tpl', NV_ROOTDIR . '/themes/' . $block_theme . '/modules/tdfoss');
            $xtpl->assign('TEMPLATE', $block_theme);
            $xtpl->assign('CONFIG', $block_config);

            foreach ($list as $l) {
                $l['link'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module . '&amp;' . NV_OP_VARIABLE . '=' . $module_array_cat[$l['catid']]['alias'] . '/' . $l['alias'] . '-' . $l['id'] . $global_config['rewrite_exturl'];
                if (!empty($l['homeimgfile']) and file_exists(NV_ROOTDIR . '/' . NV_UPLOADS_DIR . '/' . $site_mods[$module]['module_upload'] . '/' . $l['homeimgfile'])) {
                    $l['homeimgfile'] = nv_resize_crop_images(NV_ROOTDIR . '/' . NV_UPLOADS_DIR . '/' . $site_mods[$module]['module_upload'] . '/' . $l['homeimgfile'], 360, 219, $module, $l['id']);
                } elseif (!empty($show_no_image)) {
                    $l['homeimgfile'] = NV_BASE_SITEURL . $show_no_image;
                } else {
                    $l['homeimgfile'] = '';
                }

                $l['blockwidth'] = $blockwidth;
                $l['title_clean'] = nv_clean60($l['title'], $block_config['title_length']);
                $l['hometext'] = nv_clean60($l['hometext'], 160);

                $xtpl->assign('ROW', $l);
                $xtpl->parse('main.loop');
                $xtpl->parse('main.htmlcaption');
            }

            $xtpl->parse('main');
            return $xtpl->text('main');
        }
    }
}
if (defined('NV_SYSTEM')) {
    global $site_mods, $module_name, $global_array_cat, $module_array_cat, $nv_Cache, $db;
    $module = $block_config['module_name'];
    if (isset($site_mods[$module])) {
        if ($module == $module_name) {
            $module_array_cat = $global_array_cat;
            unset($module_array_cat[0]);
        } else {
            $module_array_cat = array();
            $sql = 'SELECT catid, parentid, title, alias, viewcat, subcatid, numlinks, description, keywords, groups_view FROM ' . NV_PREFIXLANG . '_' . $site_mods[$module]['module_data'] . '_cat ORDER BY sort ASC';
            $list = $nv_Cache->db($sql, 'catid', $module);
            foreach ($list as $l) {
                $module_array_cat[$l['catid']] = $l;
                $module_array_cat[$l['catid']]['link'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module . '&amp;' . NV_OP_VARIABLE . '=' . $l['alias'];
            }
        }
        $content = nv_block_news_groups_jcarousel($block_config);
    }
}
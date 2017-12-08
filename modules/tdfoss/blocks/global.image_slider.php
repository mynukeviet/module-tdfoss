<?php

/**
 * @Project NUKEVIET 4.x
 * @Author mynukeviet (contact@mynukeviet.net)
 * @Copyright (C) 2016 mynukeviet. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Thu, 27 Oct 2016 16:33:32 GMT
 */
if (!defined('NV_MAINFILE')) {
    die('Stop!!!');
}

if (!nv_function_exists('nv_block_image_slider')) {

    /**
     * nv_block_image_slider_config()
     *
     * @param mixed $module
     * @param mixed $data_block
     * @param mixed $lang_block
     * @return
     *
     */
    function nv_block_image_slider_config($module, $data_block, $lang_block)
    {
        global $global_config, $site_mods;

        if (file_exists(NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $site_mods[$module]['module_file'] . '/global.image_slider.tpl')) {
            $block_theme = $global_config['module_theme'];
        } elseif (file_exists(NV_ROOTDIR . '/themes/' . $global_config['site_theme'] . '/modules/' . $site_mods[$module]['module_file'] . '/global.image_slider.tpl')) {
            $block_theme = $global_config['site_theme'];
        } else {
            $block_theme = 'default';
        }

        $xtpl = new XTemplate('global.image_slider.tpl', NV_ROOTDIR . '/themes/' . $block_theme . '/modules/' . $site_mods[$module]['module_file']);
        $xtpl->assign('LANG', $lang_block);

        if (empty($data_block['image'])) {
            $data_block['image'][] = array(
                'index' => 0,
                'path' => '',
                'description' => '',
                'currentpath' => ''
            );
        }

        foreach ($data_block['image'] as $index => $image) {
            $image['index'] = $index;

            if (file_exists(NV_ROOTDIR . '/' . NV_UPLOADS_DIR . '/' . $image['path'])) {
                $image['path'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $image['path'];
            } else {
                continue;
            }

            $image['currentpath'] = str_replace(basename($image['path']), '', $image['path']);

            $xtpl->assign('IMAGE', $image);
            $xtpl->parse('config.image');
        }
        $xtpl->assign('INDEX', count($data_block['image']));

        $xtpl->parse('config');
        return $xtpl->text('config');
    }

    /**
     * nv_block_image_slider_config_submit()
     *
     * @param mixed $module
     * @param mixed $lang_block
     * @return
     *
     */
    function nv_block_image_slider_config_submit($module, $lang_block)
    {
        global $nv_Request;
        $return = array();
        $return['error'] = array();
        $image = $nv_Request->get_array('config_image', 'post');
        foreach ($image as $index => $value) {
            if (empty($value['path'])) {
                unset($image[$index]);
            } else {
                $lu = strlen(NV_BASE_SITEURL . NV_UPLOADS_DIR . '/');
                $image[$index]['path'] = substr($image[$index]['path'], $lu);
            }
        }
        $return['config']['image'] = $image;
        return $return;
    }

    /**
     * nv_block_image_slider()
     *
     * @param mixed $block_config
     * @return
     *
     */
    function nv_block_image_slider($block_config)
    {
        global $page_title, $global_config, $client_info, $lang_global, $site_mods;

        if (empty($block_config['image'])) {
            return '';
        }

        $module = $block_config['module'];
        $mod_file = $site_mods[$module]['module_file'];

        if (file_exists(NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $mod_file . '/global.image_slider.tpl')) {
            $block_theme = $global_config['module_theme'];
        } elseif (file_exists(NV_ROOTDIR . '/themes/' . $global_config['site_theme'] . '/modules/' . $mod_file . '/global.image_slider.tpl')) {
            $block_theme = $global_config['site_theme'];
        } else {
            $block_theme = 'default';
        }

        $xtpl = new XTemplate('global.image_slider.tpl', NV_ROOTDIR . '/themes/' . $block_theme . '/modules/' . $mod_file);
        $xtpl->assign('LANG', $lang_global);
        $xtpl->assign('TEMPLATE', $block_theme);

        foreach ($block_config['image'] as $index => $image) {
            $image['index'] = $index;

            $image['thumb'] = '';
            if (file_exists(NV_ROOTDIR . '/' . NV_ASSETS_DIR . '/' . $image['path'])) {
                $image['thumb'] = NV_BASE_SITEURL . NV_ASSETS_DIR . '/' . $image['path'];
            }

            if (file_exists(NV_ROOTDIR . '/' . NV_UPLOADS_DIR . '/' . $image['path'])) {
                $image['path'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $image['path'];
            }

            $xtpl->assign('IMAGE', $image);

            if (nv_is_url($image['link'])) {
                $xtpl->parse('main.image.link');
            } else {
                $xtpl->parse('main.image.nolink');
            }

            $xtpl->parse('main.image');

            if (!empty($image['description'])) {
                $xtpl->parse('main.description');
            }
        }

        $xtpl->parse('main');
        return $xtpl->text('main');
    }
}

if (defined('NV_SYSTEM')) {
    $content = nv_block_image_slider($block_config);
}

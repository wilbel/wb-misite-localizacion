<?php

/**
 * Plugin Name: WB Misite Localization
 * Plugin URI: https://www.wibcode.com/
 * Description: Este plugin permite ver de que parte los usuarios vistan el sitio web
 * Version: 1.0.0
 * Author: Wibcode
 * Author https://www.wibcode.com/
 * License: GPL2
 * Text Domain: wb-misite-localization
 * Domain Path: /languages
 */

defined('ABSPATH') or die('');

register_activation_hook(__FILE__, 'wbloc_init_active');

function wbloc_init_active()
{
    WRLOC_BaseDatosController::wrbda_crear_tablas();
}


if (is_admin()) {

    require_once plugin_dir_path(__FILE__) . 'administration/controllers/wblc_load_pages.php';
    require_once plugin_dir_path(__FILE__) . 'administration/wbloc_hook.php';
    require_once plugin_dir_path(__FILE__) . 'administration/models/wbloc_database.php';
}
require_once plugin_dir_path(__FILE__) . 'administration/models/wbloc_querys.php';
require_once plugin_dir_path(__FILE__) . 'shortcode/wbloc-hook.php';


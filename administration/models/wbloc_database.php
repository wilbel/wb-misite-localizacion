<?php

defined('ABSPATH') or die('');

class WRLOC_BaseDatosController
{
    function __construct()
    {

    }

    static function wrbda_crear_tablas()
    {
        global $wpdb;
        $charset_collate = $wpdb->get_charset_collate();
        $table_register_site = $wpdb->prefix . 'wrbloc_register_site';
        $sql_registersite = "CREATE TABLE IF NOT EXISTS $table_register_site(
            `id` bigint(20) NOT NULL AUTO_INCREMENT,
            `site_url` text NOT NULL,
            `direccion_ip` varchar(18) NOT NULL,
            `ubicacion` text NOT NULL,
            `time` varchar(30) NOT NULL,
            `fecha_registro` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`)
          ) $charset_collate;";
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql_registersite);
    }
}

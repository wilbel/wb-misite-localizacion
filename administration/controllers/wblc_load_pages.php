<?php
defined('ABSPATH') or die('');
class WBLOC_AdminLoadPageController
{

    function wbloc_load_page($page)
    {

        wp_enqueue_style(
            'wbloc_bootstrap_css',
            plugin_dir_url(__FILE__) . '../../static/plugins/bootstrap/css/bootstrap.min.css',
            array(),
            "1.0.0"
        );
        wp_enqueue_script(
            "alertify",
            plugin_dir_url(__FILE__) . '../../static/plugins/alertifyjs/alertify.min.js',
            array("jquery"),
            "1.13.1",
            true
        );

        wp_enqueue_style(
            'alertify',
            plugin_dir_url(__FILE__) . '../../static/plugins/alertifyjs/css/alertify.min.css',
            array(),
            "1.13.1"
        );
        if ($page == "inicio.phtml") {


            wp_enqueue_style(
                'wbloc_inicio_css',
                plugin_dir_url(__FILE__) . '../../static/css/style.css',
                array(),
                "1.0.0"
            );

            wp_enqueue_script(
                'wbloc_ajax',
                plugins_url('../../static/js/script.js', __FILE__),
                array('jquery')
            );
            wp_localize_script('wbloc_ajax', 'SolicitudesAjax', ['url' => admin_url('admin-ajax.php'), 'seguridad' => wp_create_nonce('seg')]);
        } else if ($page == "info.phtml") {
            
        } else if ($page == "table.phtml") {
            define('CANT_ITEMS_BY_PAGE', 10);
            $querys = new WBLOC_QuerysController();
            $pagina = 1;
            if (isset($_POST["pagina"])) {
                $pagina = $_POST["pagina"];
            }
            $where = "";
            if (isset($_POST["dato"])) {
                $dato = $_POST["dato"];
                $where = 'WHERE CONCAT(id , site_url, direccion_ip,fecha_registro) LIKE "%' . $dato . '%" ';
            }

            $limit = CANT_ITEMS_BY_PAGE;
            $offset = ($pagina - 1) * CANT_ITEMS_BY_PAGE;
            $conteo = $querys->wbloc_count_bd('wrbloc_register_site', $where);
            $paginas = ceil($conteo / CANT_ITEMS_BY_PAGE);
            $lista_datos = $querys->wbloc_seleccionar_bd("wrbloc_register_site", " $where  ORDER BY fecha_registro DESC LIMIT " . $limit . ' OFFSET ' . $offset);
        }


        require_once plugin_dir_path(__FILE__) . '../views/' . $page;
    }
}

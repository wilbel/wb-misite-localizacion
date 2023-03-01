<?php
add_action('admin_menu', 'wbloc_admin_menu');
function wbloc_admin_menu()
{
    add_menu_page(
        __('WB localization'),
        __('WB localization'),
        'manage_options',
        'wbloc-admin',
        'wbloc_subemnu_mostrarContenido',
        plugin_dir_url(__FILE__) . '../static/img/logo_icono.png',
        7
    );
}

function wbloc_subemnu_mostrarContenido()
{
    $load_page = new WBLOC_AdminLoadPageController();
    $load_page->wbloc_load_page("inicio.phtml");
}


/**cargar table */
add_action('wp_ajax_wbloc_page_table', 'wbloc_page_table');
function wbloc_page_table()
{
    $nonce = $_POST['nonce'];
    if (!wp_verify_nonce($nonce, 'seg')) {
        die('no tiene permisos para ejecutar ese ajax');
    }
    $load_page = new  WBLOC_AdminLoadPageController();
    $load_page->wbloc_load_page("table.phtml");
    wp_die();
}

/**Opciones en grupo */
add_action('wp_ajax_wbloc_opcion_group_item', 'wbloc_opcion_group_item');

function wbloc_opcion_group_item()
{
    $nonce = $_POST['nonce'];
    if (!wp_verify_nonce($nonce, 'seg')) {
        die('no tiene permisos para ejecutar ese ajax');
    }
    $mensaje = '';
    $querys = new WBLOC_QuerysController();
    $opcion_group = $_POST['opcion_seleccion'];
    $codigo_slogan = explode(",", $_POST['codigo_slogan']);
    $i = 0;
    try {
        while ($i < count($codigo_slogan)) {
            if ($opcion_group == 'Eliminare') {
                $querys->wbloc_eliminar_bd('wrbloc_register_site', array('id' =>   $codigo_slogan[$i]));
            }
            if ($opcion_group == 'accion') {
                wp_send_json(array('message' => "Seleziona le slogan per favore"));
            }
            $i++;
        }
        $mensaje = array('message' => 'Datos eliminados correctamente!!!');
    } catch (Exception $err) {
        $mensaje = array('message' => "Fallo la operación");
    }
    wp_send_json($mensaje);
}


/**Eliminar datos de imagen */
add_action('wp_ajax_wbloc_delete_page', 'wbloc_delete_page');
function wbloc_delete_page() //elimina solo de la base de datos no de wordpress
{
    $mensaje = '';
    $nonce = $_POST['nonce'];
    if (!wp_verify_nonce($nonce, 'seg')) {
        die('no tiene permisos para ejecutar ese ajax');
    }
    $querys = new WBLOC_QuerysController();
    $codigo = $_POST['codigo'];
    if ($querys->wbloc_eliminar_bd('wrbloc_register_site', array('id' => $codigo))) {
        $mensaje = array('message' => 'Dato eliminado correctamente');
    } else {
        $mensaje = array('message' => 'Fallo la operación');
    }
    wp_send_json($mensaje);
}
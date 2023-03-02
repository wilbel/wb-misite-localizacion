<?php

add_action('wp_footer', 'wbloc_script_ajax');

function wbloc_script_ajax()
{
    wp_enqueue_script(
        'wbloc_ajax_utilitarios',
        plugins_url('../static/js/utilitarios.js', __FILE__),
        array('jquery')
    );
    wp_localize_script('wbloc_ajax_utilitarios', 'SolicitudesAjax', ['url' => admin_url('admin-ajax.php'), 'seguridad' => wp_create_nonce('seg')]);
}


function wbloc_getRealIP()
{
    if (isset($_SERVER["HTTP_CLIENT_IP"])) {
        return $_SERVER["HTTP_CLIENT_IP"];
    } elseif (isset($_SERVER["HTTP_X_FORWARDED_FOR"])) {
        return $_SERVER["HTTP_X_FORWARDED_FOR"];
    } elseif (isset($_SERVER["HTTP_X_FORWARDED"])) {
        return $_SERVER["HTTP_X_FORWARDED"];
    } elseif (isset($_SERVER["HTTP_FORWARDED_FOR"])) {
        return $_SERVER["HTTP_FORWARDED_FOR"];
    } elseif (isset($_SERVER["HTTP_FORWARDED"])) {
        return $_SERVER["HTTP_FORWARDED"];
    } else {
        return $_SERVER["REMOTE_ADDR"];
    }
}

add_action('wp_ajax_nopriv_wbloc_obtener_hora_local', 'wbloc_obtener_datos_site');
add_action('wp_ajax_wbloc_obtener_hora_local', 'wbloc_obtener_datos_site');

function wbloc_obtener_datos_site()
{
    $nonce = $_POST['nonce'];
    if (!wp_verify_nonce($nonce, 'seg')) {
        die('denegado');
    }
    $tiempo = $_POST['hora'];
    global $wp;
    $url_actual = home_url(add_query_arg(array(), $wp->request));
    $querys = new WBLOC_QuerysController();
    $dataArray = json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . wbloc_getRealIP()));
    $ubicacion = $dataArray->geoplugin_continentName . ' - ' . $dataArray->geoplugin_countryName . ' - ' . $dataArray->geoplugin_region . ' - ' . $dataArray->geoplugin_city;
    if ($url_actual != null) {
        if (is_user_logged_in() == false) {
            try {
                $datos = ['site_url' => $url_actual, 'direccion_ip' => wbloc_getRealIP(), 'ubicacion' => $ubicacion, 'time' => $tiempo];
                $querys->wbloc_agregar_db("wrbloc_register_site", $datos);
            } catch (Exception $err) {
            }
        }
    }
    wp_die();
}

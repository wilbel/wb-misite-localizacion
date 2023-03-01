<?php


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


function wbloc_obtener_datos_site()
{
    global $wp;
    $url_actual = home_url(add_query_arg(array(), $wp->request));
    $querys = new WBLOC_QuerysController();
    $time = time();
    $tiempo = date("d-m-Y (H:i:s)", $time);

    $dataArray = json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=177.234.229.41".wbloc_getRealIP()));   
   $ubicacion = $dataArray->geoplugin_continentName.' - '.$dataArray->geoplugin_countryName.' - '.$dataArray->geoplugin_region.' - '.$dataArray->geoplugin_city;

    if ($url_actual != null) {
        if (is_user_logged_in() == false) {
            try {
                $datos = ['site_url' => $url_actual, 'direccion_ip' => wbloc_getRealIP(),'ubicacion'=>$ubicacion,'time' => $tiempo];
                $querys->wbloc_agregar_db("wrbloc_register_site", $datos);
            } catch (Exception $err) {
            }
        }
    }
}

add_action('wp_footer', 'wbloc_obtener_datos_site');



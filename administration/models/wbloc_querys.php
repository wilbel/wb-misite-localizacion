<?php

defined('ABSPATH') or die('');
class WBLOC_QuerysController
{
    private $wpdb_local;
    function __construct()
    {
        global $wpdb;
        $this->wpdb_local = $wpdb;
    }

    function wbloc_agregar_db($tabla, $datos)
    {
        $tabla = $this->wpdb_local->prefix . $tabla;
        return $this->wpdb_local->insert($tabla, $datos);
    }

    function wbloc_seleccionar_bd($tabla, $where)
    {
        $tabla = $this->wpdb_local->prefix . $tabla;
        $sql = "SELECT * FROM $tabla $where";
        return  $this->wpdb_local->get_results($sql);
    }
    function wbloc_count_bd($tabla, $where)
    {
        $tabla = $this->wpdb_local->prefix . $tabla;
        $sql = "SELECT count(*) as contador FROM $tabla $where";
        $resultado = $this->wpdb_local->get_results($sql);
        return $resultado != null ? $resultado[0]->contador : 0;
    }

    function wbloc_eliminar_bd($tabla, $where)
    {
        $tabla = $this->wpdb_local->prefix . $tabla;
        return $this->wpdb_local->delete($tabla, $where);
    }
}

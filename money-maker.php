<?php
/**
*Plugin Name: _Money Maker
*Plugin URI: http://www.danielboggiano.com/money-maker
*Author: Daniel Boggiano
*Author URI: http://www.danielboggiano.com
*Version: 1.0
*License: GPLv2
*Description: Este es un sistema de gestión creado para administrar cuentas financieras personales.
*/
global $wpdb;
$mm_db_version = '1.0';

$site = ABSPATH;
define('RUTA', "$site/wp-content/plugins/money-maker/");

/*** LLAMADO A TODOS LOS ARCHIVOS DE CONFIGURACIÓN  ***/

require RUTA."BasesDeDatos/basededatos.php";
require RUTA."Controlador/remove-menu.php"; //Quita todas las opciones del menú que vienen por defecto en wordpress
require RUTA."Controlador/add-menu.php";
require RUTA."Controlador/funciones.php";
/*
require RUTA."Controlador/logindetails.php";
*/

register_activation_hook( __FILE__, 'mm_db_install' );

/********************************
 * Registrar un ShortCode.
 */
function mm_nuevo_registro(){
    include RUTA."paginas/registros.php";
}

if(!function_exists("mm_shortcode")){
    function mm_shortcode(){
        //Poner este shortcode en un post o página de acceso público, este te permitirá agregar registros sin necesidad de iniciar sesión.
        //[nuevo_registro_formulario][/nuevo_registro_formulario]
        add_shortcode('nuevo_registro_formulario','mm_nuevo_registro');
    }
}
add_action('init','mm_shortcode');

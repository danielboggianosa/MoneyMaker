<?php

function lista_empresas($valor){
    global $wpdb;
    $folder = "/wordpress";
    require_once($_SERVER['DOCUMENT_ROOT'] . $folder . '/wp-config.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . $folder . '/wp-load.php');
    $campo = " WHERE mm_empresa_nombre LIKE '%$valor%'";
    $sql="SELECT mm_empresa_id as id, mm_empresa_nombre as nombre, mm_empresa_notas as notas, mm_empresa_foto as foto FROM mm_empresa".$campo." LIMIT 10";
    //echo $sql;
    $resultado = $wpdb->get_results($sql , OBJECT);
    echo json_encode($resultado);
}
function lista_cuentas($valor){
    global $wpdb;
    $folder = "/wordpress";
    require_once($_SERVER['DOCUMENT_ROOT'] . $folder . '/wp-config.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . $folder . '/wp-load.php');
    $campo = " WHERE mm_cuenta_nombre LIKE '%$valor%' OR mm_empresa_nombre LIKE '%$valor%'";
    $sql="SELECT mm_cuenta_id as id, mm_cuenta_nombre as nombre, mm_cuenta_notas as notas, mm_cuenta_banco as banco, mm_cuenta_moneda as moneda, mm_cuenta_numero as numero, mm_cuenta_cci as cci, mm_cuenta_foto as foto, mm_empresa_nombre as empresa FROM mm_cuenta INNER JOIN mm_empresa ON mm_empresa_id = mm_cuenta_empresa_id".$campo." LIMIT 10";
    //echo $sql;
    $resultado = $wpdb->get_results($sql , OBJECT);
    echo json_encode($resultado);
}
function lista_registros($valor){
    global $wpdb;
    $folder = "/wordpress";
    require_once($_SERVER['DOCUMENT_ROOT'] . $folder . '/wp-config.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . $folder . '/wp-load.php');
    $campo = " WHERE mm_registro_descripcion LIKE '%$valor%' OR mm_registro_entidad LIKE '%$valor%' OR mm_registro_operacion LIKE '%$valor%' OR mm_registro_operacion LIKE '%$valor%'";
    $sql="SELECT mm_registro_id as id, mm_registro_fecha as fecha, mm_registro_categoria as categoria, mm_registro_entidad as entidad, mm_registro_operacion as operacion, mm_registro_monto as monto, mm_registro_foto as foto, mm_cuenta_nombre as cuenta, mm_empresa_nombre as empresa FROM mm_registro INNER JOIN mm_cuenta ON mm_registro_cuenta_id = mm_cuenta_id INNER JOIN mm_empresa ON mm_cuenta_empresa_id = mm_empresa_id".$campo." ORDER BY mm_registro_fecha DESC LIMIT 50";
    //echo $sql;
    $resultado = $wpdb->get_results($sql , OBJECT);
    echo json_encode($resultado);
}

$boton= $_POST['boton'];
	if($boton==='empresa'){
		$valor=$_POST['valor'];
        lista_empresas($valor);
	}

	if($boton==='cuenta'){
		$valor=$_POST['valor'];
        lista_cuentas($valor);
	}

	if($boton==='registro'){
		$valor=$_POST['valor'];
        lista_cuentas($valor);
	}

?>
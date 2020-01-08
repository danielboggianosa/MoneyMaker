<?php

/*****************************************
        |==> EMPRESA <==|
******************************************/

function MostrarListaEmpresas($limit = 0, $filtro = null){

global $wpdb;
global $tabla1;
global $tabla6;
global $current_url;
global $page1;
global $sql_cliente;
if($orden != null){
    $orden = "ORDER BY $tabla1"."_".$orden;
}
if($campo != null){
    $campo = " WHERE $campo = $filtro";
    $campo2 = "mm_cuenta_nombre";
}
if(isset($_POST["buscar"])){
    $buscar = $_POST["buscar"];
    $campo = " WHERE mm_empresa_nombre LIKE '%$buscar%' ";
    $campo2 = "mm_cuenta_nombre";
    $filtro = "'%$buscar%'";
}
$sql="SELECT mm_empresa_id as empresaid, mm_empresa_usuario_id as userid, mm_empresa_nombre as nombre, mm_empresa_notas as notas, mm_empresa_foto as foto, user_nicename as usuario FROM mm_empresa INNER JOIN wp_users ON mm_empresa_usuario_id = ID ".$campo." GROUP BY mm_empresa_id LIMIT $limit,".MAX_LIST.$orden;
//echo $sql;
?>
<form method="post">
    <input type="search" name="buscar" id="buscar" class="form-control buttons" placeholder="Buscar por nombre de la empresa" oninput="lista_empresas(this.value)">
</form><br>
<div id="lista"></div>
<div id="tabla_empresas">
<?php
$resultado = $wpdb->get_results($sql , OBJECT);
    if($resultado[0] != null){    ?>
<table class="widefat">
    <thead>
        <tr>
            <th class="row-title"><!--input type="checkbox" name="selectall" id="selectall"-->ID</th>
            <th>NOMBRE</th>
            <th>NOTAS</th>
        </tr>
    </thead>
    <tbody>
        <?php
        //$prev_id = 0;
        for($i=0;$i<sizeof($resultado);$i++){
            $registro=$resultado[$i];
            ?>       
                <tr <?php //if($i % 2 == 0){echo "class='alternate'";} ?>>
                    <td>
                        <?php echo $registro->empresaid ?>
                    </td>
                    <td><a href="<?php  echo $page1 ?>&empresa=<?php echo $registro->empresaid ?>"><?php echo $registro->nombre ?></a></td>
                    <td><?php echo $registro->notas ?></td>
                </tr>
            <?php
        }
        ?>
    </tbody>
</table>
<?php }
    else{
        echo "<h3 class='text-center'>NO SE ENCONTRARON COINCIDENCIAS INTENTA NUEVAMENTE</h1>";
    }
?></div>
<?php
}

function MostrarEmpresa($empresa){
    
    global $wpdb;
    global $tabla1;
    global $tabla2;
    global $page1;
    global $page2;
    global $dummy_empresa;
        
    $sql = "SELECT mm_empresa_id as id, mm_empresa_nombre as nombre, mm_empresa_notas as notas, mm_empresa_foto as foto FROM mm_empresa WHERE $tabla1"."_id = $empresa";
    //echo $sql;
    $resultado = $wpdb->get_results( $sql , OBJECT);
    $registro = $resultado[0];
    ?>
    <div class="accesos-directos">
        <a href="#" class="btn btn-warning">
            <span class="dashicons dashicons-edit"></span>Editar Datos
        </a>
    </div>
    <table class="table table-responsive">
        <tr>
            <td>
                <img src="<?php 
        if($registro->foto == null){
            echo get_site_url().$dummy_empresa; 
        }else{        
            echo $registro->foto; 
        }
                ?>" style="max-height:100px"><br>
            </td>
            <td class="text-uppercase text-center bg-primary"><h2><?php echo $registro->nombre; ?></h2></td>
        </tr>
        <tr>
            <td><b>NOTAS:</b></td>
            <td><?php echo $registro->notas; ?></td>
        </tr>
    </table>
    <div class="accesos-directos">
        <a href="admin.php?page=mm-cuentas&cuenta=nuevo&empresa=<?php echo $empresa ?>" class="btn btn-info">
            <i class="fas fa-tasks"></i> Agregar Cuenta
        </a>
        <a href="admin.php?page=mm-registros&registro=transferencia&cuenta=<?php echo $cuenta?>&empresa=<?php echo $_GET["empresa"] ?>&moneda=<?php echo $registro->mm_cuenta_moneda ?>" class="btn btn-warning">
            <i class="fas fa-tasks"></i> Transferir o Retirar Dinero
        </a>
    </div>
    <table class="table table-responsive">
        <tr>
            <th>CUENTA</th>
            <th>BANCO</th>
            <th>MONEDA</th>
            <th>NÚMERO</th>
            <th class="no-movil">CCI</th>
        </tr>
<?php
    $sql="SELECT mm_cuenta_id as id, mm_cuenta_nombre as cuenta, mm_cuenta_banco as banco, mm_cuenta_moneda as moneda, mm_cuenta_numero as numero, mm_cuenta_cci as cci, mm_cuenta_notas as notas, mm_cuenta_foto as foto FROM mm_cuenta WHERE mm_cuenta_empresa_id = $empresa";
    $resultado = $wpdb->get_results($sql,OBJECT);
    for($i=0;$i<sizeof($resultado);$i++){
        $registro=$resultado[$i];
        ?>
        <tr>
            <td><a href="admin.php?page=mm-cuentas&cuenta=<?php echo $registro->id ?>&empresa=<?php echo $empresa ?>"><?php echo $registro->cuenta ?></a></td>
            <td><?php echo $registro->banco ?></td>
            <td><?php echo $registro->moneda ?></td>
            <td><?php echo $registro->numero ?></td>
            <td class="no-movil"><?php echo $registro->cci ?></td>
        </tr>
        <?php
    }
?>
    </table>
<?php    
}

function AgregarNuevaEmpresa($datos = null){
    if($datos != null){
        global $wpdb;
        global $tabla1;
        $wpdb->insert( $tabla1 , $datos );
        $empresa = $wpdb->insert_id;
        AgregarFoto($tabla1, $empresa);
        MostrarEmpresa($empresa);
    }
    else{
?>
<form method="post" enctype="multipart/form-data">    
    <?php include RUTA."paginas/formularios/empresa-nueva.php" ?>
    <input type="hidden" name="guardar" value="yes">
    <button type="submit" class="btn btn-success form-control"> Guardar Información</button>
</form>
<?php }
}

function ActualizarEmpresa($empresa, $datos){
    global $wpdb;
    global $tabla1;
    $wpdb->update(
        $tabla1,
        $datos,
        array($tabla1.'_'.'id' => $empresa)
    );
}

function SeleccionarEmpresa($id = null, $read = 0){
    ?>
<div class="form-group">
    <label for="empresa">Empresa:</label>
    
<?php
        global $wpdb;
        if($id != null){
                $sql="SELECT mm_empresa_id as id, mm_empresa_nombre as nombre FROM mm_empresa WHERE mm_empresa_id = $id";
                $results = $wpdb->get_results( $sql , OBJECT );
                $register = $results[0];
            if($read == 0){
                ?>
                <input type="hidden" name="empresa" value="<?php echo $register->id ?>">
                <input type="text" value="<?php echo $register->nombre ?>" class="form-control" disabled>
                <?php                
            }
            else{
                ?><select name='empresa' id='empersa' class='form-control' required>
                <option value="<?php echo $register->id ?>"><?php echo $register->nombre ?></option><?php
                $sql="SELECT mm_empresa_id as id, mm_empresa_nombre as nombre FROM mm_empresa WHERE mm_empresa_id != '$id' ";
                $results = $wpdb->get_results( $sql , OBJECT );
                    for($i=0;$i<sizeof($results);$i++){
                        $register = $results[$i];
                ?>
                <option value="<?php echo $register->id; ?>"><?php echo $register->nombre ?></option>
                <?php }   
                ?></select><?php
            }
        }
        else{            
            ?><select name='empresa' id='empersa' class='form-control' required>
            <option>Elegir una Empresa</option><?php
        $sql="SELECT mm_empresa_id as id, mm_empresa_nombre as nombre FROM mm_empresa";
        $results = $wpdb->get_results( $sql , OBJECT );
            for($i=0;$i<sizeof($results);$i++){
                $register = $results[$i];
        ?>
        <option value="<?php echo $register->id; ?>"><?php echo $register->nombre ?></option>
<?php        }
        echo "</select>";
         }
?>
</div>
<?php
}

/*****************************************
        |==> CUENTA <==|
******************************************/

function MostrarListaCuentas($limit = 0, $filtro = null){
    global $wpdb;
    $sql = "SELECT SUM(mm_registro_monto) as subtotal, mm_cuenta_nombre as cuenta, mm_registro_moneda as moneda, mm_cuenta_id as id FROM mm_registro INNER JOIN mm_cuenta ON mm_registro_cuenta_id = mm_cuenta_id GROUP BY mm_registro_cuenta_id";
    //echo $sql;
    $resultado = $wpdb->get_results($sql, OBJECT);
    ?><form method="post">
        <label for="tc">1 dolar corresponde a:
            <input type="number" step="0.001" name="tc" id="tc"> soles.
            <input type="submit">
    </label>
    </form>
    <table class="table table-hover">
    <tr>
        <th>CUENTA</th>
        <th>SOLES</th>
        <th>DÓLARES</th>
    </tr><?php
    $tc = $_POST["tc"];
    $total_soles = 0;
    $total_dolares = 0;
    foreach($resultado as $registro){
        $moneda = $registro->moneda;
        $monto = $registro->subtotal;
        if(isset($tc)){
            if($moneda == "PEN"){
                ?><tr>
                <td><a href="admin.php?page=mm-cuentas&cuenta=<?php echo $registro->id ?>"><?php echo $registro->cuenta ?></a></td>
                <td><?php echo $monto ?></td>
                <td><?php echo number_format($monto / $tc, 2) ?></td>
            </tr><?php
                $total_soles += $monto;
                $total_dolares += $monto / $tc;  
            }
            elseif($moneda == "USD"){
                ?><tr>
                <td><a href="admin.php?page=mm-cuentas&cuenta=<?php echo $registro->id ?>"><?php echo $registro->cuenta ?></a></td>
                <td><?php echo number_format($monto * $tc, 2) ?></td>
                <td><?php echo $monto ?></td>
            </tr><?php
                $total_soles += $monto * $tc;
                $total_dolares += $monto; 
            }   
        }
        else{
            if($moneda == "PEN"){
                ?><tr>
                <td><a href="admin.php?page=mm-cuentas&cuenta=<?php echo $registro->id ?>"><?php echo $registro->cuenta ?></a></td>
                <td><?php echo $monto ?></td>
                <td><?php echo "--" ?></td>
            </tr><?php
                $total_soles += $monto;
            }
            elseif($moneda == "USD"){
                ?><tr>
                <td><a href="admin.php?page=mm-cuentas&cuenta=<?php echo $registro->id ?>"><?php echo $registro->cuenta ?></a></td>
                <td><?php echo "--" ?></td>
                <td><?php echo $monto ?></td>
            </tr><?php
                $total_dolares += $monto; 
            }   
        }
    }
    ?>
        <tr>
            <th>TOTAL</th>
            <th><?php echo number_format($total_soles,2) ?></th>
            <th><?php echo number_format($total_dolares,2) ?></th>
            <th></th>
        </tr>
    </table><?php
}

function MostrarCuenta($cuenta){
    global $wpdb;
    global $tabla2;
    global $tabla3;
    global $page1;
    global $page2;
    global $dummy_empresa;
    
    $sql="SELECT SUM(mm_registro_monto) as balance FROM `mm_registro` WHERE mm_registro_cuenta_id = $cuenta";
    $resultado = $wpdb->get_results( $sql , OBJECT);
    $suma = $resultado[0]->balance;
        
    $sql = "SELECT * FROM mm_cuenta WHERE $tabla2"."_id = $cuenta";
    //echo $sql;
    $resultado = $wpdb->get_results( $sql , OBJECT);
    $registro = $resultado[0];
    ?>
    <div class="accesos-directos">
        <a href="#" class="btn btn-warning">
            <span class="dashicons dashicons-edit"></span>Editar Datos
        </a>
    </div>
    <table class="table table-responsive">
        <tr>
            <td>
                <img src="<?php 
        if($registro->mm_cuenta_foto == null){
            echo get_site_url().$dummy_empresa; 
        }else{        
            echo $registro->mm_cuenta_foto; 
        }
                ?>" style="max-height:100px;max-width:100px;"><br>
            </td>
            <td class="text-uppercase text-center bg-primary"><h2><?php echo $registro->mm_cuenta_nombre; ?></h2></td>
        </tr>
        <tr>
            <td><b>BANCO:</b></td>
            <td><?php echo $registro->mm_cuenta_banco; ?></td>
        </tr>
        <tr>
            <td><b>MONEDA:</b></td>
            <td><?php echo $registro->mm_cuenta_moneda; ?></td>
        </tr>
        <tr>
            <td><b>NÚMERO DE DE CUENTA:</b></td>
            <td><?php echo $registro->mm_cuenta_numero; ?></td>
        </tr>
        <tr>
            <td><b>CÓDIGO INTERBANCARIO:</b></td>
            <td><?php echo $registro->mm_cuenta_cci; ?></td>
        </tr>
        <tr>
            <td><b>NOTAS:</b></td>
            <td><?php echo $registro->mm_cuenta_notas; ?></td>
        </tr>
        <tr>
            <td><b>BALANCE:</b></td>
            <td><h2><?php echo $suma; ?></h2></td>
        </tr>
    </table>
    <div class="accesos-directos">
        <a href="admin.php?page=mm-registros&registro=nuevo&cuenta=<?php echo $cuenta?>&empresa=<?php echo $registro->mm_cuenta_empresa_id ?>&moneda=<?php echo $registro->mm_cuenta_moneda ?>" class="btn btn-info">
            <i class="fas fa-tasks"></i> Agregar Registro
        </a>
    </div><br>
    <?php MostrarListaRegistros($cuenta);
                    
}

function AgregarNuevaCuenta($datos = null){
    if($datos != null){
        global $wpdb;
        global $tabla2;
        $wpdb->insert( $tabla2 , $datos );
        $id = $wpdb->insert_id;
        AgregarFoto($tabla2, $id);
        MostrarCuenta($id);
    }
    else{
?>
<form method="post" enctype="multipart/form-data">    
    <?php include RUTA."paginas/formularios/cuenta-nueva.php" ?>
    <input type="hidden" name="guardar" value="yes">
    <button type="submit" class="btn btn-success form-control"> Guardar Información</button>
</form>
<?php
    }
}

function ActualizarCuenta($cuenta, $datos){
    global $wpdb;
    global $tabla2;
    $wpdb->update(
        $tabla2,
        $datos,
        array($tabla2.'_'.'id' => $cuenta)
    );
}

function SeleccionarCuenta($id = null, $read = 0){
     ?>
<div class="form-group">
    <label for="cuenta">cuenta:</label>
    
<?php
        global $wpdb;
        if($id != null){
            $sql="SELECT mm_cuenta_id as id, mm_cuenta_nombre as nombre FROM mm_cuenta WHERE mm_cuenta_id = $id";
            $results = $wpdb->get_results( $sql , OBJECT );
            $register = $results[0];
            if($read == 0){
                ?>
                <input type="hidden" name="cuenta" value="<?php echo $register->id ?>">
                <input type="text" value="<?php echo $register->nombre ?>" class="form-control" disabled>
                <?php                
            }
            else{
                ?><select name='cuenta' id='cuenta' class='form-control' required>
                <option value="<?php echo $id ?>"><?php echo $register->nombre ?></option>
                <?php
                $sql="SELECT mm_cuenta_id as id, mm_cuenta_nombre as nombre FROM mm_cuenta WHERE mm_cuenta_id != '$id'";
                $results = $wpdb->get_results( $sql , OBJECT );
                for($i=0;$i<sizeof($results);$i++){
                $register = $results[$i];
                ?><option value="<?php echo $register->id; ?>"><?php echo $register->nombre ?></option>
<?php        }
        echo "</select>";
            }
        }
        else{            
            echo "<select name='cuenta' id='cuenta' class='form-control' required>";
            echo "<option>Elegir una Cuenta</option>";
        $sql="SELECT mm_cuenta_id as id, mm_cuenta_nombre as nombre FROM mm_cuenta";
        $results = $wpdb->get_results( $sql , OBJECT );
            for($i=0;$i<sizeof($results);$i++){
                $register = $results[$i];
        ?>
        <option value="<?php echo $register->id; ?>"><?php echo $register->nombre ?></option>
<?php        }
        echo "</select>";
         }
?>
</div>
<?php
}

/*****************************************
        |==> REGISTRO <==|
******************************************/

function MostrarListaRegistros($cuenta = null){
    global $wpdb;
    ?>
    <table class="table table-hover">
        <tr>
            <th>ID</th>
            <th>FECHA</th>
            <th class="no-movil">CATEGORIA</th>
            <th class="no-movil">SUBCATEGORIA</th>
            <th class="no-movil">ENTIDAD</th>
            <th>DESCRIPCIÓN</th>
            <th>MONTO</th>
        </tr>
<?php
    $sql="SELECT * FROM mm_registro INNER JOIN mm_categoria ON mm_registro_categoria_id = mm_categoria_id INNER JOIN mm_subcategoria ON mm_registro_subcategoria_id = mm_subcategoria_id WHERE mm_registro_cuenta_id = $cuenta ORDER BY mm_registro_fecha DESC, mm_registro_id DESC LIMIT 100";
    //echo $sql;
    $resultado = $wpdb->get_results($sql,OBJECT);
    for($i=0;$i<sizeof($resultado);$i++){
        $registro=$resultado[$i];
        ?>
        <tr onclick="window.location='admin.php?page=mm-registros&registro=<?php echo $registro->mm_registro_id ?>'" class="tr-link">
            <td>
            <!--a href="admin.php?page=mm-registros&registro=<?php echo $registro->mm_registro_id ?>"-->
                <?php echo $registro->mm_registro_id ?>
            <!--/a-->
            </td>
            <td><?php echo FormatoFecha($registro->mm_registro_fecha,"corta") ?></td>
            <td  class="no-movil text-uppercase"><?php echo $registro->mm_categoria_nombre ?></td>
            <td  class="no-movil text-uppercase"><?php echo $registro->mm_subcategoria_nombre ?></td>
            <td  class="no-movil text-uppercase"><?php echo $registro->mm_registro_entidad ?></td>
            <td><?php echo $registro->mm_registro_descripcion ?></td>
            <td><?php echo $registro->mm_registro_monto ?>
            </td>
        </tr>
        <?php
    }
?>
    </table>
    <style>
        .tr-link{
            cursor: pointer;
        }
    </style>
<?php        
}

function MostrarReporteRegistros($moneda = null, $fecha_inicio = null, $fecha_fin = null){
    global $wpdb;
    global $tabla4;
    $balance_pen = 0;
    $balance_usd = 0;
    $filtro_fecha = "";
    
    $nuevo = $_SERVER['REQUEST_URI']."&registro=nuevo";
    $nuevo2 = $_SERVER['REQUEST_URI']."?registro=nuevo";
    $ver = $_SERVER['REQUEST_URI']."&reporte=ver";
    
    $inicio = date("Y-m-d");
    $fin = date("Y-m-d");
    $hoy = $_SERVER['REQUEST_URI']."&finicio=".$inicio."&ffin=".$fin;
        
    $inicio = date("Y-m-d", strtotime('-1 day'));
    $fin = date("Y-m-d", strtotime('-1 day'));
    $ayer = $_SERVER['REQUEST_URI']."&finicio=".$inicio."&ffin=".$fin;
    
    $inicio = date("Y-m-d", strtotime('-1 week'));
    $fin = date("Y-m-d");
    $esta_semana = $_SERVER['REQUEST_URI']."&finicio=".$inicio."&ffin=".$fin;
    
    $inicio = date("Y-m-d", strtotime('-2 week'));
    $fin = date("Y-m-d", strtotime('-1 week'));
    $semana_pasada = $_SERVER['REQUEST_URI']."&finicio=".$inicio."&ffin=".$fin;
    
    $inicio = date("Y-m-01");
    $fin = date("Y-m-d");
    $este_mes = $_SERVER['REQUEST_URI']."&finicio=".$inicio."&ffin=".$fin;
    
    $inicio = date("Y-m-01", strtotime('-1 month'));
    $fin = date("Y-m-31", strtotime('-1 month'));
    $mes_pasado = $_SERVER['REQUEST_URI']."&finicio=".$inicio."&ffin=".$fin;
    
    
    if(isset($_GET["finicio"]) and isset($_GET["ffin"])){
        $finicio = $_GET["finicio"];
        $ffin = $_GET["ffin"];
        $filtro_fecha = "AND mm_registro_fecha >= '$finicio' AND mm_registro_fecha <= '$ffin'";
    }
    if($moneda == null){
        $moneda = "PEN";
    }
    ?><div class="accesos-directos text-center">
    <?php 
        if(get_current_user_id() != null){
            ?>
        <a href="<?php echo $nuevo ?>" class="btn btn-success">
            <span class="dashicons dashicons-plus-alt"></span> Nuevo Registro
        </a>
        <a href="<?php echo $ver ?>" class="btn btn-danger">
            <span class="dashicons dashicons-plus-alt"></span> Ver Reporte
        </a><br>
    <?php }
    else{
        ?>
        <a href="<?php echo $nuevo2 ?>" class="btn btn-success">
            <span class="dashicons dashicons-plus-alt"></span> Nuevo Registro
        </a>
        <a href="<?php echo get_site_url()."/wp-login.php" ?>" class="btn btn-info">
            <span class="dashicons dashicons-plus-alt"></span> Iniciar Sesión
        </a>
    <?php
    }?>
    </div>
    <?php
    if(isset($_GET["reporte"])){
        ?>
    <div class="accesos-directos">
        <a href="<?php echo $mes_pasado ?>" class="btn btn-warning">
            <span class="dashicons dashicons-calendar-alt"></span> El mes pasado
        </a>
        <a href="<?php echo $este_mes ?>" class="btn btn-warning">
            <span class="dashicons dashicons-calendar-alt"></span> Este mes
        </a>
        <a href="<?php echo $semana_pasada ?>" class="btn btn-warning">
            <span class="dashicons dashicons-calendar"></span> La Semana pasada
        </a>
        <a href="<?php echo $esta_semana ?>" class="btn btn-warning">
            <span class="dashicons dashicons-calendar"></span> Esta semana
        </a>
        <a href="<?php echo $ayer ?>" class="btn btn-warning">
            <span class="dashicons dashicons-align-center"></span> Ayer
        </a>
        <a href="<?php echo $hoy ?>" class="btn btn-warning">
            <span class="dashicons dashicons-align-center"></span> Hoy
        </a>
        <br>
        <a href="<?php echo $_SERVER['REQUEST_URI']."&moneda=USD" ?>" class="btn btn-success">
            <span class="dashicons">$</span> DÓLARES
        </a>
        <a href="<?php echo $_SERVER['REQUEST_URI']."&moneda=PEN" ?>" class="btn btn-success">
            <span class="dashicons">S/</span> SOLES
        </a>
        <a href="<?php echo $_SERVER['REQUEST_URI']."&moneda=EUR" ?>" class="btn btn-success">
            <span class="dashicons">€</span> EUROS
        </a>
    </div><br>
    <table class="table table-hover">
    <tr>
        <th>CATEGORIA</th>
        <th>SOLES</th>
        <th>DÓLARES</th>
        <th></th>
    </tr><?php
    
    //$sql = "SELECT *, SUM(mm_registro_monto) as total FROM mm_registro INNER JOIN mm_categoria ON mm_registro_categoria_id = mm_categoria_id WHERE mm_registro_moneda = '$moneda' $filtro_fecha GROUP BY mm_categoria_nombre ORDER BY total DESC";
    $sql = "SELECT *, SUM(mm_registro_monto) as total FROM mm_registro INNER JOIN mm_categoria ON mm_registro_categoria_id = mm_categoria_id WHERE mm_registro_categoria_id != 1 $filtro_fecha GROUP BY mm_categoria_nombre ORDER BY total DESC";
    echo $sql;
    $resultado = $wpdb->get_results($sql,OBJECT);
    for($i=0;$i<sizeof($resultado);$i++){
        $registro = $resultado[$i];
        ?><tr>
    <td class="text-uppercase"><?php echo $registro->mm_categoria_nombre; ?></td>
    <td>
        <?php
        if($registro->mm_registro_moneda == "PEN"){            
            echo $registro->total;
            $balance_pen += $registro->total;
        }
        ?>
    </td>
    <td>
        <?php
        if($registro->mm_registro_moneda == "USD"){            
            echo $registro->total;
            $balance_usd += $registro->total;
        }
        ?>
    </td>
    <td><input type="checkbox" name="ver" id="<?php echo $i; ?>" onclick="VerDetalles(this.id)" class="hidden"><label for="<?php echo $i; ?>" id="ver_<?php echo $i; ?>"><span class="dashicons dashicons-visibility"></span></label><label for="<?php echo $i; ?>" id="ocultar_<?php echo $i; ?>" class="hidden"><span class="dashicons dashicons-hidden"></span></label></td>
    </tr>
    <tr id="detalle_<?php echo $i; ?>" class="hidden">
        <td colspan="13" id="<?php echo $i; ?>">
            <table class="table table-striped">
        <?php 
            //$sql2 = "SELECT * FROM mm_registro INNER JOIN mm_subcategoria ON mm_registro_subcategoria_id = mm_subcategoria_id INNER JOIN mm_cuenta ON mm_registro_cuenta_id = mm_cuenta_id WHERE mm_registro_categoria_id = $registro->mm_categoria_id AND mm_registro_moneda = '$moneda' $filtro_fecha ORDER BY mm_registro_fecha DESC";
            $sql2 = "SELECT *, SUM(mm_registro_monto) as total FROM mm_registro INNER JOIN mm_subcategoria ON mm_registro_subcategoria_id = mm_subcategoria_id WHERE mm_registro_categoria_id = $registro->mm_categoria_id AND mm_registro_moneda = '$moneda' $filtro_fecha GROUP BY mm_subcategoria_id ORDER BY total DESC";
            //echo $sql2;
            $resultado2 = $wpdb->get_results($sql2,OBJECT);
            for($j=0;$j<sizeof($resultado2);$j++){
                $registro2 = $resultado2[$j];
                ?><tr class="bg-warning">
                <!--td><?php echo $registro2->mm_cuenta_nombre ?></td>
                <td><?php echo $registro2->mm_registro_id ?></td-->
                <td><?php echo $registro2->mm_subcategoria_nombre ?></td>
                <!--td><?php echo $registro2->mm_registro_descripcion ?></td>
                <td><?php echo $registro2->mm_registro_entidad ?></td-->
                <td><?php 
                $moneda = $registro2->mm_registro_moneda;
                $subtotal = $registro2->total;
                //$subtotal = $registro2->total;
                echo $subtotal;
                $total += $subtotal;
                ?></td>
                <!--td><input type="checkbox" name="subver" id="<?php echo $j; ?>" onclick="SubVerDetalles(this.id)" class="hidden"><label for="<?php echo $j; ?>" id="subver_<?php echo $j; ?>"><span class="dashicons dashicons-visibility"></span></label><label for="<?php echo $j; ?>" id="subocultar_<?php echo $j; ?>" class="hidden"><span class="dashicons dashicons-hidden"></span></label></td>
                </tr>
                <tr id="subdetalle_<?php echo $j; ?>" class="hidden">
                    <td>
                        <h1>HOla</h1>
                    </td-->
                </tr>
                <?php
            }
        ?>
                <tr class="<?php echo DarColor($total) ?>"><!--td></td><td></td--><td>TOTAL DE <?php echo $registro->mm_categoria_nombre; ?></td><!--td></td--><td><?php echo number_format($total,2); $total = 0; ?></td></tr>
            </table>
        </td>
        
    </tr><?php } ?>
    <tr class="<?php echo DarColor($balance) ?>"><td>BALANCE TOTAL</td><td><?php echo number_format($balance,2) ?></td><td></td></tr>
    </table><?php
    }
}

function MostrarRegistro($id = null){
    if($id != "nuevo"){
        global $wpdb;
        $sql="SELECT * FROM mm_registro INNER JOIN mm_cuenta ON mm_cuenta_id = mm_registro_cuenta_id INNER JOIN mm_categoria ON mm_registro_categoria_id = mm_categoria_id INNER JOIN mm_subcategoria ON mm_registro_subcategoria_id = mm_subcategoria_id WHERE mm_registro_id = $id";
        $resultado = $wpdb->get_results($sql,OBJECT);
        $registro = $resultado[0];
        ?>
    <div id="tabs">
        <ul>    
            <li><a href="#tabs-1">Registro</a></li>
            <li><a href="#tabs-2">Editar Registro</a></li>
            <li><a href="#tabs-3">Nuevo Registro</a></li>
        </ul>
        <div id="tabs-1">
        <table class="table table-bordered">
            <tr><td>CUENTA</td><td><a href="admin.php?page=mm-cuentas&cuenta=<?php echo $registro->mm_cuenta_id ?>"><?php echo $registro->mm_cuenta_nombre ?></a></td></tr>
            <tr><td>MONEDA</td><td><?php echo $registro->mm_registro_moneda ?></td></tr>
            <tr><td>FECHA</td><td><?php echo FormatoFecha($registro->mm_registro_fecha, "larga") ?></td></tr>
            <tr><td>CATEGORIA</td><td><?php echo $registro->mm_categoria_nombre ?></td></tr>
            <tr><td>SUBCATEGORIA</td><td><?php echo $registro->mm_subcategoria_nombre ?></td></tr>
            <tr><td>MONTO</td><td><?php echo $registro->mm_registro_monto ?></td></tr>
            <tr><td>ENTIDAD</td><td><?php echo $registro->mm_registro_entidad ?></td></tr>
            <tr><td>OPERACIÓN</td><td><?php echo $registro->mm_registro_operacion ?></td></tr>
            <tr><td>DESCRIPCIÓN</td><td><?php echo $registro->mm_registro_descripcion ?></td></tr>
            <tr><td>FOTO</td><td><img src="<?php echo $registro->mm_registro_foto ?>" width="150"></td></tr>
        </table>
        </div>
        <div id="tabs-2">
            <?php EditarRegistro($id); ?>
        </div>
        <div id="tabs-3">
            <?php MostrarRegistro("nuevo"); ?>
        </div>
    </div>
    <?php
    }
    else{
?>
<form method="post" enctype="multipart/form-data">    
    <?php include RUTA."paginas/formularios/registro-nuevo.php" ?>
    <input type="hidden" name="guardar" value="yes">
    <button type="submit" class="btn btn-success form-control"> Guardar Información</button>
</form>
<?php
    }
}

function AgregarNuevoRegistro($datos = null, $moneda = null){
    if($datos != null){
            global $wpdb;
            global $tabla3;
            //print_r($datos);
            $wpdb->insert( $tabla3 , $datos );
            $id = $wpdb->insert_id;
            AgregarFoto($tabla3, $id);
            $wpdb->update($tabla3, array("mm_registro_moneda" => $moneda), array("mm_registro_id" => $id));
            //MostrarRegistro($id);
    }
    else{
?>
<form method="post" enctype="multipart/form-data">    
    <?php include RUTA."paginas/formularios/registro-nuevo.php" ?>
    <input type="hidden" name="guardar" value="yes">
    <button type="submit" class="btn btn-success form-control"> Guardar Información</button>
</form>
<?php
    }
}

function AgregarTransferencia($datos = null){
    ?>
    <form method="post" enctype="multipart/form-data">    
        <?php include RUTA."paginas/formularios/transferencia-nueva.php" ?>
        <input type="hidden" name="guardar" value="yes">
        <button type="submit" class="btn btn-success form-control"> Guardar Información</button>
    </form><?php
}

function ActualizarRegistro($registro, $datos){
    global $wpdb;
    global $tabla3;
    $wpdb->update(
        $tabla3,
        $datos,
        array($tabla3.'_'.'id' => $registro)
    );
}

function EditarRegistro($registro = null){
    ?>
    <form method="post" enctype="multipart/form-data">
        <?php include RUTA."paginas/formularios/registro-editar.php" ?>
        <input type="hidden" name="actualizar" value="yes">
        <button type="submit" class="btn btn-success form-control"> Actualizar Información</button>
    </form>
    <?php
}

function SeleccionarMoneda($moneda = null, $read = 0){
    if($moneda != null){
        if($read == 0){
        ?>
            <label for="moneda">Moneda:</label>
            <input type="text" name="moneda" id="moneda" value="<?php echo $moneda?>" class="form-control" disabled>
        <?php            
        }
        else{
            ?>
            <label for="moneda">Moneda:</label>
            <input type="text" name="moneda" id="moneda" value="<?php echo $moneda?>" class="form-control" required>
        <?php 
        }
    }else{
        include RUTA."paginas/formularios/moneda-seleccionar.php";
    }
}

function EliminarRegistro($id){
    global $wpdb;
    $tabla = "mm_registro";
    $wpdb->delete($tabla, $id);
};


/*****************************************
        |==> CATEGORIAS <==|
******************************************/

function AgregarCategoria($datos = null){
    global $wpdb;
    global $tabla4;
    if($datos == "nuevo"){
        $wpdb->insert($tabla4, 
                      array(
                          $tabla4."_"."nombre" => $_POST["categoria_otra"]
                      )
                     );        
        return $wpdb->insert_id;
    }
    else{
        return $datos;
    }
}

function SeleccionarCategoria($id = null, $read = 0){
    global $wpdb;
    ?>
<div class="form-group">
    <label for="categoria">Categoria:</label>
<?php
    if($id != null){
        $sql = "SELECT * FROM mm_categoria WHERE mm_categoria_id = $id ORDER BY mm_categoria_nombre ASC";
        $results = $wpdb->get_results( $sql , OBJECT );
        $entrada = $results[0];
        $nombre = $entrada->mm_categoria_nombre;
        if($read = 0){
            ?><input type="hidden" name="categoria" id="categoria" value="<?php echo $id ?>">
            ?><input type="hidden" value="<?php echo $nombre ?>" class="form-control">
    
        <?php
        }
        else{
            ?><select name="categoria" id="categoria" class="form-control text-uppercase" onchange="Categoria(this.value)">
                <option value="<?php echo $id ?>"><?php echo $nombre ?></option><?php
            $sql = "SELECT * FROM mm_categoria WHERE mm_categoria_id != '$id' ORDER BY mm_categoria_nombre ASC";
            $resultado = $wpdb->get_results($sql, OBJECT);
            foreach($resultado as $p){
                echo "<option value='".$p->mm_categoria_id."'>".$p->mm_categoria_nombre."</option>";
            }
            ?><option value="nuevo">Nueva categoria...</option>
            </select><?php
        }
    }
    else{
        ?><select name="categoria" id="categoria" class="form-control text-uppercase" onchange="Categoria(this.value)">
        <option>Seleccionar una Categoría</option>
        <?php
        $sql = "SELECT * FROM mm_categoria ORDER BY mm_categoria_nombre ASC";
        $resultado = $wpdb->get_results($sql, OBJECT);
        foreach($resultado as $p){
            echo "<option value='".$p->mm_categoria_id."'>".$p->mm_categoria_nombre."</option>";
        }
        ?><option value="nuevo">Nueva categoria...</option>
        </select><?php
    }
    ?>
    <div id="categoria_otra" class="hidden">
        <input type="text" name="categoria_otra" class="form-control" placeholder="Escribe el nombre de la categoria">
    </div>
</div>
<?php
}

function AgregarSubcategoria($datos = null, $id = null){
    global $wpdb;
    global $tabla5;
    if($datos == "nuevo"){
        $wpdb->insert($tabla5, 
                      array(
                          $tabla5."_"."categoria_id" => $id,
                          $tabla5."_"."nombre" => $_POST["subcategoria_otra"]
                      )
                     );        
        return $wpdb->insert_id;
    }
    else{
        return $datos;
    }
}

function SeleccionarSubcategoria($id = null, $read = 0){
    global $wpdb;
    ?>
<div class="form-group">
    <label for="subcategoria">Subcategoria:</label>
<?php
    if($id != null){
        $sql = "SELECT * FROM mm_subcategoria WHERE mm_subcategoria_id = $id ORDER BY mm_subcategoria_nombre ASC";
        $results = $wpdb->get_results( $sql , OBJECT );
        $entrada = $results[0];
        $nombre = $entrada->mm_subcategoria_nombre;
        if($read = 0){
            ?><input type="hidden" name="subcategoria" id="subcategoria" value="<?php echo $id ?>">
            ?><input type="hidden" value="<?php echo $nombre ?>" class="form-control">
    
        <?php
        }
        else{
            ?><select name="subcategoria" id="subcategoria" class="form-control text-uppercase" onchange="Subcategoria(this.value)">
                <option value="<?php echo $id ?>"><?php echo $nombre ?></option><?php
            $sql = "SELECT * FROM mm_subcategoria WHERE mm_subcategoria_id != '$id' ORDER BY mm_subcategoria_nombre ASC";
            $resultado = $wpdb->get_results($sql, OBJECT);
            foreach($resultado as $p){
                echo "<option value='".$p->mm_subcategoria_id."'>".$p->mm_subcategoria_nombre."</option>";
            }
            ?><option value="nuevo">Nueva subcategoria...</option>
            </select><?php
        }
    }
    else{
        ?><select name="subcategoria" id="subcategoria" class="form-control text-uppercase" onchange="Subcategoria(this.value)">
        <?php
        $sql = "SELECT * FROM mm_subcategoria ORDER BY mm_subcategoria_nombre ASC";
        $resultado = $wpdb->get_results($sql, OBJECT);
        foreach($resultado as $p){
            echo "<option value='".$p->mm_subcategoria_id."'>".$p->mm_subcategoria_nombre."</option>";
        }
        ?><option value="nuevo">Nueva subcategoria...</option>
        </select><?php
    }
    ?>
    <div id="subcategoria_otra" class="hidden">
        <input type="text" name="subcategoria_otra" class="form-control" placeholder="Escribe el nombre de la subcategoria">
    </div>
</div>
<?php
}


/*****************************************
        |==> ADICIONALES <==|
******************************************/

function FormatoFecha($fecha,$modo){
    //echo $fecha."<br>";
    $meses = array("", "enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "setiembre", "octubre", "noviembre", "diciembre");
    $ano = substr($fecha,0,4);
    $mes = substr($fecha,5,2);
    $dia = substr($fecha,8,2);
    $hor = substr($fecha,11,2);
    $min = substr($fecha,14,2);
    $sec = substr($fecha,17,2);
    
    switch ($modo){
        case "corta":
            $nuevaFecha = $dia."/".$mes."/".$ano;
            break;
        case "corta hh:mm":
            $nuevaFecha = $dia."/".$mes."/".$ano." $hor:$min";
            break;
        case "corta hh:mm:ss":
            $nuevaFecha = $dia."/".$mes."/".$ano." $hor:$min:$sec";
            break;
        case "larga":
            $mes = $mes * 1;
            $nuevaFecha = $dia." de ".$meses[$mes]." del ".$ano;
            break;
        case "año":
            $nuevaFecha = $ano;
            break;
    }
    return $nuevaFecha;
}

function NumerosEnLetras($Valor){
    //VALOR MAXIMO SOPORTADO: 1 999 999 999.99
    
    if($Valor!=0){
        $Valor = round($Valor,2,PHP_ROUND_HALF_UP);
        $Cantidad = $Valor;    
        $ValorEntero = floor($Valor);
        $Centavos = round(($Valor - $ValorEntero) * 100);

        $Unidades = array("", "UN", "DOS", "TRES", "CUATRO", "CINCO", "SEIS", "SIETE", "OCHO", "NUEVE", "DIEZ", "ONCE", "DOCE", "TRECE", "CATORCE", "QUINCE", "DIECISEIS", "DIECISIETE", "DIECIOCHO", "DIECINUEVE", "VEINTE", "VEINTIUN", "VEINTIDOS", "VEINTITRES", "VEINTICUATRO", "VEINTICINCO", "VEINTISEIS", "VEINTISIETE", "VEINTIOCHO", "VEINTINUEVE");
        $Decenas = array("", "DIEZ", "VEINTE", "TREINTA", "CUARENTA", "CINCUENTA", "SESENTA", "SETENTA", "OCHENTA", "NOVENTA");
        $Centenas = array("", "CIENTO", "DOSCIENTOS", "TRESCIENTOS", "CUATROCIENTOS", "QUINIENTOS", "SEISCIENTOS", "SETECIENTOS", "OCHOCIENTOS", "NOVECIENTOS");

        $Mayores = array("", " MIL ", " MILLÓN ", " MILLONES "," MIL ", " BILLÓN ", "BILLONES");
        $BloqueCien = array();
        
        $i = 0;
        $k = 0;

        if($Centavos == 0)
            $NumeroEnLetras = " CON "."00/100";
        elseif($Centavos >= 1 and $Centavos <= 9)
            $NumeroEnLetras = " CON 0".$Centavos."/100";
        else
            $NumeroEnLetras = " CON ".$Centavos."/100";
        
        while($ValorEntero != 0){
            $Extracto = round(($ValorEntero % 1000),1,PHP_ROUND_HALF_UP);
            $ValorEntero = intval(($ValorEntero / 1000),10);
            $BloqueCien[$i] = $Extracto;
            $i++;
        }
        for($j = 0; $j < $i; $j++){
            if($BloqueCien[$j] >= 2 and $k == 2){
                $k = 3;    
            }
            if($BloqueCien[$j] <= 29){
                $NumeroEnLetras = $Unidades[$BloqueCien[$j]]." ".$Mayores[$k]." ".$NumeroEnLetras;
            }elseif($BloqueCien[$j] > 29 and $BloqueCien[$j] <= 99){
                $decena = floor($BloqueCien[$j] / 10);
                $unidad = floor($BloqueCien[$j] % 10);
                if($unidad == 0)
                    $NumeroEnLetras = $Decenas[$decena]." ".$Mayores[$k]." ".$NumeroEnLetras;    
                else
                    $NumeroEnLetras = $Decenas[$decena]." Y ".$Unidades[$unidad]." ".$Mayores[$k]." ".$NumeroEnLetras;
            }else{
                if($BloqueCien[$j] == 100){
                    $NumeroEnLetras = "CIEN ".$Mayores[$k]." ".$NumeroEnLetras;
                }else{
                    $centena = floor($BloqueCien[$j] / 100);
                    $resto = floor($BloqueCien[$j]  % 100);
                    if($resto <= 29){
                        $NumeroEnLetras = $Centenas[$centena]." ".$Unidades[$resto]." ".$Mayores[$k]." ".$NumeroEnLetras;
                    }else{
                        $decena = floor($resto / 10);
                        $unidad = floor($resto % 10);
                        if($unidad == 0)
                            $NumeroEnLetras = $Centenas[$centena]." ".$Decenas[$decena]." ".$Mayores[$k]." ".$NumeroEnLetras;    
                        else
                            $NumeroEnLetras = $Centenas[$centena]." ".$Decenas[$decena]." Y ".$Unidades[$unidad]." ".$Mayores[$k]." ".$NumeroEnLetras;
                    }               
                }
            }   
            $k++;
            if($k == 6)
                $k=0;
        }
        
        return $NumeroEnLetras;
    };
}

function SegundosATiempo($tiempo_en_segundos) {
	$horas = floor($tiempo_en_segundos / 3600);
	$minutos = floor(($tiempo_en_segundos - ($horas * 3600)) / 60);
    ($minutos<10) ? $minutos="0".$minutos : $minutos;
	$segundos = $tiempo_en_segundos - ($horas * 3600) - ($minutos * 60);
    ($segundos<10) ? $segundos="0".$segundos : $segundos;
 
	return $horas . ':' . $minutos . ":" . $segundos;
}

function currency($from_Currency,$to_Currency,$amount) {
  $amount = urlencode($amount);
  $from_Currency = urlencode($from_Currency);
  $to_Currency = urlencode($to_Currency);
  $url = "http://www.google.com/ig/calculator?hl=en&q=$amount$from_Currency=?$to_Currency";
    echo $url;
  $ch = curl_init();
  $timeout = 0;
  curl_setopt ($ch, CURLOPT_URL, $url);
  curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch,  CURLOPT_USERAGENT , "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1)");
  curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
  $rawdata = curl_exec($ch);
  curl_close($ch);
  $data = explode('"', $rawdata);
  $data = explode('.', $data['3']);
  $data[0] = str_replace(" ", "",preg_replace('/\D/', '',  $data[0]));
  if(isset($data[1])){
    $data[1] = str_replace(" ", "",preg_replace('/\D/', '', $data[1]));
    $var = $data[0].".".$data[1];        
  } else{
    $var = $data[0];
  }
  return round($var,2); }

function DarColor($monto = null){
    ($monto) > 0 ? $color = "bg-success" : $color = "bg-danger";
    return $color;
}

/*****************************************
        |==> FOTO <==|
*****************************************/

function AgregarFoto($table, $id){
    global $wpdb;
    
    if($_FILES["fileToUpload"]["size"] != 0){
    $target_dir = RUTA."imagenes/$table/";
    $target_file = $target_dir . basename($id.".jpg");
    $uploadOk = 1;
    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
    // Check if image file is a actual image or fake image
    if(isset($_POST["submit"])) {
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if($check !== false) {
            echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }
    }
    // Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }
    // Check file size
    if ($_FILES["fileToUpload"]["size"] > 2000000) {
        echo "Lo siento, tu imágen es muy grande, el tamaño máximo es de 2 MB.";
        $uploadOk = 0;
    }
    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Lo siento, Tu archivo no se ha subido.";
    // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            //echo "La imágen ". basename($id). " se ha subido con éxito.";
        } else {
            echo "No se subió ningún archivo.";
        }
    }
    
    $wpdb->update(
        $table,
        array( $table."_foto" => plugin_dir_url(__DIR__)."/imagenes/$table/$id.jpg" ),
        array( $table."_id" => $id )
    );
    }    
}

function EliminarFoto($table, $id){
    global $wpdb;
    $wpdb->update(
        $table,
        array( $table."_foto" => "" ),
        array( $table."_id" => $id )
    );
    unlink(RUTA."imagenes/$table/$id.jpg");
    echo "Se eliminó la foto correctamente";
}

function ActualizarFoto($table, $id){
    if($_FILES["fileToUpload"]["size"] != 0){
        if (file_exists(RUTA."imagenes/$table/$id.jpg")) {
            unlink(RUTA."imagenes/$table/$id.jpg");
        }
        AgregarFoto($table, $id);
    }
}


?>

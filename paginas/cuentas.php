<?php include RUTA."paginas/head.php"; ?>

<div id="wpbody-content">
<div class="wrap impresion">

    <h2 class="bg-info">Cuentas</h2>
<?php
    if(isset($_GET["cuenta"])){
        if(isset($_GET["cuenta"])){
            $cuenta = $_GET["cuenta"];
            $eliminar = $_POST["eliminar"];
            $eliminarfoto = $_POST["eliminarfoto"];
            $agregar = $_POST["AgregarNuevo"];
            
            if(isset($_POST["actualizar"])){
                ActualizarCuenta(
                    $cuenta, 
                    array(
                        $tabla2."_"."empresa_id" => $empresa,
                        $tabla2."_"."nombre" => $_POST["nombre"],
                        $tabla2."_"."banco" => $_POST["banco"],
                        $tabla2."_"."moneda" => $_POST["moneda"],
                        $tabla2."_"."numero" => $_POST["numero"],
                        $tabla2."_"."cci" => $_POST["cci"],
                        $tabla2."_"."notas" => $_POST["notas"]
                    )
                );
                ActualizarFoto($tabla2, $cuenta);
            }
            if($eliminarfoto == "foto"){
                EliminarFoto($tabla2,$cuenta);
            }
            if($eliminar == "cuenta"){
                EliminarCuenta($cuenta);
            }
            if($cuenta == "nuevo"){
                if(isset($_POST["guardar"])){
                    AgregarNuevaCuenta(
                        array(
                            $tabla2."_"."empresa_id" => $_POST["empresa"],
                            $tabla2."_"."nombre" => $_POST["nombre"],
                            $tabla2."_"."banco" => $_POST["banco"],
                            $tabla2."_"."moneda" => $_POST["moneda"],
                            $tabla2."_"."numero" => $_POST["numero"],
                            $tabla2."_"."cci" => $_POST["cci"],
                            $tabla2."_"."notas" => $_POST["notas"]
                        )
                    );
                }
                else{AgregarNuevaCuenta();}
            }
            else{
                Mostrarcuenta($cuenta);                
            }
        }
    }
    else{
        if(isset($_GET["limit"])){
            if(isset($_GET["orden"])){
                MostrarListaCuentas($_GET["limit"], $_GET["orden"]);
            }
            else{
                MostrarListaCuentas($_GET["limit"]);            
            }
        }
        else{
            //MostrarListaCuentas();
        }    
    }
?>
    
</div>
</div>
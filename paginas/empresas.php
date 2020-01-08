<?php include RUTA."paginas/head.php"; ?>

<div id="wpbody-content">
<div class="wrap impresion">

    <h2 class="bg-info">Empresas</h2>
<?php
    if(isset($_GET["empresa"])){
        if(isset($_GET["empresa"])){
            $empresa = $_GET["empresa"];
            $eliminar = $_POST["eliminar"];
            $eliminarfoto = $_POST["eliminarfoto"];
            $agregar = $_POST["AgregarNuevo"];
            
            if(isset($_POST["actualizar"])){
                Actualizarempresa(
                    $empresa, 
                    array(
                        $tabla1."_"."nombre" => $_POST["nombre"],
                        $tabla1."_"."usuario_id" => get_current_user_id(),
                        $tabla1."_"."notas" => $_POST["notas"]
                    )
                );
                ActualizarFoto($tabla1, $empresa);
            }
            if($eliminarfoto == "foto"){
                EliminarFoto($tabla1,$empresa);
            }
            if($eliminar == "empresa"){
                Eliminarempresa($empresa);
            }
            if($empresa == "nuevo"){
                if(isset($_POST["guardar"])){
                    AgregarNuevaEmpresa(
                        array(
                            $tabla1."_"."nombre" => $_POST["nombre"],
                            $tabla1."_"."usuario_id" => get_current_user_id(),
                            $tabla1."_"."notas" => $_POST["notas"]
                        )
                    );
                }
                else{AgregarNuevaEmpresa();}
            }
            else{
                MostrarEmpresa($empresa);                
            }
        }
    }
    else{
        if(isset($_GET["limit"])){
            if(isset($_GET["orden"])){
                MostrarListaEmpresas($_GET["limit"], $_GET["orden"]);
            }
            else{
                MostrarListaEmpresas($_GET["limit"]);            
            }
        }
        else{
            //MostrarListaempresas();
        }    
    }
?>
    
</div>
</div>
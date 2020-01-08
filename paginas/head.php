<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css'>
<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js'></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script>
  $( function() {
    $( "#tabs" ).tabs();
  } );
</script> <!--JQUERY UI PARA TABS-->
<script>
$(function () {
$( "#NuevaHistoria" ).dialog({
  autoOpen: false,
  height: 500,
  width: 'auto',
  create: function( event, ui ) {
    // Set maxWidth
    $(this).css("maxWidth", "800px");
  },
    
  show: {
    effect: "blind",
    duration: 500
  },
  hide: {
    effect: "explode",
    duration: 500
  },
  buttons: {
    "Agregar": function() {
      $( "#FormularioHistoria" ).submit();
    },
    Cancel: function() {
      $( this ).dialog( "close" );
    }
  }
});

$( "#MostrarFormularioHistoria" ).on( "click", function() {
  $( "#NuevaHistoria" ).dialog( "open" );
});
}); // ==> Historia
$(function () {
$( "#FormularioEditar" ).dialog({
  autoOpen: false,
  //height: 500,
  width: 'auto',
  create: function( event, ui ) {
    // Set maxWidth
    $(this).css("maxWidth", "800px");
  },
  show: {
    effect: "blind",
    duration: 500
  },
  hide: {
    effect: "explode",
    duration: 500
  },
  buttons: {
    "Actualizar Información": function() {
      $( "#FormularioEditar" ).submit();
    },
    Cancel: function() {
      $( this ).dialog( "close" );
    }
  }
});

$( "#BotonEditar" ).on( "click", function() {
  $( "#FormularioEditar" ).dialog( "open" );
});
}); // ==> Cliente
$(function () {
$( "#FormularioAgregarTelefono" ).dialog({
  autoOpen: false,
  //height: 500,
  width: 'auto',
  create: function( event, ui ) {
    // Set maxWidth
    $(this).css("maxWidth", "500px");
  },
  show: {
    effect: "blind",
    duration: 500
  },
  hide: {
    effect: "explode",
    duration: 500
  },
  buttons: {
    "Agregar Teléfono": function() {
      $( "#FormularioAgregarTelefono" ).submit();
    },
    Cancel: function() {
      $( this ).dialog( "close" );
    }
  }
});

$( "#BotonAgregarTelefono" ).on( "click", function() {
  $( "#FormularioAgregarTelefono" ).dialog( "open" );
});
}); // ==> Teléfono
$(function () {
$( "#FormularioAgregarCorreo" ).dialog({
  autoOpen: false,
  //height: 500,
  width: 'auto',
  create: function( event, ui ) {
    // Set maxWidth
    $(this).css("maxWidth", "500px");
  },
  show: {
    effect: "blind",
    duration: 500
  },
  hide: {
    effect: "explode",
    duration: 500
  },
  buttons: {
    "Agregar Correo": function() {
      $( "#FormularioAgregarCorreo" ).submit();
    },
    Cancel: function() {
      $( this ).dialog( "close" );
    }
  }
});

$( "#BotonAgregarCorreo" ).on( "click", function() {
  $( "#FormularioAgregarCorreo" ).dialog( "open" );
});
}); // ==> Correo
$(function () {
$( "#FormularioAgregarDireccion" ).dialog({
  autoOpen: false,
  //height: 500,
  width: 'auto',
  create: function( event, ui ) {
    // Set maxWidth
    $(this).css("maxWidth", "500px");
  },
  show: {
    effect: "blind",
    duration: 500
  },
  hide: {
    effect: "explode",
    duration: 500
  },
  buttons: {
    "Agregar Dirección": function() {
      $( "#FormularioAgregarDireccion" ).submit();
    },
    Cancel: function() {
      $( this ).dialog( "close" );
    }
  }
});

$( "#BotonAgregarDireccion" ).on( "click", function() {
  $( "#FormularioAgregarDireccion" ).dialog( "open" );
});
}); // ==> Dirección
$(function () {
$( "#FormularioAgregarIdentificacion" ).dialog({
  autoOpen: false,
  //height: 500,
  width: 'auto',
  create: function( event, ui ) {
    // Set maxWidth
    $(this).css("maxWidth", "500px");
  },
  show: {
    effect: "blind",
    duration: 500
  },
  hide: {
    effect: "explode",
    duration: 500
  },
  buttons: {
    "Agregar Identificación": function() {
      $( "#FormularioAgregarIdentificacion" ).submit();
    },
    Cancel: function() {
      $( this ).dialog( "close" );
    }
  }
});

$( "#BotonAgregarIdentificacion" ).on( "click", function() {
  $( "#FormularioAgregarIdentificacion" ).dialog( "open" );
});
}); // ==> Identificación
</script> <!--JQUERY UI PARA POP UP DE UN FORMULARIO DE HISTORIA CLÍNICA-->
<script>
function EditarCampo(myinput){
    document.getElementById(myinput).removeAttribute("readonly");
    document.getElementById(myinput).removeAttribute("disabled");
};
function OcultarTabla(formid,checkid, icono){
    checkbox1 = document.getElementById(checkid);
    if(checkbox1.checked){
        document.getElementById(formid).className = "hidden";
        document.getElementById(icono).className = "dashicons dashicons-arrow-down-alt2";
    }else{        
        document.getElementById(formid).className = "table";
        document.getElementById(icono).className = "dashicons dashicons-arrow-up-alt2"
    }
};
function MostrarOcultar(mostrar, ocultar){
    document.getElementById(mostrar).className -= "hidden";
    document.getElementById(ocultar).className += " hidden";
}
function Activar(id){
    document.getElementById(id).value = "yes";
}
function ValidarFormulario(formulario, campo){
    var x = document.forms[formulario][campo].value;
    if (x == "") {
        alert("Name must be filled out");
        return false;
    }
}
function lista_animales(valor){
        //alert(valor);
	$.ajax({
        url:'<?php echo plugins_url() ?>/ohana-sdg/recursos/listas.php',
		type:'POST',
		data:'valor='+escape(valor)+'&boton=animal'
	}).done(function(resp){
        //alert(resp);
		var valores = eval(resp);
        //alert(valores[0]['dueño']); 
        html="<table class='widefat'><thead><tr><th class='row-title'>ID</th><th>NOMBRE</th><th>RAZA</th><th>DUEÑO</th><th class='no-movil'>ESPECIE</th></tr></thead><tbody>";
		for(i=0;i<valores.length;i++){
			html+="<tr><td>"+valores[i]['id']+"</td><td class='mayuscula'><a href='admin.php?page=ohana-animales&animal="+valores[i]['id']+"'>"+valores[i]['nombre']+"</a></td><td class='text-uppercase'>"+valores[i]['raza']+"</td><td><a href='admin.php?page=ohana-clientes&cliente="+valores[i]['cliente']+"'>"+valores[i]['dueño']+"</a></td><td class='text-uppercase'>"+valores[i]['especie']+"</td></tr>";
		}
		html+="</tbody></table><br>";
        $("#tabla_animales").hide();
		$("#lista").html(html);
	});
};
function lista_empresas(valor){
        //alert(valor);
	$.ajax({
        url:'Controlador/listas.php',
		type:'POST',
		data:'valor='+escape(valor)+'&boton=empresa'
	}).done(function(resp){
        //alert(resp);
		var valores = eval(resp);
        //alert(valores[0]['dueño']); 
        html="<table class='widefat'><thead><tr><th class='row-title'>ID</th><th>NOMBRES</th><th>NOTAS</th></tr></thead><tbody>";
		for(i=0;i<valores.length;i++){
			html+="<tr><td>"+valores[i]['id']+"</td><td class='mayuscula'><a href='admin.php?page=mm-empresas&empresa="+valores[i]['id']+"'>"+valores[i]['nombre']+"</a></td><td class='text-uppercase'>"+valores[i]['notas']+"</td></tr>";
		}
		html+="</tbody></table><br>";
        $("#tabla_empresas").hide();
		$("#lista").html(html);
	});
};
function lista_productos(valor){
        //alert(valor);
	$.ajax({
        url:'<?php echo plugins_url() ?>/ohana-sdg/recursos/listas.php',
		type:'POST',
		data:'valor='+escape(valor)+'&boton=producto'
	}).done(function(resp){
        //alert(resp);
		var valores = eval(resp);
        //alert(valores[0]['dueño']); 
        html="<table class='widefat'><thead><tr><th class='row-title'>ID</th><th>CÓDIGO</th><th>PRODUCTO</th><th>PRESENTACIÓN</th><th class='no-movil'>STOCK</th><th class='no-movil'>CATEGORIA</th><th class='no-movil'>SUBCATEGORIA</th></tr></thead><tbody>";
		for(i=0;i<valores.length;i++){
			html+="<tr><td>"+valores[i]['id']+"</td><td class='mayuscula'>"+valores[i]['codigo']+"</td><td><a href='admin.php?page=ohana-productos&producto="+valores[i]['id']+"'>"+valores[i]['nombre']+"</a></td><td>"+valores[i]['presentacion']+"</a></td><td class='text-uppercase'>"+valores[i]['stock']+"</td><td class='text-uppercase'>"+valores[i]['categoria']+"</td><td class='text-uppercase'>"+valores[i]['subcategoria']+"</td></tr>";
		}
		html+="</tbody></table><br>";
        $("#tabla_productos").hide();
		$("#lista").html(html);
	});
};
function lista_proveedores(valor){
        //alert(valor);
	$.ajax({
        url:'<?php echo plugins_url() ?>/ohana-sdg/recursos/listas.php',
		type:'POST',
		data:'valor='+escape(valor)+'&boton=proveedor'
	}).done(function(resp){
        //alert(resp);
		var valores = eval(resp);
        //alert(valores[0]['dueño']); 
        html="<table class='widefat'><thead><tr><th class='row-title'>ID</th><th>NOMBRE</th><th>APELLIDOS</th><th>TELEFONO</th><th class='no-movil'>RUC</th></thead><tbody>";
		for(i=0;i<valores.length;i++){
			html+="<tr><td>"+valores[i]['id']+"</td><td><a href='admin.php?page=ohana-proveedores&proveedor="+valores[i]['id']+"'>"+valores[i]['nombre']+"</a></td><td>"+valores[i]['apellido']+"</a></td><td class='text-uppercase'>"+valores[i]['telefono']+"</td><td class='text-uppercase'>"+valores[i]['identificacion']+"</td></tr>";
		}
		html+="</tbody></table><br>";
        $("#tabla_proveedores").hide();
		$("#lista").html(html);
	});
};
function CambiarDeColor(id_1, id_2, color){
    //alert (color);
    document.getElementById(id_1).className += "hidden";
}
function SubVerDetalles(id){
    checkbox = document.getElementById(id);
    if(checkbox.checked){
        //alert("Activado");
        document.getElementById("subdetalle_"+id).className = "";
        document.getElementById("subver_"+id).className = "hidden";
        document.getElementById("subocultar_"+id).className = "";
    }else{
        //alert("Desactivado");
        document.getElementById("subdetalle_"+id).className = "hidden";
        document.getElementById("subver_"+id).className = "";
        document.getElementById("subocultar_"+id).className = "hidden";
    }
}
function VerDetalles(id){
    checkbox = document.getElementById(id);
    if(checkbox.checked){
        //alert("Activado");
        document.getElementById("detalle_"+id).className = "";
        document.getElementById("ver_"+id).className = "hidden";
        document.getElementById("ocultar_"+id).className = "";
    }else{
        //alert("Desactivado");
        document.getElementById("detalle_"+id).className = "hidden";
        document.getElementById("ver_"+id).className = "";
        document.getElementById("ocultar_"+id).className = "hidden";
    }
}
function Categoria(valor){
    if(valor == "nuevo"){
        MostrarOcultar('categoria_otra', 'categoria');
    }
}
function Subcategoria(valor){
    if(valor == "nuevo"){
        MostrarOcultar('subcategoria_otra', 'subcategoria');
    }
}

</script>
<script>
$(document).ready(function(){  
    $("#categoria").on('change', function(){
        var categoria = $(this).val();
        if(categoria){
            $.ajax({
                type:'POST',
                url:'<?php echo plugins_url() ?>/money-maker/paginas/formularios/subcategorias.php',
                data:'categoria=' + categoria,
                success:function(html){
                    $("#subcategoria").html(html);
                    //alert(html);
                }
            });
        }
    }); 
    $("#cuenta").on('change', function(){
        var cuenta = $(this).val();
        if(cuenta){
            $.ajax({
                type:'POST',
                url:'<?php echo plugins_url() ?>/money-maker/paginas/formularios/cuentas.php',
                data:'cuenta=' + cuenta,
                success:function(html){
                    $("#moneda").html(html);
                    //alert(html);
                }
            });
        }
    });
    
});
</script> <!--JQUERY PARA SELECCIÓN EN CASCADA-->
<style>
    .bg-black{
        background-color: black!important;
        color: white!important;
    }
    @media screen and (max-width: 782px) {
        .no-movil{
            display: none;
        }
    }
    @media print{
        td.bg-black{
            background-color: black!important;
            color: white!important;
        }
        #adminmenumain, .buttons, .btn, div #adminmenuback *, #adminmenu, #adminmenuwrap, #adminmenu .wp-submenu *, #adminmenuwrap .printhidden{
            display: none;
        }
        a:link:after, a:visited:after {  
          display: none;
          content: "";    
        }
        #wpcontent{
            margin: 0;
            padding: 0;
            width: 100%;
            font-size: 12px;
        }
        #wpfooter{
            display: none;
        }
        input.form-control{
            border:none;
            background: none;
            margin: 0;
            padding: 0;
            height: auto;
            font-size: 12px;
        }
        .col-md-3{
            width: 30%;
        }
        .col-md-9{
            width: 70%;
        }
        
    }
    td img{
        display: block;
        margin-left: auto;
        margin-right: auto;
    }
    .btn-sq-lg {
      width: 150px !important;
      height: 150px !important;
    }

    .btn-sq {
        width: 100px !important;
        height: 100px !important;
        text-align: center;
    }

    .btn-sq-sm {
      width: 50px !important;
      height: 50px !important;
      font-size: 10px;
    }

    .btn-sq-xs {
      width: 25px !important;
      height: 25px !important;
      padding:2px;
    }
    
// ÍCONOS DEL INICIO
    
    
</style>
<style>
    .switch {
  position: relative;
  display: inline-block;
  width: 80px;
  height: 34px;
}

.switch input { 
  opacity: 0;
  width: 0;
  height: 0;
}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #c00;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #0c0;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(46px);
  -ms-transform: translateX(46px);
  transform: translateX(46px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}
</style>

<?php

date_default_timezone_set('America/Lima');
global $current_url; 
global $tabla1;
global $tabla2;
global $tabla3;
global $tabla4;
global $tabla5;
global $tabla6;
global $page1;
global $page2;
global $page3;
global $page4;
global $page5;
global $page6;
global $base_url;
global $sql_animal;
global $animal;
global $registro_animal;
global $dummy_cliente;
global $dummy_proveedor;
$base_url = site_url()."/wp-admin/admin.php?page=";
$current_url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$page1 = site_url()."/wp-admin/admin.php?page=mm-empresas";
$page2 = site_url()."/wp-admin/admin.php?page=mm-cuentas";
$page3 = site_url()."/wp-admin/admin.php?page=mm-registros";
$page4 = site_url()."/wp-admin/admin.php?page=mm-reposrtes";
$page5 = site_url()."/wp-admin/admin.php?page=mm-categorias";
$page6 = site_url()."/wp-admin/admin.php?page=mm-subcategorias";
$tabla1 = "mm_empresa";
$tabla2 = "mm_cuenta";
$tabla3 = "mm_registro";
$tabla4 = "mm_categoria";
$tabla5 = "mm_subcategoria";
define("MAX_LIST",20);
(isset($_GET["limit"])) ? $_GET["limit"] : $_GET["limit"] = 0;
//echo $current_url;

?>

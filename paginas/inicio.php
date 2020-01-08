<?php include RUTA."paginas/head.php" ?>
<div class="wrap impresion">
<h2>Hola <?php echo wp_get_current_user()->first_name; ?></h2>
<h1>Bienvenido a Tu Sistema Financiero</h1>

<section class="accesos-directos">
    <h2>¿Qué deseas hacer hoy?</h2>
    <div class="row">
        <div class="col-lg-12">
          <p>
            <a href="admin.php?page=mm-registros&registro=nuevo&ingreso=checked" class="btn btn-sq btn-success">
                <i class="fas fa-cart-plus fa-3x"></i><br/>
                Nuevo<br>Ingreso
            </a>
            <a href="admin.php?page=mm-registros&registro=transferencia&empresa=5" class="btn btn-sq btn-info">
                <i class="fas fa-exchange-alt fa-3x"></i><br/>
                Nueva<br>Transferencia
            </a>
            <a href="admin.php?page=mm-registros&registro=nuevo" class="btn btn-sq btn-danger">
              <i class="fas fa-briefcase fa-3x"></i><br/>
              Nuevo<br>Egreso
            </a>
            <a href="admin.php?page=mm-empresas&empresa=nuevo" class="btn btn-sq btn-primary">
              <i class="fas fa-address-card fa-3x"></i><br/>
              Agregar<br>Empresa
            </a>
            <a href="#" class="btn btn-sq btn-info">
              <i class="fas fa-tasks fa-3x"></i><br/>
              Agregar<br>Cuenta
            </a>
            <a href="admin.php?page=mm-registros" class="btn btn-sq btn-warning">
              <i class="fas fa-tag fa-3x"></i><br/>
              Ver<br>Reportes
            </a>
          </p>
        </div>
	</div>
</section>
 
</div>
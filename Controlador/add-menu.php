<?php
add_action( 'admin_menu', 'mm_add_menu_page' );
//add_action( 'admin_menu', 'sg_add_submenu_page' );

function mm_add_menu_page() {
    $usuario = array( 'suscriptor' => 'read', 'colaborador' => 'edit_posts', 'autor' => 'upload_files', 'editor' => 'manage_categories', 'administrador' => 'manage_options' );
    add_menu_page(
        'Inicio',
        'Inicio',
        $usuario["colaborador"], 
        'mm-index', 
        'mm_index',
        'dashicons-admin-home',
        1
    );
    add_menu_page(
        'Empresas',
        'Empresas',
        $usuario["colaborador"], 
        'mm-empresas', 
        'mm_empresas',
        'dashicons-store',
        8
    );
    add_menu_page(
        'Cuentas',
        'Cuentas',
        $usuario["colaborador"], 
        'mm-cuentas', 
        'mm_cuentas',
        'dashicons-media-spreadsheet',
        9
    );
    add_menu_page(
        'Registros',
        'Registros',
        $usuario["colaborador"], 
        'mm-registros', 
        'mm_registros',
        'dashicons-list-view',
        10
    );
    
}
function mm_index(){
    include RUTA."paginas/inicio.php";
}
function mm_empresas(){
    include RUTA."paginas/empresas.php";
}
function mm_cuentas(){
    include RUTA."paginas/cuentas.php";
}
function mm_registros(){
    include RUTA."paginas/registros.php";
}


add_action( 'admin_bar_menu', 'mm_add_subpage', 999 );

function mm_add_subpage( $wp_admin_bar ){
    $args = array(
		'id'    => 'print',
		'title' => '<span class="ab-icon dashicons dashicons-media-text"></span><span class="ab-lable">Imprimir</span>',
        'href' => '#',
		'meta'  => array( 
                    'class' => 'ab-item',
                    'onclick' => 'print()',
                        )
	);
	$wp_admin_bar->add_node( $args );
    $args = array(
		'id'    => 'send-mail',
		'title' => '<span class="ab-icon dashicons dashicons-email-alt"></span> Enviar por Correo',
        'href' => site_url()."/wp-admin/admin.php?page=mm-index",
		'meta'  => array( 'class' => 'my-toolbar-page' )
	);
	$wp_admin_bar->add_node( $args );
    $args = array(
        'parent' => 'new-content',
		'id'    => 'new-business',
		'title' => 'Empresa',
		'href'  => site_url()."/wp-admin/admin.php?page=mm-empresas&empresa=nuevo",
		'meta'  => array( 'class' => 'my-toolbar-page' )
	);
	$wp_admin_bar->add_node( $args );
}
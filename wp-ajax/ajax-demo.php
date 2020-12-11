<?php
/*
Plugin Name: Ajax Demo
Plugin URI:
Description: Ajax Demo
Version: 1.0.0
Author: LWHH
Author URI:
License: GPLv2 or later
Text Domain: ajax-demo
 */

add_action( 'admin_enqueue_scripts', function ( $hook ) {
    if ( 'toplevel_page_ajax-demo' == $hook ) {
        wp_enqueue_style( 'pure-grid-css', '//unpkg.com/purecss@1.0.1/build/grids-min.css' );
        wp_enqueue_style( 'ajax-demo-css', plugin_dir_url( __FILE__ ) . "assets/css/style.css", null, time() );
        wp_enqueue_script( 'ajax-demo-js', plugin_dir_url( __FILE__ ) . "assets/js/main.js", array( 'jquery' ), time(), true );

        $action = 'ajd_protected';
        $ajd_nonce = wp_create_nonce( $action );
        wp_localize_script(
            'ajax-demo-js',
            'plugindata',
            array( 'ajax_url' => admin_url( 'admin-ajax.php'),'ajd_nonce'=>$ajd_nonce)
        );
        wp_localize_script("ajax-demo-js","baket",array("name"=>"naeem khan","email"=>"naeemkhan.cse@gmail.com"));


    }
} );




add_action( 'admin_menu', function () {
    add_menu_page( 'Ajax Demo', 'Ajax Demo', 'manage_options', 'ajax-demo', 'ajaxdemo_admin_page' );
} );

function ajaxdemo_admin_page() {
    ?>
        <div class="container" style="padding-top:20px;">
            <h1>Ajax Demo</h1>
            <div class="pure-g">
                <div class="pure-u-1-4" style='height:100vh;'>
                    <div class="plugin-side-options">
                        <button class="action-button" data-task='simple_ajax_call'>Simple Ajax Call</button>
                        <button class="action-button" data-task='unp_ajax_call'>Unprivileged Ajax Call</button>
                        <button class="action-button" data-task='ajd_localize_script'>Why wp_localize_script</button>
                        <button class="action-button" data-task='ajd_secure_ajax_call'>Security with Nonce</button>
                    </div>
                </div>
                <div class="pure-u-3-4">
                    <div class="plugin-demo-content">
                        <h3 class="plugin-result-title">Result</h3>
                        <div id="plugin-demo-result" class="plugin-result"></div>
                    </div>
                </div>
            </div>
        </div>
    <?php
}
add_action("wp_ajax_ajd_simple",function (){
    $data=$_POST['data'];
    echo "HALLO"." ". strtoupper($data);
    die();
});

function ajax_process(){
    $data=$_POST['data'];
    echo "Hallo ".strtoupper($data);
    die();
}

add_action('wp_ajax_unp_simple',"ajax_process");
add_action('wp_ajax_nopriv_unp_simple',"ajax_process");

function ajax_localdata(){
    $security=$_POST["security"];
    $ajd_nonce=$_POST["ajd_nonce"];
    $action = 'ajd_protected';
    if(wp_verify_nonce($ajd_nonce,$action)){
        echo $security;
    }else{
        echo "this is not a author";
    }
   
    die();
}
add_action('wp_ajax_local_data',"ajax_localdata");

function ajd_protected(){
    $data=$_POST['data'];
    echo "Hallo ".strtoupper($data);
    die();
}

add_action('wp_ajax_ajd_protected',"ajd_protected");
add_action('wp_ajax_nopriv_ajd_protected',"ajd_protected");
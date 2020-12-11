<?php
/*
Plugin Name:Transient Demo
Plugin URI:
Description:this is my first plugin.
Author: LWHH
Author URI:
Version: 1.0
License:GPLv2 or later
Text Domain:transient-demo
*/
add_action( 'admin_enqueue_scripts', function ( $hook ) {
    if ( 'toplevel_page_transient-demo' == $hook ) {
        wp_enqueue_style( 'pure-grid-css', '//unpkg.com/purecss@1.0.1/build/grids-min.css' );
        wp_enqueue_style( 'transient-demo-css', plugin_dir_url( __FILE__ ) . "assets/css/style.css", null, time() );
        wp_enqueue_script( 'transient-demo-js', plugin_dir_url( __FILE__ ) . "assets/js/main.js", array( 'jquery' ), time(), true );
        $nonce = wp_create_nonce( 'transient_display_result' );
        wp_localize_script(
            'transient-demo-js',
            'plugindata',
            array( 'ajax_url' => admin_url( 'admin-ajax.php' ), 'nonce' => $nonce )
        );
    }
} );
add_action( 'wp_ajax_transient_display_result', function () {
  global $transient;
    $table_name = $transient->prefix . 'wpdemo';
    if ( wp_verify_nonce( $_POST['nonce'], 'transient_display_result' ) ) {
        $task = $_POST['task'];
    if($task=="add-transient"){
        $key="tr-country";
        $value="bangladesh";
        $result=set_transient($key,$value);
        echo $result;
    } elseif($task=="set-expiry"){
            $key="tr-capital";
            $value="dhaka";
            $expire=1*60;//1minuet
            $result=set_transient($key,$value,$expire);
            echo $result;
        }elseif ($task=="get-transient"){

        $key1="tr-country";
        $key2="tr-capital";
        $result1=get_transient($key1);
        $result2=get_transient($key2);
        echo $result1."<br/>";
        echo $result2."<br/>";
    }
    elseif ($task=="importance"){
        $key="ct-tempture";
        $value=0;
        set_transient($key,$value);

        $result=get_transient($key);
        if($result===false){
            echo "not found";
        }else{
            echo "data is founded";
        }

    }elseif($task=="add-complex-transient"){
        global $wpdb;
        $result=$wpdb->get_results("SELECT DISTINCT post_title FROM wp_posts ORDER BY ID LIMIT 10",ARRAY_N);
        print_r($result);
    }elseif ($task=="transient-filter-hook"){
        $key="tr-country";
        $result=get_transient($key);
        echo $result;
    }elseif ($task=="delete-transient"){
        $key="tr-country";
       echo "before transient=".get_transient($key);
       echo "<br/>";
       echo "after Transient=".delete_transient($key);

    }
    }
    die(0);
});
//add_filter("pre_transient_tr-country",function ($value){
//    //return false; dile default ta paibe.
//    //ekhane ja issa patethe pari but acctiule value ta r paibo na option er motho.
//    return "My love bangladesh";
//
//});
add_action( 'admin_menu', function () {
    add_menu_page( 'Transient Demo', 'Transient Demo', 'manage_options', 'transient-demo', 'transientdemo_admin_page' );
} );

function transientdemo_admin_page() {
    ?>
    <div class="container" style="padding-top:20px;">
        <h1>Transient Demo</h1>
        <div class="pure-g">
            <div class="pure-u-1-4" style='height:100vh;'>
                <div class="plugin-side-options">
                    <button class="action-button" data-task='add-transient'>Add New transient</button>
                    <button class="action-button" data-task='set-expiry'>Set Expiry</button>
                    <button class="action-button" data-task='get-transient'>Display Transient</button>
                    <button class="action-button" data-task='importance'>Importance of ===</button>
                    <button class="action-button" data-task='add-complex-transient'>Add Complex Transient</button>
                    <button class="action-button" data-task='transient-filter-hook'>Transient Filter Hook</button>
                    <button class="action-button" data-task='delete-transient'>Delete Transient</button>
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
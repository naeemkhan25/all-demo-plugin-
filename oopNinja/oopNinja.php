<?php
/*
Plugin Name:OOP Ninja
Plugin URI:
Description:Count word form any wordpress Post
Version: 1.0
Author: LWHH
Author URI:
License: GPLv2 or later
Text Domain:oopNinja
Domain Path:/languages/
*/
define("ASN_ASSETS_DIR",plugin_dir_url(__FILE__)."assets/");
define("ASN_ASSETS_PUBLIC_DIR",plugin_dir_url(__FILE__)."assets/public/");
define("ASN_ASSETS_ADMIN_DIR",plugin_dir_url(__FILE__)."assets/admin/");
define("ASN_VERSION",time());

class assetsNinja{
    public function __construct(){

        add_action("plugin_loaded",array($this,"plugin_load_textdomain"));
        add_action("wp_enqueue_scripts",array($this,"ninjaAssets"));
        add_shortcode("bgImage",array($this,"add_inline_bgImage_style"));
    }
    function  plugin_load_textdomain(){
        load_plugin_textdomain("oopNinja",false,dirname(__FILE__)."/languages");

    }
    function add_inline_bgImage_style($attributes){
        $attributes_image=wp_get_attachment_image_src($attributes['id'],"medium");



        $attributes_output=<<<EOD
            <div id="bgimagedata" style="background-image: url({$attributes_image[0]})">
            
</div>
EOD;
        return $attributes_output;


    }
}
new assetsNinja();
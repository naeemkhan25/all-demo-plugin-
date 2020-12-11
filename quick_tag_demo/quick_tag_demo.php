<?php
/*
Plugin Name: Quick Tag Demo
Plugin URI:
Description:this is my first plugin.
Author: LWHH
Author URI:
Version: 1.0
License:GPLv2 or later
Text Domain:quick_tag_demo
*/

class QuickTagDemo{
    public function __construct()
    {
        add_action("plugin_loaded",array($this,"load_plugin_quick_tag"));
        add_action("admin_enqueue_scripts",array($this,"admin_enqueue_script_quick_tag"));
    }
    public function load_plugin_quick_tag(){
        load_plugin_textdomain("quick_tagA_demo",false,plugin_dir_path(__FILE__)."/languages");
    }
    public function admin_enqueue_script_quick_tag($screen){
        if("post.php"==$screen){
            wp_enqueue_script("quick_main_js",plugin_dir_url(__FILE__)."/assets/admin/js/qk.js",array("quicktags"),time(),true);
        }
    }

}
new QuickTagDemo();
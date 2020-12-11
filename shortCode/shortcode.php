<?php
/*
Plugin Name: Short code
Plugin URI:
Description:Count word form any wordpress Post
Version: 1.0
Author: LWHH
Author URI:
License: GPLv2 or later
Text Domain:shortCode
Domain Path:/languages/
*/
function shortcode_plugin_setup(){
    load_plugin_textdomain("shortCode",dirname(__FILE__)."/languages");
}
add_action("plugin_loaded","shortcode_plugin_setup");


function shortCode_button1($attributes,$content){
    $default=array(
     'type'=>'primary',
        'url'=>'',
        'title'=>''

    );
    $shorcat_button=shortcode_atts($default,$attributes);
    return sprintf("<a  target='_blank' class='btn btn--%s full-width' href='%s'>%s</a>",$shorcat_button['type'],
        $shorcat_button["href"],
        $shorcat_button['title']
    );

}

add_shortcode("button","shortCode_button1");
function shortCode_button2($attributes,$content){
    return sprintf("<a  target='_blank' class='btn btn--%s full-width' href='%s'>%s</a>",$attributes['type'],
        $attributes["href"],
        $content
    );

}
add_shortcode("button2","shortCode_button2");




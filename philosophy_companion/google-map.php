<?php

function philosophy_google_map(){
    $fields=array(
        array(
            "label"=>__("Place","philosophy"),
            "attr"=>"place",
            "type"=>"text",
            "meta"=>array(
                "placeholder"=>"place"
            )
        ),
        array(
            "label"=>__("width","philosophy"),
            "attr"=>"width",
            "type"=>"text"
        ),
        array(
            "label"=>__("height","philosophy"),
            "attr"=>"height",
            "type"=>"text"
        ),
        array(
            "label"=>__("ZOOM","philosophy"),
            "attr"=>"zoom",
            "type"=>"text"
        )
    );
    $setting=array(
        "label"=>__("GOOGLE MAPS","philosophy"),
        "listItemImage"=>"dashicons-admin-site",
        "post_type"=>array("page","post"),
        "attrs"=>$fields
    );
    shortcode_ui_register_for_shortcode("gmap",$setting);
}

add_action("register_shortcode_ui","philosophy_google_map");
<?php
/*
Plugin Name: Philosophy Companion
Plugin URI:
Description:Companion plugin for the philosophy theme
Version: 1.0
Author: LWHH
Author URI:
License: GPLv2 or later
Text Domain: philosophy_companion
 */
require_once dirname(__FILE__)."/gmap_ui.php";
function philosophy_register_my_cpts_book() {

    /**
     * Post Type: Books.
     */

    $labels = [
        "name" => __( "Books", "philosophy" ),
        "singular_name" => __( "Book", "philosophy" ),
        "menu_name" => __( "My Books", "philosophy" ),
        "all_items" => __( "All Books", "philosophy" ),
        "add_new" => __( "Add new", "philosophy" ),
        "add_new_item" => __( "Add new Book", "philosophy" ),
        "edit_item" => __( "Edit Book", "philosophy" ),
        "new_item" => __( "New Book", "philosophy" ),
        "view_item" => __( "View Book", "philosophy" ),
        "featured_image" => __( "Cover image for this Book", "philosophy" ),
        "set_featured_image" => __( "Set  cover image for this Book", "philosophy" ),
    ];

    $args = [
        "label" => __( "Books", "philosophy" ),
        "labels" => $labels,
        "description" => "",
        "public" => true,
        "publicly_queryable" => true,
        "show_ui" => true,
        "show_in_rest" => true,
        "rest_base" => "",
        "rest_controller_class" => "WP_REST_Posts_Controller",
        "has_archive" => "books",
        "show_in_menu" => true,
        "show_in_nav_menus" => true,
        "delete_with_user" => false,
        "exclude_from_search" => false,
        "capability_type" => "post",
        "map_meta_cap" => true,
        "hierarchical" => false,
        "rewrite" => [ "slug" => "books", "with_front" => false ],
        "query_var" => true,
        "menu_position" => 5,
        "supports" => [ "title", "editor", "thumbnail", "excerpt", "author" ],
    ];

    register_post_type( "book", $args );
}

add_action( 'init', 'philosophy_register_my_cpts_book');


function philosophy_sortCode($attributes){
    $default=array(
      'type'=>'primary',
      'title'=>__('button',"philosophy"),
      'url'=>'https://WordPress.org'
    );
    $replace_attributes=shortcode_atts($default,$attributes);
        return sprintf('<a  target="_blank" class="btn btn--%s full-width" href="%s">%s</a>',
            $replace_attributes['type'],
            $replace_attributes['url'],
            $replace_attributes['title']

        );
}

add_shortcode("button","philosophy_sortCode");

function philosophy_sortCode2($attributes,$content='')
{
    $default = array(
        'type' => 'primary',
        'title' => __('button', "philosophy"),
        'url' => 'https://WordPress.org'
    );
    $replace_attributes = shortcode_atts($default, $attributes);
    return sprintf('<a  target="_blank" class="btn btn--%s full-width" href="%s">%s</a>',
        $replace_attributes['type'],
        $replace_attributes['url'],
        do_shortcode($content)
    );

    }
add_shortcode("button2","philosophy_sortCode2");

function philosophy_uc($attributes,$content){
    return strtoupper(do_shortcode($content));

}
add_shortcode("uc","philosophy_uc");
function philosophy_gmap($attributes){
    $default=array(
      'place'=>"dhaka Museum",
        'width'=>'800',
        'height'=>'500',
        'zoom'=>'14'
    );
        $params=shortcode_atts($default,$attributes);
    $map = <<<EOD
<div>
    <div>
        <iframe width="{$params['width']}" height="{$params['height']}"
                src="https://maps.google.com/maps?q={$params['place']}&t=&z={$params['zoom']}&ie=UTF8&iwloc=&output=embed"
                frameborder="0" scrolling="no" marginheight="0" marginwidth="0">
        </iframe>
    </div>
</div>
EOD;
    return $map;

}

add_shortcode("gmap","philosophy_gmap");
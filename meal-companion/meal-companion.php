<?php
/*
Plugin Name:meal companion
Plugin URI:
Description:Meal companion for meal theme.
Author: LWHH
Author URI:
Version: 1.0
License:GPLv2 or later
Text Domain:meal-companion
Domain Path:/languages/
*/

function mealc_load_text_domain(){
    load_plugin_textdomain("meal-companion",false,dirname(__FILE__."/languages"));
}
add_action("plugin_loaded","mealc_load_text_domain");
function cptui_register_my_cpts_section() {

    /**
     * Post Type: sections.
     */

    $labels = [
        "name" => __( "sections", "meal" ),
        "singular_name" => __( "section", "meal" ),
    ];

    $args = [
        "label" => __( "sections", "meal" ),
        "labels" => $labels,
        "description" => "",
        "public" => false,
        "publicly_queryable" => false,
        "show_ui" => true,
        "show_in_rest" => true,
        "rest_base" => "",
        "rest_controller_class" => "WP_REST_Posts_Controller",
        "has_archive" => false,
        "show_in_menu" => true,
        "show_in_nav_menus" => true,
        "delete_with_user" => false,
        "exclude_from_search" => true,
        "capability_type" => "post",
        "map_meta_cap" => true,
        "hierarchical" => false,
        "rewrite" => [ "slug" => "section", "with_front" => false ],
        "query_var" => true,
        "menu_position" => 5,
        "supports" => [ "title", "editor", "thumbnail" ],
    ];

    register_post_type( "section", $args );
}

add_action( 'init', 'cptui_register_my_cpts_section' );
function cptui_register_my_cpts_recipes() {

    /**
     * Post Type: recipes.
     */

    $labels = [
        "name" => __( "recipes", "meal" ),
        "singular_name" => __( "recipes", "meal" ),
    ];

    $args = [
        "label" => __( "recipes", "meal" ),
        "labels" => $labels,
        "description" => "",
        "public" => true,
        "publicly_queryable" => true,
        "show_ui" => true,
        "show_in_rest" => true,
        "rest_base" => "",
        "rest_controller_class" => "WP_REST_Posts_Controller",
        "has_archive" => false,
        "show_in_menu" => true,
        "show_in_nav_menus" => true,
        "delete_with_user" => false,
        "exclude_from_search" => false,
        "capability_type" => "post",
        "map_meta_cap" => true,
        "hierarchical" => false,
        "rewrite" => [ "slug" => "recipes", "with_front" => false ],
        "query_var" => true,
        "menu_position" => 5,
        "supports" => [ "title", "editor", "thumbnail" ],
        "taxonomies"=>array("category")
    ];

    register_post_type( "recipes", $args );
}

add_action( 'init', 'cptui_register_my_cpts_recipes' );
function cptui_register_my_cpts_reservation() {

    /**
     * Post Type: reservation.
     */

    $labels = [
        "name" => __( "Reservations", "meal" ),
        "singular_name" => __( "Reservations", "meal" ),
    ];

    $args = [
        "label" => __( "Reservation", "meal" ),
        "labels" => $labels,
        "description" => "",
        "public" => false,
        "publicly_queryable" => false,
        "show_ui" => true,
        "show_in_rest" => true,
        "rest_base" => "",
        "rest_controller_class" => "WP_REST_Posts_Controller",
        "has_archive" => false,
        "show_in_menu" => true,
        "show_in_nav_menus" => true,
        "delete_with_user" => false,
        "exclude_from_search" => true,
        "capability_type" => "post",
        "map_meta_cap" => true,
        "hierarchical" => false,
        "rewrite" => [ "slug" => "reservation", "with_front" => true ],
        "query_var" => true,
        "menu_position" => 5,
        "supports" => [ "title"],
    ];

    register_post_type( "reservation", $args );
}

add_action( 'init', 'cptui_register_my_cpts_reservation' );
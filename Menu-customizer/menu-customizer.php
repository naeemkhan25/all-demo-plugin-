<?php
/*
Plugin Name:menu Customizer
Plugin URI:
Description:this is my first plugin.
Author: LWHH
Author URI:
Version: 1.0
License:GPLv2 or later
Text Domain:menu-customizer
*/
use Carbon_Fields\Container;
use Carbon_Fields\Field;
use HasinHayder\D\D;
require_once( "vendor/autoload.php");
function crb_load() {

    \Carbon_Fields\Carbon_Fields::boot();
}
add_action("plugin_loaded","crb_load");
function mac_init()
{
    if(!class_exists("wooCommerce")){
        return;
    }
//ai hok ta woocommerce initilize hobar age e run hoy.
//er jonno amra kokhon o out put pabo na.
    //ai jonno amra data base use korbo wp_posts er modde sob e ache;
    global $wpdb;
     $table_name=$wpdb->prefix. 'posts';
     $products=$wpdb->get_results("SELECT ID,post_title as name FROM {$table_name} WHERE post_status='publish' AND post_type='product'",ARRAY_A);
     $_products=array('0'=>"Always Display");
     foreach ($products as $product){
         $_products[$product['ID']]=$product['name'];
     }
//D::print_r($_products);
    Container::make('nav_menu_item', __('Menu Settings'))
        ->add_fields(array(
            Field::make( 'select', 'crb_select', __( 'Choose Options' ) )
                ->set_options($_products)
        ));
}

add_action("carbon_fields_register_fields",'mac_init',99);
//wordpress e menu item gulo display te show er jonno ekta filter hook run hoy


add_filter("wp_get_nav_menu_items",function ($items){
    if(!class_exists("wooCommerce")){
        return $items;
    }

if(!is_admin()) {
    $is_hide=array();
    foreach ($items as $key => $item) {
        $product_id = carbon_get_nav_menu_item_meta($item->ID, "crb_select");
        if ($product_id != 0) {
            $current_user = wp_get_current_user();
            if ($current_user) {
                $is_owner = wc_customer_bought_product($current_user->user_email, $current_user->ID, $product_id);
                if (!$is_owner) {
                    $is_hide[$key]=$item->ID;
                }
            }
        }
    }
   foreach ($is_hide as $key=>$hide){
       unset($items[$key]);
   }

//    D::print_r($is_hide);
}
    return $items;
});

add_action('wp_footer',function (){
//    $products=wc_get_products(array(
//       'posts_per_page'=>5,
//        'post_status'=>'publish',
//        'orderby'=>'asc'
//    ));
//    $_products=array();
//    foreach ($products as $product){
//        $_products[$product->get_id()]=array($product->get_name());
//    }
//
//    D::print_r($_products);
   D::dumpInConsole();
});
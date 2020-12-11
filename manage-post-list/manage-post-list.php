<?php
/*
Plugin Name:manage post List
Plugin UR{I:
Description:Meal companion for meal theme.
Author: LWHH
Author URI:
Version: 1.0
License:GPLv2 or later
Text Domain:manage-post-list
Domain Path:/languages/
*/
function managePL_plugin_load(){
    load_plugin_textdomain("manage-post-list",false,dirname(__FILE__)."/languages");
}
add_action("plugin_loaded",'managePL_plugin_load');
//sobe columns er modde aarray hisabe ase;

function manage_post_columns($columns){
        if(isset($_GET['post_type'])=='book'){
            return  $columns;
        }
    $columns['post_id'] = "ID";
    $columns['thumbnails'] = "Post Thumbnails";
    $columns['wordCount'] = "word Count";
    return $columns;
}

add_filter("manage_posts_columns",'manage_post_columns');

//add_filter("manage_book_posts_columns",'manage_post_columns');
//
//function manage_category($cat_columns){
//    $cat_columns['cat_image_thumb'] = 'Image';
//    return $cat_columns;
//}
//add_filter("manage_category_columns","manage_category",10,2);

//same procehes category_pages er kheter
//add_filter("manage_pages_columns",'manage_post_columns');
//add_filter("manage__custom_column");

function manage_add_post_columns_value($columns,$postID){
    //ekhane $columns toiri kora array er key ta patay.

//    print_r($columns);
    if('post_id'==$columns){
        echo $postID;
    }elseif ('thumbnails'==$columns){
        echo get_the_post_thumbnail($postID,array(50,60));
    }elseif ("wordCount"==$columns){
        $word=get_post_meta($postID,'wordDataCount',true);
        echo $word;
    }

}
add_action("manage_posts_custom_column","manage_add_post_columns_value",10,2);
//add_action("manage_pages_custom_column","manage_add_post_columns_value",10,2);

//add_action("manage_book_posts_custom_column",'manage_add_post_columns_value',10,2);
//aita short kore clickable kore
//word count title ta link up korar jonno use hobe.
function manage_edit_columns($columns){

    $columns['wordCount']='wordn';
    return $columns;

}
add_filter("manage_edit-post_sortable_columns","manage_edit_columns");
//post gulo meta hisabe set korbo.then pore tule niye asbo
//function manage_post_meta_save_data(){
//    $_Post=get_posts(array(
//        'posts_per_page'=>-1,
//        'post_type'=>'post',
//        'post_status'=>'any'
//    ));
//   foreach ($_Post as $post){
//       $content=$post->post_content;
//       $wordcount=str_word_count(strip_tags($content));
//       update_post_meta($post->ID,"wordDataCount",$wordcount);
//   }
//}
//
//add_action("init","manage_post_meta_save_data");
function manage_post_sorted($wpquery){

    if(!is_admin()){
        return;
    }

    $orderby=$wpquery->get('orderby');
    if('wordn'==$orderby){
        $wpquery->set('meta_key',"wordDataCount");
        $wpquery->set("orderby",'meta_value_num');
    }


}
add_action("pre_get_posts","manage_post_sorted");

function post_to_meta_convart_update($post_id){

    $post=get_post($post_id);
    $content=$post->post_content;
    $wordcount=str_word_count(strip_tags($content));
    update_post_meta($post->ID,"wordDataCount",$wordcount);
}
add_action("save_post","post_to_meta_convart_update");
//ok
function manage_posts_filter_columns(){

    if(isset($_GET['post_type'])&&$_GET['post_type']!='post'){
        return;
    }
    $_filter=isset($_GET['DREM11'])?$_GET['DREM11']:'';
    $filtering=array(
        0=>apply_filters("all_one",__("all","manage-post-list")) ,
        1=>apply_filters("some_one",__("some One","manage-post-list")) ,
        2=>apply_filters("another_one",__("another One","manage-post-list"))
    );
    ?>
    <select name="DREM11">
        <?php
        foreach ($filtering as $key=>$value){
            printf("<option value='%s' %s>%s</option>",$key,$key==$_filter?'selected':'',$value);
        }
        ?>
    </select>
    <?php
}
add_action("restrict_manage_posts","manage_posts_filter_columns");

function filter_post_DREM11($wpquery){
    if(!is_admin()){
        return;
    }
    $_filter=isset($_GET['DREM11'])?$_GET['DREM11']:'';

    if($_filter==1){
        $wpquery->set("post__in",array(1,540,12));
    } elseif($_filter==2){
        $wpquery->set("post__in",apply_filters("another_one_data",array(14,11)));
    }
}
add_action("pre_get_posts","filter_post_DREM11");
//thumbnails filter
function manage_posts_thumbanils_columns(){

    if(isset($_GET['post_type'])&&$_GET['post_type']!='post'){
        return;
    }
    $_filter=isset($_GET['thumbnails_filter'])?$_GET['thumbnails_filter']:'';
    $filtering=array(

        0=>apply_filters("all_thumbnails",__("all thumbnails","manage-post-list")) ,
        1=>apply_filters("has_thumbnails",__("Has thumbnails","manage-post-list")) ,
        2=>apply_filters("no_thumbnails",__("NO Thumbnails","manage-post-list"))
    );
    ?>
    <select name="thumbnails_filter">
        <?php
        foreach ($filtering as $key=>$value){
            printf("<option value='%s' %s>%s</option>",$key,$key==$_filter?'selected':'',$value);
        }
        ?>
    </select>
    <?php
}
add_action("restrict_manage_posts","manage_posts_thumbanils_columns");
function filter_post_thumbnails($wpquery){
    if(!is_admin()){
        return;
    }
    $_filter=isset($_GET['thumbnails_filter'])?$_GET['thumbnails_filter']:'';
    if($_filter==1){
        $wpquery->set('meta_query',array(
            array(
                'key'=>'_thumbnail_id',
                'compare'=>'EXISTS',
            )
        ));
    } elseif($_filter==2){
        $wpquery->set('meta_query',array(
            array(
                'key'=>'_thumbnail_id',
                'compare'=>'NOT EXISTS',
            )
        ));
    }
}
add_action("pre_get_posts","filter_post_thumbnails");
//_thumbnail_id meta the wordpress nije pass kore
function manage_wordCount_filtaring(){

    if(isset($_GET['post_type'])&&$_GET['post_type']!='post'){
        return;
    }
    $_filter=isset($_GET['wordcount_filter'])?$_GET['wordcount_filter']:'';
    $filtering=array(

        0=>apply_filters("Word_count",__("word count","manage-post-list")) ,
        1=>apply_filters("400_UP",__("400 < up","manage-post-list")) ,
        2=>apply_filters("200_to_400",__("200 to 400","manage-post-list")),
        3=>apply_filters("200",__("200 >less","manage-post-list"))
    );
    ?>
    <select name="wordcount_filter">
        <?php
        foreach ($filtering as $key=>$value){
            printf("<option value='%s' %s>%s</option>",$key,$key==$_filter?'selected':'',$value);
        }
        ?>
    </select>
    <?php
}
add_action("restrict_manage_posts","manage_wordCount_filtaring");


function filter_wordCOunt($wpquery){
    if(!is_admin()){
        return;
    }
    $_filter=isset($_GET['wordcount_filter'])?$_GET['wordcount_filter']:'';
    if($_filter==1){
        $wpquery->set('meta_query',array(
            array(
                'key'=>'wordDataCount',
                'value'=>400,
                'compare'=>'>=',
                'type'=>'NUMERIC'
            )
        ));
    } elseif($_filter==2){
        $wpquery->set('meta_query',array(
            array(
                'key'=>'wordDataCount',
                'value'=>array(200,400),
                'compare'=>'BETWEEN',
                'type'=>'NUMERIC'
            )
        ));
    }elseif($_filter==3){
        $wpquery->set('meta_query',array(
            array(
                'key'=>'wordDataCount',
                'value'=>200,
                'compare'=>'<=',
                'type'=>'NUMERIC'
            )
        ));
    }
}

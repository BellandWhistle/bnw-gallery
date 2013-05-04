<?php
/*
Plugin Name: BnW Gallery
Plugin URI: bell-n-whistle.com/bnw-gallery
Description: Gallery 
Version: 1.0
Author: Bell & Whistle
Author URI: http://bell-n-whistle.com
*/


// Plugin helpers
include('helpers.php');

// Add plugin CSS & Javascript
add_action('template_redirect', 'glry_add_assets');

// Put in header gallery information in json format
add_action('wp_head', 'add_gallery_data');

// Custom template
add_filter( 'image_template', 'glry_image_template');
add_filter( 'tag_template', 'glry_tag_template' );
add_filter( 'single_template', 'glry_single_template' );

// Custom Permalink
add_filter( 'query_vars', 'add_query_vars' );
// add_action( 'generate_rewrite_rules', 'my_rewrite_rules' );

register_activation_hook( __FILE__, 'glry_activation');


function glry_activation()
{
  global $wp_rewrite;

  add_rewrite_endpoint('album', EP_PERMALINK);
  
  $wp_rewrite->flush_rules();
}


function add_gallery_data()
{
  $gallery_data = array(
            'base_dir'      => glry_plugin_url('/'),
            'glry_base_url'   => get_bloginfo('home')
          );
  echo '<script> var GLRY_data = '.json_encode($gallery_data).'; </script>';
}

function glry_add_assets()
{
  global $wp_query;
  
  if( is_attachment() or is_tag('gallery') or  isset( $wp_query->query['album'] ) )
  {
    // CSS
    wp_enqueue_style('glry_css', glry_plugin_url('css/style.css') );

    wp_enqueue_style( 'twentytwelve-style', glry_plugin_url('css/blank.css') );
    wp_enqueue_style( 'twentytwelve-fonts', glry_plugin_url('css/blank.css') );
    

    // JS
    wp_deregister_script( 'comment-reply' );
    wp_deregister_script( 'jquery' );
    wp_register_script( 'jquery', glry_plugin_url('js/jquery.js') );
    wp_enqueue_script( 'jquery' );

    wp_register_script( 'glry_libs', glry_plugin_url('js/libs.js'), array( 'jquery' ) );
    wp_enqueue_script( 'glry_libs' );

    wp_register_script( 'glry_scripts', glry_plugin_url('js/scripts.js'), array( 'jquery', 'glry_libs' ) );
    wp_enqueue_script( 'glry_scripts' );
  }
}

function glry_image_template($single_template)
{
  global $post, $query;
  
  if($post->post_type == 'attachment')
  {
     $single_template = dirname( __FILE__ ) . '/template/template.php';
     // $single_template = dirname( __FILE__ ) . '/template/attachment.php';
  }
  return $single_template;
}


function glry_tag_template( $template_file )
{
    global $post;

  $tag = get_queried_object();

     if ( is_tag ( 'gallery' ) ) {
    $template_file = dirname( __FILE__ ) . '/template/template.php';
    // $template_file = dirname( __FILE__ ) . '/template/tag.php';
     }

     return $template_file;
}


function glry_single_template( $template_file )
{
    global $wp_query;

  $tag = get_queried_object();

     if(isset( $wp_query->query['album'] )){
    $template_file = dirname( __FILE__ ) . '/template/template.php';
    // $template_file = dirname( __FILE__ ) . '/template/gallery.php';
     }

     return $template_file;
}

 
/* Modificamos permalink */
function add_query_vars($vars)
{
  $vars[] = 'album';
  return $vars;
}

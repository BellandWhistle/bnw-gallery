<?php

require('.././../../wp-load.php');

if( isset($_GET['action']) ){

  $action   = $_GET['action'];
  $response   = array();

  $paged    = empty($_GET['paged']) ? 1 : (int) $_GET['paged'];
  $title    = 'Galleries';
  $albums   = array();

  if( 'get_gallery' == $action )
  {

    $args = array(  /*'numberposts' => -1,*/
            'paged'   => $paged,
            'tax_query' => array(
                      'taxonomy' => 'tag',
                      'field' => 'slug',
                      'terms' => 'gallery'
                      ) );

    $get_albums = new WP_query($args);
    $order = 0;
    foreach($get_albums->get_posts() as $post){
      setup_postdata($post);
      $thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ) );

      $albums[] = array(
                'permalink'   => get_permalink().'/album',
                'thumbnail_src' => $thumbnail_src[0],
                'title'     => get_the_title(),
                'id'      => get_the_ID(),
                'order_id'    => $order++
              );
    }

    // Little hack to fix the pagination links
    $_SERVER['REQUEST_URI'] = "/tag/gallery/page/".$paged;
    if (function_exists(wp_pagenavi)) {
      $pagination = wp_pagenavi(  array( 'echo' => false, 'query' => $get_albums ) );
    }
    else{
      $pagination = '';
    }

    $response = array(
              'paged' => $page,
              'title' => $title,
              'albums' => $albums,
                    'pagination' => $pagination
              );
  }
  elseif ('get_album' == $action)
  {
    $postname = $_GET['albumname'];

    // Obtenemosl el post del que estamos
    $query = new WP_query(array('name' => $postname));

    $query = get_posts( array('name' => $postname) );
    // var_dump($query);
    $post = $query[0];
    // var_dump($post);
    setup_postdata($post);
    // Obtenemos las fotos del post
    $get_photos = get_children(array(
                'post_parent'   => $post->ID,
                'post_type'     => 'attachment',
                'mime_type'     => 'image',
                'order'     => 'DESC',
                'orderby'     => 'none'
              ));
    $order = 1;
    foreach( $get_photos as $photo)
    {
      // var_dump($photo);
      list($thumb_src, $x, $y) = wp_get_attachment_image_src($photo->ID);
      list($full_src, $width, $height) = wp_get_attachment_image_src($photo->ID, 'full');

      // Tags
      $tags = get_post_meta($post->ID, 'glry_tag');

      // solo data que necesitamos
      // OJO: FALTA OBTENER EL BACK TO SLIDESHOW QUE
      // DEBE SER EL PRIMER ITEM DE LA LISTA DE PHOTOS
      $data   = array(
                        'ID'          => $photo->ID,
                        'permalink'     => get_permalink($photo->ID),
                        'thumb_src'   => $thumb_src,
                        'full_src'    => $full_src,
                        // 'max_width'    => $width,
                        'photoname'   => $photo->post_name,
                        'order'     => $order++,
                        'description' => $photo->post_content,
                        'tags'      => get_post_meta($photo->ID, 'glry_tag')
                      );
      $photos[] = $data;


    }

    $response = array(
              'post_url'    => get_permalink(),
              'total_photos'  => $order - 1,
                  'album_url'   => get_permalink($post->ID).'/album',
              'album_title' => get_the_title(),
              // 'permalink' => get_permalink().'/album',
              'photos' => $photos
            );

  }
}
else
{
  die( array('error' => true) );
}
header('Content-type: application/json');
echo json_encode($response);

<?php


// URL de plugin
function glry_plugin_url($path_file)
{
  return plugins_url($path_file, __FILE__);
}


// Retorna solo la url del attachment
function glry_adjacent_image_link($prev = true) {

  global $post;
  $post = get_post($post);

  $attachments = array_values(get_children( array('post_parent' => $post->post_parent,
    'post_status' => 'inherit',
    'post_type' => 'attachment',
    'post_mime_type' => 'image',
    'order' => 'DESC',
    'orderby' => 'menu_order ID') ));

  // var_dump($attachments);

  $total = count($attachments);

  foreach ( $attachments as $k => $attachment )
    if ( $attachment->ID == $post->ID )
      break;


  // var_dump($attachment->ID, $post->ID, $k);
  $actual = $k + 1;
  $k = $prev ? $k - 1 : $k + 1;
  if ( isset($attachments[$k]) )
  {
    // echo wp_get_attachment_link($attachments[$k]->ID, $size, true, false, $text);
    // function wp_get_attachment_link( $id = 0, $size = 'thumbnail', $permalink = false, $icon = false, $text = false ) {

    // $id = intval( $attachments[$k]->ID);
    // $_post = get_post( $id );

    // if ( empty( $_post ) || ( 'attachment' != $_post->post_type ) || ! $url = wp_get_attachment_url( $_post->ID ) )
    //  return __( 'Missing Attachment' );

    // $url = get_attachment_link( $_post->ID );

    // var_dump($url);

    $id = intval( $attachments[$k]->ID );
    $_post = get_post( $id );

    if ( empty( $_post ) || ( 'attachment' != $_post->post_type ) || ! $url = wp_get_attachment_url( $_post->ID ) )
      return __( 'Missing Attachment' );

    //if ( $permalink )
      $url = get_attachment_link( $_post->ID );

    //$post_title = esc_attr( $_post->post_title );

    //if ( $text )
      //$link_text = $text;
    //elseif ( $size && 'none' != $size )
      //$link_text = wp_get_attachment_image( $id, $size, $icon );
    //else
      //$link_text = '';

    //if ( trim( $link_text ) == '' )
      //$link_text = $_post->post_title;

    return array($url, $actual, $total);
  }
  return array(NULL, $actual, $total);
}

function _dump($var) {
  echo '<pre>';
  print_r($var);
  echo '</pre>';
  die();
}
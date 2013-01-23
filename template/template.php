<?php

$template = '';

// Sharing
$data_facebook = array(
          'button_container' => '.glry_button_container_facebook',
          'title' => 'Share on Facebook'
        );

$data_twitter = array(
          'button_container' => '.glry_button_container_twitter',
          'title' => 'Share on Twitter'
        );

$data_google = array(
          'button_container' => '.glry_button_container_google',
          'title' => 'Share on Twitter'
        );

$data_pinterest = array(
          'button_container' => '.glry_button_container_pinterest',
          'title' => 'Share on Twitter'
        );

$data_link = array(
        'button_container' => '.glry_link_container',
        'title' => 'Share link',
        'position' => array(
            'my' => 'top right',
            'at' => 'bottom center',
            'viewpost' => '$(window)',
            'adjust' => array(
                    'x' => 0
                  )
            )
      );



// si es galería
if( is_tag ( 'gallery' ) ){
	$template = 'gallery';
}

// Si es album
if(isset( $wp_query->query['album'] ))
{
	$template = 'album';
	// Set thumbnail images
	$get_thumbnails = get_children(array(
	            'post_parent'   => $post->ID,
	            'post_type'     => 'attachment',
	            'mime_type'     => 'image',
				// 'order' 		=> 'DESC',
				'orderby' 		=> 'menu_order'
	          ));

	// Set thumbnails
	$first = true;
	foreach( $get_thumbnails as $thumbnail)
	{

	  list($thumb_src, $x, $y) = wp_get_attachment_image_src($thumbnail->ID);

	  // solo data que necesitamos
	  $data   = array(
	                    'ID'      => $thumbnail->ID,
	                    'post_title'  => $thumbnail->post_title,
	                    'permalink'   => get_permalink($thumbnail->ID),
	                    'full_src'    => $thumbnail->guid,
	                    'thumb_src'   => $thumb_src
	                  );
	  if($first){
	    $firt_attachment = $data;
	    $first = false;
	  }
	  $thumbnails[$thumbnail->ID] = $data;
	}
}

// Si es foto
if($post->post_type == 'attachment')
{
	$template = 'photo';

	$post_parent_id			= $post->post_parent;
	$post_parent 			= get_post($post_parent_id);
	$post_parent_permalink	= get_permalink($post_parent_id);


	list($next_link, $of, $total) 		= glry_adjacent_image_link(false);
	list($previous_link, $of, $total) 	= glry_adjacent_image_link();


	$attachment_data		= array(
									'previous_link' 	=> $previous_link,
									'next_link' 		=> $next_link,
									'image_pos'			=> $of,
									'total_images'		=> $total
								);

	$_post = $post;  // guardamos temporalmente para no romper algunas cosas

	// Datos de la imagen 
	list($full_image_src, $h, $w) = wp_get_attachment_image_src(get_the_ID(), 'full');

	$data_facebook = array(
						'button_container' => '.glry_button_container_facebook',
						'title'	=> 'Share on Facebook'
					);

	$data_twitter = array(
						'button_container' => '.glry_button_container_twitter',
						'title'	=> 'Share on Twitter'
					);

	$data_google = array(
						'button_container' => '.glry_button_container_google',
						'title'	=> 'Share on Twitter'
					);

	$data_pinterest = array(
						'button_container' => '.glry_button_container_pinterest',
						'title'	=> 'Share on Twitter'
					);

	$data_link = array(
					'button_container' => '.glry_link_container',
					'title'	=> 'Share link',
					'position' => array(
							'my' => 'top right',
							'at' => 'bottom center',
							'viewpost' => '$(window)',
							'adjust' => array(
											'x' => 0
										)
							)
				);

	$post = $_post;  // devolvemos el $post

	// Obtenemos los tags que tenga la imagen
	$tags = get_post_meta($post->ID, 'glry_tag');
}

?><!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<title><?php
	/*
	 * Print the <title> tag based on what is being viewed.
	 */
	global $page, $paged;

	wp_title( '|', true, 'right' );

	// Add the blog name.
	bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		echo " | $site_description";

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		echo ' | ' . sprintf( __( 'Page %s', 'twentyeleven' ), max( $paged, $page ) );

	?></title>
	<?php wp_head(); ?>
 	<?php include('header.php'); ?>
</head>
<body <?php body_class(); ?>>
	<div class="gallery_container">
			<div id="gallery_base">
					<?php // include($template.'.php');?>
			</div>
	</div>
	<?php include('templates.php'); ?>
	<?php wp_footer(); ?>
</body>
</html>

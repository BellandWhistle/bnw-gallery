<?php while ( have_posts() ) { the_post(); ?>
<div class="wrap_content"> 	  
    <div class="content">
      <img class="full_image" src="<?php echo $full_image_src; ?>" alt="<?php echo the_title_attribute(); ?>" usemap="#Map" >
    </div>
</div>
<div class="primary">
	<div class='site_title'><a href='<?php echo bloginfo('home') ?>'><?php echo bloginfo('name'); ?></a></div>
	
	<div class="post_details">
		<h1>
		<a href="<?php echo get_permalink($post_parent->ID); ?>">
			<span class='label'><img src="<?php echo glry_plugin_url('/img/transparent.png'); ?>" alt="" class="icon arrow" width="4" height="7"> BACK TO ARTICLE</span>
			<span class='post_title'><?php echo $post_parent->post_title; ?></span>
		</a>
		</h1>
	</div>

	<div class="item_details">
		<div class="description">
			<?php the_excerpt() ?>
		</div>
	</div>
</div>	
<div class="secondary">
   	<div class="global_nav cf">
   		<ul class="left">
   			<li class="more_galleries">
   				<a href="<?php echo get_term_link('gallery', 'post_tag'); ?>"><img class="icon more_galleries" src="<?php echo glry_plugin_url('/img/transparent.png'); ?>" alt=""><span class="text">More galleries</span></a>
   			</li>
   		</ul>
   		<ul class="right">
   			<li><a href="<?php echo $post_parent_permalink; ?>/album">Thumbnails</a></li>
   			<li><a href="<?php echo get_permalink( $post_parent->ID ); ?>">Close</a></li>
   		</ul>
   	</div>
   	<div class="main_navigation cf">
   		<div class="previous">
   			<?php 
   			if( $attachment_data['previous_link'] )
   			{ ?>
       			<a class="link" href="<?php echo $attachment_data['previous_link']; ?>">
       				<img src="<?php echo glry_plugin_url('/img/transparent.png'); ?>" alt="" class="icon arrow_previous" width="5" height="11">
       				<span>Previous</span>
       			</a>
   				<?php
   			}else{ ?> &nbsp; <?php } ?>
   			</div>
   		<div class="offset">
   			<span class="on"><?php echo $attachment_data['image_pos']; ?></span> <span class="of">of</span> <span class="total"><?php echo $attachment_data['total_images'] ?></span>
   		</div>
   		<div class="next">
   			<?php 
   			if($attachment_data['next_link']){ ?>
   				<a class="link" href="<?php echo $attachment_data['next_link']; ?>"><span>Next</span>
   					<img src="<?php echo glry_plugin_url('/img/transparent.png'); ?>" alt="" class="icon arrow_next" width="5"  height="11">
   				</a>
   			<?php }else{ ?> &nbsp; <?php } ?>
   		</div>
   	</div>
</div>
<?php } ?>

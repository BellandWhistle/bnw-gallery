<div class="global_nav cf">
	<div class="logo">
		<div class='site_title'><a href='<?php echo bloginfo('home') ?>'><?php echo bloginfo('name'); ?></a></div>
	</div>
	<h1 class="title">Galleries<?php //single_cat_title(); ?></h1>
</div>
<div class="content cf">
	<ul class="thumb_list cf">
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<li>
				<a href="<?php echo the_permalink(); ?>/album">
				<span class="thumbnail">
					<?php the_post_thumbnail('thumbnail'); ?>
				</span>
				<span class="title"><?php the_title(); ?></span>
				</a>
			</li>
		<?php endwhile; ?>
		<?php else: ?>
		<?php endif; ?>
	</ul>
	<div class="pagination"><p><?php posts_nav_link(); ?></p></div>
</div>
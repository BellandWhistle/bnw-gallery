    <div class="primary">
      <div class='site_title'><a href='<?php echo bloginfo('home') ?>'><?php echo bloginfo('name'); ?></a></div>
      <div class="post_details">
        <h1>
          <a class="back_to_slidehow" href="<?php echo $firt_attachment['permalink']; ?>">
            <span class='label'><img src="<?php echo glry_plugin_url('/img/transparent.png'); ?>" alt="" class="icon arrow" width="4" height="7"> BACK TO SLIDEHOW</span>
            <span class='post_title'><?php the_title(); ?></span>
          </a>
        </h1>
      </div>
      <div class="additional_links">
        <span class="more_galleries">
          <a href="<?php echo get_term_link('gallery', 'post_tag'); ?>"><img class="icon more_galleries" src="<?php echo glry_plugin_url('/img/transparent.png'); ?>" alt=""><span class="text">More<br>Slideshows</span></a>
        </span>
      </div>
    </div>
    <div class="content cf">
      <ul class="thumb_list">
        <?php foreach ($thumbnails as $thumbnail){ ?>
        <li><a href="<?php echo $thumbnail['permalink']; ?>"><img src="<?php echo $thumbnail['thumb_src'] ?>" alt=""></a></li>
        <?php } ?>
      </ul>
    </div>

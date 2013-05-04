<!-- Main Gallery View  -->
<script type="text/template" id="GalleryView">
<div class='site_title'><a href='<?php echo bloginfo('home') ?>'><?php echo bloginfo('name'); ?></a></div>
<h1 class="page_title">Galleries</h1>
<div class="thumb_list_container">
</div>
<div class="pagination_container"></div>
</script>

<!-- Album Item List view  -->
<script type="text/template" id="AlbumItemView">
<li class="album_item">
  <a href="<%= permalink %>">
  <span class="thumbnail">
    <img src="<%= thumbnail_src %>" >
  </span>
  <span class="title"><%= title %></span>
  </a>
</li>
</script>

<!--  Main  Album View  -->
<script type="text/template" id="AlbumView">
<div class="row">
  <div class="left">
    <div class='site_title'><a href='<?php echo bloginfo('home') ?>'><?php echo bloginfo('name'); ?></a></div>
  </div>
  <div class="right">
    <div class="page_links">
      <a href="<%= post_url %>">View Post</a> &middot;
      <a class="navigate" href="<?php echo get_term_link('gallery', 'post_tag'); ?>"><span class="text">More galleries</span></a>
    </div>
  </div>
</div>
<h1 class="page_title"><%= album_title %></h1>
<div class="thumb_list_container"> </div>
</script>

<!-- Photo item in album view  -->
<script type="text/template" id="PhotoItemView">
<li class="photo_item">
  <a data-id="<%= ID %>" class="navigate" href="<%= permalink %>"><img src="<%= thumb_src %>" alt="" /></a>
</li>
</script>
<!-- Template para Vista General de Foto-->
<script type="text/template" id="PhotoView">
<div class="photo_view">
  <div class="row">
    <div class="left">
      <div class='site_title'><a href='<?php echo bloginfo('home') ?>'><?php echo bloginfo('name'); ?></a></div>
    </div>
    <div class="right">
      <div class="page_links">
      <a href="<%= post_url %>">View Post</a> &middot;
      <a class="navigate" href="<%= post_url %>/album">View Album</a> &middot;
      <a class="navigate" href="<?php echo get_term_link('gallery', 'post_tag'); ?>">More galleries</a></div>
    </div>
  </div>
  <h1 class="page_title"><a href="<%= post_url %>"><%= album_title %></a></h1>
  <div class="sidebar">
    <div class="main_navigation">
      <span class="previous">
      <% if(prev_photo_url){ %>
        <a class="link" href="<%= prev_photo_url %>">Previous</a>
      <% } %>
      </span>
      <div class="info">
        <span class="on"><%= order %></span> <span class="of">of</span> <span class="total"><%= total_photos %></span>
      </div>
      <span class="next">
      <% if(next_photo_url){ %>
        <a class="link" href="<%= next_photo_url %>">Next</a>
      <% } %>
      </span>
    </div>
    <div class="description">
      <%= description %>
    </div>
  </div>
  <div class="photo_container">
    <img class="full_image" src="<%= full_src %>" alt="" >
  </div>
</div>
</script>

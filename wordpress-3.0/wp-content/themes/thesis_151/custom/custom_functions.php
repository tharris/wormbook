<?php

// Using hooks is absolutely the smartest, most bulletproof way to implement things like plugins,
// custom design elements, and ads. You can add your hook calls below, and they should take the 
// following form:
// add_action('thesis_hook_name', 'function_name');
// The function you name above will run at the location of the specified hook. The example
// hook below demonstrates how you can insert Thesis' default recent posts widget above
// the content in Sidebar 1:
// add_action('thesis_hook_before_sidebar_1', 'thesis_widget_recent_posts');

// Delete this line, including the dashes to the left, and add your hooks in its place.

/**
 * function custom_bookmark_links() - outputs an HTML list of bookmarking links
 * NOTE: This only works when called from inside the WordPress loop!
 * SECOND NOTE: This is really just a sample function to show you how to use custom functions!
 *
 * @since 1.0
 * @global object $post
*/

function custom_bookmark_links() {
	global $post;
?>
<ul class="bookmark_links">
	<li><a rel="nofollow" href="http://delicious.com/save?url=<?php urlencode(the_permalink()); ?>&amp;title=<?php urlencode(the_title()); ?>" onclick="window.open('http://delicious.com/save?v=5&amp;noui&amp;jump=close&amp;url=<?php urlencode(the_permalink()); ?>&amp;title=<?php urlencode(the_title()); ?>', 'delicious', 'toolbar=no,width=550,height=550'); return false;" title="Bookmark this post on del.icio.us">Bookmark this article on Delicious</a></li>
</ul>
<?php
}



// This is currently only used for pages where I don't want to see
// the "Comments have been disabled for this post"

function single_column_no_comments() {

  get_header(apply_filters('thesis_get_header',$name));
  echo '<div id="container">' . "\n";
  echo '<div id="page">' . "\n";
  
  thesis_header_area();
  // thesis_content();
  
  echo '<div id="content_box" class="no_sidebars">' . "\n";
  
  // Display Content ( was thesis_content_column() )
  echo '<div id="content"';
  thesis_content_classes();
  thesis_hook_before_content();

  // Customize the loop to remove the "comments closed"
  // Was: thesis_page_loop();
  global $post;
  global $thesis;

  while (have_posts()) {
    the_post();
    $post_image = thesis_post_image_info('image');
		
    thesis_hook_before_post_box();
?>

      <div class="post_box top" id="post-<?php the_ID(); ?>">
	 <?php thesis_headline_area(false, $post_image); ?>
	 <div class="format_text">

<?php
	    if (get_post_meta($post->ID, '_wp_page_template', true) == 'archives.php')
	      thesis_hook_archives_template();
	    else
	      thesis_post_content(false, $post_image);
?>
	    </div>
		</div>

<?php
		thesis_hook_after_post_box();


  }

  thesis_hook_after_content();

  echo "</div>";
  echo '</div>' . "\n";
  
  thesis_footer_area();
  echo '</div>'  . "\n";
  echo '</div>' . "\n";
}



function gazette_home_page() {
  get_header(apply_filters('thesis_get_header',$name));
  echo '<div id="container">' . "\n";
  echo '<div id="page">' . "\n";
  
  thesis_header_area();
  
  echo '<div id="content_box">' . "\n";
  // thesis_content_column

  // Display Content ( was thesis_content_column() )
  echo '<div id="content"';
  thesis_content_classes();
  thesis_hook_before_content();

  // Instead just include the category

  
  // Customize the loop to remove the "comments closed"
  // Was: thesis_page_loop();
  global $post;
  global $thesis;

  while (have_posts()) {
    echo "what";
    the_post();
    $post_image = thesis_post_image_info('image');
		
    thesis_hook_before_post_box();
?>

      <div class="post_box top" id="post-<?php the_ID(); ?>">
	 <?php thesis_headline_area(false, $post_image); ?>
	 <div class="format_text">

<?php
	    if (get_post_meta($post->ID, '_wp_page_template', true) == 'archives.php')
	      thesis_hook_archives_template();
	    else
	      thesis_post_content(false, $post_image);
?>
	    </div>
		</div>

<?php
		thesis_hook_after_post_box();


  }

  thesis_hook_after_content();

  echo "</div>";

  thesis_sidebars();
  echo ' </div>' . "\n";
    
  thesis_footer_area();
  echo '</div>'  . "\n";
  echo '</div>' . "\n";
}



// This is called by embedded PHP in the Gazette Index Page
function display_issue_contents($category) {

  //The Query
  query_posts("category_name=$category");

  //The Loop
  //  if ( have_posts() ) : while ( have_posts() ) : the_post();
  echo '<div class="toc">';
  if ( have_posts() ) {
    while ( have_posts() ) {
      the_post();

      echo '<div class="entry">';
  
      // The title and submission meta
      // Needs: Links to pages, authors custom field.
      echo '<div class="title">';
      echo '<a href="' . get_permalink() . '">';
      echo get_the_title() . '</a></div>';


      // The authors
      echo '<div class="authors">';
      $id = get_the_ID();
      echo get_post_meta($id,'Authors','true');
      echo "</div>";

      // Tags
      echo '<div class="tags">';
      echo the_tags() ;
      echo "</div>";

      if ($category == "unvetted submissions") {
	// Get submitter info
	$author_name = get_post_meta($id,'Author Name','true');
	$author_home_page = get_post_meta($id,'Author Home Page','true');
	if ($author_home_page) {
	  echo "<div class=\"date\">Submitted by: <a href=\"$author_home_page\">$author_name</a></div>";
	} else {
	  echo "<div class=\"date\">Submitted by: $author_name</div>";
	}
	echo '<div class="date">Submitted on: ' . get_the_time('F j, Y') . "</div>";
      }

      echo '</div>';
    }
  }
  echo "</div>";

  //Reset Query
  wp_reset_query();
}



function archives_single_column() {

  get_header(apply_filters('thesis_get_header',$name));
  echo '<div id="container">' . "\n";
  echo '<div id="page">' . "\n";
  
  thesis_header_area();
  // thesis_content();
  
  echo '<div id="content_box" class="no_sidebars">' . "\n";
  
  // Display Content ( was thesis_content_column() )
  echo '<div id="content"';
  thesis_content_classes();
  thesis_hook_before_content();

  // Customize the loop to remove the "comments closed"
  // Was: thesis_page_loop();
  global $post;
  global $thesis;

  while (have_posts()) {
    the_post();
    $post_image = thesis_post_image_info('image');
		
    thesis_hook_before_post_box();
?>

      <div class="post_box top" id="post-<?php the_ID(); ?>">
	 <?php thesis_headline_area(false, $post_image); ?>
	 <div class="format_text">

<?php
	    if (get_post_meta($post->ID, '_wp_page_template', true) == 'archives.php')
	      thesis_hook_archives_template();
	    else
	      thesis_post_content(false, $post_image);
?>
	    </div>
		</div>

<?php
		thesis_hook_after_post_box();


  }

  thesis_hook_after_content();

  echo "</div>";
  echo '</div>' . "\n";
  
  thesis_footer_area();
  echo '</div>'  . "\n";
  echo '</div>' . "\n";
}



function add_category_archives() {
  if (is_page('page')) {
    $archive_query = new WP_Query('showposts=1000&category_name=Category');
    if ($archive_query->have_posts()) echo '<h2>Category Posts</h2>';
    $post_count = 1;
    while ($archive_query->have_posts()) {
      $archive_query->the_post();
?>
	<div class="post_box hentry<?php if ($post_count == 1) echo(' top'); ?>">
	   <?php thesis_headline_area(); ?>
	   </div>

<?php
	       $post_count++;
    }
  }
}
add_action('thesis_hook_after_content', 'add_category_archives');
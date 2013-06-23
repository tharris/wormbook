<?php


// UPDATE WITH EACH NEW RELEASE.
// Specific items need to be updated whenever a new issue is released.
// Search for the phrase above for these entries.


// *********************************************************************
//
//       GENERAL FORMATTING
//
// *********************************************************************

// Get rid of the horrible curly quotes
remove_filter('the_content', 'wptexturize');
remove_filter('comment_text', 'wptexturize');



function limits($key) {  
  $my_limits = array( 'authors'      => 22,
		      'references'   => 6,
		      'affiliations' => 7,
		      'figures'      => 3,
		      );
  return $my_limits[$key];
}



// *********************************************************************
//
//       CUSTOM TEMPLATE FUNCTIONS
//
// *********************************************************************

// Custom loops, using the Thesis 1.8 Loop API
$loops = new my_custom_loops;

class my_custom_loops extends thesis_custom_loop {

  ////////////////////////////////////////////////
  //
  // Archive pages: new loop
  // using Thesis 1.8 loop API
  function archive() {

    //    echo '<div id="content_box" class="narrow_box">' . "\n";
    //    echo "archive";
    //if (is_tax()) {
    //  echo "axoomy";
    //}
    thesis_hook_before_post_box();          
      ?>
      <div class="post_box top" id="post-<?php the_ID(); ?>">
	 
	 <?php
	 	 
	 // Volumes are a custom taxonomy 
	 // We need to extract the data a bit differently.
	 $fields = get_article_volume_details($post->ID);
    $name = $fields[0];
    $date = $fields[1];
    $slug = $fields[2];
	
    
    // Dynamically insert the cover from the issue
    echo '<div id="cover-image-solo"><a href="/wbg/volumes/' 
      . $slug
      . '/cover-large.jpg"><img src="/wbg/volumes/' 
      . $slug 
      . '/cover-small.jpg" /></a></div>';
    
    echo '<div class="headline_area">';
    echo '<h1 class="entry-title">From The Archive: ' . $name . ' (' . $date . ')</h1>';
    
    // wbg/volumes/volume-18-number-1/pdf/
    echo '<div id="pdf-issue"><a href="/wbg/volumes/'
      . $slug
      . '/pdf/'
      . "wbg-$slug.pdf"
      . '" title="Download issue as a single PDF"><img class="pdf-icon" src="/wbg/i/pdf.png" />Full issue in PDF</a></div>';
    echo "</div>";
    
    echo '<div class="format_text">';
    
    display_issue_contents($name,$slug);
    
    echo "</div>";
    echo "</div>";
    
    //	 thesis_hook_after_post_box();    
    //thesis_hook_after_content();
    echo "</div>";	 	 
  }
  
  
  
  ////////////////////////////////////////////////
  //
  // A single column page with no comments.
  //   Used for
  //      * Instructions for authors (68)
  //      * About (2)
  //      * Citing the Gazette (178)
  //      * Gazette Archive (list of all issues) (91)
  //      * News
  function page() {
    if (is_page('68') || is_page('2') || is_page('178')  || is_page('91')  || is_page('845')) {
      
      echo '<div id="content_box" class="narrow_box">' . "\n";
      // Display content ( derived from thesis_content_column )
      echo '<div id="content">';
      thesis_content_classes();
      thesis_hook_before_content();
      
      // Customize the loop and remove the "comments closed"
      // Was: thesis_page_loop();
      global $post;
      global $thesis;
      
      while (have_posts()) {
	the_post();
	$post_image = thesis_post_image_info('image');
	
	thesis_hook_before_post_box();
	  ?>
	  
	  <div class="post_box top" id="post-<?php the_ID(); ?>">
	     <?php custom_thesis_headline_area(false, $post_image); ?>
	     <div class="format_text">
		
		<?php thesis_post_content(false, $post_image); ?>
		</div>
		    </div>
		    
		    <?php
		    thesis_hook_after_post_box();
      }
      
      thesis_hook_after_content();
      
      echo "</div>";
      echo '</div>' . "\n";
      
      // My prepress page, mimics the index page.
    } elseif (is_page('2437')) {
      front_page(0);
    } else {      
      thesis_loop::page();
    }
  }
  
  
  ////////////////////////////////////////////////
  //
  // gazette_home_page: The Home Page for the WBG
  // Displays the current volume contents
  function front() {
    front_page(0);
  }
  
  function single() {
    thesis_loop::single();
  }  
}



// The generic front page, used for both the front page and for the prepress proof.
function front_page($slug) {
  echo '<div id="content">';
  //    thesis_content_classes();
  //    echo ">";    
  //thesis_hook_before_content();
  
  // Customize the loop
  // We will only include entries from the current
  // issue specified as a variable in the page content itself.
  global $post;
  global $thesis;  
  
  while (have_posts()) {
    the_post();
    $post_image = thesis_post_image_info('image');
    
    thesis_hook_before_post_box();          
      ?>
      <div class="post_box top" id="post-<?php the_ID(); ?>">
	 
	 <?php
	 
	 // Stick in the current cover, floating left with the TOC wrapping around it.
	 // TODO
	 // This should be DYNAMIC and should LINK TO the current cover
	 //	 echo '<div id="cover-image-solo">
	 //      <a href="/wbg/volumes/current-cover-large.jpg">
	 //            <img src="/wbg/volumes/current-cover.jpg" width="250px" />
	 //      </a>
	 // </div>';
	 
	 // Cover images should be dynamic but I don't know what volume I am processing yet. Boo.	 
	 echo '<div id="pseudo-sidebar">';
//    echo '<div id="cover-image">
//                    <a href="/wbg/volumes/current-cover-large.jpg">
//                   <img src="/wbg/volumes/current-cover.jpg" />
//                 </a>

    echo '<div id="cover-image">
                    <a href="/wbg/volumes/current-cover-large.jpg">
                    <img src="/wbg/volumes/current-cover.jpg" />
                    <br />
		    <a href="/wbg/volumes/current-backcover-large.jpg">
                    <img class="cover-with-border" src="/wbg/volumes/current-backcover.jpg" />
                </a>
 
                 </div>';

    // UPDATE WITH EACH NEW RELEASE. Change the future volume and date as appropriate.
    echo '<div id="big-note">
	   <h3>Next Worm Breeder\'s Gazette</h3>
           <p class="noindent">


	   The next issue of the Worm Breeder\'s Gazette (Volume 19, #4) will be released in August 2013.  The <b>submission deadline</b> is <b>01 August, 2013</b>.</p>


          <h3>Stay up-to-date!</h3>
          <p class="noindent">Subscribe for updates to the WBG by <a href="http://feedburner.google.com/fb/a/mailverify?uri=TheWormBreedersGazette&amp;loc=en_US">email</a> or <a href="http://feedburner.google.com/TheWormBreedersGazette">RSS</a>.
          </p>
         
          <div class="readmore"><a href="/wbg/news/">read more...</a></div>
';
    
    //	 echo '<p class="noindent">
    //      <a href="http://feedburner.google.com/fb/a/mailverify?uri=TheWormBreedersGazette&amp;loc=en_US">Subscribe to The Worm Breeder\'s Gazette by Email</a>
    // </p>';
    
    echo '</div></div>';
    
    
    // The content of the post
    // The page content should specify the category name of the current
    // issue. It will make calls to display_issue_contents() 
    // and thesis_hook_after_headline.
    
    // This is really PAGE content...
    thesis_post_content(false, $post_image); 
    echo "</div>";
    echo "</div>";
    
    thesis_hook_after_post_box();
  }
  thesis_hook_after_content();
  
  echo "</div>";
  
  // To use dynamic sidebars, uncomment this.
  // thesis_sidebars();
  
  // Instead we will over-ride Thesis's sidebar build
  // on the home page. The WBG theme as a whole will
  // be single column, but the home page will LOOK
  // like it has a sidebar. 
  //    echo '<div id="sidebars">';
  //echo '			<div id="sidebar_1" class="sidebar">' . "\n";
  //echo '				<ul class="sidebar_list">' . "\n";
  //echo '<img src="/wbg/i/covers/current-cover.jpg" width="250px" />';
  //echo '</ul></div></div>';
  
  echo ' </div>' . "\n";
}








// ******************************************************
//
//       BOILERPLATE FORMATTING
//
// ******************************************************

// Remove the comments thing. It's ugly.
// This is a filter.
function wbg_comments_intro($content) {
  $content = '<div id="respond_intro">';
  $content .= '<p>Comments</p>';
  $content .= '</div>' . "\n";
  return $content;
}
add_filter('thesis_comments_intro', 'wbg_comments_intro');



// The Generic Gazette header
function add_header() {
?>
 <div id="header-left">
    <p id="logo">
      <a href="/wbg/">
      <img src="/wbg/i/banner_small.png" alt="The Worm Breeder's Gazette" width="800px" />
      </a>
    </p>
  </div>
<?php
 
}

remove_action('thesis_hook_header','thesis_default_header');
add_action('thesis_hook_header','add_header');


# Add the search box to the navigation bar.
function _search_box() {
  
?>
<div class="widget thesis_widget_search">
<form method="get" class="search_form" action="http://dev.wormbook.org/wbg/">
<input class="text_input" type="text" 
       value="Search the Gazette" 
       name="s" 
       id="s" onfocus="if (this.value == 'To search, type and hit enter') {this.value = '';}" onblur="if (this.value == '') {this.value = 'To search, type and hit enter';}" />
<input type="hidden" id="searchsubmit" value="Search" />
</form>
</div>

<?php
}
add_action('thesis_hook_last_nav_item', 'thesis_search_form');



// Add in a custom footer
function add_footer() {
  ?>
 
 <div style="float:left">
    <span style="border-right:1px solid #DDDDDD;float:left;padding-right:10px;margin-right:10px">
    <a href="http://www.wormbook.org">
    <img width="125px" src="/images/wormbook_sponsor.png" />
    </a>
    </span>
    <span style="border-right:1px solid #DDDDDD;float:left;padding-right:10px;margin-right:10px">
    
    <a href="http://creativecommons.org/licenses/by/2.5/" target="_blank">
    <img style="float:left;border:0" src="/images/somerights20.gif" align="middle" alt="Creative Commons License"/>
    </a>
    </span>
    </div>
    
    <div>    
    All content, except where otherwise noted, is licensed under a
    <a href="http://creativecommons.org/licenses/by/2.5/" title="Creative Commons Attribution License" target="_blank">
    Creative Commons Attribution License.
    </a>
    <br />
    General information about the Worm Breeder's Gazette on this page is copyrighted under the 
      <a href="/db/misc/copyright_gfdl">GNU Free Documentation License</a>.
</div>

<?php
}
remove_action('thesis_hook_footer','thesis_footer_scripts');
add_action('thesis_hook_footer','add_footer');
// Remove thesis attribution
remove_action('thesis_hook_footer','thesis_attribution');


// Move the navigation menu BELOW the header.
// We have to remove it from the before_header_hook
remove_action('thesis_hook_before_header','thesis_nav_menu');
add_action('thesis_hook_after_header','thesis_nav_menu');

add_action('thesis_hook_after_header','alert_box');


// UPDATE WITH EACH NEW RELEASE
function alert_box() {
    if (is_front_page() || is_page('2437')) {

    // Add in an alert. Oof. This should be manageable 
    // in the interface itself.
    echo '<div id="index-alert">
   <h3>Submit an article for the next Worm Breeder\'s Gazette</h3>
  <div class="readmore">
<a target="_blank" href="http://www.wormbook.org/wbg/wp-login.php?action=register">Register</a> or <a target="_blank" href="http://www.wormbook.org/wbg/wp-login.php">Log In</a> to get started. Submit your article online!</div>

<!--
<div class="deadline">
     Submission deadline: 1 June 2012.
</div>
-->

</div>';
}
}



function previous_next_article() {
        global $thesis;

//        if (is_single() && $thesis['display']['posts']['nav']) {
        if (is_single()) {
        
            echo '<div class="prev_next post_nav">' . "\n";
	    echo '<div class="previous">';

            $id = get_the_ID();

            // Volumes are custom taxonomies
	    $fields = get_article_volume_details($post->ID);
	    $volume = $fields[0];
	    $date = $fields[1];
	    $slug = $fields[2];
            $post_order = get_post_meta($id,'_wbg_publish_order',true);
            $pdf  = "wbg-$slug.$post_order.pdf";
        
            echo '<span>' . $volume . ': </span>';

            echo '<a href="/wbg/archives/' . $slug . '/">contents</a>';

           // PREVIOUS is really NEXT when thinking of a magazine
           previous_post_link_plus( array(
                    'order_by' => 'custom',
                    'meta_key' => '_wbg_publish_order',
                    'max_length' => 0,
                    'format' => '&laquo; %link',
                    'link' => 'previous',
                    'before' => ' |',
                    'after' => '',
                    'in_same_cat' => true,
                    'ex_cats' => '',
                    'num_results' => 1,
                    'echo' => true
                    ) );

            // These posts should be limited to the current category (issue)
            // NEXT is really PREVIOUS for when thinking of a magazine
            next_post_link_plus( array(
                    'order_by' => 'custom',
                    'meta_key' => '_wbg_publish_order',
                    'max_length' => 0,
                    'format' => '%link &raquo;',
                    'link' => 'next',
                    'before' => ' |',
                    'after' => '',
                    'in_same_cat' => true,
                    'ex_cats' => '',
                    'num_results' => 1,
                    'echo' => true
                    ) );

           // Provide a link to the PDF using the category slug
           // and the name of the PDF file.
      
           echo '<div class="navigation-meta">';
           echo "<a title=\"Download a PDF of this article\" href=\"/wbg/volumes/$slug/pdf/$pdf\">
							  Download as PDF
							  </a> | ";

      // Provide a dynamic link to comments - will display the number of comments if there are any.
      echo '<a href="#respond">';
	     comments_number('Submit a comment', '1 comment', '% comments');
      echo "</a>";
      echo "</div>";

    echo '</div>' . "\n";
   echo '</div>' . "\n";
   }
}


// REMOVE THEM FROM THEIR DEFAULT LOCATION
// ... AND PLACE THEM ABOVE THE POST BOX
remove_action('thesis_hook_after_content','thesis_prev_next_posts');
//add_action('thesis_hook_before_post_box','previous_next_article');
add_action('thesis_hook_before_headline','previous_next_article');
// OR Below the posts and comment form
// add_action('thesis_hook_after_content','previous_next_article');



// Add some caveats to the comment form.
function comment_caveats() {
?>
<div class="comment-caveat">
   Your email address will not be displayed and will never be shared or distributed.<br /><br />
   Your comment will be held for moderation. The Worm Breeder's 
    Gazette editors reserve the right to refuse offensive or inappropriate comments.

</div>
<?php
    }
add_action('thesis_hook_comment_form_top','comment_caveats');






// ******************************************************
//
//       Issue-wide and single post processing
//
// ******************************************************



// Custom post type articles: need a differnet mechanism of accessing articles.
function get_article_volume_details ($id) {
  $terms = get_the_terms($id,'volume');
  foreach ($terms as $taxindex => $taxitem) {
    $name = $taxitem->name;
    $date = $taxitem->description;
    $slug = $taxitem->slug;
    return array($name,$date,$slug);
  }
}



// display_issue_contents: a brief listing of an issue
// Should be supplied with a category name
// The category name is one of 'Volume XX, Number XX'
// Queries of custom post type Articles need to use the slug.
function display_issue_contents($category,$slug) {
  
  //The Query - custom post type wbg_abstracts
  $args = array(
		  'taxonomy'  => 'volume',
		  'term'      => $slug,
		  'post_type' => 'wbg_abstracts',
		  'posts_per_page' => 100,
		  'caller_get_posts'=> 1,
		  'orderby'   => 'meta_value_num',
		  'meta_key'  => '_wbg_publish_order',
		  'order'     => 'ASC',
		  );
  query_posts($args);
  
  //The Loop
  echo '<div id="toc">';
    
  if ( have_posts() ) {
    while ( have_posts() ) {
      the_post();
      
      echo '<div class="entry">';
      // The title
      // Needs: Links to pages, authors custom field.
      // This is the post title
      echo '<div class="title">';
      echo '<a href="' . get_permalink() . '">';
      echo get_the_title() . '</a></div>';
      
      // The authors
      _display_authors('TOC');
      
      // The Tags
      _display_tags();
      
      if ($category == "unvetted submissions" && current_user_can('administrator')) {
	
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



// Content blocks for both TOC and individual pages.
// Context should be one of 'TOC' for table of contents
// or 'single' fo individual abstract pages.
function _display_authors($context) {

  $id = get_the_ID();
  echo '<div class="authors">';

  // Create an array of formatted names, then join them together.
  // NUMBER OF AUTHORS HARD-CODED HERE AND IN meta_boxes
  $authors      = array();
  for ($count = 0 ; $count<limits('authors'); $count++) {
    
    $key = "_wbg_author_firstname_" . $count;
    $firstname = get_post_meta( $id, $key, true );
    
    $key = "_wbg_author_lastname_" . $count;
    $lastname = get_post_meta( $id, $key, tre );
    
    if ( $firstname ) {
      $authors[$count] = "$firstname $lastname";
    } 
  }
  
  // Single page?  We need to add in affiliations, too. Meh.
  // Create an array that maps authors2affiliations
  $affiliations = array();
  $affiliations2authors = array();
  if ($context == 'single') {      
    for ($affiliation=0;$affiliation<limits('affiliations');$affiliation++) {
      
      //	// Fetch the first affiliation (not actually necessary here)
      //$name = '_wbg_affiliation_' . $affiliation;
      //$existing_data = get_post_meta( $id, $name, true );
      //$affiliations[$affiliation] = $existing_data;
      
      // affiliations2authors
      for ($author=0;$author<limits('authors'); $author++) {
	// One check box for every single author instead of a group. Ugh.
	$name = '_wbg_affiliations2authors_paper_' . $affiliation . '_author_' . $author;
	$existing_data = get_post_meta( $id, $name, true );
	
	if ($existing_data) {
	  // Authors can have multiple affiliations.
	  // Create a formatted string here. I hate PHP.
	  $current = $affiliations2authors[$author];
	  if ($current) {
	    $affiliations2authors[$author] = "$current," . ($affiliation+1); // array is zero-based but we don't want affiliations to be
	  } else {
	    $affiliations2authors[$author] = ($affiliation+1); // array is zero-based but we don't want affiliations to be
	  }
	}
      }
    }
  }
    
  // Create a formatted author string
  $string = _create_author_formatted_string($authors,$affiliations2authors,$context);
  echo $string;
  echo "</div>";
}      






function _display_figures() {
  global $post;
  
  // Using Custom Field Templates for images and figure legends
  
  for ($i=1;$i<=3;$i++) { 
    // Get the image ID
    $img_id = get_post_meta($post->ID, "Figure $i",true);
    
    if ($img_id) {

      // Add a header, but only if we have images.
      if ($i == 1) {
	echo "<h3>Figures</h3>";
      }

      // Open the image div
      echo "<div class=\"figure-box\">";

      // Is this an image? Fetch a thumbnail and dump it.
      if (wp_attachment_is_image($img_id)) {
	
	// Other sizes: thumnbail, medium, large, full or
//	$img = wp_get_attachment_image($img_id , 'thumbnail' ) ;
	$img = wp_get_attachment_image($img_id , 'medium' ) ;

	// Get the src
	$src = wp_get_attachment_image_src($img_id , 'full' );
//	$src = wp_get_attachment_image_src($img_id , 'small' );
	// $img = wp_get_attachment_image($img_id , 'attachment-160x160' ) ;	
            
	// Get the figure legend, if one exists.
	$legend = get_post_meta($post->ID, "Figure $i Legend",true);

	// Dump out the image with lightbox parameters
	$encoded = htmlentities($legend);
	echo "<a href=\"$src[0]\" width=\"$src[1]\" height=\"$src[2]\" title=\"$encoded\" class=\"lightbox\" rel=\"wbg\">$img</a>";

	echo "<div class=\"caption\"><b>Figure $i</b>"; 
	if ($legend) {
	  echo ": $legend";
	}
	echo "</div>";
      } else {
	// Not an image. Maybe it's a video.
	$url = wp_get_attachment_url($img_id); 

        echo "<embed src=\"$url\" width=\"100\" href=\"$url\" autohref=\"false\" type=\"video/quicktime\" width=\"300px\" class=\"movie\" target=\"_blank\">";

	// Get the figure legend, if one exists.
	$legend = get_post_meta($post->ID, "Figure $i Legend",true);

	// Dump out the image with lightbox parameters
	$encoded = htmlentities($legend);

	echo "<div class=\"caption\"><b>Figure $i</b>"; 
	if ($legend) {
	  echo ": $legend</div>";
	}
      }
      
      // close the figure-box div
      echo "</div>";      
    }
  }
}


function _display_references() {

  $id = get_the_ID();
  
  $references = array();
  
  if (is_single()) {
    for($i=0;$i<=limits('references');$i++) {
      
      $name = '_wbg_reference_' . $i; 
      $existing_data = get_post_meta( $id, $name, true );
      
      $pmid = '_wbg_pmid_' . $i;
      $pmid_existing_data = get_post_meta( $id, $pmid, true );	
      
      if ($pmid_existing_data) {
	$link = 'http://www.ncbi.nlm.nih.gov/entrez/query.fcgi?db=pubmed&cmd=retrieve&dopt=abstract&list_uids=' . $pmid_existing_data;
	//	  $existing_data .= ' [<a target="_blank" href="' . $link . '">PubMed</a>]';
	$existing_data .= ' <a target="_blank" href="' . $link . '"><img src="/images/pubmed_button.gif" alt="PubMed" /></a>';
      }
      
      if ($existing_data) {
	array_push($references,$existing_data);
      }
    }
    
    sort($references);
    foreach ($references as $index => $reference) {
      if ($index == 0) {  // Make sure there are references before printing them
	echo "<h3>References</h3>";	 
      }
      echo "<p class=\"reference\">$reference</p>";
    }
  }
}


add_action('thesis_hook_after_post','_display_figures');
add_action('thesis_hook_after_post','_display_references');


// Authors <-> affiliations
function _display_affiliations() {
  
  $id = get_the_ID();
  echo '<div class="affiliations">';
      
  $string;
  for ($affiliation=0;$affiliation<limits('affiliations');$affiliation++) {
    
    // Fetch the first affiliation (not actually necessary here)
    $name = '_wbg_affiliation_' . $affiliation;
    $existing_data = get_post_meta( $id, $name, true );
    
    if ($existing_data) {
      //	$affiliations[$affiliation+1] = $existing_data;
      if ($string) {
	$string .= ', ';	  
      }
      $string .= '<sup>' . ($affiliation+1) . '</sup>' . $existing_data;
    }
  }
  
  echo $string;
  echo "</div>";  
}

function _display_tags() {
    echo '<div class="tags">';
    echo the_tags() ;
    echo "</div>";
}

function _display_correspondence_to() {
  
  $id = get_the_ID();
  
  $correspondence;
  
  // Create an array of formatted names, then join them together.
  // NUMBER OF AUTHORS HARD-CODED HERE AND IN meta_boxes
  // Walk through authors to find 
  $authors      = array();
  for ($count = 0 ; $count<limits('authors'); $count++) {
    
    $key = "_wbg_author_is_corresponding_" . $count;
    $is_corresponding = get_post_meta( $id, $key, true );
    
    if ($is_corresponding) {
      $key = "_wbg_author_firstname_" . $count;
      $firstname = get_post_meta( $id, $key, true );
      
      $key = "_wbg_author_lastname_" . $count;
      $lastname = get_post_meta( $id, $key, tre );
      
      $key = "_wbg_author_email_" . $count;
      $email = get_post_meta( $id, $key, tre );


      // Strip off the WormBook attribution.
      $lastname = preg_replace('/, editor of the[\w\W]+section of WormBook/','',$lastname); 
      
      if ( $firstname ) {
	//	  $authors[$count] = "$firstname $lastname";
	//	} 
	if ($correspondence) {
	  $correspondence .= ", $firstname $lastname (<a href=\"mailto:$email\">$email</a>)";
	} else {
	  $correspondence .= "$firstname $lastname (<a href=\"mailto:$email\">$email</a>)";
	}
      }
    }
  }  

  
  if ($correspondence) {
    echo '<div class="correspondence-to">';
    echo "Correspondence to: ";
    echo $correspondence;
    echo "</div>";       
  } 
}


function _create_author_formatted_string($array,$auth2affiliations,$context) {
  
  $join =',';
  $size = count($array);    
  $string;
  if ($size == 1) {
    if ($context == 'single') {
      $string = $array[0];
    } else {
      $string = "$array[0]<sup>$auth2affiliations[0]</sup>";
    }
  } elseif ($size == 2) {    
    if ($context == 'single') {
      $string = "$array[0]<sup>$auth2affiliations[0]</sup> and $array[1]<sup>$auth2affiliations[1]</sup>";
    } else {
      $string = join(" and ",$array);
    }
  } else {
    
    for ($i=0;$i<$size;$i++) {
      //      echo "i: $i $array[$i]<br />";
      if ($i == 0) {
	$string = $array[$i];
      } elseif ($i < $size - 1 ) {
	$string .= "$join $array[$i]";
      } elseif ($i == $size - 1) {
	$string .= " and $array[$i]";
      } else {
	$string .= $array[$i];
      }
        
      // Single page?  We need to add in affiliations, too. Meh.
      if ($context == 'single') {
	$affiliations = $auth2affiliations[$i];
	$string .= "<sup>$affiliations</sup>";
      }
    }
  }
  
  return $string;
}





// Try to create a general guideline
// limiting the length of a submission.
// This would be used during submission preview.
function _calculate_submission_limits() {
  global $post;
  
  if ( ! is_preview() ) {
   return;
  }

  // Also keep track of total word counts;
  $total_word_count = 0;

  // Count how many images we have.
  $image_count = 0;
  for ($i=1;$i<=3;$i++) { 
    // Get the image ID
    $img_id = get_post_meta($post->ID, "Figure $i",true);
    
    if ($img_id) {
      $image_count++;
      
      // Get the figure legend, if one exists.
      $legend = get_post_meta($post->ID, "Figure $i Legend",true);
      if ($legend) {
	$total_word_count += str_word_count(strip_tags($legend));	
      }
    }
  }
   
  // Count the number of references
  $reference_count = 0;
  for($i=0;$i<=limits('references');$i++) {
    
    $name = '_wbg_reference_' . $i; 
    $existing_data = get_post_meta( $id, $name, true );
    
    if ($existing_data) {
      $reference_count++;
	$total_word_count += str_word_count(strip_tags($existing_data));	
    }
  }

  // Finally, get the length of the abstract.
  $abstract_word_count = str_word_count(strip_tags($post->post_content));
  $total_word_count += $abstract_word_count;	
  //  echo "reference count: $reference_count<br />";
  //  echo "image_count : $image_count<br />";
  //  echo "abstract word count  : $abstract_word_count<br />";
  //  echo "total word count     : $total_word_count<br />";

  // Finally, set some standards.
  $approach = 2;


  $directions_to_fix = "Because you are seeing this message, your abstract is too long. Please return to the edit screen and reduce the length of your abstract.  If you do not, the Worm Breeder's Gazette editors reserve the right to edit your submission to comply with these guidelines.";
  
  // Possible approaches  
  // 1. Reduce max allowed according to the number of references and images. Max allowed pertains ONLY to abstract text.
  if ($approach == 1) {
    $base_max_allowed_words = 750;    
    
    // For every image, we subtract 50 words.
    $adjusted_max_allowed_words = $base_max_allowed_words - ($image_count * 50);
    
    // For every reference, we substract 50 words;
    $adjusted_max_allowed_words = $adjusted_max_allowed_words - ($reference_count * 50);
    
    if ($abstract_word_count > $adjusted_max_allowed_words) {
      $message = "In keeping with the brief, single page submissions of the original Worm Breeder's Gazette, we restrict the abstract length of new submissions to <b>$base_max_allowed_words</b> words. We further reduce the number of allowed words by 50 for each figure and reference included with a submission.";
      $message .= " Given the number of references ($reference_count) and figures ($image_count) submitted, your abstract text can be no longer than <b>$adjusted_max_allowed_words</b> words.  <b>Your abstract text is currently $abstract_word_count words long.</b>";
    }
    
    
    // 2. Simply set a limit for ALL text and ignore the presence of figures.
  } elseif ($approach == 2) {   
    $max_allowed_words = 750;
    if ($total_word_count > $max_allowed_words) {
      $message = "In keeping with the brief, single page submissions of the original Worm Breeder\'s Gazette, we restrict the total word count of new submissions (including figure legends and references) to $max_allowed_words.  Your total text count is now <b>$total_word_count</b> words long.";
    }
    
  } elseif ($approach == 3) {
  // 3. Combination. Set a limit for all text, and reduce max allowed if there are figures.
    // Um. This is the same as 1.
  }
  
  if ($message) {
    print "<div style=\"border:3px solid red;background-color:pink;padding:0px 30px 30px 30px;margin-bottom:20px;font-size:1.2em\"><h2>Submission Too Long</h2><p class=\"noindent\">$message</p><p class=\"noindent\">$directions_to_fix</p></div>";
  }

}
add_action('thesis_hook_before_post','_calculate_submission_limits');



function _check_required_fields() {

 if ( ! is_preview() ) {
   return;
  }
 
 // Ignore previews of the home page or the prepress index.
 if (is_front_page() || is_page('2437')) {
   return;
 }

  $id = get_the_ID();

  // Make sure there is at least ONE affiiation
  $have_affiliations = '';
  for ($affiliation=0;$affiliation<limits('affiliations');$affiliation++) {  
    $name = '_wbg_affiliation_' . $affiliation;
    $existing_data = get_post_meta( $id, $name, true );
    if ($existing_data) {
      $have_affiliations = 1;
    }
  }
  
  // Is there a corresponding author
  $have_corresponding_author = '';
  for ($count = 0 ; $count<limits('authors'); $count++) {
      $key = "_wbg_author_is_corresponding_" . $count;
      $is_corresponding = get_post_meta( $id, $key, true );
      if ($is_corresponding) {
	$have_corresponding_author = 1;
      }
  }
  
  $messages = array();
  if ( ! $have_affiliations) {
    array_push($messages,
	       'No affiliations indicated. You must supply ast least one affiliation before submitting your abstract for consideration.');
  }

  if ( ! $have_corresponding_author ) {
    array_push($messages,
	       'No corresponding author indicated. You must specify at least one corresponding author.');
  }
  
  $message = join('<br><br>',$messages);

  if ($message) {

    $directions_to_fix = "Problems detected with your submission. Please return to the edit page and fix the following ";
    if ( count($messages) > 1 ) {
      $directions_to_fix .= 'issues:';
    } else {
      $directions_to_fix .= 'issue:';
    }

    print "<div style=\"border:3px solid red;background-color:pink;padding:0px 30px 30px 30px;margin-bottom:20px;font-size:1.2em\"><h2>Alert!</h2><p class=\"noindent\"><b>$directions_to_fix</b></p><p class=\"noindent\">$message</p></div>";
  }
}
add_action('thesis_hook_before_post','_check_required_fields');





// Provide a custom thesis_headline_area.
// This is the headline for a given post
// This is a component of thesis_hook_headline but there isn't a specific
// hook for this function.
function custom_thesis_headline_area($post_count = false, $post_image = false) {
  
  /* We're not setting up the headline area for the front page */
  if (is_front_page() || is_page('2437')) {  
    return true;
  }
  
  echo '<div class="headline_area">';
  
  thesis_hook_before_headline($post_count);
  
  if ($post_image['show'] && $post_image['y'] == 'before-headline')
    echo $post_image['output'];
  
  if (is_404()) {
    echo '<h1>';
    thesis_hook_404_title();
    echo '</h1>' . "\n";
  } elseif (is_page()) {
    if (is_front_page() || is_page('2437')) {
      // Suppress the page title on the front page
      // echo '<h2>' . get_the_title() . '</h2>' . "\n";
   

    } else {
      echo '<h1>' . get_the_title() . '</h1>' . "\n";
      
      if ($post_image['show'] && $post_image['y'] == 'after-headline')
	echo $post_image['output'];
      
      thesis_hook_after_headline($post_count);
      thesis_byline();
    }


  // Single post pages.
  } else {   
    if (is_single()) {      
      echo '<h1 class="entry-title">' . get_the_title() . '</h1>';      
    } else {
  ?>
 <h2 class="entry-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent link to <?php the_title(); ?>">
    <?php the_title(); ?>
    </a>
	</h2>
	<?php
	}
    
    if ($post_image['show'] && $post_image['y'] == 'after-headline')
      echo $post_image['output'];
    
    thesis_hook_after_headline($post_count);
    thesis_byline($post_count);
    thesis_post_categories();
  }

  echo '</div>';
}
 

// Add custom fields meta data to single posts after the post headline.
// This pulls data from the custom fields.
function add_meta_data_after_post_headline() {
  
  if (is_single()) {
    echo '<div class="post-meta">';
    
    // The authors
    _display_authors('single');
    
    // Affiliations
    _display_affiliations();
    
    _display_correspondence_to();
    
    echo "</div>";
  }
}
add_action('thesis_hook_after_headline','add_meta_data_after_post_headline');






// Volume 18, Nos. 1 & 2 were entered as Posts
// before I had written the custom Abstracts
// post type. They require special formatting
// This function acts as a simple boolean.

// 2010.12.18: Now deprecated: moved all articles into their own structure.
//   but the logic here is pretty useful for other tasks, too.
function is_legacy($category) {
  return false;
  if ($category) {
    //    if ($category == 'Volume 18, Number 1' || $category == 'Volume 18, Number 2') {
    if ($category == 'Volume 18, Number 1') {
      //isset($categories[0])) {
      return true;
    } else {
      return false; 
    }
  } else {
    $categories = get_the_category(',');
    
    //    if ($categories[0]->cat_name == 'Volume 18, Number 1' || $categories[0]->cat_name == 'Volume 18, Number 2') {
    if ($categories[0]->cat_name == 'Volume 18, Number 1') {
      //isset($categories[0])) {
      return true;
    } else {
      return false; 
    }
  }
}




////////////////////////////////////////////////
//
// WBG Submissions
//

// Build up custom entries in the admin interface.
// This is MOSTLY for administrative purposes (ie correcting errors)

add_action('admin_menu', 'wbg_add_meta_boxes');
add_action('save_post', 'wbg_save_meta');

function wbg_add_meta_boxes() {
  $meta_boxes = wbg_meta_boxes();
  foreach ($meta_boxes as $meta_box) {

    // Processed information is only visible to moderators/admins
    if ($meta_box['id'] == 'wbg-admin-meta' && current_user_can('contributor')) {
    } else {
      add_meta_box($meta_box['id'], $meta_box['title'], $meta_box['function'], 'wbg_abstracts', 'normal', 'high');
    }
  }
}



//function wbg_save_meta($post_id) {
function wbg_save_meta() {
  global $post;
  $post_id = $post->ID;
  $meta_boxes = wbg_meta_boxes();
  
  // We have to make sure all new data came from the proper Thesis entry fields
  //	foreach($meta_boxes as $meta_box) {
	//	  if (!wp_verify_nonce($_POST[$meta_box['noncename'] . '_noncename'], plugin_basename(__FILE__)))
	//	    return $post_id;
	//	}
	
	//	if ($_POST['post_type'] == 'page') {
	//	  if (!current_user_can('edit_page', $post_id))
	//	    return $post_id;
	//	}
	//	else {
	//	  if (!current_user_can('edit_post', $post_id))
	//	    return $post_id;
	//	}
	
	// If we reach this point in the code, that means we're authenticated. Proceed with saving the new data	
	// Iterate through the meta boxes.
	foreach ($meta_boxes as $meta_box) {
	  	 
	    // authors: Need to deal with programmatically
	    //     author_firstname_$index, author_lastname_$index, author_is_corresponding_$index, author_email_$index 
	    if ($meta_box['id'] == 'wbg-authors-meta') {
	  
	      for ($index=0;$index<limits('authors');$index++) {
		foreach ($meta_box['fields'] as $meta_field) {

		  // Create the name for the field. Must match!
		  $name = $meta_field['name'] . '_' . $index;

		  // Add, delete, or update the data		
		  _do_add_meta($post_id,$name,$meta_field['default']);
		}
	      }
		// affiliations: need to deal with programmatically	     
	    } elseif ($meta_box['id'] == 'wbg-affiliations-meta') {

	      for ($index=0;$index<limits('affiliations');$index++) {
		
		$count   = 0;
		foreach ($meta_box['fields'] as $meta_field) {
		  $count++;
		  
		  // Affiliations
		  if ($count == 1) {	  
		    // Create a name for this field. It just has the index appended.
		    $name = $meta_field['name'] . '_' . $index;
		    
		    _do_add_meta($post_id,$name,$meta_field['default']);
		  }
		    
		  // affiliations2authors
		  if ($count == 2) {	  
		    for ($authorid=0;$authorid<limits('authors'); $authorid++) {
		      $name = $meta_field['name'] . '_paper_' . $index . '_author_' . $authorid;

		      //    // This is the default save routine, now a separate function.
		      //    // It doesn't wor as _do_add_meta, so it's replicated here five times. Great.
		      _do_add_meta($post_id,$name,$meta_field['default']);
		    }
		  }
		}
	      }
	      
	      // references: need to deal with programmatically
	    } elseif ($meta_box['id'] == 'wbg-references-meta') {
	      
	      for ($index=0;$index<limits('references');$index++) {		
		foreach ($meta_box['fields'] as $meta_field) {
		  //		foreach ($meta_box['fields'] as $meta_id => $meta_field) {
		  
		  // Create a name for this field. It just has the index appended.
		  $name = $meta_field['name'] . '_' . $index;

		  // This is the default save routine, now a separate function.
		  // It doesn't wor as _do_add_meta, so it's replicated here five times. Great.
		  _do_add_meta($post_id,$name,$meta_field['default']);		  
		}
	      }


	      
	      //  } elseif ($meta_box['id'] == 'wbg-processed-abstracts-meta') {
	      // Take the submitted text, pass it through textpresso, and stash it here.


	    } else {
	    
	      
	      // No special processing required: submitting-authors
	      foreach ($meta_box['fields'] as $meta_field) {
		//echo $_POST[$meta_field['name']];
		_do_add_meta($post_id,$meta_field['name'],$meta_field['default']);       
	      }
	    }
	}
}



function _do_add_meta($post_id, $name, $default=false) {
  global $post;
  $current_data = get_post_meta($post_id, $name, true);	
  $new_data = $_POST[$name];

  if ($current_data) {
    if ($new_data == '')
      delete_post_meta($post_id, $name);
    elseif ($new_data == $meta_field['default'])
      delete_post_meta($post_id, $name);
    elseif ($new_data != $current_data)
      update_post_meta($post_id, $name, $new_data);
  }
  elseif ($new_data != '')
    add_post_meta($post_id, $name, $new_data, true);
}




function wbg_meta_boxes($meta_name = false) {
  $meta_boxes 
    = array(
	    'authors' => array(  
			       'id'        => 'wbg-authors-meta',
			       'title'     => 'Authors (required)',
			       'function'  => 'wbg_authors_meta_box',
			       'noncename' => 'wbg_authors_nonce',
			       'instructions' => 'Enter authors here, including the submitting author. Authors will be listed in the order they are entered. Middle initials should be entered in the first name field; titles should be entered following the last name.  Email addresses are optional for all authors except corresponding authors.<br /><br />Indicate corresponding authors by selecting the <b>Corresponding Author</b> checkbox and providing an email address.',
			       'fields' =>
			       array(  
				     // These fields will be replicated 10x
				     'author_firstname' 
				     => array(
					      'name'          => '_wbg_author_firstname',  
					      'type'          => 'text',
					      'width'         => 'full',
					      'default'       => '',
					      'title'         => 'First Name',
					      'description'   => '',
					      'margin'        => 'true',
					      ),  
				     'author_lastname' 
				     => array(  
					      'name'          => '_wbg_author_lastname',  
					      'type'          => 'text',
					      'width'         => 'full',
					      'default'       => '',
					      'title'         => 'Last Name',
					      'description'   => '',
					      'label'         => 'the label',
					      'margin'        => 'true',
					      ), 
				     'author_is_corresponding' 
				     => array(  
					      'name'          => '_wbg_author_is_corresponding',  
					      'type'          => 'checkbox',
					      'width'         => 'full',
					      'default'       => '',
					      'title'         => 'Is corresponding?',
					      'description'   => '',  											      
					      'label'         => 'the label',
					      'margin'        => 'true',										       
					      ),  
				     'author_email' 
				     => array(  
					      'name'          => '_wbg_author_email',  
					      'type'          => 'text',
					      'width'         => 'full',
					      'default'       => '',
					      'title'         => 'Email, corresponding author only',
					      'description'   => '',  											      
					      'label'         => 'the label',
					      'margin'        => 'true',										       
					      ),  
				     ),
			       ),
	    
	    'affiliations' => array(  
				    'id'        => 'wbg-affiliations-meta',
				    'title'     => 'Affiliations (required)',							
				    'function'  => 'wbg_affiliations_meta_box',
				    'noncename' => 'wbg_affiliations_nonce',
				    'instructions' => 'Enter author affiliations here, one affiliation per row. Associate authors with each affiliation by selecting the boxes that correspond to the authors above.',
				    'examples' => 
				    '
<b>Within the US</b>: Department, Institute, University, City State abbreviation<br /><br/>
    

&nbsp; &nbsp; Department of Biochemistry and Molecular Biophysics, Howard Hughes Medical Institute, Columbia University, New York NY<br /><br />
&nbsp; &nbsp; Department of Biology, Portland State University, Portland OR<br /><br />
		              
<b>In Canada</b>: Department, University, City, Province, Canada<br /><br />
            
&nbsp; &nbsp; Department of Biochemistry, Queen’s University, Kingston, ON, Canada<br /><br />

<b>In other countries:</b> Department, Institute, University, City, Country<br /><br />
             
&nbsp; &nbsp; Institute of Physiology, University of Zürich, Zürich, Switzerland<br /><br />
	    
&nbsp; &nbsp; Institute of Plant Protection, Georgikon Faculty, University of Pannonia, Keszthely, Hungary<br /><br />

<b>If not at a University</b>:  Name of company/institute, City, State or Country<br /><br />

&nbsp; &nbsp; New Scientific Technologies Ltd (Asinex Ltd), Moscow, Russian Federation',
				    
				    'fields' =>
				    array(  
					  'affiliation' 
					  => array(
						   'name'          => '_wbg_affiliation',  
						   'type'          => 'text',
						   'width'         => 'full',
						   'default'       => '',
						   'title'         => 'Affiliation',
						   'description'   => 'this is the description',
						   'margin'        => 'true',										       
						   ),  
					  'affiliation2authors' 
					  => array(  
						   'name'          => '_wbg_affiliations2authors',  
						   'type'          => 'checkbox',
						   'width'         => 'full',
						   'default'       => '',
						   'title'         => 'Affiliated Authors',
						   'description'   => '',     
						   'label'         => 'the label',
						   'margin'        => 'true',
						   ),
					  ),
				    ),
	    'references' => array(  
				  'id'        => 'wbg-references-meta',
				  'title'     => 'References (optional)',							
				  'function'  => 'wbg_references_meta_box',
				  'noncename' => 'wbg_references_nonce',
				  'instructions' => 'Please paste formatted references here, one per row, followed by the PMID ID. References should be cited in the text as (Brenner, 1974). They do not need to be numbered in the text.<br /><br />In keeping with the spirit of brief and direct missives, the editors have chosen to restrict the maximum number of citations to five.',
				  'examples'  => '
Generally: Last name Initial, Last name Initial, and Last name Initial. (year). Article title. Journal Title #, pp.-pp. PMID: ### (or doi or URL)<br /><br />

<b>Journal article</b><br />

Sarin S, Prabhu S, O\'Meara MM, Pe\'er I, and Hobert O. (2008). Caenorhabditis elegans mutant allele identification by whole-genome sequencing. Nat. Methods 5, 865-867. PMID: 18677319<br /><br />

<b>Article in press</b><br />
Calahorro C, Alejandre E, and Ruiz-Rubio M. (in press). Osmotic avoidance in Caenorhabditis elegans: synaptic function of two genes, orthologues of human NRXN1 and NLGN1, as candidates for autism. Journal of Visualized Experiments. http://www.jove.com/index/Details.stp?ID=1616
<br /><br />

<b>More than 10 authors</b><br />
Meissner B. et al. (2009). An integrated strategy to study muscle developmentand myofilament structure in C. elegans. PLoS Genetics 5, e1000537.<br /><br />

<b>Article in a book</b><br />

Sorenson PW,  and Caprio JC. (1998). Chemoreception. In The Physiology of Fishes, DH Evans, ed. (Boca Raton, FL: CRC Press), pp.
375-405.<br /><br />

<b>An entire book</b><br />

Cowan, WM, Jessell, TM, and Zipursky, SL. (1997). Molecular and Cellular Approaches to Neural Development (New York: Oxford University Press)',
				  
				  'fields' =>
				  array(  
					'reference' 
					=> array(
						 'name'          => '_wbg_reference',  
						 'type'          => 'textarea',
						 'width'         => '80%',
						 'default'       => '',
						 'title'         => 'Reference',
						 'description'   => 'this is the description',
						 'margin'        => 'true',										       
						 ),
					'pmid' 
					=> array(
						 'name'          => '_wbg_pmid',  
						 'type'          => 'textfield',
						 'width'         => 'full',
						 'default'       => '',
						 'title'         => 'PMID (optional)',
						 'description'   => 'this is the description',
						 'margin'        => 'true',										       
						 ),  
					//							 'reference_marked_up' => array(  
					//											'name'          => '_wbg_reference_marked_up',  
					//											'type'          => 'textarea',
					//											'width'         => 'full',
					//											'default'       => '',
					//											'title'         => 'Reference (marked up)',
					//											'description'   => '',
					//											'label'         => 'the label',
					//											'margin'        => 'true', 
					//											),  
					),
				  ),
    
	    
	    'admin' => array(  
			     'id'        => 'wbg-admin-meta',
			     'title'     => 'Administrative Details (internal use only)',
			     'function'  => 'wbg_admin_meta_box',
			     'noncename' => 'wbg_admin_nonce',
			     'instructions' => 'Administrative details added by editors that control the presentation of articles.<br /><br />
<b>Publish order (required)</b> sets the order of publication in a given volume, starting with 01.<br />
<b>Submitting author (optional)</b> can be recorded here if this was submitted by a WBG editor<br />
',
			     'fields' => 
			     array(  				
				   'publish_order' 
				   => array(
					    'name'          => '_wbg_publish_order',  
					    'type'          => 'text',
					    'width'         => 'full',
					    'default'       => '',
					    'title'         => 'Publish Order (integer)',
					    'description'   => '',
					    'margin'        => 'true',
					    ),  
				   'submitting_author_firstname' 
				   => array(
					    'name'          => '_wbg_submitting_author_firstname',  
					    'type'          => 'text',
					    'width'         => 'full',
					    'default'       => '',
					    'title'         => 'Submitting Author: First Name',
					    'margin'        => 'true',										       
					    'description'   => '',  											      
					    'label'         => '',
					    ),  
				   'submitting_author_lastname' 
				   => array(  
					    'name'          => '_wbg_submitting_author_lastname',  
					    'type'          => 'text',
					    'width'         => 'full',
					    'default'       => '',
					    'title'         => 'Submitting Author: Last Name',
					    'description'   => '',
					    'label'         => '',
					    'margin'        => 'true',
					    ),  
				   'submitting_author_email' 
				   => array(  
					    'name'          => '_wbg_submitting_author_email',  
					    'title'         => 'Submitting Author: Email',
					    'width'         => 'full',
					    'default'       => '',
					    'description'   => '',
					    'label'         => '',
					    'type'          => 'text',
					    'margin'        => 'true',
					    ),  
				   ),
			     ),
	    );
  
  if ($meta_name)
  return $meta_boxes[$meta_name];
  else
  return $meta_boxes;
  }
  



//function wbg_submitting_author_meta_box() {
//  wbg_add_meta_box('submitting_author');
//}

function wbg_authors_meta_box() {
  wbg_add_meta_box('authors');
}

function wbg_affiliations_meta_box() {
  wbg_add_meta_box('affiliations');                   
}

function wbg_references_meta_box() {
  wbg_add_meta_box('references');                   
}

function wbg_figures_meta_box() {
    wbg_add_meta_box('figures');
}

function wbg_wordupload_meta_box() {
  wbg_add_meta_box('wordupload');
}

function wbg_admin_meta_box() {

    if ($meta_box['id'] == 'wbg-admin-meta' && current_user_can('contributor')) {
    } else {
      wbg_add_meta_box('admin');
    }
}

//function wbg_processed_abstracts_meta_box() {
//      wbg_add_meta_box('processed_abstracts');
//}


function wbg_add_meta_box($box_name) {
  global $post;
  
  // Grab this meta box item's information from the construct array
  $meta_box = wbg_meta_boxes($box_name);
  $box_instructions = $meta_box['instructions'];  // Box level instructions
  $examples         = $meta_box['examples'];
  
  if ($box_instructions) {
    $switch = ' <a class="switch" href="">[+] more info</a>';
    $description = '<p class="description">' . $box_instructions . '</p>' . "\n";

    echo "<div class=\"thesis-post-control\">\n";
    echo '<p><strong>Instructions for this section</strong>' . $switch . '</p>' . "\n";
    echo '<p><strong>Complete author instructions</strong> <a target="_blank" href="http://www.wormbook.org/wbg/instructions-for-authors/">[new window]</a></p>';
    //echo "<p>$switch</p>\n";
    echo $description;
    echo '</div>';
  }
  
  if ($examples) {
    $switch = ' <a class="switch" href="">[+] more info</a>';
    $description = '<p class="description">' . $examples . '</p>' . "\n";
    echo "<div class=\"thesis-post-control\">\n";
    echo '<p><strong>Examples</strong>' . $switch . '</p>' . "\n";
    //echo "<p>$switch</p>\n";
    echo $description;
    echo '</div>';
  }
  
  // Authors require some custom formatting
  if ($box_name == 'authors') {
    
    echo "<table><tr><th>Author</th><th>First Name</th><th>Last Name</th><th>Corresponding<br />Author?</th><th>EMail</th>";
    //      echo "<th>Affiliations</th>";
    echo "</tr>";
    
    // Authors are repeated 10x, placed into a table
    // Field names will have the index appended
    
    for ($index=0;$index<limits('authors');$index++) {
      echo '<tr><td>' . ($index+1) . '</td>';
      
      $count   = 0;
      foreach ($meta_box['fields'] as $meta_id => $meta_field) {
	$count++;
	
	// Create a name for this field. It just has the index appended.
	$name = $meta_field['name'] . '_' . $index;
	
	$existing_value = get_post_meta($post->ID, $name, true);
	$value = ($existing_value != '') ? $existing_value : $meta_field['default'];
	
	if ($count == 1 || $count == 2 || $count == 4) {
	  // firstname (column 1), lastname (column 2), email (column 4)
	  echo '<td><input type="text" size="20" name="' . $name
	    . '" id="' . $name . '" value="' 
	    . $value . '" /></td>';
	}
	
	if ($count == 3) {
	  // Checkbox for corresponding author
	  $checked = ($value) ? ' checked="checked"' : '';
	  echo '<td><input type="checkbox" id="' . $name . '" name="' . $name . '" value="1"' . $checked . ' /></td>';	  
	}
	
	if ($count == 4) {
	  $count = 0;
	  echo '</tr>';
	}
      }
    }
    
    echo "</table>";
    echo '</div>';
    
  } elseif ($box_name == 'affiliations') {
							
    // Display 10 maximum affiliations
    echo "<table><tr>";
    // Hiding IDs
    echo     '<th>#</th>';
    echo      "<th>Affiliation</th>";
    echo "<th width='50%'>Affiliated Authors</th></tr>";
    
    // Affiliation fields are repeated 5 times
    // Field names will have the index appended
    
    for ($index=0;$index<limits('affiliations');$index++) {
      
      echo '<tr><td>' . ($index+1) . '</td>';
      
      $count   = 0;
      foreach ($meta_box['fields'] as $meta_id => $meta_field) {
	$count++;
		
	// Affiliations
	if ($count == 1) {

	  // Create a name for this field. It just has the index appended.
	  $name = $meta_field['name'] . '_' . $index;
	  	  
	  $existing_value = get_post_meta($post->ID, $name, true);
	  $value = ($existing_value != '') ? $existing_value : $meta_field['default'];	    

	  // Is it necessary to save the value for textareas?
	  echo '<td><textarea rows="3" cols="40" name="' . $name
	    . '" id="' . $name . '">'
	    . $value . '</textarea></td>';
	}
	
	// Affiliated Authors, replicated 10x
	if ($count == 2) {
	  
	  // The form show affiliations -> authors,
	  // but the data schema maps authors -> affiliations in order to facilitate display.
	  // To display
	  // 1. iterate over authors, getting their ids
	  // 2. get_post_meta for prefixauthors2affiliations$id (possibly array of affiliation ids)
	  // 3. list the corresponding affiliation
	  echo '<td>';
	  echo '<table width="100%"><tr>';
	  for ($authorid=0;$authorid<limits('authors'); $authorid++) {
	    echo "<td>" . ($authorid+1) . "</td>";
	  }
	  echo '</tr>';
	  
	  echo '<tr>';
	  for ($authorid=0;$authorid<limits('authors'); $authorid++) {
	    
	    // Create checkboxes for _wbg_authors2affiliations_$author_id. Value is the affiliation ID	    
	    // Every checkbox is unique...
	    $name = $meta_field['name'] . '_paper_' . $index . '_author_' . $authorid;
	    // Or a checkbox group...
	    // $name = $meta_field['name'] . '_' . $index;
    
	    $existing_value = get_post_meta($post->ID, $name, true);
	    $value = ($existing_value != '') ? $existing_value : '';
	    
	    $checked = ($value) ? 'checked="checked"' : '';
	    echo '<td><input type="checkbox" id="' . $name . '" name="' . $name . '" value="1" ' . $checked . ' /></td>';
	  }
	  echo '</tr></table>';
	  echo '</td></tr>';
	  $count == 0;
	}
      }
    }
    echo '</table>';      
    //      echo '</div>';        
  } elseif ($box_name == 'references') {

    // Display 5 maximum references
    echo "<table><tr><th>#</th><th>Reference</th><th>PMID</th>";
    //    echo '<th>Marked up Reference</th>';
    echo "</tr>";
    
    for ($index=0;$index<limits('references');$index++) {

      echo '<tr><td>' . ($index+1) . '</td>';
      $count   = 0;
      foreach ($meta_box['fields'] as $meta_id => $meta_field) {
	$count++;	
	
	// Create a name for this field. It just has the index appended.
	$name = $meta_field['name'] . '_' . $index;
	
	$existing_value = get_post_meta($post->ID, $name, true);
	$value = ($existing_value != '') ? $existing_value : $meta_field['default'];
	//	if ($count == 1 || $count == 2) {
	if ($count == 1) {
	  echo '<td><textarea rows="3" cols="50" name="' . $name
	    . '" id="' . $name
	    . '">' . $value. '</textarea></td>';
	}

	if ($count == 2) {
	  echo '<td valign="top"><input type="text" size="20" name="' . $name
	    . '" id="' . $name . '" value="' 
	    . $value . '" /></td>';
	}

	// Marked up references will go somewhere else
	// Not using marked up references now... end the row at count == 1
	if ($count == 2) {
	//	if ($count == 1) {
	  $count == 0;
	  echo '</tr>';	  
	}
      }
    }
    echo '</table>';
    //    echo '</div>';


  } elseif ($box_name == 'processed_abstracts') {

      foreach ($meta_box['fields'] as $meta_id => $meta_field) {
	
	// Create a name for this field. It just has the index appended.
	$name = $meta_field['name'];
	
	$existing_value = get_post_meta($post->ID, $name, true);
	$value = ($existing_value != '') ? $existing_value : $meta_field['default'];
	echo '<textarea rows="20" cols="70" name="' . $name
	  . '" id="' . $name
	  . '">' . $value. '</textarea>';
      }
      
  } elseif ($box_name == "wordupload") {
    echo '<p><i>This is the original Word-formatted upload, used to verify formatting</i></p>';


    //  } elseif ($box_name == "pdf_filename") {
    // echo '<p><i>The filename of the PDF version of this article.</i></p>';


  //  Default formatting
  } else {
    
    // Spit out the actual form on the WordPress post page
    foreach ($meta_box['fields'] as $meta_id => $meta_field) {
      // Grab the existing value for this field from the database
      $existing_value = get_post_meta($post->ID, $meta_field['name'], true);
      $value = ($existing_value != '') ? $existing_value : $meta_field['default'];
      $margin = ($meta_field['margin']) ? ' class="add_margin"' : '';
      
      echo "<div id=\"$meta_id\" class=\"thesis-post-control\">\n";
      
      if ($meta_field['description']) {
	$switch = ' <a class="switch" href="">[+] more info</a>';
	$description = '<p class="description">' . $meta_field['description'] . '</p>' . "\n";
      }
      else {
	$switch = '';
	$description = '';
      }
      
      if ($meta_field['title'])
	echo '<p><strong>' . $meta_field['title'] . '</strong>' . $switch . '</p>' . "\n";
      
      if ($description)
	echo $description;
      
      
      if (is_array($meta_field['type'])) {
	if ($meta_field['type']['type'] == 'radio') {
	  $options = $meta_field['type']['options'];
	  $default = $meta_field['default'];
	  
	  echo '<ul' . $margin . '>' . "\n";
	  
	  foreach ($options as $option_value => $label) {
	    if ($existing_value)
	      $checked = ($existing_value == $option_value) ? ' checked="checked"' : '';
	    elseif ($option_value == $default)
	      $checked = ' checked="checked"';
	    else
	      $checked = '';
	    
	    if ($option_value == $default)
	      $option_value = '';
	    
	    echo '	<li><input type="radio" name="' . $meta_field['name'] . '" value="' . $option_value . '"' . $checked .' /> <label>' . $label . '</label></li>' . "\n";
	  }
	  
	  echo '</ul>' . "\n";
	}
      }	
      elseif ($meta_field['type'] == 'text') {
	$width = ($meta_field['width']) ? ' ' . $meta_field['width'] : '';
	
	echo '<p' . $margin . '>' . "\n";
	echo '	<input type="text" class="text_input' . $width . '" id="' . $meta_field['name'] . '" name="' . $meta_field['name'] . '" value="' . $value . '" />' . "\n";
	echo '	<label for="' . $meta_field['name'] . '">' . $meta_field['label'] . '</label>' . "\n";
	echo '</p>' . "\n";
      }
      elseif ($meta_field['type'] == 'textarea') {
	echo '<p' . $margin . '>' . "\n";
	echo '	<textarea id="' . $meta_field['name'] . '" name="' . $meta_field['name'] . '">' . $value . '</textarea>' . "\n";
	echo '	<label for="' . $meta_field['name'] . '">' . $meta_field['label'] . '</label>' . "\n";
	echo '</p>' . "\n";
      }

      elseif ($meta_field['type'] == 'wysiwyg') {

	echo '<textarea name="' . $meta_field[ 'name' ] . '" id="' . $meta_field[ 'name' ] . '" columns="30" rows="3">' . $value . '</textarea>';	

 ?>
 <script type="text/javascript">
    jQuery( document ).ready( function() {
      jQuery( "<?php echo $meta_field['name']; ?>" ).addClass( "mceEditor" );
      if ( typeof( tinyMCE ) == "object" && typeof( tinyMCE.execCommand ) == "function" ) {
	tinyMCE.execCommand( "mceAddControl", false, "<?php echo $meta_field['name']; ?>" );
      }
    });
</script>
    <?php 
    }
      

      elseif ($meta_field['type'] == 'checkbox') {
	$checked = ($value) ? ' checked="checked"' : '';
	echo '<p' . $margin . '><input type="checkbox" id="' . $meta_field['name'] . '" name="' . $meta_field['name'] . '" value="1"' . $checked . ' /> <label for="' . $meta_field['name'] . '">' . $meta_field['label'] . '</label></p>' . "\n";
      }
      
      echo '</div>' . "\n";
    }
    
    // What is this for?
    echo '	<input type="hidden" name="' . $meta_box['noncename'] . '_noncename" id="' . $meta_box['noncename'] . '_noncename" value="' . wp_create_nonce(plugin_basename(__FILE__)) . '" />' . "\n";
    
  }
}



//      var id = getElementById("id").value;
//      //  $("#divTxt").append("hello");
//      
//      //  $(‘#row’ + id).highlightFade({
//      //speed:1000
//      //	});
//      
//      // id = (id – 1) + 2;
//      //document.getElementById(“id”).value = id;


//
     // This should be more like
      // <a id="add_form_element">Add Author</a>
      // $('#add_form_element').click(function() {
      
      // Get the inner value, see what it is, then insert the appropriate form element.
      
      //    }







/* ****************************************
   Contributing authors should only be
   able to see their posts and nobody elses
   **************************************** */
function posts_for_current_author($query) {  

  if ($query->is_admin && current_user_can('contributor')) {
    global $user_ID;
    $query->set('author',  $user_ID);
    unset($user_ID);
  }
  
  return $query;
}
add_filter('pre_get_posts', 'posts_for_current_author');


/* ****************************************
   Let's let contributors upload files.
   **************************************** */
if ( current_user_can('contributor') && !current_user_can('upload_files')) {
  add_action('admin_init', 'allow_contributor_uploads');
}

function allow_contributor_uploads() {
  $contributor = get_role('contributor');
  $contributor->add_cap('upload_files');
}




/* ****************************************
   Customize the log-in screen
   **************************************** */

function custom_login() {
  // Path is hard-coded get_options
  echo '<link rel="stylesheet" type="text/css" href="' . get_option('siteurl') . '/wp-content/themes/' . get_option('template') . '/custom/custom_login.css" />';
}
add_action('login_head', 'custom_login');






/* ********************************************

   Create a custom post type exclusively for abstracts

   ******************************************** */

add_action( 'init', 'create_post_type' );
add_action( 'init', 'create_abstract_taxonomies',0);


function create_post_type() {
  register_post_type( 'wbg_abstracts',
		      array(
			    'labels' => array(
			    		      'name' => __( 'Articles' ),
			    		      'singular_name' => __( 'Article' )
			    		      ),
			    'public' => true,
                            'publicly_queryable' => true,
			    'rewrite'     => array('slug'=>'articles/%volume%','with_front'=>false),                            
			    'query_var'   => true,    
			    'description' => 'Articles submitted for inclusion to the Gazette',
			    //			    'supports' => array('title','editor','revisions','comments'),
			    'supports' => array('title','editor','comments'),
			    'menu_position' => 5,   // Place abstracts just below posts in the admin menu
			    'description' => __( 'Articles submitted for inclusion in the Gazette.' ),
			    'add_new' => __( 'Add New Articles' ),
			    'add_new_item' => __( 'Add New Articles' ),
			    'edit' => __( 'Edit' ),
			    'edit_item' => __( 'Edit Article' ),
			    'new_item' => __( 'New Article' ),
			    'view' => __( 'View Article' ),
			    'view_item' => __( 'View Article' ),
			    'search_items' => __( 'Search Articles' ),
			    'not_found' => __( 'No Articles found' ),			    
			    'not_found_in_trash' => __( 'No Articles found in Trash' ),
			    //			    'register_meta_box_cb' => '
			    )
		      );
}


/* Establish a couple of taxonomies for abstracts */
function create_abstract_taxonomies() {

  // Add new taxonomy, NOT hierarchical (like tags)
  $labels = array(
		  'name' => _x( 'Keywords', 'taxonomy general name' ),
		  'singular_name' => _x( 'Keyword', 'taxonomy singular name' ),
		  'search_items' =>  __( 'Search Keywords' ),
		  'popular_items' => __( 'Popular Keywords' ),
		  'all_items' => __( 'All Keywords' ),
		  'parent_item' => null,
		  'parent_item_colon' => null,
		  'edit_item' => __( 'Edit Keyword' ), 
		  'update_item' => __( 'Update Keyword' ),
		  'add_new_item' => __( 'Add New Keyword' ),
		  'new_item_name' => __( 'New Keyword Name' ),
		  'separate_items_with_commas' => __( 'Separate keywords with commas' ),
		  'add_or_remove_items' => __( 'Add or remove keywords' ),
		  'choose_from_most_used' => __( 'Choose from the most used keywords' )
		  ); 

    register_taxonomy('keyword','wbg_abstracts',array(
  					   'hierarchical' => false,
  					   'labels' => $labels,
  					   'show_ui' => true,
  					   'query_var' => true,
  					   'rewrite' => array( 'slug' => 'keywords' ),
  					   ));

    // Volumes - for administrators only
  $labels = array(
		  'name'          => _x( 'Volumes','taxonomy general name'),
		  'singular_name' => _x( 'Volume','taxonomy singular name'),
		  'search_items'  => __( 'Search Volumes' ),
		  'all_items'     => __( 'All Volumes' ),
		  //		  'parent_item'   => __( 'Parent Genre' ),
		  // 'parent_item_colon' => __( 'Parent Genre:' ),
		  'edit_item'     => __( 'Edit Volume' ), 
		  'update_item'   => __( 'Update Volume' ),
		  'add_new_item'  => __( 'Add New Volume' ),
		  'new_item_name' => __( 'New Volume Name' ),		  
		  ); 
  
  register_taxonomy('volume',array('wbg_abstracts'), array(
							   'hierarchical' => true,
							   'labels' => $labels,
							   'show_ui' => true,
							   'query_var' => true,
							   'piblicly_queryable' => 'true',
							   'rewrite' => array( 'slug' => 'archives' ),
							   // Restrict who can assign terms
							   'capabilities' => array ('manage_terms' => 'remove_users',
										    'edit_terms'   => 'remove_users',
										    'delete_terms' => 'remove_users',
										    'assign_terms' => 'remove_users',
										    ),							   
							   ));
  
  
  
  // Add hiearchical taxonomy for article types
  $labels = array(
		  'name' => _x( 'Article Types', 'taxonomy general name' ),
		  'singular_name' => _x( 'Article Type', 'taxonomy singular name' ),
		  'search_items' =>  __( 'Search Article Types' ),
		  'all_items' => __( 'All Article Types' ),
		  'edit_item' => __( 'Edit Article Type' ), 
		  'update_item' => __( 'Update Article Type' ),
		  'add_new_item' => __( 'Add New Article Type' ),
		  'new_item_name' => __( 'New Article Type' ),
		  ); 
  
  register_taxonomy('article_type',array('wbg_abstracts'), array(
								 'hierarchical' => true,
								 'labels' => $labels,
								 'show_ui' => true,
								 'query_var' => true,
								 'rewrite' => array( 'slug' => 'volume' ),
								 // Restrict who can assign terms
								 'capabilities' => array ('manage_terms' => 'remove_users',
											  'edit_terms'   => 'remove_users',
											  'delete_terms' => 'remove_users',
											  'assign_terms' => 'remove_users',
											  ), 
								 ));
}





/* Adjust permalinks for custom post types and taxonomies */
add_filter('post_link', 'my_permalink_filter', 1, 3);
add_filter('post_type_link', 'my_permalink_filter', 1, 3);
 
function my_permalink_filter($permalink, $post_id, $leavename) {
  if (strpos($permalink, '%volume%') === FALSE) return $permalink;
 
  // Get post
  $post = get_post($post_id);
  if ( !is_object($post) || $post->post_type != 'wbg_abstracts' ) {
    return $post_link;
  }

  // Get taxonomy terms
  $terms = wp_get_object_terms($post->ID, 'volume');
  if (!is_wp_error($terms) && !empty($terms) && is_object($terms[0])) $taxonomy_slug = $terms[0]->slug;
  else $taxonomy_slug = 'not-rated';
 
  return str_replace('%volume%', $taxonomy_slug, $permalink);
}




/* Configure columns for the administrative display */
add_filter( "manage_edit-wbg_abstracts_columns", "wbg_abstracts_column_headers");
add_action( "manage_posts_custom_column",        "wbg_abstracts_column_contents");

function wbg_abstracts_column_headers($columns) {
  $columns = array(
		   "cb"       => "<input type=\"checkbox\" />",
		   "title"    => "Article Title",
		   "volume"   => "Volume",
		   "order"    => "Publish Order",
		   "author"   => "Submitting Author",
		   "comments" => 'Comments',
		   );
  return $columns;
}


function wbg_abstracts_column_contents($column) {
  global $post;
  if ("ID" == $column) echo $post->ID;

  if ("volume" == $column) {
    $categories = get_the_category(',');
    echo get_the_term_list($post->ID,'volume','',', ','');
  }

  if ("order" == $column) {
    echo get_post_meta($post->ID,'_wbg_publish_order',true);
  }
}



/* Make sure our posts end up in our RSS feed, too */
function myfeed_request($qv) {
  if (isset($qv['feed']) && !isset($qv['post_type'])){

    $qv['post_type'] = array();
    $qv['post_type'] = get_post_types($args = array(
						    'public'   => true,
						    '_builtin' => false
						    ));
    $qv['post_type'][] = 'post';
  }
  return $qv;

}
add_filter('request', 'myfeed_request');






// Add some custom javascript
// <!--   <script type="text/javascript" src="/js/jquery.lightbox-0.5.js"></script>-->
//   <link rel="stylesheet" type="text/css" href="/css/jquery.lightbox-0.5.css" media="screen" />

function add_custom_javascript() {?>

   <script type="text/javascript" src="/js/jquery.js"></script>
   <script type="text/javascript" src="/js/jquery.lightbox.js"></script>
   <link rel="stylesheet" type="text/css" href="/css/jquery.lightbox.css" media="screen" />

<script type="text/javascript">
      $(function() {
	$("a.lightbox").lightbox({
fitToScreen: true,
	       scaleImages: true,
	       xScale: 1.2,
	       yScale: 1.2,
	       })
      });
</script>

<?php
}
add_action('wp_head','add_custom_javascript');


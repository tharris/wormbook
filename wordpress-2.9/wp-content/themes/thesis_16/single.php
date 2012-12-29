<?php 
/** 
 * @package Thesis 
 */ 

global $thesis; 
global $thesis_design; 
     
if (is_single() || (is_page() && !$thesis['display']['comments']['disable_pages'])) 
     wp_enqueue_script('comment-reply'); 
     
     get_header(apply_filters('thesis_get_header', $name)); 
     
     echo '<div id="container">' . "\n"; 
     echo '<div id="page">' . "\n"; 
     
     thesis_header_area(); 

     thesis_hook_before_content_box(); 
     
     echo '    <div id="content_box" class="narrow_box">' . "\n"; 

     thesis_content_column(); 
     
     // No longer using any sidebars on the single post pages
     // thesis_sidebars(); 

         
echo '    </div>' . "\n"; 
echo '</div>';     

thesis_hook_after_content_box(); 

thesis_footer_area(); 
     
echo '</div>' . "\n"; 
echo '</div>' . "\n"; 
         
get_footer(apply_filters('thesis_get_footer', $name));
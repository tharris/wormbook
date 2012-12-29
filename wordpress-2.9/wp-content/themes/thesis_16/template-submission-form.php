<?php

// Template Name: Gazette Submission Template

?>

<?php 

//require("process_gazette_submissions.php");
global $thesis; 
global $thesis_design; 

// Get the thesis header
get_header(apply_filters('thesis_get_header', $name)); 


echo '<div id="container">' . "\n"; 
echo '<div id="page">' . "\n"; 

thesis_header_area(); 
thesis_hook_before_content_box(); 

echo '    <div id="content_box" class="narrow_box">' . "\n"; 


// The meat of the submission form
?>

<form name="wbg-submission-form" action="" method="post">

</form>


<?php
thesis_hook_after_post_box();


thesis_hook_after_content(); 


echo '    </div></div>' . "\n"; 
     
thesis_hook_after_content_box(); 
thesis_footer_area(); 

echo '</div>' . "\n"; 
echo '</div>' . "\n"; 

get_footer(apply_filters('thesis_get_footer', $name));


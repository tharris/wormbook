<?php
/*
Name: "Custom Fields"
URI: http://thedeadone.net/software/tdo-mini-forms-wordpress-plugin/
Description: Add a custom field to your form!
Version: 0.7
Author: Mark Cunningham
Author URI: http://thedeadone.net
*/

if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('TDOMF: You are not allowed to call this page directly.'); }

function tdomf_widget_customfields_gen_fmt($index,$value,$options){
  $value = strval($value);
  if($value != '0' && (empty($value) || trim($value) == "")) {
    return "";
  }
  $title = $options['title'];
  $key = $options['key'];
  
  $output = $options['format'];
  // title safe : set by admin
  $output = ereg_replace("%%TITLE%%",$title,$output);
  // value not safe, so scrub it for PHP and js
  $output = ereg_replace("%%VALUE%%",tdomf_protect_input($value),$output);
  // key safe : set by admin
  $output = ereg_replace("%%KEY%%",$key,$output);
  return $output;
}

function tdomf_widget_customfields_append($post_ID,$options,$index,$form_id){
  // Grab value
  $value = get_post_meta($post_ID,$options['key'],true);
  // select of course has to be a special case!
  if($options['type'] == 'select') {
    $value = tdomf_widget_customfields_select_convert($value,$options);
  }
  // we should only really care if the field is "empty" ... false is a valid setting
  if(/*!empty($value) &&*/ (!is_string($value) || trim($value) != "") )
  {
    // Gen Format
    $fmt = tdomf_widget_customfields_gen_fmt($index,$value,$options);
    $fmt = trim(tdomf_prepare_string($fmt,$form_id,"",$post_ID));
    if($fmt != "") {
      // Grab existing data
      $post = wp_get_single_post($post_ID, ARRAY_A);
      if(!empty($post['post_content'])) {
         $post = add_magic_quotes($post);
      }
      $post_content = $post['post_content'];
      $post_content .= addslashes($fmt);
      // Update post
      $post = array (
          "ID"                      => $post_ID,
          "post_content"            => $post_content,
      );
      $post_ID = wp_update_post($post);
    }
  }
}

// TODO: Add a box to allow customised formatting of custom field and 
// automatically added it to the post content

// Add a menu option to control the number of cf widgets to the bottom of the 
// tdomf widget page
//
function tdomf_widget_customfields_number_bottom($form_id,$mode){
    if(tdomf_form_exists($form_id) && TDOMF_Widget::isSubmitForm($mode,$form_id)) {
      $count = tdomf_get_option_widget('tdomf_customfields_widget_count',$form_id);
      if($count <= 0){ $count = 1; } 
      $max = tdomf_get_option_form(TDOMF_OPTION_WIDGET_INSTANCES,$form_id);
      if($max == false){ $max = 9; }
      if($count > ($max+1)){ $count = ($max+1); }
      
      if($max > 1) {
      ?>
      <div class="wrap">
        <form method="post">
          <h2><?php _e("Custom Fields Widgets","tdomf"); ?></h2>
          <p style="line-height: 30px;"><?php _e("How many Custom Fields widgets would you like?","tdomf"); ?>
          <select id="tdomf-widget-customfields-number" name="tdomf-widget-customfields-number" value="<?php echo $count; ?>">
          <?php for($i = 1; $i < ($max+1); $i++) { ?>
            <option value="<?php echo $i; ?>" <?php if($i == $count) { ?> selected="selected" <?php } ?>><?php echo $i; ?></option>
          <?php } ?>
          </select>
          <span class="submit">
            <input type="submit" value="Save" id="tdomf-widget-customfields-number-submit" name="tdomf-widget-customfields-number-submit" />
          </span>
          </p>
        </form>
      </div>
      <?php 
      }
    }
}
add_action('tdomf_widget_page_bottom','tdomf_widget_customfields_number_bottom', 10, 2);

// Get Options for this widget
//
function tdomf_widget_customfields_get_options($index,$form_id) {
  $options = tdomf_get_option_widget('tdomf_customfields_widget_'.$index,$form_id);
    if($options == false) {
       $options = array();
       $options['key'] = "TDOMF Form #$form_id Custom Field #$index";
       $options['title'] = "";
       $options['required'] = false;
       $options['defval'] = "";
       $options['size'] = 30;
       $options['type'] = 'textfield';
       $options['cols'] = 40;
       $options['rows'] = 10; 
       $options['append'] = false;
       $options['format'] = "<p><b>%%TITLE%%</b>: %%VALUE%%</p>";
       $options['preview'] = true;
       $options['required-value'] = true; 
       // textfield specific
       $options['tf-subtype'] = 'text';
       // textarea specific
       $options['ta-restrict-tags'] = false;
       $options['ta-allowable-tags'] = "<p><b><em><u><strong><a><img><table><tr><td><blockquote><ul><ol><li><br><sup>";
       $options['ta-quicktags'] = true;
       $options['ta-content-filter'] = true;     
    }
    if(!isset($options['append'])){ $options['append'] = false; }
    if(!isset($options['format'])){ $options['format'] = "<p><b>%%TITLE%%</b>: %%VALUE%%</p>"; }
    if(!isset($options['preview'])){ $options['preview'] = true; }
    if(!isset($options['required-value'])){ $options['required-value'] = true; }
    // select specific
    if(!isset($options['s-multiple'])){ $options['s-multiple'] = true; }
    if(!isset($options['s-values'])){ $options['s-values'] = "test:test"; }
    if(!isset($options['s-defaults'])){ $options['s-defaults'] = "test"; }
    // new textarea ones
    if(!isset($options['ta-char-limit'])){ $options['ta-char-limit'] = 0; }
    if(!isset($options['ta-word-limit'])){ $options['ta-word-limit'] = 0; }
  return $options;
}

//////////////////////////////
// Display the widget! 
//
function tdomf_widget_customfields($args,$params) {
  $number = 0;
  if(is_array($params) && count($params) >= 1){
     $number = $params[0];
  }
  $options = tdomf_widget_customfields_get_options($number,$args['tdomf_form_id']);
  
  if($options['type'] == 'textfield') {
    return tdomf_widget_customfields_textfield($args,$number,$options);
  } else if($options['type'] == 'hidden') {
    return tdomf_widget_customfields_hidden($args,$number,$options);
  } else if($options['type'] == 'textarea') {
    return tdomf_widget_customfields_textarea($args,$number,$options);
  } else if($options['type'] == 'checkbox') {
    return tdomf_widget_customfields_checkbox($args,$number,$options);
  } else if($options['type'] == 'select') {
    return tdomf_widget_customfields_select($args,$number,$options);
  }
  return "";
}

//////////////////////////////
// Hack this widget 
//
function tdomf_widget_customfields_hack($args,$params) {
  $number = 0;
  if(is_array($params) && count($params) >= 1){
     $number = $params[0];
  }
  $options = tdomf_widget_customfields_get_options($number,$args['tdomf_form_id']);
  
  if($options['type'] == 'textfield') {
    return tdomf_widget_customfields_textfield_hack($args,$number,$options);
  } else if($options['type'] == 'hidden') {
    return tdomf_widget_customfields_hidden($args,$number,$options);
  } else if($options['type'] == 'textarea') {
    return tdomf_widget_customfields_textarea_hack($args,$number,$options);
  } else if($options['type'] == 'checkbox') {
    return tdomf_widget_customfields_checkbox_hack($args,$number,$options);
  } else if($options['type'] == 'select') {
    return tdomf_widget_customfields_select_hack($args,$number,$options);
  }
  return "";
}

///////////////////////////////////////
// Preview 
//
function tdomf_widget_customfields_preview($args,$params) {
    
  $number = 0;
  if(is_array($params) && count($params) >= 1){
     $number = $params[0];
  }
  $options = tdomf_widget_customfields_get_options($number,$args['tdomf_form_id']);
  
  $output = "";
  if($options['preview']) {
    if($options['type'] == 'textfield') {
      $output .= tdomf_widget_customfields_textfield_preview($args,$number,$options);
    } else if($options['type'] == 'textarea') {
      $output .= tdomf_widget_customfields_textarea_preview($args,$number,$options);
    } else if($options['type'] == 'checkbox') {
      $output .= tdomf_widget_customfields_checkbox_preview($args,$number,$options);
    } else if($options['type'] == 'select') {
      $output .= tdomf_widget_customfields_select_preview($args,$number,$options);
    }
  }
  return $output;
}
  
function tdomf_widget_customfields_validate($args,$preview,$params) {
  $number = 0;
  if(is_array($params) && count($params) >= 1){
     $number = $params[0];
  }
  $options = tdomf_widget_customfields_get_options($number,$args['tdomf_form_id']);
  
  if($options['type'] == 'textfield') {
    return tdomf_widget_customfields_textfield_validate($args,$number,$options);
  } else if($options['type'] == 'textarea') {
    return tdomf_widget_customfields_textarea_validate($args,$number,$options);
  } else if($options['type'] == 'checkbox') {
    return tdomf_widget_customfields_checkbox_validate($args,$number,$options);
  }
  
  return NULL;
}

function tdomf_widget_customfields_post($args,$params) {
  $number = 0;
  if(is_array($params) && count($params) >= 1){
     $number = $params[0];
  }
  $options = tdomf_widget_customfields_get_options($number,$args['tdomf_form_id']);
  
  $retVal = NULL;
  
  if($options['type'] == 'textfield') {
    $retVal = tdomf_widget_customfields_textfield_post($args,$number,$options);
  } else if($options['type'] == 'hidden') {
    $retVal = tdomf_widget_customfields_hidden_post($args,$number,$options);
  } else if($options['type'] == 'textarea') {
    $retVal = tdomf_widget_customfields_textarea_post($args,$number,$options);
  } else if($options['type'] == 'checkbox') {
    $retVal = tdomf_widget_customfields_checkbox_post($args,$number,$options);
  } else if($options['type'] == 'select') {
    $retVal = tdomf_widget_customfields_select_post($args,$number,$options);
  }
  
  if($options['append'] && $retVal == NULL){
    tdomf_widget_customfields_append($args['post_ID'],$options,$number,$args['tdomf_form_id']);
  }
  
  return $retVal;
}

function tdomf_widget_customfields_adminemail($args,$params) {
  $number = 0;
  if(is_array($params) && count($params) >= 1){
     $number = $params[0];
  }
  $options = tdomf_widget_customfields_get_options($number,$args['tdomf_form_id']);
  
  if($options['type'] == 'textfield') {
    return tdomf_widget_customfields_textfield_adminemail($args,$number,$options);
  } else if($options['type'] == 'textarea') {
    return tdomf_widget_customfields_textarea_adminemail($args,$number,$options);
  } else if($options['type'] == 'checkbox') {
    return tdomf_widget_customfields_checkbox_adminemail($args,$number,$options);
  } else if($options['type'] == 'select') {
    return tdomf_widget_customfields_select_adminemail($args,$number,$options);
  }
  
  return "";
}

function tdomf_widget_customfields_admin_error($form_id,$params) {
    
  $number = 0;
  if(is_array($params) && count($params) >= 1){
     $number = $params[0];
  }
  $options = tdomf_widget_customfields_get_options($number,$form_id);
  
  $output = "";
  
  if(empty($options['key']))
  {
      $output .= sprintf(__('<b>Error</b>: Widget "Custom Fields #%d" contains an empty key. The key must be set to something and must be unique.','tdomf'),$number);
  }
  
  /* @todo: grabbing all the other custom field widgets */
  
  return $output;
}

///////////////////////////////////////////////////
// Display and handle content widget control panel 
//
function tdomf_widget_customfields_control($form_id,$params) {
  $number = 0;
  if(is_array($params) && count($params) >= 1){
     $number = $params[0];
  }
  
  $options = tdomf_widget_customfields_get_options($number,$form_id);
  // Store settings for this widget
  if (isset($_POST["customfields-$number-submit"]) ) {
     $newoptions['title'] = $_POST["customfields-title-$number"];
     $newoptions['key'] = $_POST["customfields-key-$number"];;
     $newoptions['required'] = isset($_POST["customfields-required-$number"]);
     $newoptions['preview'] = isset($_POST["customfields-preview-$number"]);
     $newoptions['defval'] = $_POST["customfields-defval-$number"];
     $newoptions['size'] = intval($_POST["customfields-size-$number"]);
     $newoptions['cols'] = intval($_POST["customfields-cols-$number"]);
     $newoptions['rows'] = intval($_POST["customfields-rows-$number"]);
     $newoptions['type'] = $_POST["customfields-type-$number"];
     $newoptions['append'] = isset($_POST["customfields-append-$number"]);
     $newoptions['format'] = $_POST["customfields-format-$number"];
     if($newoptions['type'] == 'textfield') {
       $newoptions = tdomf_widget_customfields_textfield_control_handler($number,$newoptions);
     } else if($newoptions['type'] == 'textarea') {
       $newoptions = tdomf_widget_customfields_textarea_control_handler($number,$newoptions);
     } else if($newoptions['type'] == 'checkbox') {
       $newoptions = tdomf_widget_customfields_checkbox_control_handler($number,$newoptions);
     } else if($newoptions['type'] == 'select') {
       $newoptions = tdomf_widget_customfields_select_control_handler($number,$newoptions);
     }
     if ( $options != $newoptions ) {
        $options = $newoptions;
        tdomf_set_option_widget('tdomf_customfields_widget_'.$number, $options,$form_id);
        
     }
  }
// Display control panel for this widget
  
        ?>
<div>

<label for="customfields-title-<?php echo $number; ?>">
<?php _e("Title:","tdomf"); ?><br/>
<input type="text" size="40" id="customfields-title-<?php echo $number; ?>" name="customfields-title-<?php echo $number; ?>" value="<?php echo htmlentities($options['title'],ENT_QUOTES,get_bloginfo('charset')); ?>" />
</label>

<br/><br/>

<label for="customfields-name-<?php echo $number; ?>">
<?php _e("Custom Field Key:","tdomf"); ?><br/>
<small>
<?php _e("You must specify a unique value for the Custom Field key.","tdomf"); ?>
</small><br/>
<input type="text" size="40" id="customfields-key-<?php echo $number; ?>" name="customfields-key-<?php echo $number; ?>" value="<?php echo htmlentities($options['key'],ENT_QUOTES,get_bloginfo('charset')); ?>" />
</label>

<br/><br/>

<label for="customfields-preview-<?php echo $number; ?>">
<input type="checkbox" name="customfields-preview-<?php echo $number; ?>" id="customfields-preview-<?php echo $number; ?>" <?php if($options['preview']) { ?> checked <?php } ?> />
<?php _e("Include in Preview","tdomf"); ?>
</label>

<br/><br/>

<label for="customfields-append-<?php echo $number; ?>">
<input type="checkbox" name="customfields-append-<?php echo $number; ?>" id="customfields-append-<?php echo $number; ?>" <?php if($options['append']){ ?> checked <?php } ?> />
<?php _e("Append Custom Field to Post Content","tdomf"); ?>
</label>

<br/><br/>

<label for="customfields-format-<?php echo $number; ?>">
<?php _e("Format to use:","tdomf"); ?><br/>
<small>
<?php _e("If you enable the append option, this format will be used for preview as well. It supports the Form Hacker macros and you can use PHP code. Additional macros are listed below:","tdomf"); ?>
<br/>
%%VALUE%% <?php _e("= Value of Custom Field","tdomf"); ?></br>
%%KEY%% <?php _e("= Custom Field Key","tdomf"); ?><br/> 
%%TITLE%% <?php _e("= Title","tdomf"); ?>
</small><br/>
<textarea cols="40" rows="3" id="customfields-format-<?php echo $number; ?>" name="customfields-format-<?php echo $number; ?>"><?php echo $options['format']; ?></textarea>
</label>

<br/><br/>

<script type="text/javascript">
  //<![CDATA[
  function customfields_change_specific<?php echo $number; ?>(){
    var type = document.getElementById("customfields-type-<?php echo $number; ?>").value;
    if(type == 'textfield') {
      document.getElementById("customfiles-specific-textfield-<?php echo $number; ?>").style.display = 'inline';
      document.getElementById("customfiles-specific-hidden-<?php echo $number; ?>").style.display = 'none';
      document.getElementById("customfiles-specific-textarea-<?php echo $number; ?>").style.display = 'none';
      document.getElementById("customfiles-specific-checkbox-<?php echo $number; ?>").style.display = 'none';
      document.getElementById("customfiles-specific-select-<?php echo $number; ?>").style.display = 'none';
    } else if(type == 'hidden') {
      document.getElementById("customfiles-specific-textfield-<?php echo $number; ?>").style.display = 'none';
      document.getElementById("customfiles-specific-hidden-<?php echo $number; ?>").style.display = 'inline';
      document.getElementById("customfiles-specific-textarea-<?php echo $number; ?>").style.display = 'none';
      document.getElementById("customfiles-specific-checkbox-<?php echo $number; ?>").style.display = 'none';
      document.getElementById("customfiles-specific-select-<?php echo $number; ?>").style.display = 'none';
    } else if(type == 'textarea') {
      document.getElementById("customfiles-specific-textfield-<?php echo $number; ?>").style.display = 'none';
      document.getElementById("customfiles-specific-hidden-<?php echo $number; ?>").style.display = 'none';
      document.getElementById("customfiles-specific-textarea-<?php echo $number; ?>").style.display = 'inline';
      document.getElementById("customfiles-specific-checkbox-<?php echo $number; ?>").style.display = 'none';
      document.getElementById("customfiles-specific-select-<?php echo $number; ?>").style.display = 'none';
    } else if(type == 'checkbox') {
      document.getElementById("customfiles-specific-textfield-<?php echo $number; ?>").style.display = 'none';
      document.getElementById("customfiles-specific-hidden-<?php echo $number; ?>").style.display = 'none';
      document.getElementById("customfiles-specific-textarea-<?php echo $number; ?>").style.display = 'none';
      document.getElementById("customfiles-specific-checkbox-<?php echo $number; ?>").style.display = 'inline';
      document.getElementById("customfiles-specific-select-<?php echo $number; ?>").style.display = 'none';
    } else if(type == 'select') {
      document.getElementById("customfiles-specific-textfield-<?php echo $number; ?>").style.display = 'none';
      document.getElementById("customfiles-specific-hidden-<?php echo $number; ?>").style.display = 'none';
      document.getElementById("customfiles-specific-textarea-<?php echo $number; ?>").style.display = 'none';
      document.getElementById("customfiles-specific-checkbox-<?php echo $number; ?>").style.display = 'none';
      document.getElementById("customfiles-specific-select-<?php echo $number; ?>").style.display = 'inline';
    }
  }
  //]]>
</script>

<label for="customfields-type-<?php echo $number; ?>">
<?php _e("Type: ","tdomf"); ?>
<select name="customfields-type-<?php echo $number; ?>" id="customfields-type-<?php echo $number; ?>" onChange="customfields_change_specific<?php echo $number; ?>();">
<option value="textfield" <?php if($options['type'] == 'textfield') { ?> selected <?php } ?> /><?php _e("Text Field","tdomf"); ?>
<option value="hidden" <?php if($options['type'] == 'hidden') { ?> selected <?php } ?> /><?php _e("Hidden","tdomf"); ?>
<option value="textarea" <?php if($options['type'] == 'textarea') { ?> selected <?php } ?> /><?php _e("Text Area","tdomf"); ?>
<option value="checkbox" <?php if($options['type'] == 'checkbox') { ?> selected <?php } ?> /><?php _e("Check Box","tdomf"); ?>
<option value="select" <?php if($options['type'] == 'select') { ?> selected <?php } ?> /><?php _e("Select","tdomf"); ?>

<!-- Checkboxes, Radio (Radio Group) -->

<!-- TODO <option value="radio" /><?php _e("Radio Group","tdomf"); ?> -->
</select>
</label>

<div id="customfiles-specific-textfield-<?php echo $number; ?>" <?php if($options['type'] == 'textfield') { ?> style="display:inline;" <?php } else { ?> style="display:none;" <?php } ?>>
<?php echo tdomf_widget_customfields_textfield_control($number,$options); ?>
</div>

<div id="customfiles-specific-hidden-<?php echo $number; ?>" <?php if($options['type'] == 'hidden') { ?> style="display:inline;" <?php } else { ?> style="display:none;" <?php } ?>>
<?php echo tdomf_widget_customfields_hidden_control($number,$options); ?>
</div>

<div id="customfiles-specific-textarea-<?php echo $number; ?>" <?php if($options['type'] == 'textarea') { ?> style="display:inline;" <?php } else { ?> style="display:none;" <?php } ?>>
<?php echo tdomf_widget_customfields_textarea_control($number,$options); ?>
</div>

<div id="customfiles-specific-checkbox-<?php echo $number; ?>" <?php if($options['type'] == 'checkbox') { ?> style="display:inline;" <?php } else { ?> style="display:none;" <?php } ?>>
<?php echo tdomf_widget_customfields_checkbox_control($number,$options); ?>
</div>

<div id="customfiles-specific-select-<?php echo $number; ?>" <?php if($options['type'] == 'select') { ?> style="display:inline;" <?php } else { ?> style="display:none;" <?php } ?>>
<?php tdomf_widget_customfields_select_control($number,$options); ?>
</div>

</div>
        <?php 
}

function tdomf_widget_customfields_handle_number($form_id, $mode) {
  if(tdomf_form_exists($form_id) && TDOMF_Widget::isSubmitForm($mode,$form_id)) {   
     if (isset( $_POST['tdomf-widget-customfields-number-submit'] )) {
       $count = $_POST['tdomf-widget-customfields-number'];
       if($count > 0){ tdomf_set_option_widget('tdomf_customfields_widget_count',$count,$form_id); }
     }
  }
}
#add_action('tdomf_widget_page_top','tdomf_widget_customfields_handle_number', 10, 2);
add_action('tdomf_control_form_start','tdomf_widget_customfields_handle_number', 10, 2);

function tdomf_widget_customfields_init($form_id,$mode){
  if(tdomf_form_exists($form_id) && TDOMF_Widget::isSubmitForm($mode,$form_id)) {
    $count = tdomf_get_option_widget('tdomf_customfields_widget_count',$form_id);
    if($count <= 0){ $count = 1; } 
    $max = tdomf_get_option_form(TDOMF_OPTION_WIDGET_INSTANCES,$form_id);
    if($max <= 1){ $count = 1; }
    else if($count > ($max+1)){ $count = $max + 1; }
    
    for($i = 1; $i <= $count; $i++) {
      tdomf_register_form_widget("customfields-$i","Custom Fields $i", 'tdomf_widget_customfields', array('new'), $i);
      tdomf_register_form_widget_control("customfields-$i", "Custom Fields $i",'tdomf_widget_customfields_control', 500, 960, array('new'), $i);
      tdomf_register_form_widget_preview("customfields-$i", "Custom Fields $i",'tdomf_widget_customfields_preview', array('new'), $i);
      tdomf_register_form_widget_validate("customfields-$i", "Custom Fields $i",'tdomf_widget_customfields_validate', array('new'), $i);
      tdomf_register_form_widget_post("customfields-$i", "Custom Fields $i",'tdomf_widget_customfields_post', array('new'), $i);
      tdomf_register_form_widget_adminemail("customfields-$i", "Custom Fields $i",'tdomf_widget_customfields_adminemail', array('new'), $i);
      tdomf_register_form_widget_hack("customfields-$i", "Custom Fields $i",'tdomf_widget_customfields_hack', array('new'), $i);
      tdomf_register_form_widget_admin_error("customfields-$i", "Custom Fields $i", 'tdomf_widget_customfields_admin_error', array('new'), $i);
    }
  }
}
add_action('tdomf_create_post_start','tdomf_widget_customfields_init', 10, 2);
add_action('tdomf_generate_form_start','tdomf_widget_customfields_init', 10, 2);
add_action('tdomf_preview_form_start','tdomf_widget_customfields_init', 10, 2);
add_action('tdomf_validate_form_start','tdomf_widget_customfields_init', 10, 2);
add_action('tdomf_control_form_start','tdomf_widget_customfields_init', 10, 2);
#add_action('tdomf_widget_page_top','tdomf_widget_customfields_init');

////////////////////////////////////////////////////////////////////////////////
//                                                Custom Field as a Textfield //
////////////////////////////////////////////////////////////////////////////////

function tdomf_widget_customfields_textfield($args,$number,$options) {
  extract($args);
  
  $prefix = 'customfields-tf-'.$number.'-';
  $textarea = new TDOMF_WidgetFieldTextField($prefix);
  
  # update options
  $options = tdomf_widget_customfields_textfield_default_options($number,$options);
  
  $output = $textarea->form($args,$options);
  
  return $before_widget.$output.$after_widget;
}

function tdomf_widget_customfields_textfield_hack($args,$number,$options) {
  extract($args);
  
  $prefix = 'customfields-tf-'.$number.'-';
  $textarea = new TDOMF_WidgetFieldTextField($prefix);
  
  # update options
  $options = tdomf_widget_customfields_textfield_default_options($number,$options);
  
  $output = $textarea->formHack($args,$options);
  
  return $before_widget.$output.$after_widget;
}

function tdomf_widget_customfields_textfield_default_options($number,$options) 
{
  $prefix = 'customfields-tf-'.$number.'-';
  $textfield = new TDOMF_WidgetFieldTextField($prefix);

  # append, size, title, required and defval (aka default-text) are common to all
    
  if(isset($options['title'])) {
      $options[$prefix.'title'] = $options['title'];
  }
  
  if(isset($options['required'])) {
      $options[$prefix.'required'] = $options['required'];
  }
  
  if(isset($options['defval'])) {
      $options[$prefix.'default-text'] = $options['defval'];
  }
  
  if(isset($options['size'])) {
      $options[$prefix.'size'] = $options['size'];
  }  
  
  if(isset($options['tf-subtype'])) {
      $options[$prefix.'restrict-type'] = $options['tf-subtype'];
      unset($options['tf-subtype']);
  }
  
  # grab default widget field options
  
  $options = $textfield->getOptions($options);
  
  return $options;
}


function tdomf_widget_customfields_textfield_control_handler($number,$options) {
  
  $prefix = 'customfields-tf-'.$number.'-';
  $textfield = new TDOMF_WidgetFieldTextField($prefix);
  
  # textarea ones
  
  $options = tdomf_widget_customfields_textfield_default_options($number,$options);

  # now update
  
  # a bit of a hack but works
  ob_start();
  $options = $textfield->control($options,false);
  ob_end_clean();
  
  # make sure to copy 'common' ones back
  
  if(isset($options[$prefix."required"])) {
      $options['required'] = $options[$prefix.'required'];
  }
  
  if(isset($options[$prefix.'default-text'])) {
      $options["defval"] = $options[$prefix.'default-text'];
  }
  
  if(isset($options[$prefix.'size'])) {
      $options['size'] = $options[$prefix.'size'];
  }

  return $options;
}                                                     

function tdomf_widget_customfields_textfield_control($number,$options){ 
  
  $output  = "<h3>".__("Text Field","tdomf")."</h3>";

  $prefix = 'customfields-tf-'.$number.'-';
  $textfield = new TDOMF_WidgetFieldTextField($prefix);
  
  # update options
  $options = tdomf_widget_customfields_textfield_default_options($number,$options);
  
   $tfhide = array($prefix.'title');
  
  # a bit of a hack but works
  ob_start();
  $options = $textfield->control($options,false,false,$tfhide);
  $output .= ob_get_contents();
  ob_end_clean();
  
  return $output;
}

function tdomf_widget_customfields_textfield_preview($args,$number,$options) {
  extract($args);
  
  $prefix = 'customfields-tf-'.$number.'-';
  $textarea = new TDOMF_WidgetFieldTextField($prefix);
  
  # update options
  $options = tdomf_widget_customfields_textfield_default_options($number,$options);
  
  $output = $textarea->preview($args,$options);
  
  return $before_widget.$output.$after_widget;
}

function tdomf_widget_customfields_textfield_validate($args,$number,$options) {
  extract($args);
    
  $prefix = 'customfields-tf-'.$number.'-';
  $textfield = new TDOMF_WidgetFieldTextField($prefix);
  
  # update options
  $options = tdomf_widget_customfields_textfield_default_options($number,$options);
  
  $output = $textfield->validate($args,$options);
  
  // return output if any
  if($output != "") {
    return $before_widget.$output.$after_widget;
  } else {
    return NULL;
  }
}

function tdomf_widget_customfields_textfield_post($args,$number,$options) {
  extract($args);
  
  $prefix = 'customfields-tf-'.$number.'-';
  $textfield = new TDOMF_WidgetFieldTextField($prefix);
  
  # update options
  $options = tdomf_widget_customfields_textfield_default_options($number,$options);
  
  $text = $textfield->post($args,$options,"customfields-textfield-$number");
   
  add_post_meta($post_ID,$options['key'],$text);
  
  return NULL;
}

function tdomf_widget_customfields_textfield_adminemail($args,$number,$options) {
  extract($args);
  $output  = $before_widget;
  $output .= $before_title.__("Custom Field: ","tdomf");
  if($options['title'] != "") {
    $output .= '"'.$options['title'].'" ';
  }
  $output .= '['.$options['key'].']';
  $output .= $after_title;
  $output .= get_post_meta($post_ID,$options['key'],true);
  $output .= $after_widget;
   
  return $output;
}

////////////////////////////////////////////////////////////////////////////////
//                                                   Custom Field as a Hidden //
////////////////////////////////////////////////////////////////////////////////

function tdomf_widget_customfields_hidden($args,$number,$options) {
  $value = htmlentities($options['defval'],ENT_NOQUOTES,get_bloginfo('charset'));
  $output = "\t\t<div><input type=\"hidden\" name=\"customfields-hidden-$number\" id=\"customfields-hidden-$number\" value=\"".htmlentities($value,ENT_QUOTES,get_bloginfo('charset'))."\" /></div>\n";
  return $output;
}

function tdomf_widget_customfields_hidden_post($args,$number,$options) {
  extract($args);
  add_post_meta($post_ID,$options['key'],$args["customfields-hidden-$number"]);
  return NULL;
}

function tdomf_widget_customfields_hidden_control($number,$options){ 
  $output  = "<h3>".__("Hidden","tdomf")."</h3>";
  $output .= "<label for=\"customfields-defval-$number\">";
  $output .= __("Value:","tdomf")."<br/>";
  $output .= "<input type=\"text\" size=\"40\" id=\"customfields-defval-$number\" name=\"customfields-defval-$number\" value=\"".htmlentities($options['defval'],ENT_QUOTES,get_bloginfo('charset'))."\" />";
  $output .= "</label><br/><br/>";
  return $output;
}

////////////////////////////////////////////////////////////////////////////////
//                                                 Custom Field as a Textarea //
////////////////////////////////////////////////////////////////////////////////

function tdomf_widget_customfields_textarea_default_options($number,$options) 
{
  $prefix = 'customfields-ta-'.$number.'-';
  $textarea = new TDOMF_WidgetFieldTextArea($prefix);

  # title, cols, rows, required and defval (aka default-text) are common to all
  
    
  if(isset($options['title'])) {
      $options[$prefix.'title'] = $options['title'];
  }
  
  if(isset($options['required'])) {
      $options[$prefix.'required'] = $options['required'];
  }
  
  if(isset($options["defval"])) {
      $options[$prefix.'default-text'] = $options["defval"];
  }
  
  if(isset($options['cols'])) {
      $options[$prefix.'cols'] = $options['cols'];
  }
  
  if(isset($options['rows'])) {
      $options[$prefix.'rows'] = $options['rows'];
  }
  
  if(isset($options['ta-quicktags'])) {
      $options[$prefix.'quicktags'] = $options['ta-quicktags'];
      unset($options['quicktags']);
  }
  
  if(isset($options['ta-restrict-tags'])) {
      $options[$prefix.'restrict-tags'] = $options['ta-restrict-tags'];
      unset($options['ta-restrict-tags']);
  }
  
  if(isset($options['ta-allowable-tags'])) {
      $options[$prefix.'allowable-tags'] = $options['ta-allowable-tags'];
      unset($options['allowable-tags']);
  }
  
  if(isset($options['ta-char-limit'])) {
      $options[$prefix.'char-limit'] = $options['ta-char-limit'];
      unset($options['ta-char-limit']);
  }
  
  if(isset($options['ta-word-limit'])) {
      $options[$prefix.'word-limit'] = $options['ta-word-limit'];
      unset($options['ta-word-limit']);
  }
  
  if(isset($options['ta-content-filter'])) {
      if($options['ta-content-filter']) {
          $options[$prefix.'use-filter'] = 'preview';
      } else {
          $options[$prefix.'use-filter'] = false;
      }
      $options[$prefix.'filter'] = 'the_content';
      unset($options['ta-content-filter']);
  }
  
  # grab default widget field options
  
  $options = $textarea->getOptions($options);
  
  return $options;
}

function tdomf_widget_customfields_textarea_control_handler($number,$options) {
  
  $prefix = 'customfields-ta-'.$number.'-';
  $textarea = new TDOMF_WidgetFieldTextArea($prefix);

  # textarea ones
  
  $options = tdomf_widget_customfields_textarea_default_options($number,$options);

  # now update
  
  # a bit of a hack but works
  ob_start();
  $options = $textarea->control($options,false);
  ob_end_clean();

  # specific to this widget/textarea

  if(/*isset($_POST["customfields-ta-content-filter-$number"]) ||*/ isset($_POST["customfields-append-$number"])) {
      $options[$prefix.'use-filter'] = /*true*/ 'preview';
      $options[$prefix.'filter'] = 'the_content';
  } else {
      $options[$prefix.'use-filter'] = false;
  }  
  
  # make sure to copy 'common' ones back
  
  if(isset($options[$prefix."required"])) {
      $options['required'] = $options[$prefix.'required'];
  }
  
  if(isset($options[$prefix.'default-text'])) {
      $options["defval"] = $options[$prefix.'default-text'];
  }
  
  if(isset($options[$prefix.'cols'])) {
      $options['cols'] = $options[$prefix.'cols'];
  }

  if(isset($options[$prefix.'rows'])) {
      $options['rows'] = $options[$prefix.'rows'];
  }
  
  return $options;
}                                                      


function tdomf_widget_customfields_textarea_control($number,$options){ 
  
  $output  = "<h3>".__("Text Area","tdomf")."</h3>";

  $prefix = 'customfields-ta-'.$number.'-';
  $textarea = new TDOMF_WidgetFieldTextArea($prefix);
  
  # update options
  $options = tdomf_widget_customfields_textarea_default_options($number,$options);
  
  $tashow = array($prefix.'cols',
                  $prefix.'rows',
                  $prefix.'quicktags',
                  $prefix.'restrict-tags',
                  $prefix.'allowable-tags',
                  $prefix.'char-limit',
                  $prefix.'word-limit',
                  $prefix.'required',
                  $prefix.'default-text');
  # a bit of a hack but works
  ob_start();
  $options = $textarea->control($options,false,$tashow);
  $output .= ob_get_contents();
  ob_end_clean();

  /*$output .= "<label for=\"customfields-ta-content-filter-$number\">";
  $output .= "<input type=\"checkbox\" name=\"customfields-ta-content-filter-$number\" id=\"customfields-ta-content-filter-$number\"";
  if($options[$prefix.'use-filter']) { $output .= " checked "; }
  $output .= "/> ".__("Format like Post Content <i>(convert new lines to paragraphs, etc.)</i>","tdomf")."</label><br/><Br/>";*/
  
  return $output;
}

function tdomf_widget_customfields_textarea($args,$number,$options) {
  extract($args);
  
  $prefix = 'customfields-ta-'.$number.'-';
  $textarea = new TDOMF_WidgetFieldTextArea($prefix);
  
  # update options
  $options = tdomf_widget_customfields_textarea_default_options($number,$options);
  
  $output = $textarea->form($args,$options);
  
  return $before_widget.$output.$after_widget;
}

function tdomf_widget_customfields_textarea_hack($args,$number,$options) {
  extract($args);
  
  $prefix = 'customfields-ta-'.$number.'-';
  $textarea = new TDOMF_WidgetFieldTextArea($prefix);
  
  # update options
  $options = tdomf_widget_customfields_textarea_default_options($number,$options);
  
  $output = $textarea->formHack($args,$options);
  
  return $before_widget.$output.$after_widget;
}

function tdomf_widget_customfields_textarea_validate($args,$number,$options) {
  extract($args);
    
  $prefix = 'customfields-ta-'.$number.'-';
  $textarea = new TDOMF_WidgetFieldTextArea($prefix);
  
  # update options
  $options = tdomf_widget_customfields_textarea_default_options($number,$options);
  
  $output = $textarea->validate($args,$options);
  
  // return output if any
  if($output != "") {
    return $before_widget.$output.$after_widget;
  } else {
    return NULL;
  }
}

function tdomf_widget_customfields_textarea_post($args,$number,$options) {
  extract($args);
  
  $prefix = 'customfields-ta-'.$number.'-';
  $textarea = new TDOMF_WidgetFieldTextArea($prefix);
  
  # update options
  $options = tdomf_widget_customfields_textarea_default_options($number,$options);
  
  $text = $textarea->post($args,$options,"customfields-textarea-$number");
   
  add_post_meta($post_ID,$options['key'],$text);
  
  return NULL;
}

function tdomf_widget_customfields_textarea_adminemail($args,$number,$options) {
  extract($args);
  $output  = $before_widget;
  $output .= $before_title.__("Custom Field: ","tdomf");
  if($options['title'] != "") {
    $output .= '"'.$options['title'].'" ';
  }
  $output .= '['.$options['key'].']';
  $output .= $after_title;
  $output .= get_post_meta($post_ID,$options['key'],true);
  $output .= $after_widget;
  return $output;
}

function tdomf_widget_customfields_textarea_preview($args,$number,$options) {
  extract($args);
  
  $prefix = 'customfields-ta-'.$number.'-';
  $textarea = new TDOMF_WidgetFieldTextArea($prefix);
  
  # update options
  $options = tdomf_widget_customfields_textarea_default_options($number,$options);
  
  $output = $textarea->preview($args,$options);
  
  return $before_widget.$output.$after_widget;
}

////////////////////////////////////////////////////////////////////////////////
//                                                 Custom Field as a Checkbox //
////////////////////////////////////////////////////////////////////////////////

function tdomf_widget_customfields_checkbox_control_handler($number,$options) {
  $options['required'] = isset($_POST["customfields-cb-required-$number"]);
  $options['defval'] = isset($_POST["customfields-cb-defval-$number"]);
  $options['required-value'] = isset($_POST["customfields-required-value-$number"]);
  return $options;
}


function tdomf_widget_customfields_checkbox_control($number,$options){
  $output  = "<h3>".__("Check Box","tdomf")."</h3>";
  
  $output .= "<label for=\"customfields-cb-required-$number\">";
  $output .= "<input type=\"checkbox\" name=\"customfields-cb-required-$number\" id=\"customfields-cb-required-$number\"";
  if($options['required']) { $output .= " checked "; }
  $output .= "/> ".__("Required","tdomf")."</label><br/><Br/>";
  
  $output .= "&nbsp;&nbsp;&nbsp;<label for=\"customfields-required-value-$number\">";
  $output .= "<input type=\"checkbox\" name=\"customfields-required-value-$number\" id=\"customfields-required-value-$number\"";
  if($options['required-value']) { $output .= " checked "; }
  $output .= "/> ".__("Required Setting (<i>checkbox must be this value or the post cannot be submitted</i>)","tdomf")."</label><br/><Br/>";

  $output .= "<label for=\"customfields-cb-defval-$number\">";
  $output .= "<input type=\"checkbox\" name=\"customfields-cb-defval-$number\" id=\"customfields-cb-defval-$number\"";
  if($options['defval']) { $output .= " checked "; }
  $output .= "/> ".__("Default Setting","tdomf")."</label><br/><Br/>";

  return $output;
}
  

function tdomf_widget_customfields_checkbox($args,$number,$options) {
  extract($args);
  
  $output  = $before_widget;
  
  $value = $options['defval'];
  // only grab value if post is previewed!
  if(isset($args["tdomf_key_$tdomf_form_id"])){
    $value = isset($args["customfields-checkbox-$number"]);
  }
  
  if($options['required']) {
    $output .= "<label for=\"customfields-checkbox-$number\" class=\"required\">";
  } else {
    $output .= "<label for=\"customfields-checkbox-$number\">";
  }

  $output .= "<input type=\"checkbox\" name=\"customfields-checkbox-$number\" id=\"customfields-checkbox-$number\"";
  if($value){ $output .= " checked "; }
  $output .= "/> ";
  
  if($options['required']) {
    $output .= $options['title']." ".__("(Required)","tdomf");
  } else {
    $output .= $options['title'];
  }
  
  $output .= "</label>\n";
  
  $output .= $after_widget;
  return $output;
}

function tdomf_widget_customfields_checkbox_hack($args,$number,$options) {
  extract($args);
  
  $output  = $before_widget;
  
  $defval = false;
  if(isset($options['defval']) && is_bool($options['defval'])) {
      $defval = $options['defval'];
  }
  $defval = ($defval) ? "true" : "false" ;  
  
  // only grab value if post is previewed!
  $output = "\t\t<?php \$value = $defval;\n\t\tif(isset(\$post_args['tdomf_key_$tdomf_form_id'])) { \$value = isset(\$post_args['customfields-checkbox-$number']); } ?>\n";
  
  if($options['required']) {
    $output .= "\t\t<label for=\"customfields-checkbox-$number\" class=\"required\">\n";
  } else {
    $output .= "\t\t<label for=\"customfields-checkbox-$number\">\n";
  }

  $output .= "\t\t<input type=\"checkbox\" name=\"customfields-checkbox-$number\" id=\"customfields-checkbox-$number\"";
  $output .= "<?php if(\$value){ ?> checked <?php } ?>";
  $output .= "/>\n\t\t";
  
  if($options['required']) {
    $output .= $options['title']." ".__("(Required)","tdomf")."\n";
  } else {
    $output .= $options['title']."\n";
  }
  
  $output .= "\t\t</label>\n";
  
  $output .= $after_widget;
  return $output;
}

function tdomf_widget_customfields_checkbox_validate($args,$number,$options) {
  extract($args);
  $output = "";
  if($options['required']) {
    if(!isset($args["customfields-checkbox-$number"]) && $options['required-value']){
      if(!empty($options['title'])) {
        $output .= sprintf(__("You must select \"%s\".","tdomf"),$options['title']);
      } else {
        $output .= __("You must select the checkbox!","tdomf");
      }
    } else if(isset($args["customfields-checkbox-$number"]) && !$options['required-value']){
      if(!empty($options['title'])) {
        $output .= sprintf(__("You must not select \"%s\".","tdomf"),$options['title']);
      } else {
        $output .= __("You must not select the checkbox!","tdomf");
      }     
    }
  }
  // return output if any
  if($output != "") {
    return $before_widget.$output.$after_widget;
  } else {
    return NULL;
  }
}

function tdomf_widget_customfields_checkbox_post($args,$number,$options) {
  extract($args);
  add_post_meta($post_ID,$options['key'],isset($args["customfields-checkbox-$number"]));
  return NULL;
}

function tdomf_widget_customfields_checkbox_preview($args,$number,$options) {
  $value = isset($args["customfields-checkbox-$number"]);
  extract($args);  
  $output = $before_widget;  
  if($options['append'] && trim($options['format']) != "") {
    $fmt = tdomf_widget_customfields_gen_fmt($number,$value,$options);
    $output .= trim(tdomf_prepare_string($fmt,$tdomf_form_id,$mode));
  } else {
    if($options['title'] != "") {
      $output .= $before_title.$options['title'].$after_title;
    }
    $output .= $value;
  }
  $output .= $after_widget;
  return $output;
}

function tdomf_widget_customfields_checkbox_adminemail($args,$number,$options) {
  extract($args);
  $output  = $before_widget;
  $output .= $before_title.__("Custom Field: ","tdomf");
  if($options['title'] != "") {
    $output .= '"'.$options['title'].'" ';
  }
  $output .= '['.$options['key'].']';
  $output .= $after_title;
  if(get_post_meta($post_ID,$options['key'],true)) {
    $output .= __("Checked","tdomf");
  } else {
    $output .= __("Not checked","tdomf");
  }
  $output .= $after_widget;
  return $output;
}

////////////////////////////////////////////////////////////////////////////////
//                                                   Custom Field as a Select //
////////////////////////////////////////////////////////////////////////////////

function tdomf_widget_customfields_select_control_handler($number,$options) {
  $options['rows'] = intval($_POST["customfields-s-rows-$number"]); 
  $options['s-multiple'] = isset($_POST["customfields-s-multi-$number"]);
  $options['s-values'] = $_POST["customfields-s-list-values-$number"];
  $options['s-defaults'] = $_POST["customfields-s-list-defaults-$number"];
  return $options;
}

function tdomf_widget_customfields_select_control($number,$options){
  ?>
  
  <h3><?php _e("Select","tdomf"); ?></h3>

  <!-- Javascript taken (and then hacked) from http://www.mredkj.com/tutorials/tutorial006.html -->
  
  <script type="text/javascript">
  //<![CDATA[
    function appendToSelectList<?php echo $number; ?>() {
      var theSel = document.getElementById("customfields-s-list-<?php echo $number; ?>");
      var newText = document.getElementById("customfields-s-item-name-<?php echo $number; ?>").value;
      var newValue = document.getElementById("customfields-s-item-value-<?php echo $number; ?>").value;
      if(newText == "" || newValue == "") {
        alert("<?php _e("You must specify a value for Item name and Item value", "tdomf"); ?>");
        return;
      }
      var settingString = "";
      if (theSel.length == 0) {
        var newOpt1 = new Option(newText, newValue, true, true);
        theSel.options[0] = newOpt1;
        theSel.selectedIndex = 0;
        settingString = settingString + newText + ":" + newValue + ";";
      } else {
        var selText = new Array();
        var selValues = new Array();
        var i;
        for(i=0; i<theSel.length; i++)
        {
          selText[i] = theSel.options[i].text;
          selValues[i] = theSel.options[i].value;
          if(theSel.options[i].value == newValue) {
            alert("<?php _e("That value already exists!", "tdomf"); ?>");
            return;
          }
        }
        for(i=0; i<theSel.length; i++)
        {
          var newOpt = new Option(selText[i], selValues[i], false, false);
          theSel.options[i] = newOpt;
          settingString = settingString + selText[i] + ":" + selValues[i] + ";";
        }
        //var newOpt2 = new Option(newText, newValue, true, false);
        var newOpt2 = new Option(newText, newValue, false, false);
        theSel.options[i] = newOpt2;
        theSel.selectedIndex = -1;
        settingString = settingString + newText + ":" + newValue + ";";
      }
      document.getElementById("customfields-s-list-values-<?php echo $number; ?>").value = settingString;
    }
    function removeFromSelectList<?php echo $number; ?>()
    {
      var theSel = document.getElementById("customfields-s-list-<?php echo $number; ?>");
      var selIndex = theSel.selectedIndex;
      if (selIndex != -1) {
        theSel.options[selIndex] = null;
        var settingString = "";
        for(i=0; i<theSel.length; i++)
        {
          settingString = settingString + theSel.options[i].text + ":" + theSel.options[i].value + ";";
        }
        document.getElementById("customfields-s-list-values-<?php echo $number; ?>").value = settingString;
      } else {
        alert("<?php _e("Please select item to remove from the list!","tdomf"); ?>");
      }
    }
    function makeDefaultSelectList<?php echo $number; ?>()
    {
      var theSel = document.getElementById("customfields-s-list-<?php echo $number; ?>");
      var settingString = "";
      var messageString = "<?php _e("Default selected options will be: ","tdomf"); ?>";
      for(i=0; i<theSel.length; i++)
      {
        if(theSel[i].selected)
        {
          settingString = settingString + theSel.options[i].value + ";";
          messageString = messageString + theSel.options[i].text + ", ";
        }
      }
      document.getElementById("customfields-s-list-defaults-<?php echo $number; ?>").value = settingString;
      document.getElementById("customfields-s-defs-msg-<?php echo $number; ?>").innerHTML = messageString;
    }
  //]]>
  </script>
  
  <input type="hidden" name="customfields-s-list-defaults-<?php echo $number; ?>" id="customfields-s-list-defaults-<?php echo $number; ?>" value="<?php echo $options['s-defaults']; ?>" />
  <input type="hidden" name="customfields-s-list-values-<?php echo $number; ?>" id="customfields-s-list-values-<?php echo $number; ?>" value="<?php echo $options['s-values']; ?>" />
  
  <input type="checkbox" name="customfields-s-multi-<?php echo $number; ?>" id="customfields-s-multi-<?php echo $number; ?>" <?php if($options['s-multiple']){ ?> checked <?php } ?> /> 
  <label for="customfields-s-multi-<?php echo $number; ?>" ><?php _e("Allow multiple selections","tdomf"); ?></label>
  
  <br/><br/>
  
  <label for="customfields-s-rows-<?php echo $number; ?>">
  <?php _e("How many rows?","tdomf"); ?> 
  <input type="text" size="5" name="customfields-s-rows-<?php echo $number; ?>" id="customfields-s-rows-<?php echo $number; ?>" value="<?php echo htmlentities($options['rows'],ENT_QUOTES,get_bloginfo('charset')); ?>" />
  <?php _e("<i>(1 row will create a drop down list)</i>","tdomf"); ?>
  </label>
  
  <br/><br/>

  <input type="button" value="<?php _e("Remove","tdomf"); ?>" onclick="removeFromSelectList<?php echo $number; ?>();" />
  <input type="button" value="<?php _e("Make Current Selection Default","tdomf"); ?>" onclick="makeDefaultSelectList<?php echo $number; ?>();" />
  
  <br/><br/>
  
  <div id="customfields-s-defs-msg-<?php echo $number; ?>" >
    <?php $select_options = split(";",$options['s-values']); 
          $select_defaults = split(";",$options['s-defaults']);
          $defs_msg = "";
          foreach($select_defaults as $select_default) {
            if(trim($select_default) != "" && trim($select_default) != "") {
              foreach($select_options as $select_option) {
                list($text,$value) = split(":",$select_option,2);
                if($value == $select_default) {
                  $defs_msg .= $text.", ";
                }
              }
            }
          }
          if($defs_msg != "") { ?>
            <?php _e("Default selected options will be: ","tdomf"); ?>
            <?php echo $defs_msg; ?>
    <?php } ?>
  </div>
  
  <br/><br/>
  
  <div style="float:left;">
  
  <select name="customfields-s-list-<?php echo $number; ?>" id="customfields-s-list-<?php echo $number; ?>" size="10" multiple="multiple" >
  <?php if(!empty($options['s-values'])) {
          $select_options = split(";",$options['s-values']);
          foreach($select_options as $select_option) {
            list($text,$value) = split(":",$select_option,2);
             if(trim($text) != "" && trim($value) != "") { 
             ?><option value="<?php echo $value; ?>">
             <?php echo $text; ?>
             </option><?php
             }
          }
        } ?>
  </select>
  
  <br/><br/>

 </div>
 
 <div style="float:right;">
 
  
  <label for="customfields-s-item-name-<?php echo $number; ?>">
  <?php _e("Name/Text of Item","tdomf"); ?></label><br/>
  <input type="text" size="30" name="customfields-s-item-name-<?php echo $number; ?>" id="customfields-s-item-name-<?php echo $number; ?>" ?>
  
  <br/><br/>
  
  <label for="customfields-s-item-value-<?php echo $number; ?>">
  <?php _e("Value of Item","tdomf"); ?></label><br/>
  <input type="text" size="30" name="customfields-s-item-value-<?php echo $number; ?>" id="customfields-s-item-value-<?php echo $number; ?>" ?>
  
  <br/><br/>
  
  <input type="button" value="<?php _e("Append Item","tdomf"); ?>" onclick="appendToSelectList<?php echo $number; ?>();" />
  
  </div>
  
  <?php 
}

function tdomf_widget_customfields_select($args,$number,$options) {
    extract($args);
  
    $output  = $before_widget;

    if($options['required']) {
      $output .= "<label for=\"customfields-s-list-$number\" class=\"required\">";
    } else {
      $output .= "<label for=\"customfields-s-list-$number\">";
    }
    if($options['required']) {
      $output .= $options['title']." ".__("(Required)","tdomf");
    } else {
      $output .= $options['title'];
    }
    $output .= "</label><br/>\n";
    
    if($options['s-multiple']) {
      $output .= '<select name="customfields-s-list-'.$number.'[]" id="customfields-s-list-'.$number.'[]" size="'.$options['rows'].'" multiple="multiple" >';
    } else {
      $output .= "<select name=\"customfields-s-list-$number\" id=\"customfields-s-list-$number\" size=\"".$options['rows']."\" >\n";
    }

    $select_defaults = array();
    if(isset($args['customfields-s-list-'.$number])){
      $select_defaults = $args['customfields-s-list-'.$number];
      if(!is_array($select_defaults)) {
        $select_defaults = array( $select_defaults );
      }
    } else if(!empty($options['s-defaults'])) {
      $select_defaults = split(";",$options['s-defaults']);
    }
    
    if(!empty($options['s-values'])) {
      $select_options = split(";",$options['s-values']);
      foreach($select_options as $select_option) {
        list($text,$value) = split(":",$select_option,2);
        if(trim($text) != "" && trim($value) != "") {
          $output .= " <option value=\"$value\" ";
          if(in_array($value,$select_defaults)) {
            $output .= "selected='selected'";
          }
          $output .= "> $text</option>\n"; 
        }
     }
    }
    
    $output .= "</select>";
    $output .= $after_widget;
    
    return $output;
  }

function tdomf_widget_customfields_select_hack($args,$number,$options) {
    extract($args);
  
    $output  = $before_widget;

    if($options['required']) {
      $output .= "\t\t<label for=\"customfields-s-list-$number\" class=\"required\">";
    } else {
      $output .= "\t\t<label for=\"customfields-s-list-$number\">";
    }
    if($options['required']) {
      $output .= $options['title']." ".__("(Required)","tdomf");
    } else {
      $output .= $options['title'];
    }
    $output .= "</label>\n\t\t<br/>\n";
    
    if($options['s-multiple']) {
      $output .= "\t\t".'<select name="customfields-s-list-'.$number.'[]" id="customfields-s-list-'.$number.'[]" size="'.$options['rows'].'" multiple="multiple" >'."\n";
    } else {
      $output .= "\t\t<select name=\"customfields-s-list-$number\" id=\"customfields-s-list-$number\" size=\"".$options['rows']."\" >\n";
    }

    $select_defaults = array();
    if(!empty($options['s-defaults'])) {
      $select_defaults = split(";",$options['s-defaults']);
    }
    
    $output .= "\t\t<?php \$value = array();\n"; 
    $output .= "\t\tif(isset(\$post_args['customfields-s-list-$number'])) {\n";
    $output .= "\t\t\t\$value = \$post_args['customfields-s-list-$number'];\n";
    $output .= "\t\t\tif(!is_array(\$value)) { \$value = array( \$value ); }\n";
    if(!empty($select_defaults)) {
        $output .= "\t\t} else {\n";
        $output .= "\t\t\t\$value = array( ";
        foreach($select_defaults as $def) {
            if(!empty($def)) {
                $output .= '"'.str_replace("\"","\\\"",$def).'", ';
            }
        }
        $output .= " );\n";
    }
    $output .= "\t\t} ?>\n";
    
    if(!empty($options['s-values'])) {
      $select_options = split(";",$options['s-values']);
      foreach($select_options as $select_option) {
        list($text,$value) = split(":",$select_option,2);
        if(trim($text) != "" && trim($value) != "") {
          $output .= "\t\t\t<option value=\"".str_replace("\"","\\\"",$value)."\" ";
          $output .= "<?php if(in_array(\"".str_replace("\"","\\\"",$value)."\",\$value)) { ?> selected <?php } ?>";
          $output .= " > $text</option>\n"; 
        }
     }
    }
    
    $output .= "\t\t</select>\n";
    $output .= $after_widget;
    
    return $output;
  }

  
  
function tdomf_widget_customfields_select_convert($post_input,$options) {
  $opts = split(";",$options['s-values']);
  $message = "";
  if(is_array($post_input)) {
    foreach($opts as $opt) {
        list($text,$value) = split(":",$opt,2);
        if(in_array($value,$post_input)) {
          $message .= $text . ", ";
        }
    }
  } else {
    foreach($opts as $opt) {
        list($text,$value) = split(":",$opt,2);
        if($value == $post_input) {
          $message = $text;
          break;
        }
    }
  }
  return $message;
}
  
function tdomf_widget_customfields_select_preview($args,$number,$options) {
  $vals = $args["customfields-s-list-$number"];
  $message = tdomf_widget_customfields_select_convert($vals,$options);
  
  extract($args);  
  $output = $before_widget;
  if($options['append'] && trim($options['format']) != "") {
    $fmt = tdomf_widget_customfields_gen_fmt($number,$message,$options);
    $output .= trim(tdomf_prepare_string($fmt,$tdomf_form_id,$mode));    
  } else {
    if($options['title'] != "") {
      $output .= $before_title.$options['title'].$after_title;
    }
    $output .= $message;
  }
  $output .= $after_widget;  
  return $output;
}

function tdomf_widget_customfields_select_post($args,$number,$options) {
  extract($args);
  add_post_meta($post_ID,$options['key'],$args["customfields-s-list-$number"]);
  return NULL;
}

function tdomf_widget_customfields_select_adminemail($args,$number,$options) {
  extract($args);
  $output  = $before_widget;
  $output .= $before_title.__("Custom Field: ","tdomf");
  if($options['title'] != "") {
    $output .= '"'.$options['title'].'" ';
  }
  $output .= '['.$options['key'].']';
  $output .= $after_title;
  $value = get_post_meta($post_ID,$options['key'],true);
  $output .= tdomf_widget_customfields_select_convert($value,$options);
  $output .= $after_widget;
  return $output;
}

////////////////////////////////////////////////////////////////////////////////
//                                              Custom Field as a Radio group //
////////////////////////////////////////////////////////////////////////////////

?>

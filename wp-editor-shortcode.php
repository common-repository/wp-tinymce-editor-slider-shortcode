<?php
/*
Plugin Name: WP tinymce editor slider shortcode
Plugin URI: http://wordpress.org/plugins/
Description: tinymc editor add Slider button with shortcode functionality
Author: Abhay Jain
Author URI:https://www.wordpressintegration.com/
Version: 1.1
*/
add_action( 'admin_menu', 'wpescodeInit' );
function wpescodeInit(){
	
	add_menu_page('Editor_shortcode', "Editor shortcode", "manage_options", "editorshortcodes", "wpescodeEditorshortcodes",plugins_url('ico.png',__FILE__),"10");
add_action( 'admin_init', 'wpescodeUpdateEditorshortcodes' );
}
if( !function_exists("wpescodeUpdateEditorshortcodes") )
{
function wpescodeUpdateEditorshortcodes() {
register_setting( 'sliders-settings', 'slider-dots' );
//register_setting( 'sliders-settings',  'bcontrols');
register_setting( 'sliders-settings',  'binfiniteLoop' );
register_setting( 'sliders-settings',  'bautoStart');
register_setting( 'sliders-settings',  'slider-speed');
register_setting( 'sliders-settings',  'show-slide');
register_setting( 'sliders-settings',  'scroll-slide');
register_setting( 'sliders-settings',  'f_show-slide');
register_setting( 'sliders-settings',  'f_scroll-slide');
register_setting( 'sliders-settings',  'slider-speed');
register_setting( 'sliders-settings',  'slider-speed-opt');
register_setting( 'sliders-settings',  'f_breakpoint');
}
}
if(isset($_REQUEST["submit"])){
update_option('slider-dots',sanitize_text_field($_REQUEST['slider-dots']));    
update_option('slider-speed-opt',sanitize_text_field($_REQUEST['slider-speed-opt']));    
update_option('binfiniteLoop',sanitize_text_field($_REQUEST['binfiniteLoop']));    
update_option('bautoStart',sanitize_text_field($_REQUEST['bautoStart'])); 
update_option('show-slide',sanitize_text_field($_REQUEST['show-slide'])); 
update_option('scroll-slide',sanitize_text_field($_REQUEST['scroll-slide'])); 
update_option('f_show-slide',sanitize_text_field($_REQUEST['f_show-slide'])); 
update_option('f_scroll-slide',sanitize_text_field($_REQUEST['f_scroll-slide'])); 
update_option('slider-speed',sanitize_text_field($_REQUEST['slider-speed']));
update_option('f_breakpoint',sanitize_text_field($_REQUEST['f_breakpoint'])); 
echo '<div id="message" class="updated"><p>Options Updates</p></div>';
}
function wpescodeEditorshortcodes() { ?>
<p>This slider give you advantage to show slider with use of shortcode:</p><p>
[slider-shortcode img="" classname="test"]</p>
<h2>Settings</h2>
  <?php settings_errors(); ?>
<form method="post" action="options.php">
<?php settings_fields( 'sliders-settings' ); ?>
<?php do_settings_sections( 'sliders-settings' ); ?>
<div class="form-group">
<table class="form-table">
<tbody>
<tr>
<th scope="row">Default Slider Settings</th>
<td>
<fieldset>
<legend class="screen-reader-text"><span>Default Slider Settings</span></legend>
<br>
<label>
<input type="checkbox" class="form-control"   name="bautoStart" value="true" <?php if(get_option( 'bautoStart' )):?> checked <?php endif;?> >
autoStart
</label>
<br>
<label>
<input type="checkbox" class="form-control"  name="slider-dots" value="true" <?php if(get_option( 'slider-dots' )):?> checked <?php endif;?> />
Dots options
</label>
<br>
<br>
<label>
slides To Show 
<input type="text" class="form-control" name="show-slide" value="<?php echo get_option('show-slide') ?>">
</label>
<br>
<br>
<label>
slides To Scroll 
<input type="text" class="form-control"   name="scroll-slide" value="<?php echo get_option('scroll-slide') ?>">
</label>
<br>
<br>
<label>
 Slider speed	
<input type="text" class="form-control" name="slider-speed-opt" value="<?php echo get_option( 'slider-speed-opt' ) ?>">
</label>
<br>
<br>
<label>
Autoplay Speed	
<input type="text" class="form-control" name="slider-speed" value="<?php echo get_option( 'slider-speed' ) ?>">
</label>
<br>
<h2> Mobile setting image Slider(First breakpoint Setting)</h2>
<br>
<label>
First breakpoint 	
<input type="text" class="form-control" name="f_breakpoint" value="<?php echo get_option( 'f_breakpoint' ) ?>">
</label>
<br>
<br>
<label>
First breakpoint slides To Scroll	
<input type="text" class="form-control" name="f_show-slide" value="<?php echo get_option( 'f_show-slide' ) ?>">
</label>
<br>
<br>
<label>
First breakpoint scroll to slide	
<input type="text" class="form-control" name="f_scroll-slide" value="<?php echo get_option( 'f_scroll-slide' ) ?>">
</label>
<br>
<p class="description">(These settings may be overrid the default settings.)</p>
</fieldset>
</td>
</tr>
</tr>
</tbody>
</table>
</div>
<?php //submit_button(); ?>
<input type="submit" value="submit" class="button-primary" />
</form>
<?php }
function wpescodeSliderShortcode($atts) {
$html="";
$atts = shortcode_atts(
		array(
			'img' => '',
			'classname' => '',
		), $atts, 'slider-shortcode' );
	if($atts['img']!=''){
	
		$img_id=explode(',',$atts['img']);
		if($atts['classname']){
		$classname=$atts['classname'];	
		}
		else{
		$classname='';	
		}
		
			$html.='<div class="shortcode-slider '.$classname.'">';
			foreach($img_id as $attchment_id){
			$image_url= wp_get_attachment_url($attchment_id);
			$caption = wp_get_attachment_caption($attchment_id);
			$alt = get_post_meta($attchment_id, '_wp_attachment_image_alt', true);
        $html.= '<div>
        <img src="'.$image_url.'" alt="'.$alt.'"></div>';
		 }
		$html .=  '</div>';
	
		
return $html;
}
}
add_shortcode('slider-shortcode', 'wpescodeSliderShortcode');
function wpescodeCustomScriptsMethod() {
	wp_enqueue_script( 'slick-js',plugins_url('/assets/js/slick.min.js',__FILE__));
	wp_enqueue_style('slick-css', plugins_url('/assets/css/slick.css',__FILE__));
}
add_action( 'wp_footer', 'wpescodeCustomScriptsMethod' );
function wpescodeUploadMceButton() {
  // Check if user have permission
  if ( !current_user_can( 'edit_posts' ) && !current_user_can( 'edit_pages' ) ) {
    return;
  }
  // Check if WYSIWYG is enabled
  if ( 'true' == get_user_option( 'rich_editing' ) ) {
    add_filter( 'mce_external_plugins', 'wpescodeUploadButtonTinymcePlugin' );
    add_filter( 'mce_buttons', 'wpescodeUploadButtonRegisterMceButton' );
  }
}
add_action('admin_head', 'wpescodeUploadMceButton');
// Function for new button
function wpescodeUploadButtonTinymcePlugin( $plugin_array ) {
  //$plugin_array['upload_mce_button'] = plugins_url() .'/wp-editor-shortcode/assets/js/custom-editor.js';
	$plugin_array['upload_mce_button'] = plugins_url('/assets/js/custom-editor.js',__FILE__);
  return $plugin_array;
}
// Register new button in the editor
function wpescodeUploadButtonRegisterMceButton( $buttons ) {
  array_push( $buttons, 'upload_mce_button' );
  return $buttons;
}
add_action( 'wp_footer', 'wpescodeSliderCustomScript', 100 );
function wpescodeSliderCustomScript(){
	if(get_option('bautoStart')){
	$autoplay=get_option('bautoStart');	
	}
	else{
	$autoplay='false';	
	}
	if(get_option('slider-dots')){
		$dots= get_option('slider-dots');
	}
	else{
		$dots= 'false';
	}
   if(get_option('show-slide')){
   	$slidesToShow=get_option('show-slide');
   }
   else{
   	$slidesToShow=1;
   }
   if(get_option('scroll-slide')){
   	$slidesToScroll=get_option('scroll-slide');
   }
   else{
   	$slidesToScroll=1;
   }
  
  if(get_option('slider-speed-opt')){
   	$sliderspeedopt=get_option('slider-speed-opt');
   }
   else{
   	$sliderspeedopt=500;
   }
   
   if(get_option('slider-speed')){
   	$sliderspeed=get_option('slider-speed');
   }
   else{
   	$sliderspeed=500;
   }
   if(get_option('f_breakpoint')){
   	$f_breakpoint=get_option('f_breakpoint');
   }
   else{
   	$f_breakpoint=600;
   }
   if(get_option('f_show-slide')){
   	$f_showslide=get_option('f_show-slide');
   }
   else{
   	$f_showslide=1;
   }
   if(get_option('f_scroll-slide')){
   	$f_scrollslide=get_option('f_scroll-slide');
   }
   else{
   	$f_scrollslide=1;
   }
	
?>
<script>
jQuery(document).ready(function($) {
	jQuery('.shortcode-slider').slick({
	   autoplay:<?php echo $autoplay ?>,
	   autoplaySpeed:<?php echo $sliderspeed?>,
	   speed:<?php echo $sliderspeedopt ?>,
	   dots:<?php echo $dots ?>,
		infinite: false,
		slidesToShow: <?php echo $slidesToShow ?>,
        slidesToScroll: <?php echo $slidesToScroll ?>,
		adaptiveHeight: false,
		responsive: [
    {
      breakpoint: <?php echo $f_breakpoint?>,
      settings: {
        slidesToShow: <?php echo $f_showslide?>,
        slidesToScroll: <?php echo $f_scrollslide?>
      }
    },
    {
      breakpoint: 480,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1
      }
    }
    // You can unslick at a given breakpoint now by adding:
    // settings: "unslick"
    // instead of a settings object
  ]
	});
	
});
</script>
<?php } ?>
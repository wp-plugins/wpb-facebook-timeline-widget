<?php
/**
Plugin Name: WPB Facebook Timeline widget
Plugin URI: http://demo.wpbean.com/wpb-facebook-timeline-widget
Description: Just install this plugin & put shortcode to a text widget to enable Facebook Timeline on your Wordpress sidebar. Shortcode example: [facebook-timeline fb_id="facebook_id"]  &nbsp;&nbsp;&nbsp;&nbsp; jQuery Plugin by: <a href="https://github.com/ffabiosales/FaceBadge">ffabiosales</a>.
Author: wpbean
Version: 1.0
Author URI: http://wpbean.com
*/

//--------------- Adding Latest jQuery------------//
function wpb_ft_jquery() {
	wp_enqueue_script('jquery');
}
add_action('init', 'wpb_ft_jquery');


//-------------- include js files---------------//
function wpb_ft_reg_js() {
	wp_register_script('wpb_ft_js', plugins_url('js/jquery.faceBadge.js', __FILE__), array('jquery'),'1.10.2', true);
	wp_enqueue_script('wpb_ft_js');
}
add_action( 'wp_enqueue_scripts', 'wpb_ft_reg_js' ); 


//------------ include css files-----------------//
function wpb_ft_style() {
	wp_register_style('wpb_ft_main', plugins_url('css/faceBadge.css', __FILE__),'','1.10.2', false);
	wp_enqueue_style('wpb_ft_main');
}
add_action( 'init', 'wpb_ft_style' ); 



// shortcode enable for text widget
add_filter('widget_text', 'do_shortcode');

// shortcode register
function wpb_ft_function($atts) {
	global $wpb_atts;
	$wpb_atts = shortcode_atts(array(
      'fb_id' => 'wpbean',
   ), $atts);

    $wpb_ft_return_string = '<div class="wpb_ft"></div>';
	
	function wpb_trigger_ft(){
	?>
	<script>

		jQuery(document).ready(function() {
			jQuery(".wpb_ft").faceBadge({
				pageId: "<?php global $wpb_atts; echo $wpb_atts['fb_id'];?>", //The ID of your paga. aftder facebook.com/
				loaderText: "Loading...", //Text to show before load all data.
				width: 350,
				coverHeight: 113, //The height of cover div in the FaceBadge.
				showDesc: false, //Show/Hide some text of your Page.
				linkToPage: true //add a link direct to your Page in the thumbnail.
			});
		});

	</script>
	<?php
	}
	add_action('wp_footer','wpb_trigger_ft');
	
	
    return $wpb_ft_return_string;
}
function wpb_ft_register_shortcodes(){
   add_shortcode('facebook-timeline', 'wpb_ft_function');
}
add_action( 'init', 'wpb_ft_register_shortcodes');
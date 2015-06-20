<?php
/*
Plugin Name: Smart News Ticker
Plugin URI:  http://wppluginarea.com/smart-news-ticker/
Description: This plugin enable by Smart News Ticker for wordpress, In This plugin you will get these facilities easy installation, multiple sortcodes, color variation and many more.
Author: Wp Plugin Area
Author URI: http://wppluginarea.com
Version: 2.1
*/

/* Adding Latest jQuery from Wordpress */
function smooth_ticker_latest_jquery() {
	wp_enqueue_script('jquery');
}
add_action('init', 'smooth_ticker_latest_jquery');

/*Some Set-up*/
define('TP_SMOOTH_TICKER', WP_PLUGIN_URL . '/' . plugin_basename( dirname(__FILE__) ) . '/' );

/* Adding Plugin javascript file */
wp_enqueue_script('tp-news-ticker-plugin-js', TP_SMOOTH_TICKER.'js/inewsticker.js', array('jquery'));
/* Adding Plugin css file */
wp_enqueue_style('tp-news-ticker-plugin-js', TP_SMOOTH_TICKER.'css/ticker.css');
/* Adding Plugin css file */
wp_enqueue_style('tp-news-scroll-ticker-plugin-js', TP_SMOOTH_TICKER.'css/li-scroller.css');



// Hooks your functions into the correct filters
function tp_ticker_mce_button() {
	// check user permissions
	if ( !current_user_can( 'edit_posts' ) && !current_user_can( 'edit_pages' ) ) {
		return;
	}
	// check if WYSIWYG is enabled
	if ( 'true' == get_user_option( 'rich_editing' ) ) {
		add_filter( 'mce_external_plugins', 'tp_add_tinymce_plugin' );
		add_filter( 'mce_buttons', 'tp_ticker_register_mce_button' );
	}
}
add_action('admin_head', 'tp_ticker_mce_button');

// Declare script for new button
function tp_add_tinymce_plugin( $plugin_array ) {
	$plugin_array['tp_ticker_button'] = plugins_url('js/ticker-custom-button.js', __FILE__);
	return $plugin_array;
}

// Register new button in the editor
function tp_ticker_register_mce_button( $buttons ) {
	array_push( $buttons, 'tp_ticker_button' );
	return $buttons;
}

//Tinymc css load functions
function tp_ticker_mce_css() {
	wp_enqueue_style('ticker_shortcode_mc', plugins_url('/css/tp-ticker-mc.css', __FILE__) );
}
add_action( 'admin_enqueue_scripts', 'tp_ticker_mce_css' );



/* Add Plugin Loop Code */
function smooth_ticker_list_shortcode($atts){
	extract( shortcode_atts( array(
		'title' => 'Latest News',
		'count' => '-1',
		'effect' => 'slide',
		'title_bg' => '#333',
		'color' => '#000',
		'ticker_bg' => '',
		'id' => 'ticker',
		'speed' => '2000',
		'fontsize' => '13',
		'category' => ''
	), $atts, '' ) );
	
    $q = new WP_Query(
        array('posts_per_page' => $count, 'post_type' => 'post', 'category_name' => $category)
        );		

	$list = '
		<script type="text/javascript">
			jQuery(document).ready(function(){
				jQuery("#smoothticker'.$id.'").inewsticker({
					speed           : '.$speed.',
					effect          : "'.$effect.'",
					font_size       : '.$fontsize.',
					color           : "#000",
					font_family     : "arial",
					dir             : "ltr",
					delay_after 	: 1000,					
			});
		}); 	
	</script>
	<div id="tp_ticker" style="background-color:'.$ticker_bg.';"><strong style="background-color:'.$title_bg.'">'.$title.'</strong><ul id="smoothticker'.$id.'">'; 
		while($q->have_posts()) : $q->the_post();
			$idd = get_the_ID();
			$list .= '
				<li><a style="color:'.$color.'" href="'.get_permalink().'">'.get_the_title().'</a></li>	
				';        
		endwhile;
		$list.= '</ul></div>';
		wp_reset_query();
		return $list;
}
add_shortcode('tp_smart_ticker', 'smooth_ticker_list_shortcode');	



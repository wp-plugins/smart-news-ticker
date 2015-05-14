<?php
/*
Plugin Name: Smart News Ticker
Plugin URI:  http://touchpointdev.com/smart-news-ticker/
Description: This plugin enable by Smart News Ticker for wordpress, In This plugin you will get these facilities easy installation, multiple sortcodes, color variation and many more.
Author: Touch Point Dev
Author URI: http://touchpointdev.com
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


/* Add Slider Shortcode Button on Post Visual Editor */
function tp_ticker_button_function() {
	add_filter ("mce_external_plugins", "tp_tickerl_button_js");
	add_filter ("mce_buttons", "tp_ticker_button");
}

function tp_tickerl_button_js($plugin_array) {
	$plugin_array['tptickers'] = plugins_url('js/ticker-custom-button.js', __FILE__);
	return $plugin_array;
}

function tp_ticker_button($buttons) {
	array_push ($buttons, 'tpticker');
	return $buttons;
}
add_action ('init', 'tp_ticker_button_function'); 


/* Add Plugin Loop Code */
function smooth_ticker_list_shortcode($atts){
	extract( shortcode_atts( array(
		'text' => 'Latest News',
		'count' => '-1',
		'effect' => 'slide',
		'textbg' => '#333',
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
	<div id="tp_ticker" style="background-color:'.$ticker_bg.';"><strong style="background-color:'.$textbg.'">'.$text.'</strong><ul id="smoothticker'.$id.'">'; 
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



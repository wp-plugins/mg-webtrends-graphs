<?php
/*
Plugin Name: MG-WebTrends-Graphs
Plugin URI: http://www.mirkogrewing.it/mg-webtrends-graphs/
Description: Embed a Google Trends graphic in your website in a handful of second thanks to the shortcode provided by this plugin and the shortcode builder integrated in the editor.
Version: 1.0
Author: Mirko Grewing
Author URI: http://www.mirkogrewing.it

	Copyright: © 2013 Mirko Grewing (email : mirko@grewing.me)
	License: GNU General Public License v3.0
	License URI: http://www.gnu.org/licenses/gpl-3.0.html
*/

add_action('admin_head', 'mgtrends_add_my_tc_button');
load_plugin_textdomain('mgtrends_tc_button', false, dirname(plugin_basename(__FILE__)) . '/languages/');

/**
 * Main function to call the button
 * 
 * @return null
 */
function mgtrends_add_my_tc_button()
{
	global $typenow;
	// check user permissions
	if (!current_user_can('edit_posts') && !current_user_can('edit_pages')) {
		return;
	}
	// verify the post type
    if (!in_array($typenow, array('post', 'page')))
		return;
	// check if WYSIWYG is enabled
	if (get_user_option('rich_editing') == 'true') {
		add_filter("mce_external_plugins", "mgtrends_add_tinymce_plugin");
		add_filter('mce_buttons', 'mgtrends_register_my_tc_button');
	}
}

/**
 * Specify the path of TinyMCE plugin
 * 
 * @return array
 */
function mgtrends_add_tinymce_plugin($plugin_array)
{
	$plugin_array['mgtrends_tc_button'] = plugins_url( '/js/mgtrends_plugin.js', __FILE__ );
	return $plugin_array;
}

/**
 * Add a button to the editor
 * 
 * @return array
 */
function mgtrends_register_my_tc_button($buttons)
{
	array_push($buttons, "mgtrends_tc_button");
	return $buttons;
}

/**
 * Load a specific CSS
 * 
 * @return array
 */
function mgtrends_tc_css()
{
	wp_enqueue_style('mgtrends-tc', plugins_url('/css/mgtrends.css', __FILE__));
}

add_action('admin_enqueue_scripts', 'mgtrends_tc_css');

/**
 * Load translations
 * 
 * @return string
 */
function mgtrends_lang($locales)
{
	$locales['mgtrends_tc_button'] = plugin_dir_path ( __FILE__ ) . 'languages/translations.php';
	return $locales;
}

add_filter( 'mce_external_languages', 'mgtrends_lang');

/**
 * Parse the parameters from the shortcode
 *
 * @return null
 */
function mg_trend($atts)
{
	extract(shortcode_atts(array(
		'w' => '500',           // width
		'h' => '330',           // height
		'q' => '',              // query
		'loc' => '',          	// location
		'val' => 'std',         // average trigger
		'sdate' => '',          // start date
		'elaps' => '',          // timeframe
	), $atts));
	$h=(int)$h;
	$w=(int)$w;
	$q=esc_attr($q);
	$loc=esc_attr($loc);
	$lan=str_replace("_","-",get_locale());
    $val=esc_attr($val);
    $sdate = esc_attr($sdate);
    $elaps = (int)$elaps;
	ob_start();
	?>
	<script type="text/javascript" src="http://www.google.com/trends/embed.js?hl=<?php echo $lan;?>&q=<?php echo $q;?><?php echo '',(!empty($sdate)) ? '&date=' . $sdate .'+' . $elaps .'m' : ''; ?>&geo=<?php echo $loc;?>&cmpt=q&content=1&cid=<?php echo '', ($avg == 'avg') ? 'TIMESERIES_GRAPH_AVERAGES_CHART' : 'TIMESERIES_GRAPH_0'; ?>&export=5&w=<?php echo $w;?>&h=<?php echo $h;?>"></script>
	<?php return ob_get_clean();
}

add_shortcode('mgtrends', 'mg_trend');
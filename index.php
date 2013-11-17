<?php
/*
Plugin Name: MG-WebTrends-Graphs
Plugin URI: http://www.mirkogrewing.it/mg-webtrends-graphs/
Description: Embed a Google Trends graphic in your website in a handful of second thanks to the shortcode provided by this plugin and the shortcode builder integrated in the editor.
Version: 0.3
Author: Mirko Grewing
Author URI: http://www.mirkogrewing.it

	Copyright: © 2013 Mirko Grewing (email : mirko@grewing.me)
	License: GNU General Public License v3.0
	License URI: http://www.gnu.org/licenses/gpl-3.0.html
*/

if ( ! defined( 'ABSPATH' ) )
	die( "Can't load this file directly" );

class MGTrends
{
	function __construct() {
		add_action( 'admin_init', array( $this, 'action_admin_init' ) );
	}
	
	function action_admin_init() {
		// only hook up these filters if we're in the admin panel, and the current user has permission
		// to edit posts and pages
		if ( current_user_can( 'edit_posts' ) && current_user_can( 'edit_pages' ) ) {
			add_filter( 'mce_buttons', array( $this, 'filter_mce_button' ) );
			add_filter( 'mce_external_plugins', array( $this, 'filter_mce_plugin' ) );
		}
	}
	
	function filter_mce_button( $buttons ) {
		// add a separation before our button, here our button's id is "mgtrends_button"
		array_push( $buttons, '|', 'mgtrends_button' );
		return $buttons;
	}
	
	function filter_mce_plugin( $plugins ) {
		// this plugin file will work the magic of our button
		$plugins['mgtrends'] = plugin_dir_url( __FILE__ ) . 'js/mgtrends_plugin.js';
		return $plugins;
	}
}

function mg_trend($atts){
	extract( shortcode_atts( array(
			'w' => '500',           // width
			'h' => '330',           // height
			'q' => '',              // query
			'loc' => 'US',          // location
            'val' => 'std',         // average trigger
            'sdate' => '',          // start date
            'elaps' => '',          // timeframe
	), $atts ) );
	//format input
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
	<?php
	return ob_get_clean();
}

add_shortcode('mgtrends','mg_trend');
$mygallery = new MGTrends();

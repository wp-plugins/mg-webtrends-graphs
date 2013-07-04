<?php

/*
Plugin Name: MG Webtrends Graphs
Plugin URI: http://www.mirkogrewing.eu/mg-webtrends-graphs/
Description: This plugin provides a shortcode that allows to embed a Google WebTrends graphic in your website.
Version: 0.1
Author: Mirko Grewing
Author URI: http://www.mirkogrewing.eu

	Copyright: © 2013 Mirko Grewing (email : mirko@grewing.us)
	License: GNU General Public License v3.0
	License URI: http://www.gnu.org/licenses/gpl-3.0.html
*/

define('MGTRENDS_DIR', plugin_dir_path(__FILE__));
define('MGTRENDS_URL', plugin_dir_url(__FILE__));

function mgtrends_load(){
    require_once(MGTRENDS_DIR.'includes/core.php');
}
mgtrends_load();

?>
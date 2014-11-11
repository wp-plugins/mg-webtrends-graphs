<?php

if (!defined('ABSPATH'))
	exit;

if (!class_exists('_WP_Editors'))
	require(ABSPATH . WPINC . '/class-wp-editor.php');

function mgtrends_translation()
{
	$strings = array(
		'popup_title' => esc_js( __('Add MG Web Trends Shortcode', 'mgtrends_tc_button') ),
		'width_label' => esc_js( __('Width (Pixels)', 'mgtrends_tc_button') ),
		'height_label' => esc_js( __('Height (Pixels)', 'mgtrends_tc_button') ),
		'geoloc_label' => esc_js( __('Geolocation (e.g. US)', 'mgtrends_tc_button') ),
		'values_label' => esc_js( __('Values', 'mgtrends_tc_button') ),
		'average_label' => esc_js( __('Average', 'mgtrends_tc_button') ),
		'sdate_label' => esc_js( __('Start Date (MM/YYYY, e.g. 01/2010)', 'mgtrends_tc_button') ),
		'elapsed_label' => esc_js( __('Elapsed (Months)', 'mgtrends_tc_button') ),
		'keywords_label' => esc_js( __('Keywords (Comma Separated)', 'mgtrends_tc_button') )
	);
	
	$locale = _WP_Editors::$mce_locale;
	$translated = 'tinyMCE.addI18n("' . $locale . '.mgtrends_tc_button", ' . json_encode($strings) . ");\n";
	
	return $translated;
}

$strings = mgtrends_translation();
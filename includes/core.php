<?php
	function mg_trend($atts){
		extract( shortcode_atts( array(
				'w' => '500',           // width
				'h' => '330',           // height
				'q' => '',              // query
				'loc' => 'US',          // location
		), $atts ) );
		//format input
		$h=(int)$h;
		$w=(int)$w;
		$q=esc_attr($q);
		$loc=esc_attr($loc);
		$lan=str_replace("_","-",get_locale());
		ob_start();
		?>
		<script type="text/javascript" src="http://www.google.com/trends/embed.js?hl=<?php echo $lan;?>&q=<?php echo $q;?>&geo=<?php echo $loc;?>&cmpt=q&content=1&cid=TIMESERIES_GRAPH_0&export=5&w=<?php echo $w;?>&h=<?php echo $h;?>"></script>
		<?php
		return ob_get_clean();
	}
	add_shortcode('mgtrends','mg_trend');
?>
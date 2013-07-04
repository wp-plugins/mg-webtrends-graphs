// closure to avoid namespace collision
(function(){
	// creates the plugin
	tinymce.create('tinymce.plugins.mgtrends', {
		// creates control instances based on the control's id.
		// our button's id is "mgtrends_button"
		createControl : function(id, controlManager) {
			if (id == 'mgtrends_button') {
				// creates the button
				var button = controlManager.createButton('mgtrends_button', {
					title : 'MG Trends Shortcode', // title of the button
					image : '../wp-content/plugins/mg-webtrends-graphs/mg_webtrends_graph.png',  // path to the button's image
					onclick : function() {
						// triggers the thickbox
						var width = jQuery(window).width(), H = jQuery(window).height(), W = ( 720 < width ) ? 720 : width;
						W = W - 80;
						H = H - 84;
						tb_show( 'MG Trends Shortcode', '#TB_inline?width=' + W + '&height=' + H + '&inlineId=mgtrends-form' );
					}
				});
				return button;
			}
			return null;
		}
	});
	
	// registers the plugin. DON'T MISS THIS STEP!!!
	tinymce.PluginManager.add('mgtrends', tinymce.plugins.mgtrends);
	
	// executes this when the DOM is ready
	jQuery(function(){
		// creates a form to be displayed everytime the button is clicked
		// you should achieve this using AJAX instead of direct html code like this
		var form = jQuery('<div id="mgtrends-form"><table id="mgtrends-table" class="form-table">\
			<tr>\
				<th><label for="mgtrends-w">Width</label></th>\
				<td><input type="text" id="mgtrends-w" name="w" value="500" /><br />\
				<small>Specify the width of the graph in pixels.</small></td>\
			</tr>\
			<tr>\
				<th><label for="mgtrends-h">Height</label></th>\
				<td><input type="text" name="h" id="mgtrends-h" value="330" /><br />\
				<small>Specify the height of the graph in pixels</small>\
			</tr>\
			<tr>\
				<th><label for="mgtrends-q">Query</label></th>\
				<td><input type="text" name="q" id="mgtrends-q" value="" /><br />\
				<small>Enter the value to look for, separated by comma.</small></td>\
			</tr>\
			<tr>\
				<th><label for="mgtrends-loc">Geolocalization</label></th>\
				<td><input type="text" name="loc" id="mgtrends-loc" value="US" /><br />\
					<small>Enter the two-letters country code (es. US).</small></td>\
			</tr>\
		</table>\
		<p class="submit">\
			<input type="button" id="mgtrends-submit" class="button-primary" value="Insert Shortcode" name="submit" />\
		</p>\
		</div>');
		
		var table = form.find('table');
		form.appendTo('body').hide();
		
		// handles the click event of the submit button
		form.find('#mgtrends-submit').click(function(){
			// defines the options and their default values
			// again, this is not the most elegant way to do this
			// but well, this gets the job done nonetheless
			var options = { 
				'w'		: '500',
				'h'		: '330',
				'q'		: '',
				'loc'	: 'US'
				};
			var shortcode = '[mgtrends';
			
			for( var index in options) {
				var value = table.find('#mgtrends-' + index).val();
				if (index == 'q' ) {
					value = value.replace(/(^\s+|\s+$)/g, '');
					value = value.replace(/\s{2,}/g, ' ');
					value = value.replace(/, /g,",");
					value = value.replace(/ ,/g,",");
					value = value.replace(/ /g,"+");
					value = value.replace(/,/g,",+");
					value = "+" + value;
				}	
				// attaches the attribute to the shortcode only if it's different from the default value
				if ( value !== options[index] )
					shortcode += ' ' + index + '="' + value + '"';
			}
			
			shortcode += ']';
			
			// inserts the shortcode into the active editor
			tinyMCE.activeEditor.execCommand('mceInsertContent', 0, shortcode);
			
			// closes Thickbox
			tb_remove();
		});
	});
})()
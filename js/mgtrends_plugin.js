(function() {
    tinymce.PluginManager.add('mgtrends_tc_button', function( editor, url ) {
        editor.addButton( 'mgtrends_tc_button', {
            title: 'MG Web Trends',
            icon: 'icon dashicons-chart-bar',
            onclick: function() {
				editor.windowManager.open( {
					title: editor.getLang('mgtrends_tc_button.popup_title'),
					body: [
						{
							type: 'textbox',
							name: 'width',
							label: editor.getLang('mgtrends_tc_button.width_label')
						},
						{
							type: 'textbox',
							name: 'height',
							label: editor.getLang('mgtrends_tc_button.height_label')
						},
						{
							type: 'textbox',
							name: 'geoloc',
							label: editor.getLang('mgtrends_tc_button.geoloc_label')
						},
						{
							type: 'listbox',
							name: 'values',
							label: editor.getLang('mgtrends_tc_button.values_label'),
							'values': [
								{text: 'Standard', value: 'std'},
								{text: editor.getLang('mgtrends_tc_button.average_label'), value: 'avg'}
							]
						},
						{
							type: 'textbox',
							name: 'sdate',
							label: editor.getLang('mgtrends_tc_button.sdate_label')
						},
						{
							type: 'textbox',
							name: 'elaps',
							label: editor.getLang('mgtrends_tc_button.elapsed_label')
						},
						{
							type: 'textbox',
							name: 'query',
							label: editor.getLang('mgtrends_tc_button.keywords_label')
						}
					],
					onsubmit: function( e ) {
						var shortcode = '[mgtrends';
						var newKeyword = e.data.query;
						newKeyword = newKeyword.replace(/(^\s+|\s+$)/g, '');
						newKeyword = newKeyword.replace(/\s{2,}/g, ' ');
						newKeyword = newKeyword.replace(/, /g, ",");
						newKeyword = newKeyword.replace(/ ,/g, ",");
						newKeyword = newKeyword.replace(/ /g, "+");
						newKeyword = newKeyword.replace(/,/g, ",+");
						newKeyword = "+" + newKeyword;
						if (e.data.width === '') {
							shortcode += ' w="500"';
						} else {
							shortcode += ' w="' + e.data.width + '"';
						}
						if (e.data.height === '') {
							shortcode += ' h="300"';
						} else {
							shortcode += ' h="' + e.data.height + '"';
						}
						if (e.data.geoloc !== '') {
							shortcode += ' loc="' + e.data.geoloc + '"';
						}
						if (e.data.values !== '') {
							shortcode += ' val="' + e.data.values + '"';
						}
						if (e.data.sdate !== '') {
							shortcode += ' sdate="' + e.data.sdate + '"';
						}
						if (e.data.elaps !== '') {
							shortcode += ' elaps="' + e.data.elaps + '"';
						}
						shortcode += ' q="' + newKeyword + '"';
						shortcode += ']';
						editor.insertContent(shortcode);
					}
				});
			}
        });
    });
})();
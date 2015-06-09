
(function() {
	tinymce.PluginManager.add('tp_ticker_button', function( editor, url ) {
		editor.addButton( 'tp_ticker_button', {
			icon: 'sullu',
			title : 'Smart Ticker',
			onclick: function() {
				editor.insertContent('[tp_smart_ticker]');
			}
		});
	});
})();
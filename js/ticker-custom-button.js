

(function() {
	tinymce.PluginManager.add('tp_ticker_button', function( editor, url ) {
		editor.addButton( 'tp_ticker_button', {
			icon: 'chukku',
			type: 'menubutton',
			title : 'News Ticker',
					menu: [
						{
							text: 'News Ticker',
							onclick: function() {
								editor.windowManager.open( {
									title: 'Insert Ticker Shortcode',
									width: 600,
									height: 335,
									body: [
										{
											type: 'textbox',
											name: 'tickerID',
											label: 'Ticker ID',
											value: 'Write_Anything'
											
										},
										{
											type: 'textbox',
											name: 'tickerTitle',
											label: 'Ticker Text',
											value: 'Latest News'
											
										},
										{
											type: 'textbox',
											name: 'TickertitleBg',
											label: 'Title Background',
											value: '#333333'
											
										},
										{
											type: 'listbox',
											name: 'Tickereffect',
											label: 'Ticker Effect',
											'values': [
												{text: 'Slide', value: 'slide'},
												{text: 'Fade', value: 'fade'}
											]
										},
										{
											type: 'textbox',
											name: 'TickerTextColor',
											label: 'Ticker Text Color',
											value: '#00000'
											
										},
										{
											type: 'textbox',
											name: 'TickerfontSize',
											label: 'Font Size',
											value: '13'
											
										},
										{
											type: 'textbox',
											name: 'tickerBgColor',
											label: 'Ticker BG Color'
											
										},	
										{
											type: 'textbox',
											name: 'tickerCategory',
											label: 'Category'
										}										
									],
									onsubmit: function( e ) {
										editor.insertContent( '[tp_smart_ticker id="' + e.data.tickerID + '" text="' + e.data.tickerTitle + '" textbg="' + e.data.TickertitleBg + '" effect="' + e.data.Tickereffect + '" color="' + e.data.TickerTextColor + '" ticker_bg="' + e.data.tickerBgColor + '" category="' + e.data.tickerCategory + '" fontsize="' + e.data.TickerfontSize + '"]');
									}
								});
							}
						}
					]
		});
	});
})();


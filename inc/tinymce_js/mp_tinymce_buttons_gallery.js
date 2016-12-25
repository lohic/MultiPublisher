(function() {
	/* Register the buttons */
	tinymce.create('tinymce.plugins.mp_button_gallery_script', {
		init : function(editor, url) {
			/**
			* [title description]
			* @type {String}
			* https://www.gavick.com/blog/wordpress-tinymce-custom-buttons
			* http://stackoverflow.com/questions/26263597/open-access-wp-media-library-from-tinymce-plugin-popup-window
			* https://dnaber.de/blog/2012/wordpress-tinymce-plugin-mit-dialogbox/
			*/

			editor.addButton( 'mp_gallery', { // mp_tab
				title : 'Ajouter une mosaique',
				type  : 'button',
				image : url + '/../img/btn_tab.png',
				onclick: function() {
					editor.windowManager.open(
						{
							title: 'Créer une gallerie',
							id: 'mp_gallery_dialog',
							width : 480,
							height : 'auto',
							wpDialog : true,
						},
						{
							custom_param : 1,
							param : set_param(wp,editor,url)
						}
					);
				}
			});

			
		},
		createControl : function(n, cm) {
			return null;
		},
	});
	/* Start the buttons */
	tinymce.PluginManager.add( 'mp_button_gallery_script', tinymce.plugins.mp_button_gallery_script );
})();

(function() {
     /* Register the buttons */
     tinymce.create('tinymce.plugins.mp_button_script', {
          init : function(ed, url) {

               /**
                * [title description]
                * @type {String}
                * https://www.gavick.com/blog/wordpress-tinymce-custom-buttons
                * http://stackoverflow.com/questions/26263597/open-access-wp-media-library-from-tinymce-plugin-popup-window
                * https://dnaber.de/blog/2012/wordpress-tinymce-plugin-mit-dialogbox/
                */
               ed.addButton( 'mp_tab', {
                    title : 'Ajouter une mosaique',
                    type  : 'menubutton',
                    image : url + '/../img/btn_tab.png',
                    menu  : [
						{
							text: '4 images',
							value: '4 images',
							onclick: function() {
								ed.insertContent(this.value());
							}
						},
                        {
							text: '3 images',
							//value: '2 images',
							onclick: function() {

							}
						},
						{
							text: '2 images',
							//value: '2 images',
							onclick: function() {
								//ed.insertContent(this.value());
								ed.windowManager.open(
                                             {
                                                  title: 'Test avec inclusion d\'un fichier php',
                                                  id: 'mp_gallery_dialog',
                                                  width : 480,
                                                  height : 'auto',
                                                  wpDialog : true,
                                             },
									{
                                                  custom_param : 1,
                                                  param : set_param(wp,ed,url)
									}
								);
							}
						},
						{
							text: '1 image',
							value: '1 image',
							onclick: function() {
                                console.log(ed.windowManager);
								ed.windowManager.open( {
							        title: 'insert 1 image',
							        body: [{
							            type: 'textbox',
							            name: 'title',
							            label: 'Your title'
							        }],
							        onsubmit: function( e ) {
							            ed.insertContent( '&lt;h3&gt;' + e.data.title + '&lt;/h3&gt;');
							        }
							    });
							}
						}
                    ]

               });

          },
          createControl : function(n, cm) {
               return null;
          },
     });
     /* Start the buttons */
     tinymce.PluginManager.add( 'mp_button_script', tinymce.plugins.mp_button_script );
})();

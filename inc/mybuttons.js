(function() {
     /* Register the buttons */
     tinymce.create('tinymce.plugins.MyButtons', {
          init : function(ed, url) {
               /**
               * Inserts shortcode content
               */
               // ed.addButton( 'button_eek', {
               //      title : 'Insert shortcode',
               //      image : '../wp-includes/images/smilies/icon_eek.gif',
               //      onclick : function() {
               //           ed.selection.setContent('[myshortcode]');
               //      }
               // });
               /**
               * Adds HTML tag to selected content
               */
               // ed.addButton( 'button_green', {
               //      title : 'Add span',
               //      image : url + '/img/btn_tab.png',
               //      cmd: 'button_green_cmd'
               // });
               // ed.addCommand( 'button_green_cmd', function() {
               //      var selected_text = ed.selection.getContent();
               //      var return_text = '';
               //      return_text = '<h1>' + selected_text + '</h1>';
               //      ed.execCommand('mceInsertContent', 0, return_text);
               // });


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
                    image : url + '/img/btn_tab.png',
                    menu  : [
						{
							text: '4 images',
							value: '4 images',
							onclick: function() {
								ed.insertContent(this.value());
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
								ed.windowManager.open( {
							        title: 'Insert h3 tag',
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
                    //icon : 'icon dashicons-images-alt',
                    //cmd: 'mp_tab_cmd'
                    // onclick : function() {
                    //      //ed.selection.setContent('<table><tr><td></td><td></td></tr><tr><td></td><td></td></tr></table>');

                         
                    //      ed.windowManager.open({
                    //         title : 'Ajouter une mosaïque d\'images',
                    //         url : url + '/views/mp-gallery.html',
                    //         // width : 320,
                    //         // height : 240
                    //      }, {
                    //         custom_param : 1,
                    //         plugin_url : url,
                    //         wp: wp,
                    //         ed: ed
                    //      });
                    // }
                    




                    //Extend the wp.media object
                    // http://stackoverflow.com/questions/26263597/open-access-wp-media-library-from-tinymce-plugin-popup-window
                    // onclick : function() {
                    //   custom_uploader = wp.media.frames.file_frame = wp.media({
                    //       title: 'Choose Image',
                    //       button: {
                    //           text: 'Choose Image'
                    //       },
                    //       multiple: false
                    //   });

                    //   //When a file is selected, grab the URL and set it as the text field's value
                    //   custom_uploader.on('select', function() {
                    //       var attachment = custom_uploader.state().get('selection').first().toJSON();
                    //       $upload_button.siblings('input[type="text"]').val(attachment.url);
                    //   });

                    //   //Open the uploader dialog
                    //   custom_uploader.open();
                    // }

               });
               // ed.addCommand( 'mp_tab_cmd', function() {
               //      var selected_text = ed.selection.getContent();
               //      var return_text = '';
               //      return_text = '<h1>' + selected_text + '</h1>';
               //      ed.execCommand('mceInsertContent', 0, return_text);
               // });
          },
          createControl : function(n, cm) {
               return null;
          },
     });
     /* Start the buttons */
     tinymce.PluginManager.add( 'my_button_script', tinymce.plugins.MyButtons );
})();
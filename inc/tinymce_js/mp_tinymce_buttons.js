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
                    type  : 'button',
                    image : url + '/../img/btn_tab.png',
                    onclick: function() {
                        ed.windowManager.open(
                            {
                                 title: 'Creat a gallery',
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
               });

          },
          createControl : function(n, cm) {
               return null;
          },
     });
     /* Start the buttons */
     tinymce.PluginManager.add( 'mp_button_script', tinymce.plugins.mp_button_script );
})();

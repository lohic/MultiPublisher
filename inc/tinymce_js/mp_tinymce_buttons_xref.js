jQuery(document).ready(function($) {

(function() {
	/* Register the buttons */
	tinymce.create('tinymce.plugins.mp_button_xref_script', {
		init : function(editor, url) {
			/**
			* [title description]
			* @type {String}
			* https://www.gavick.com/blog/wordpress-tinymce-custom-buttons
			* http://stackoverflow.com/questions/26263597/open-access-wp-media-library-from-tinymce-plugin-popup-window
			* https://dnaber.de/blog/2012/wordpress-tinymce-plugin-mit-dialogbox/
			*/

			editor.addButton( 'mp_xref', {
				title : 'Ajouter une référence croisée',
				type  : 'button',
				image : url + '/../img/btn_xref.png',
				onclick: function() {

					//editor.insertContent('Hello World!');

					// editor.windowManager.open(
					// {
					// 	title: 'Créer une référence croisée',
					// 	id: 'mp_gallery_dialog',
					// 	width : 480,
					// 	height : 'auto',
					// 	wpDialog : true,
					// },
					// {
					// 	custom_param : 1,
					// 	param : set_param(wp,editor,url)
					// }
					// );

					//alert("xref");

					var xref = $(e.target);

			    	ed.selection.select(e.target);

					var data = {
				        'action'	: 'dialog_edit_xref',
				        'xref_id'	: xref.data('id'),//shortcode_obj.id,
				        'xref_href'	: xref.data('href'),//shortcode_obj.href,
				        'xref_txt'	: xref.text(),//shortcode_obj.txt,
				        'parent_id'   : $("#main_parent_id_field").val()
				    };

				    $.post(ajaxurl, data, function(response) {

				        
				        var dlg = $('<div class=\"xref-dialog ajax-content\">'+response+'</div>').appendTo("body");


				        dlg.dialog({
				            'dialogClass' : 'wp-dialog mp-dialog-fixed',
				            'modal' : true,
				            'autoOpen' : false,
				            'closeOnEscape' : true,
				            'draggable' : false,
			            	'resizable': false,
				            'title' : 'Éditer une référence croisée',
				            'width' : 500,
				            'buttons' : [
				                {
				                    'text' : 'Annuler',
				                    'class' : 'submitdelete deletion',
				                    'click' : function() {
				                        $(this).dialog('close');
				                    }
				                }
				            ],
				            'open' : function (event, ui){

								$(".xref_item").click(function(e){

									$(".xref_item").removeClass('selected');
									$(this).addClass('selected');

									$('.xref_result').empty();

									console.log($(this).data('id'), $(this).text() );

									var data = {
								        'action'			: 'xref_list',
								        'publication_id'	: $(this).data('id')
								    };

								    $.post(ajaxurl, data, function(response) {

								    	var contenu = $(response);
								    	var compteur = 0;

								    	contenu.find('*').each(function(){

								    		if($(this).attr('id')!== undefined){

									    		compteur ++;

									    		var xref = $("<li class='xref' data-xref-id='"+$(this).attr('id')+"'>"+$(this).html()+"</li>").click(function(e){
									    			alert( '#' + $(this).data('xref-id'));
									    		})

									    		$('.xref_result').append(xref);
								    		}
								    	});

								    	if(compteur == 0){
								    		$('.xref_result').append("<li>Aucune référence trouvée</li>");
								    	}
								    });

								
								});
				            },
				            'close' : function (event, ui){
				            	$(".xref-dialog").remove();
				            }
				        }).dialog('open');
				    });
				}
			});

			
		},
		createControl : function(n, cm) {
			return null;
		},
	});
	/* Start the buttons */
	tinymce.PluginManager.add( 'mp_button_xref_script', tinymce.plugins.mp_button_xref_script );
})();


});

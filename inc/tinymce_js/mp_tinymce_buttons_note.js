jQuery(document).ready(function($) {

(function() {
	/* Register the buttons */
	tinymce.create('tinymce.plugins.mp_button_note_script', {
		init : function(editor, url) {
			/**
			* [title description]
			* @type {String}
			* https://www.gavick.com/blog/wordpress-tinymce-custom-buttons
			* http://stackoverflow.com/questions/26263597/open-access-wp-media-library-from-tinymce-plugin-popup-window
			* https://dnaber.de/blog/2012/wordpress-tinymce-plugin-mit-dialogbox/
			*/

			editor.addButton( 'mp_note', {
				title : 'Ajouter une note',
				type  : 'button',
				image : url + '/../img/btn_note.png',
				onclick: function() {
					// editor.windowManager.open(
					// {
					// 	title: 'Créer une note',
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



					// alert("note");


					// var note = $(e.target);

			  //   	ed.selection.select(e.target);

					// var data = {
				 //        'action'	: 'dialog_edit_note',
				 //        'note_txt'	: note.text(),
				 //        'note_def'	: note.data("def"),
				 //    };


				        
			        var dlg = $('<div class=\"note-dialog ajax-content\">' 
			        	+ '<p><label>Texte</label> : <input id="note_txt" type="text" value=""></p>'
			        	+ '<p><label>Définition</label> : <input id="note_def" type="text" value=""></p>'
			        	+ '</div>')
			        .appendTo("body");


			        dlg.dialog({
			            'dialogClass' : 'wp-dialog mp-dialog-fixed',
			            'modal' : true,
			            'autoOpen' : false,
			            'closeOnEscape' : true,
			            'draggable' : false,
			            'resizable': false,
			            'title' : 'Éditer une note',
			            'width' : 500,
			            'buttons' : [
			                {
			                    'text' : 'Annuler',
			                    'class' : 'submitdelete deletion',
			                    'click' : function() {
			                        $(this).dialog('close');
			                    }
			                },
			            	{
			                    'text' : 'Enregistrer',
			                    'class' : 'valid',
			                    'click' : function() {
			                        //console.log("valeurs notes : ",$("#note_txt").val(), $("#note_def").val())

			                        var render = $('<span>')
									.addClass('mp_note')
									.addClass('mceItem')
									.text( $("#note_txt").val() )
									.attr("data-def", $("#note_def").val() );

			                        // ed.selection.setContent( render.prop('outerHTML') )

			                        editor.insertContent( render.prop('outerHTML') );


			                        $(this).dialog('close');
			                    }
			                }
			            ],
			            'open' : function (event, ui){
			            	//console.log("valeurs notes : ",$("#note_txt").val(), $("#note_def").val())
			            },
			            'close' : function (event, ui){
			            	$(".note-dialog").remove();
			            }
			        }).dialog('open');


				}
			});

			
		},
		createControl : function(n, cm) {
			return null;
		},
	});
	/* Start the buttons */
	tinymce.PluginManager.add( 'mp_button_note_script', tinymce.plugins.mp_button_note_script );
})();


});

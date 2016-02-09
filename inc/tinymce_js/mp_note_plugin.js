/**

[xref txt="Ruines" id=57 href=super]
[note mot="artiste" note="voici la définition du mot artiste"]

*/


jQuery(document).ready(function($) {


(function() {

	//console.log("note JS loaded");


	//-------------------------------------------
	//------------- xrefSHORTCODE ---------------
	//-------------------------------------------

	tinymce.create('tinymce.plugins.mp_note', {

		init : function(ed, url) {
			var t = this;

			t.url = url;

			//console.log('MCE plugin note created');
		
			
			//replace shortcode before editor content set
			ed.onBeforeSetContent.add(function(ed, o) {
				o.content = t._do_spot(o.content);
			});
			
			//replace shortcode as its inserted into editor (which uses the exec command)
			ed.onExecCommand.add(function(ed, cmd) {
			    if (cmd ==='mceInsertContent'){
					tinyMCE.activeEditor.setContent( t._do_spot(tinyMCE.activeEditor.getContent()) );
				}
			});
			//replace the image back to shortcode on save
			ed.onPostProcess.add(function(ed, o) {
				if (o.get)
					o.content = t._get_spot(o.content);
			});

			ed.onDblClick.add(function(ed, e) {
			    //ed.selection.select(e.target);

			    //console.log( e.target.className );

			    if( e.target.classList.contains('mp_note')===true ){

			    	var note = $(e.target);

			    	ed.selection.select(e.target);

					var data = {
				        'action'	: 'dialog_edit_note',
				        'note_txt'	: note.text(),
				        'note_def'	: note.data("def"),
				    };
				        
			        var dlg = $('<div class=\"note-dialog ajax-content\">' 
			        	+ '<p><label>Texte</label> : <input id="note_txt" type="text" value="'+data.note_txt+'"></p>'
			        	+ '<p><label>Définition</label> : <input id="note_def" type="text" value="'+data.note_def+'"></p>'
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

			                        ed.selection.setContent( render.prop('outerHTML') )

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


				    // });

			    }
			});

		},

		_do_spot : function(co) {
			return co.replace(/\[note([^\]]*)\]/g, function(a,b){
				// console.log('_do_spot',a,b);
				// console.log(shortCode2Obj(b));

				var shortCodeObj = shortCode2Obj(b);

				var render = $('<span>')
				.addClass('mp_note')
				.addClass('mceItem')
				.text( decodeURI(shortCodeObj.txt) )
				.attr("data-def",shortCodeObj.def);

				return render.prop('outerHTML');
			});
		},

		_get_spot : function(co) {

			function getAttr(s, n) {
				n = new RegExp(n + '=\"([^\"]+)\"', 'g').exec(s);
				return n ? tinymce.DOM.decode(n[1]) : '';
			};


			return co.replace(/(<span[^>]+>)([\w=áàâäãåçéèêëíìîïñóòôöõúùûüýÿæœÁÀÂÄÃÅÇÉÈÊËÍÌÎÏÑÓÒÔÖÕÚÙÛÜÝŸÆŒ'’" ]+)(<\/span>)*/g, function(a,b,c) {
				var cls = getAttr(a, 'class');

				//console.log('_get_spot',a,b,c);

				var info = $(a);

				if(info.hasClass('mp_note')){

					var param = 'note txt="'+encodeURI( info.text() )+'"';

					for(key in info.data()){
						param += ' '+key+'="'+info.data()[key]+'"';
					}

					return "["+param+"]";
				}else{
					return a;
				}				
			});
		},

		getInfo : function() {
			return {
				longname  : 'note Shortcode',
				author 	  : 'Loïc Horellou',
				authorurl : 'http://www.loichorellou.net',
				infourl   : '',
				version   : "1.0"
			};
		}
	});

	tinymce.PluginManager.add('mp_note', tinymce.plugins.mp_note);

})();

});


function shortCode2Obj(shortcode_str) {
	//console.log('shortCode2Obj');

    var paramRegexp = /(\w+)\s*=\s*"(.*?)"/g;
    var shortcode_obj = {};
    var paramMatch = paramRegexp.exec(shortcode_str);

    shortcode_obj[paramMatch[1]] = paramMatch[2];

    while (paramMatch != null) {
        paramMatch = paramRegexp.exec(shortcode_str);

        if (paramMatch != null) {
            shortcode_obj[paramMatch[1]] = paramMatch[2];
        }
    }

    return shortcode_obj;
}

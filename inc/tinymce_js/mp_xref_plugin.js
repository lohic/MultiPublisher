/**

[xref txt="Ruines" id=57 href=super]
[note mot="artiste" note="voici la définition du mot artiste"]

*/


jQuery(document).ready(function($) {


(function() {

	console.log("xref JS loaded");

	//-------------------------------------------
	//------------- xrefSHORTCODE ---------------
	//-------------------------------------------

	tinymce.create('tinymce.plugins.mp_xref', {

		init : function(ed, url) {
			var t = this;

			t.url = url;

			console.log('MCE plugin xref created');
		
			
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

			    if( e.target.classList.contains('mp_xref')===true ){

			    	//console.log("click xref", e.target.id);

			    	var xref = $(e.target);

			    	ed.selection.select(e.target);

					// shortcode_obj = shortCode2Obj( $(e.target).attr('title') );

					// console.log(shortcode_obj);

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
				            'dialogClass' : 'wp-dialog',
				            'modal' : true,
				            'autoOpen' : false,
				            'closeOnEscape' : true,
				            'draggable' : false,
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

		_do_spot : function(co) {
			return co.replace(/\[xref([^\]]*)\]/g, function(a,b){
				console.log('_do_spot xref',a,b);
				console.log(shortCode2Obj(b));

				var shortCodeObj = shortCode2Obj(b);

				var render = $('<span>')
				.addClass('mp_xref')
				.addClass('mceItem')
				.text( decodeURI(shortCodeObj.txt) )
				.attr("data-id",shortCodeObj.id)
				.attr("data-href",shortCodeObj.href);

				console.log('outerHTML',render.prop('outerHTML'));

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

				if(info.hasClass('mp_xref')){

					var param = 'xref txt="'+encodeURI( info.text() )+'"';

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
				longname  : 'xref Shortcode',
				author 	  : 'Loïc Horellou',
				authorurl : 'http://www.loichorellou.net',
				infourl   : '',
				version   : "1.0"
			};
		}
	});

	tinymce.PluginManager.add('mp_xref', tinymce.plugins.mp_xref);

})();

});

function shortCode2Obj(shortcode_str) {
	console.log('shortCode2Obj');

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

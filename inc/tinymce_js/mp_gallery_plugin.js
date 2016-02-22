jQuery(document).ready(function($) {

(function() {
	tinymce.create('tinymce.plugins.mp_gallery', {
		init : function(ed, url) {

			var t = this;
			// t is an "empty" object
			// ed >> objet editor


			t.url = url;
			//replace shortcode before editor content set
			ed.onBeforeSetContent.add(function(ed, o) {
				o.content = t._do_spot(o.content);

				// o.content >> table gallery
					//>> activate the dospot function
			});


			//replace shortcode as its inserted into editor (which uses the exec command)
			//function executed after the pop up windows
			ed.onExecCommand.add(function(ed, cmd) {
			    if (cmd ==='mceInsertContent'){
					tinyMCE.activeEditor.setContent( t._do_spot(tinyMCE.activeEditor.getContent()) );
					// tinyMCE.activeEditor.getContent() >> table gallery
				}
			});
			//replace the image back to shortcode on save
			ed.onPostProcess.add(function(ed, o) {
				if (o.get)
					o.content = t._get_spot(o.content);
			});

			ed.onDblClick.add(function(ed, e) {
					//console.log( e.target.className );

			    if( e.target.classList.contains('mp_gallery')===true ){

			    	var xref = $(e.target);
			    	ed.selection.select(e.target);
				    response = "RIEN";
            var dlg = $('<div class=\"mp-gallery-dialog ajax-content\">'+response+'</div>').appendTo("body");


				        dlg.dialog({
				            'dialogClass' : 'wp-dialog',
				            'modal' : true,
				            'autoOpen' : false,
				            'closeOnEscape' : true,
				            'draggable' : false,
			            	'resizable': false,
				            'title' : 'Éditer une galerie',
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

				            },
				            'close' : function (event, ui){
				            	$(".mp-gallery-dialog").remove();
				            }
				        }).dialog('open');
			    }
			});

		},

		//launch when you click on "visuel tab in editor mode"
		_do_spot : function(co) {
			return co.replace(/\[mp_gallery([^\]]*)\]/g, function(a,b){
			var shortCodeObj = shortCode2Obj(b); //transform the shortcode into an object

			//var gt = shortCodeObj.type.substring(1,2);
			/*test valeur id pour ajax à effectuer pour l'ensemble des g*/
			var ar_id = shortCodeObj.ids.split(',');
			var im_id = ar_id[0]

				 var data = {
					//'ID' : $("#post_ID").val(),
					action 	: 'galleries_image_get_html', // ligne 221 mp.class.php
					'id': im_id
				};
				var result;
				$.ajax({
							type: 'POST',
    					url 	 : ajaxurl, // on ne touche pas, variable wordpress
							data 	 : data, // variable data si dessus
							dataType : 'html', // on va renvoyer de l'html
			 				success  : function(response) {
									//$("body").html(response);
									var render = $( gallerie_data.default[ shortCodeObj.type ] );
									result = response
									console.log(result);
									//return console.log(shortCodeObj.type);
	    				}
				});

				//var render = $( gallerie_data.default[ shortCodeObj.type ] );

				// var render = $( gallerie_data.default[ shortCodeObj.type ] )
				// .addClass('mp_gallery')
				// .addClass('mceItem')
				// .attr("data-param",shortCodeObj.param)
				// .attr("data-type",shortCodeObj.type)
				// .attr("data-ids",shortCodeObj.ids);
				// return render.prop('outerHTML');


		});

		},
		_get_spot : function(co) {
			function getAttr(s, n) {
				n = new RegExp(n + '=\"([^\"]+)\"', 'g').exec(s);
				return n ? tinymce.DOM.decode(n[1]) : '';
			};


			return co.replace(/(<table[^>]*>[\s\S]*?<\/table>\s*)/gm, function(a,b) {
				var cls = getAttr( a, 'class' );


				//console.log('_get_spot',a);

				var info = $(a);

				//console.log('info',info);

				if(info.hasClass('mp_gallery')){

					var param = 'mp_gallery txt="'+encodeURI( info.text().trim() )+'"';

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
				longname  : 'gallery for multipublisher Shortcode',
				author 	  : 'Loïc Horellou',
				authorurl : 'http://www.loichorellou.net',
				infourl   : '',
				version   : "1.0"
			};
		}
	});

	tinymce.PluginManager.add('mp_gallery', tinymce.plugins.mp_gallery);

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

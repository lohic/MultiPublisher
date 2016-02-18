jQuery(document).ready(function($) {

(function() {

	//console.log("mp_gallery_plugin.js loaded");

	tinymce.create('tinymce.plugins.mp_gallery', {

		init : function(ed, url) {

			var t = this;
				console.log(t);
			t.url = url;
			//replace shortcode before editor content set
			ed.onBeforeSetContent.add(function(ed, o) {
				o.content = t._do_spot(o.content);
				// o.content >> table gallery
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
					console.log( e.target.className );

			    if( e.target.classList.contains('mp_gallery')===true ){

			    	//console.log("click xref", e.target.id);

			    	var xref = $(e.target);

			    	ed.selection.select(e.target);

					// shortcode_obj = shortCode2Obj( $(e.target).attr('title') );

					// console.log(shortcode_obj);


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
				//console.log('_do_spot mp_gallery',a,b);
				//console.log(shortCode2Obj(b));

				var shortCodeObj = shortCode2Obj(b);

	            var render = $( gallerie_data.default[ shortCodeObj.type ] )
				.addClass('mp_gallery')
				.addClass('mceItem')
				.attr("data-param",shortCodeObj.param)
				.attr("data-type",shortCodeObj.type)
				.attr("data-ids",shortCodeObj.ids);


				return render.prop('outerHTML');

			});

		},
		_get_spot : function(co) {
			function getAttr(s, n) {
				n = new RegExp(n + '=\"([^\"]+)\"', 'g').exec(s);
				return n ? tinymce.DOM.decode(n[1]) : '';
			};


			return co.replace(/(<table[^>]*>[\s\S]*?<\/table>\s*)/gm, function(a,b) {
				var cls = getAttr( a, 'class' );


				//console.log('_get_spot',a,b);

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

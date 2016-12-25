jQuery(document).ready(function($) {

	//obj console.log(gallerie_data);


(function() {
	tinymce.create('tinymce.plugins.mp_gallery', {
		init : function(ed, url) {
			var t = this;
			t.url = url;
			//replace shortcode before editor content set
			ed.onBeforeSetContent.add(function(ed, o) {
				o.content = t._get_spot(o.content);
				o.content = t._do_spot(o.content);
			});

			// ed.on('BeforeSetcontent', function(event){
			// 	console.log(event)

			// 	event.content = t._do_spot(event.content);
			// });


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

				ed.onClick = null;
				
				ed.onDblClick.add(function(ed, e) {

					console.log("doubleclick");

					if( e.target.classList.contains('mp_gallery')===true ){

					//if( e.target.src !== undefined ){
						var classOf = (e.target.dataset.abcd);
						console.log("e.target",e.target);
						var elem = $(e.target).closest('table')[0];
						console.log("elem",elem);
						var ids = $(elem).data("ids").split(',');

						console.log(ids);
						custom_uploader = wp.media.frames.file_frame = wp.media({
						title: 'Change the Image',
						button: {
							text: 'Change image'
						},
						multiple: false
						});
						custom_uploader.on('select', function() {
							var attachment = custom_uploader.state().get('selection').first().toJSON();
							//var abcd and i are in mp-admin.js
							i = abcd.indexOf(classOf);
							
							ids.splice(i, 1, (attachment.id).toString());
							ids = ids.join();
							e.target.src = attachment.url;
							console.log("new ids :" , ids);
							elem.dataset.ids = ids;
							console.log("data_set :", elem.dataset.ids);							
						});
						custom_uploader.open();
					
					}

				//OLD
			    //if( e.target.classList.contains('mp_gallery')===true ){

			    	// var xref = $(e.target);
			    	// ed.selection.select(e.target);
				    // response = "RIEN";
        //     		var dlg = $('<div class=\"mp-gallery-dialog ajax-content\">'+response+'</div>').appendTo("body");


				    //     dlg.dialog({
				    //         'dialogClass' : 'wp-dialog',
				    //         'modal' : true,
				    //         'autoOpen' : false,
				    //         'closeOnEscape' : true,
				    //         'draggable' : false,
			     //        	'resizable': false,
				    //         'title' : 'Éditer une galerie',
				    //         'width' : 500,
				    //         'buttons' : [
				    //             {
				    //                 'text' : 'Annuler',
				    //                 'class' : 'submitdelete deletion',
				    //                 'click' : function() {
				    //                     $(this).dialog('close');
				    //                 }
				    //             }
				    //         ],
				    //         'open' : function (event, ui){

				    //         },
				    //         'close' : function (event, ui){
				    //         	$(".mp-gallery-dialog").remove();
				    //         }
				    //     }).dialog('open');
			    //}
			});

		},

		//launch when you click on "visuel tab in editor mode"
		_do_spot : function(co) {	

			console.log("_do_spot");

			return co.replace(/\[mp_gallery([^\]]*)\]/g, function(a,b){

				var shortCodeObj = shortCode2Obj(b);

				var gt 		= shortCodeObj.type;
				var ar_id 	= shortCodeObj.ids.split(',');
				var abcd 	= gallery_txt(gt);
				var class_arr = [];

				//recup gallery id
				var mp_gallery_id = data2id(shortCodeObj.type, shortCodeObj.ids);

				//get the image size related to the position in the table
				var elem_td =  $(gallerie_data.default.structures[gt]).find('td');
				elem_td.each(function(index){
					var classes = $(this).attr("class");
					var class_size = classes.split(' ')[1];
					class_arr.push(class_size);
				});

				var data = {
					//'ID' : $("#post_ID").val(), //useless ?
					'action' : 'galleries_image_get_html', // ligne 221 mp.class.php
					'id'     : ar_id,
					'gt'	 : gt,
					'abcd'	 : abcd,
					'sizes'  : class_arr
				};

				$.ajax({
					type     : 'POST',
	    			url 	 : ajaxurl,
					data 	 : data,
					//async    : false,
					dataType : 'html',
					success  : function(response) {
						//console.log(response);
						return gallerie_data[mp_gallery_id] = $.parseJSON(response);
		    		}
				});

				//recup type de gallerie
				var gal_type = gallerie_data.default.structures[gt];
				var gal_img = gallerie_data[mp_gallery_id];
				
				var render = $(gal_type)
					.addClass('mp_gallery')
					.addClass('mceItem')
					.attr("data-param",shortCodeObj.param)
					.attr("data-type",shortCodeObj.type)
					.attr("data-ids",shortCodeObj.ids);

				if(gal_img !== undefined){
					 for( var i = 0; i < gal_img.length; i ++ ){
					 	var data = $($(gal_img[i])[1]).data("abcd");
					 	$(render).find("."+data+"").append(gal_img[i]);
					 };
			 	}

				return render.prop('outerHTML');
			});

		},
		_get_spot : function(co) {
			console.log("_get_spot");

			function getAttr(s, n) {
				n = new RegExp(n + '=\"([^\"]+)\"', 'g').exec(s);
				return n ? tinymce.DOM.decode(n[1]) : '';
			};


			return co.replace(/(<table[^>]*>[\s\S]*?<\/table>\s*)/gm, function(a,b) {
				var cls = getAttr( a, 'class' );
				var info = $(a);

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


function data2id(type, ids){

	var id = "";

	id = type+"_"+ids.replace(/,/g,"-");

	return id;

}

function shortCode2Obj(shortcode_str) {

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

function gallery_txt(type){
	var n = type.substr(1,1);
	var abcd = "abcd";
	var txt = abcd.substr(0,n);

	return txt;
}

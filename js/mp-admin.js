/**
 *  ┌──────────────────┐
 *  │                  │
 *  │ MULTI PUBLISHER  │
 *  │ CARNET DU FRAC   │
 *  │                  │
 *  └──────────────────┘
 */

var wp, ed, url, gt, i;
var id = [];
var abcd = ["a","b","c","d"];

function set_param(wp, ed, url){

	mp_js_vars.wp = wp;
	mp_js_vars.ed = ed;
	mp_js_vars.url = url;
}

jQuery(document).ready(function($) {

	$(function() {

		console.log('mp-admin.js ready');

		$(".mos").click(function(c){
			id = [];
			gt = $(c.target).attr('id');
			var elem = gallerie_data.default.structures[gt];
			$(".gallery_container").html(elem);
			$(".gallery_container td").append("<div class='mp_gallery_image'>&nbsp;</div>");

			var n = gt.substring(1, 2);
			for(var i = 0; i < n; i++){
				id.push('0');
			}
		});


		$(".gallery_container").on('dblclick', '.mp_gallery_image',function(e){
			ed = mp_js_vars.ed;
			wp = mp_js_vars.wp;
			$mp_gallery_image_target = $(this);

		 	var classOf = ($(e.currentTarget).parent().attr("class").split(' '))[0];
			console.log(classOf);
			custom_uploader = wp.media.frames.file_frame = wp.media({
				title: 'Choose Image',
				button: {
					text: 'Choose Image'
				},
				multiple: false
			});

			//When a file is selected, grab the URL and set it as the text field's value
			custom_uploader.on('select', function() {
				var attachment = custom_uploader.state().get('selection').first().toJSON();
				i = abcd.indexOf(classOf);
				var img = attachment.id.toString();
				id.splice(i, 1, img);
				$mp_gallery_image_target.html("<img src='"+attachment.url+"'/>");

			});
			//Open the uploader dialog
			custom_uploader.open();

		});



		// $("#mp_select_img").click(function(e){
		// 	wp = mp_js_vars.wp;
		// 	custom_uploader = wp.media.frames.file_frame = wp.media({
		// 		title: 'Choose Image',
		// 		button: {
		// 			text: 'Choose Image'
		// 		},
		// 		multiple: false
		// 	});
		//
		// 	//When a file is selected, grab the URL and set it as the text field's value
		// 	custom_uploader.on('select', function() {
		// 		var attachment = custom_uploader.state().get('selection').first().toJSON();
		// 		//$upload_button.siblings('input[type="text"]').val(attachment.url);
		//
		// 		$(".mp_gallery_image").html("<img src='"+attachment.url+"'/>");
		//
		// 		//ed.windowManager
		// 	});
		//
		// 	//Open the uploader dialog
		// 	custom_uploader.open();
		// });




		$("#submit").click(function(e){
			ed = mp_js_vars.ed;
			id = id.join(",");
			ed.insertContent( "[mp_gallery txt=\"\" ids=\""+id+"\" type=\""+gt+"\"]" );
			//empty array and caption
			$mp_gallery_image_target.empty();
			ed.windowManager.close();
		});
	});
});

/**
 *  ┌──────────────────┐
 *  │                  │
 *  │ MULTI PUBLISHER  │
 *  │ CARNET DU FRAC   │
 *  │                  │
 *  └──────────────────┘
 */

var wp, ed, url, id, gt;

function set_param(wp, ed, url){

	mp_js_vars.wp = wp;
	mp_js_vars.ed = ed;
	mp_js_vars.url = url;

	console.log('editor',ed);
}

jQuery(document).ready(function($) {

	$(function() {

		console.log('mp-admin.js ready');

		// $("#parent_id").change(function(e){
		// 	console.log($(this).val());
		// });


		// $(".xref_item").click(function(e){

		// 	console.log( $(this).text() );

		// });


		$(".mp_gallery_image").dblclick(function(e){

			ed = mp_js_vars.ed;
			wp = mp_js_vars.wp;

			$mp_gallery_image_target = $(this);

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
				//$upload_button.siblings('input[type="text"]').val(attachment.url);
				id = attachment.id.toString();
				$mp_gallery_image_target.html("<img src='"+attachment.url+"'/>");

			});
			var elem = $(this).parents().eq(3);
			gt = $(elem).data('gallery');
			//Open the uploader dialog
			custom_uploader.open();

		});



		$("#mp_select_img").click(function(e){
			wp = mp_js_vars.wp;
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
				//$upload_button.siblings('input[type="text"]').val(attachment.url);

				$(".mp_gallery_image").html("<img src='"+attachment.url+"'/>");

				//ed.windowManager
			});

			//Open the uploader dialog
			custom_uploader.open();
		});




		$("#submit").click(function(e){
			ed = mp_js_vars.ed;
			ed.insertContent( "[mp_gallery txt=\"\" ids=\""+id+"\" type=\""+gt+"\"]" );
			ed.windowManager.close();
		});


	});
});

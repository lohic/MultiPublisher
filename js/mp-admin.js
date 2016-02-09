/**
 *  ┌──────────────────┐
 *  │                  │
 *  │ MULTI PUBLISHER  │
 *  │ CARNET DU FRAC   │
 *  │                  │
 *  └──────────────────┘
 */

var wp, ed, url;

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

				$mp_gallery_image_target.html("<img src='"+attachment.url+"'/>");
								
			});

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




		$("#mos2").click(function(e){

			ed = mp_js_vars.ed;

			//console.log('ok',mp_js_vars.ed);

			//console.log('ferme');

			//var args = tinyMCE.activeEditor.windowManager.getParams();

			//console.log(mp_js_vars.mp_editor);

			//console.log( top.editor.activeEditor.windowManager.getParams() );
			//
			ed.insertContent( $("#mp_gallery_editor").html() );

			//ed.selection.setContent('<table><tr><td><div class="mp_gallery_image">&nbsp;</div></td><td><div class="mp_gallery_image">&nbsp;</div></td></tr><tr><td><div class="mp_gallery_image">&nbsp;</div></td><td><div class="mp_gallery_image">&nbsp;</div></td></tr></table>');
			ed.windowManager.close();
		});


	});
});



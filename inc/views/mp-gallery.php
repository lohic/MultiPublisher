<?php
/**
 * 	┌──────────────────┐
 *	│ 		           │
 *	│ MULTI PUBLISHER  │
 *	│ CARNET DU FRAC   │
 *	│ 		           │
 *	└──────────────────┘
 */


if ( ! defined( 'ABSPATH' ) ) {
    die( '-1' );
}


?>
<div style="display:none;">
	<div id="mp_gallery_dialog">
		<!-- <h1>super</h1> -->

		<!-- <button id="mp_select_img">Sélectionner une image</button> -->

		<div id="mp_gallery_editor">

			<!-- <table class="mp_gallery_three">
				<tr>
					<td colspan="2"><div class="mp_gallery_image">&nbsp;</div></td>
				</tr>
				<tr>
					<td><div class="mp_gallery_image">&nbsp;</div></td>
					<td><div class="mp_gallery_image">&nbsp;</div></td>
				</tr>
			</table>

			<table class="mp_gallery_four">
				<tr>
					<td><div class="mp_gallery_image">&nbsp;</div></td>
					<td><div class="mp_gallery_image">&nbsp;</div></td>
				</tr>
				<tr>
					<td><div class="mp_gallery_image">&nbsp;</div></td>
					<td><div class="mp_gallery_image">&nbsp;</div></td>
				</tr>
			</table> -->

			<table class="mp_gallery_one" data-gallery="g1">
				<tr>
					<td><div class="mp_gallery_image">1 image&nbsp;</div></td>
				</tr>
			</table>

		</div>

        <button id="mos" class="g1">1 image</button>
        <button id="mos" class="g2">2 images</button>
        <button id="mos" class="g3">3 images</button>
		<button id="mos" class="g4">4 images</button>
        <button id="submit">submit</button>

	</div>
</div>

<style>

table{
	width: 100%;
}

table td{
	width: 50%;
	vertical-align: top;
}

.mp_gallery_image{
	background: #444;
	width: 100%;
	min-height: 100px;
    color: white;
}

.mp_gallery_image img{
	width: 100%;
	height: auto;
}

</style>

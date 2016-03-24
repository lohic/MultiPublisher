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


            <!-- gallery 2 -->
            <!-- <div id="g2" class="gallery_container" style='display:none;'>
                <h2>2 images</h2>
                <table class="mp_gallery_two" data-gallery="g21">
                    <tr>
                        <td class=\"a\"><div class="mp_gallery_image">&nbsp;</div></td>
                    </tr>
                    <tr>
                        <td class=\"b\"><div class="mp_gallery_image">&nbsp;</div></td>
                    </tr>
                </table>
                <table class="mp_gallery_two" data-gallery="g22">
                    <tr>
                        <td class=\"a\"><div class="mp_gallery_image">&nbsp;</div></td>
                        <td class=\"b\"><div class="mp_gallery_image">&nbsp;</div></td>
                    </tr>
                </table>
            </div> -->
            <!-- gallery 1  -->
            <div class="gallery_container">

            </div>
		</div>

        <button id="g1" class="mos"><img src="/wp_carnetFrac/wp-content/plugins/MultiPublisher/inc/img/btn_1.png" alt="" /></button>
        <button id="g21" class="mos"><img src="/wp_carnetFrac/wp-content/plugins/MultiPublisher/inc/img/btn_21.png" alt="" /></button>
        <button id="g22" class="mos"><img src="/wp_carnetFrac/wp-content/plugins/MultiPublisher/inc/img/btn_22.png" alt="" /></button>
        <button id="g31" class="mos"><img src="/wp_carnetFrac/wp-content/plugins/MultiPublisher/inc/img/btn_31.png" alt="" /></button>
        <button id="g32" class="mos"><img src="/wp_carnetFrac/wp-content/plugins/MultiPublisher/inc/img/btn_32.png" alt="" /></button>
        <button id="g33" class="mos"><img src="/wp_carnetFrac/wp-content/plugins/MultiPublisher/inc/img/btn_33.png" alt="" /></button>
        <button id="g34" class="mos"><img src="/wp_carnetFrac/wp-content/plugins/MultiPublisher/inc/img/btn_34.png" alt="" /></button>
		<button id="g4" class="mos"><img src="/wp_carnetFrac/wp-content/plugins/MultiPublisher/inc/img/btn_4.png" alt="" /></button>

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
button img{
    width: 50%;
    height: auto;
}
button{
    background: none;
    border:0px solid;
}
.height-transition {
       -webkit-transition: max-height 0.5s ease-in-out;
       -moz-transition: max-height 0.5s ease-in-out;
       -o-transition: max-height 0.5s ease-in-out;
       transition: max-height 0.5s ease-in-out;
   }

</style>

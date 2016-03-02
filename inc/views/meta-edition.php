<?php

if ( ! defined( 'ABSPATH' ) ) {
    die( '-1' );
}

/**
 * 	┌──────────────────┐
 *	│ 		           │
 *	│ MULTI PUBLISHER  │
 *	│ CARNET DU FRAC   │
 *	│ 		           │
 *	└──────────────────┘
 */

?>
<style type="text/css" media="screen">
	.xref_item.selected h2{
	    color:#00AAFF;
	}

	.xref_result li.xref:hover{
		color:#00AAFF;
	}

    .mp-dialog-fixed{
        position: fixed !important;
        top:50px;
    }
</style>
<div class="wrap" id="multi_publisher">
    <!-- <ul> -->
    <?php 
        // wp_list_pages(
        //     array(
        //         'depth'=>-1,
        //         'post_type'=>'publication',
        //         'child_of'=>$post->ID,
        //         'title_li'=>''
        //     )
        // );
    ?>
    <!-- </ul> -->

    <?php 
     if( empty($main_parent_id) ) :
    ?>

    <button id="generate_publication">Générer la publication</button>

    <table class="form-table">
        <tr>
            <th style="width:20%">
                <label for="ISBN_field">
                    <?php _e( 'ISBN', 'mp_field' ); ?>
                </label>
            </th>
            <td>
                <input type="text" id="ISBN_field" name="ISBN_field" value="<?php echo esc_attr( $ISBN )?>" size="25" />
            </td>
        </tr>
        <tr>
            <th style="width:20%">
                <label for="langue_field">
                    <?php _e( 'Langue', 'mp_field' ); ?>
                </label>
            </th>
            <td>
                <select id="langue_field" name="langue_field">
                    <?php foreach (self::$lang as $key => $value) {?>
                        <option value="<?php echo $key; ?>"<?php echo $langue == $key ? ' selected="selected"' : ''?>><?php _e($value)  ?></option>
                    <?php } ?>
                </select>

                <input type="text" value="<?php echo esc_attr( $main_parent_id )?>" id="main_parent_id_field" name="main_parent_id_field"/><br>

            </td>
        </tr>
 
    </table>

    <?php else : ?>

    <input type="hidden" id="ISBN_field"            name="ISBN_field"           value="<?php echo esc_attr( $ISBN )?>" />
    <input type="hidden" id="langue_field"          name="langue_field"         value="<?php echo esc_attr( $langue )?>" />
    <input type="hidden" id="main_parent_id_field"  name="main_parent_id_field" value="<?php echo esc_attr( $main_parent_id )?>" />

    <?php endif; ?>

    <h1>Structure :</h1>
    <?php 

        $publication_id = empty($main_parent_id) ? $post->ID : $main_parent_id;


        echo MultiPublisher::mp_publication_get_html_structure( $publication_id, $post->ID );

     ?>

</div>

<script>


jQuery(document).ready(function($) {


    $(function() {

        console.log('meta-edition scripts ready');


        $("#generate_publication").click(function(event){
            event.preventDefault();

            var data = {
                'ID': $("#post_ID").val(),
                'action': 'generate_publication',
            };

            $.post(ajaxurl, data, function(response) {

                console.log(response);

            }, "json");
        });
      

        $("#parent_id").change(function(e){
            console.log($(this).val());

            var data = {
                'action'    : 'publication_update_parent',
                'parent_id' : $(this).val(),
                'post_id'   : $("#post_ID").val(),
            };

            $.post(ajaxurl, data, function(response) {
                console.log(response);

                response = JSON.parse(response);

                console.log(response.main_parent_id);

                $("#main_parent_id_field").val(response.main_parent_id);
            });

        });
        
    });

 


    /**
     * SEARCH POST
     */
    
	// Find posts
	var $findBox = $('#find-posts'),
		$found   = $('#find-posts-response'),
		$findBoxSubmit = $('#find-posts-submit');

	// Open
	$('input.kc-find-post').on('dblclick', function() {
		$findBox.data('kcTarget', $(this));
		findPosts.open();
	});

	/**
	 * [description]
	 * @param  {[type]}    [description]
	 * @return {[type]}    [description]
	 */
	$findBoxSubmit.click(function(e) {
		e.preventDefault();

		// Be nice!
		if ( !$findBox.data('kcTarget') )
			return;

		var $selected = $found.find('input:checked');
		if ( !$selected.length )
			return false;

		var $target = $findBox.data('kcTarget'),
			current = $target.val(),
			current = current === '' ? [] : current.split(','),
			newID   = $selected.val();

		if ( $.inArray(newID, current) < 0 ) {
			current.push(newID);
			$target.val( current.join(',') );
		}

		findPosts.close();
	});

	// Double click on the radios
	$('input[name="found_post_id"]', $findBox).on('dblclick', function() {
		$findBoxSubmit.trigger('click');
	});

	// // Close
	$( '#find-posts-close' ).click(function() {
		$findBox.removeData('kcTarget');
	});

});
</script>

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

    #mp_structure h2+ul{
        margin-top:30px;
    }

    #mp_structure h2+ul>li{
        font-weight: bold;
    }
    #mp_structure h2+ul>li li{
        font-weight: normal;
    }

    #mp_structure ul, #mp_structure li{
        font-size: 0.9rem;
        line-height: 1.15em;
        margin: 0;
        padding: 0;
    }

    #mp_structure li>ul{
        margin-top: 5px;
    }

    #mp_structure li{
        margin-bottom: 5px;
    }

    #mp_structure ul ul{
        margin-left: 2em;
    }

</style>
<div class="wrap" id="multi_publisher">

    <!-- <h2>Super</h2> -->

    <?php //MultiPublisher::wpb_list_child_pages(); ?>
    <?php //print_r(MultiPublisher::publication_children()) ?>
    <?php //print_r(MultiPublisher::mp_get_publication_json_struture( $main_parent_id!=0 ? $main_parent_id  : $post->ID )); ?>

    

    <?php 

		// cf http://stackoverflow.com/questions/10309006/php-function-that-create-nested-ul-li-from-arrayobject
		function mp_get_publication_html_structure($array, $first){
			if(!is_array($array) || !isset($_GET['post'])) return '';

			$output = '<ul>';
			foreach($array as $item){  

				if( $item['ID'] == $_GET['post'] ){
					$output .= '<li>' . $item['post_title']  ;
				}else{
					$output .= '<li><a href="post.php?post='.$item['ID'].'&action=edit">' . $item['post_title'] . '</a>' ;      
				}

				if($first == false){
					$output .= ' <a href="'.$item['guid'].'" target="_blank"><i class="fa fa-eye" aria-hidden="true"></i></a>'; 
				}

				if( isset($item['childs'] )) //property_exists($item, 'childs'))
					$output .= mp_get_publication_html_structure($item['childs'], false);

				$output .= '</li>';

			}   
			$output .= '</ul>';

			return $output;
		}


     ?>

    <!-- ENFANTS : -->
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

    <table class="form-table">
        <tr>
            <th style="width:20%">
                <label>
                    <?php _e( 'Structure', 'mp_field' ); ?>
                </label>
            </th>
            <td>
                <div id="mp_structure">
                <?php echo mp_get_publication_html_structure(MultiPublisher::mp_get_publication_json_struture( $main_parent_id!=0 ? $main_parent_id  : $post->ID ), true); ?>
                </div>
            </td>
        </tr>

        <?php if( empty( $main_parent_id ) ){ ?>
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
            </td>
        </tr>
        <?php } ?>

        <tr>
            <th style="width:20%">
                <label for="main_parent_id">
                    <?php _e( 'Parent principal', 'mp_field' ); ?>
                </label>
            </th>
            <td>
                <input type="text" value="<?php echo esc_attr( $main_parent_id )?>" id="main_parent_id_field" name="main_parent_id_field"/><br>

            </td>
        </tr>
   <!--      <tr>
            <th style="width:20%">
                <label for="afficherParties_field">
                    <?php //_e( 'Afficher les parties', 'mp_field' ); ?>
                </label>
            </th>
            <td>
                <input type="checkbox" name="afficherParties_field" id="afficherParties_field"<?php //echo $afficherParties ? ' checked="checked"' : ''?>/>
            </td>
        </tr> -->
<!--         <tr>
            <th style="width:20%">
                <label for="structure_field">
                    <?php //_e( 'Structure', 'mp_field' ); ?>
                </label>
            </th>
            <td>
                <textarea name="structure_field" id="structure_field"><?php //echo $structure ?></textarea>
            </td>
        </tr> -->
       <!--  <tr>
            <td>
                <input type="text" value="<?php // echo esc_attr( $main_parent_id )?>" id="main_parent_id_field" name="main_parent_id_field"/><br>
                <button type="" id="add_part">Ajouter une partie</button>
                <input type="text" value="" id="name_part"/>
                <button type="" id="add_chapter">Ajouter un chapitre</button>
                <button type="" id="test_dialog">Dialogue + AJAX</button>
            </td>
        </tr> -->
    <!--     <tr>
            <td> -->
                <!-- <form name="plugin_form" id="plugin_form" method="post" action=""> -->
                        <?php //wp_nonce_field('plugin_nonce'); ?> 
                        <!-- // Other form elements and code ... -->
                        <?php //find_posts_div(); ?>
                        <!-- <a onclick="findPosts.open('action','find_posts');return false;" href="#">
                        <?php //esc_attr_e('Example Post Search'); ?>
                        </a> -->

                        <!--<input type="text" name="kc-find-post" id="kc-find-post" class="kc-find-post">-->
                <!-- </form> -->

                <!-- <form id="emc2pdc_form" method="post" action="">
                    <?php //wp_nonce_field( 'find-posts', '_ajax_nonce', false); ?> 
                    <input type="text" name="kc-find-post" id="kc-find-post" class="kc-find-post">
                </form> -->
  <!--           </td>
        </tr> -->

        <tr>
            <th style="width:20%">
                <button id="generate_publication" class="button button-primary button-large">Générer la publication</button>
            </th>
            <td>
                
            </td>
        </tr>

    </table>


    <!--<p><?php echo 'pluginPath : ' . self::$pluginPath .'<br> pluginDir : ' . self::$pluginDir  .'<br> pluginUrl : ' . self::$pluginUrl ; ?></p> --> 
    <!-- <p><?php echo mp_url(); ?></p>-->

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

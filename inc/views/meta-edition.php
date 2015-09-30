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

</style>
<div class="wrap" id="multi_publisher">

    <h2>Super</h2>

    <?php //MultiPublisher::wpb_list_child_pages(); ?>

    ENFANTS :
    <ul>
    <?php 
        wp_list_pages(
            array(
                'depth'=>-1,
                'post_type'=>'publication',
                'child_of'=>$post->ID,
                'title_li'=>''
            )
        );
    ?>
    </ul>

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
            </td>
        </tr>
        <tr>
            <th style="width:20%">
                <label for="afficherParties_field">
                    <?php _e( 'Afficher les parties', 'mp_field' ); ?>
                </label>
            </th>
            <td>
                <input type="checkbox" name="afficherParties_field" id="afficherParties_field"<?php echo $afficherParties ? ' checked="checked"' : ''?>/>
            </td>
        </tr>
        <tr>
            <th style="width:20%">
                <label for="structure_field">
                    <?php _e( 'Structure', 'mp_field' ); ?>
                </label>
            </th>
            <td>
                <textarea name="structure_field" id="structure_field"><?php echo $structure ?></textarea>
                <!-- <input type="text" name="structure_field" id="structure_field"<?php //echo $afficherParties ? ' checked="checked"' : ''?>/> -->
            </td>
        </tr>
        <tr>
            <td>
                <input type="text" value="<?php echo esc_attr( $main_parent_id )?>" id="main_parent_id_field" name="main_parent_id_field"/><br>
                <button type="" id="add_part">Ajouter une partie</button>
                <input type="text" value="" id="name_part"/>
                <button type="" id="add_chapter">Ajouter un chapitre</button>
                <button type="" id="test_dialog">Dialogue + AJAX</button>
            </td>
        </tr>
        <tr>
            <td>
                <!-- <form name="plugin_form" id="plugin_form" method="post" action=""> -->
                        <?php //wp_nonce_field('plugin_nonce'); ?> 
                        // Other form elements and code ...
                        <?php find_posts_div(); ?>
                        <!-- <a onclick="findPosts.open('action','find_posts');return false;" href="#">
                        <?php //esc_attr_e('Example Post Search'); ?>
                        </a> -->

                        <input type="text" name="kc-find-post" id="kc-find-post" class="kc-find-post">
                <!-- </form> -->

                <!-- <form id="emc2pdc_form" method="post" action="">
                    <?php //wp_nonce_field( 'find-posts', '_ajax_nonce', false); ?> 
                    <input type="text" name="kc-find-post" id="kc-find-post" class="kc-find-post">
                </form> -->
            </td>
        </tr>
    </table>

    <h3>Structure :</h3>

    <p><?php echo 'pluginPath : ' . self::$pluginPath .'<br> pluginDir : ' . self::$pluginDir  .'<br> pluginUrl : ' . self::$pluginUrl ; ?></p>   

    <p><?php echo mp_url(); ?></p>

    <?php echo $structure_html ?>

   <!--  <div class="chapterlist clearafter">
        <div class="partie" id="partie-1">
            <div class="chapter" id="chapter-1">chap 1</div>
            <div class="chapter" id="chapter-2">chap 2</div>
        </div>
        <div class="partie" id="partie-2">
            <div class="chapter" id="chapter-3">chap 3</div>
            <div class="chapter" id="chapter-4">chap 4</div>
            <div class="chapter" id="chapter-5">chap 5</div>
            <div class="chapter" id="chapter-6">chap 6</div>
        </div>
        <div class="partie" id="partie-3">
            <div class="chapter" id="chapter-7">chap 7</div>
            <div class="chapter" id="chapter-8">chap 8</div>
        </div>
        <div class="partie" id="partie-4">
            <div class="chapter" id="chapter-9">chap 9</div>
        </div>
        <div class="partie" id="partie-5">
            <div class="chapter" id="chapter-10">chap 10</div>
            <div class="chapter" id="chapter-11">chap 11</div>
            <div class="chapter" id="chapter-12">chap 12</div>
        </div>
    </div> -->
</div>

<script>


jQuery(document).ready(function($) {


    $(function() {

        console.log('meta-edition scripts ready');

        // $( "div.sortEdition" ).sortable({
        //     connectWith: 'div.sortEdition',
        //     //items: "div.partie, div.chapterlist",
        //     //connectWith: "div.partie, div.chapterlist",
        //     update: function( event, ui ) {
        //         getEditionStructure();
        //     }
        // });



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
        //, "json"


        // $( "#add_part" ).click(function(event){
        //     event.preventDefault();

        //     var data = {
        //         'action': 'dialog_add_partie',
        //     };

        //     $.post(ajaxurl, data, function(response) {
   
                
        //         var dlg = $('<div class=\"ajax-content\">'+response+'</div>').appendTo("body");

        //         dlg.dialog({
        //             'dialogClass' : 'wp-dialog',
        //             'modal' : true,
        //             'autoOpen' : false,
        //             'closeOnEscape' : true,
        //             'draggable' : false,
        //             'title' : 'Ajouter une partie',
        //             'buttons' : [
        //                 {
        //                     'text' : 'Annuler',
        //                     'class' : 'submitdelete deletion',
        //                     'click' : function() {
        //                         $(this).dialog('close');
        //                     }
        //                 },
        //                 {
        //                     'text' : 'Ajouter',
        //                     'class' : 'button-primary',
        //                     'click' : function() {
        //                         var qte = $('.chapterlist').children().length + 1;
        //                         var nom = $("#name_partie").val();  
        //                         $('.chapterlist').append("<div class='partie' id='"+ qte +"'><h4>"+ nom +"</h4></div");

        //                         getEditionStructure();

        //                         $(this).dialog('close');
        //                     }
        //                 }
        //             ]
        //         }).dialog('open');
        //     });
        // });


        // $( "div.chapterlist>.partie>h4" ).disableSelection();

        // $( "div.chapterlist>.partie" ).dblclick(function(event){
        //     $(this).remove();
        //     getEditionStructure();
        // });
        

        $( "#test_dialog" ).click(function(event){
            event.preventDefault();


            var data = {
                'action': 'dialog_partie',
                'whatever': 1234
            };

            // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
            $.post(ajaxurl, data, function(response) {
                //alert('Got this from the server: ' + response);
                
                //response = JSON.parse(response);
                //var dlg = $('<div class=\"ajax-content\">'+response.content+'</div>').appendTo("body");
                
                var dlg = $('<div class=\"ajax-content\">'+response+'</div>').appendTo("body");

                dlg.dialog({
                    'dialogClass' : 'wp-dialog',
                    'modal' : true,
                    'autoOpen' : false,
                    'closeOnEscape' : true,
                    'draggable' : false,
                    'title' : 'Ajouter une partie',
                    'buttons' : [
                        {
                            'text' : 'Annuler',
                            'class' : 'submitdelete deletion',
                            'click' : function() {
                                $(this).dialog('close');
                            }
                        },
                        {
                            'text' : 'Close',
                            'class' : 'button-primary',
                            'click' : function() {
                                $(this).dialog('close');
                            }
                        }
                    ]
                }).dialog('open');
            });
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
     * [getEditionStructure description]
     * @return {[type]} [description]
     */
    // function getEditionStructure(){
    //     var structure = Array();

    //     $('.chapterlist').children().each(function(){
    //         if( $( this ).hasClass('partie') ){

    //             var partie = {
    //                 id:$( this ).attr('id'),
    //                 type:'partie',
    //                 name:'',
    //                 chapters:Array()
    //             };

    //             $( this ).children().each(function(){

    //                 if( $( this ).hasClass('chapter') ){
    //                     var chapter = {
    //                         id:$(this).attr('id'),
    //                         name:$(this).text(),
    //                         type:'chapter'
    //                     };

    //                     partie.chapters.push(chapter)
    //                 }else{
    //                     partie.name = $( this ).text();
    //                 }
    //             });

    //             structure.push(partie);
    //         }else if( $( this ).hasClass('chapter') ){
    //             var chapter = {
    //                 id:$(this).attr('id'),
    //                 name:$(this).text(),
    //                 type:'chapter'
    //             };

    //             structure.push(chapter);
    //         };
    //     });

    //     //console.log(structure);

    //     $('#structure_field').text(JSON.stringify(structure));
    // }


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

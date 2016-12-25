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
    #multi_publisher{

    }
    #multi_publisher h2{
        width: 300px;
        /*margin: 60px auto 0;*/
        margin-top:24px;
        margin-bottom:40px;
        border : solid 5px #333;
        padding: 20px;
        text-align: left;
        text-transform: uppercase;
        font-weight: bold;
    }
</style>
<div class="wrap" id="multi_publisher">
	    <!-- <span class="dashicons dashicons-book-alt" style="vertical-align: middle"></span> -->
	<h2>Multi publisher<br/><?php echo esc_attr( get_option('mp_project_title') ); ?></h2>

	<p>Ce projet est né d'une commande du <a href="http://www.fracbretagne.fr" target="_blank">Frac Bretagne</a>.</p>

	<form method="post" action="options.php">

	    <?php settings_fields( 'multipublisher_settings_group' ); ?>
	    <?php do_settings_sections( 'multipublisher_settings_group' ); ?>

	    <table class="form-table">
	        <tr valign="top">
	        <th scope="row"><?php _e('Nom du projet') ?></th>
	        <td><input type="text" name="mp_project_title" value="<?php echo esc_attr( get_option('mp_project_title') ); ?>" /></td>
	        </tr>
	    </table>

	    <hr/>

	    <table class="form-table">
			<tr valign="top">
			<th scope="row"><?php _e('Nom de l’éditeur') ?></th>
			<td><input type="text" name="mp_publisher_name" value="<?php echo esc_attr( get_option('mp_publisher_name') ); ?>" /></td>
			</tr>

			<tr valign="top">
			<th scope="row">New Option Name</th>
			<td><input type="text" name="mp_new_option_name" value="<?php echo esc_attr( get_option('mp_new_option_name') ); ?>" /></td>
			</tr>
			 
			<tr valign="top">
			<th scope="row">Some Other Option</th>
			<td><input type="text" name="mp_some_other_option" value="<?php echo esc_attr( get_option('mp_some_other_option') ); ?>" /></td>
			</tr>

			<tr valign="top">
			<th scope="row">Options, Etc.</th>
			<td><input type="text" name="mp_option_etc" value="<?php echo esc_attr( get_option('mp_option_etc') ); ?>" /></td>
			</tr>
	    </table>

	    <hr/>

	    <table class="form-table">
			<tr valign="top">
			<th scope="row"><?php _e('Url du serveur pour la génération des pdf') ?></th>
			<td><input type="text" name="mp_pdf_server_url" value="<?php echo esc_attr( get_option('mp_pdf_server_url') ); ?>" /></td>
			</tr>
	    </table>
	    
	    <?php submit_button(); ?>

	</form>

	<hr/>

	<p><strong>Conception et réalisation :</strong><br>
	    &rarr; <a href="http://www.jslb.fr" target="_blank">Jérôme Saint-Loubert Bié</a>,<br>
	    &rarr; <a href="http://www.yohannamy.com" target="_blank">Yohanna My Nguyen<a>,<br>
	    &rarr; <a href="http://www.loichorellou.net" target="_blank">Loïc Horellou</a>.</p>

</div>
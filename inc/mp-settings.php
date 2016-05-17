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


if ( is_admin() ){ // admin actions
	
	add_action( 'admin_menu', 'multipublisher_add_menu' );

} else { // non-admin enqueues, actions, and filters
	
	//

}


//add_menu_page('Multi publisher Plugin Settings', 'Multi publisher Settings', 'administrator', __FILE__, 'multipublisher_settings_page', get_stylesheet_directory_uri('stylesheet_directory')."/images/media-button-other.gif");

function multipublisher_add_menu() {

	// create new top-level menu
	// https://developer.wordpress.org/resource/dashicons/#media-spreadsheet
	add_menu_page(
		'Multi publisher Plugin Settings',
		'Multi publisher',
		'administrator',
		'multipublisher',
		'multipublisher_settings_page',
		'dashicons-book-alt',//'dashicons-media-spreadsheet',//plugins_url('/images/icon.png',__FILE__),
		30
	);

	// 
	// http://wordpress.stackexchange.com/questions/160224/show-custom-taxonomy-inside-custom-menu
	// https://wordpress.org/support/topic/moving-taxonomy-ui-to-another-main-menu
	// 
	add_submenu_page(
		'multipublisher',
		'Chapitre',
		'Auteurs',
		'administrator',
		'edit-tags.php?taxonomy=auteur',
		''
	);

	add_submenu_page(
		'multipublisher',
		'Chapitre',
		'Sujets',
		'administrator',
		'edit-tags.php?taxonomy=sujet',
		''
	);

	add_submenu_page(
		'multipublisher',
		'Chapitre',
		'Réglages',
		'administrator',
		'multipublisher_settings_subpage',
		'multipublisher_settings_page'
	);


	//call register settings function
	add_action( 'admin_init', 'multipublisher_register_settings' );

	// pour sélectionner le bon item dans le menu si taxonomy
	add_action( 'parent_file', 'multipublisher_menu_correction');
}

function multipublisher_menu_correction($parent_file) {
	global $current_screen;
	$taxonomy = $current_screen->taxonomy;
	if ($taxonomy == 'auteur' || $taxonomy == 'sujet' /*|| $taxonomy == 'course' || $taxonomy == 'skill_level'*/)
		$parent_file = 'multipublisher';
	return $parent_file;
}



function multipublisher_register_settings() { // whitelist options
	//add_option('pdf_server_url','http://localhost:8888/test/');
	add_option('mp_project_title','Carnets du Frac');

	register_setting( 'multipublisher_settings_group', 'mp_project_title' );

	register_setting( 'multipublisher_settings_group', 'mp_publisher_name' );

	register_setting( 'multipublisher_settings_group', 'mp_new_option_name' );
	register_setting( 'multipublisher_settings_group', 'mp_some_other_option' );
	register_setting( 'multipublisher_settings_group', 'mp_option_etc' );

	register_setting( 'multipublisher_settings_group', 'mp_test' );
	register_setting( 'multipublisher_settings_group', 'mp_pdf_server_url' );


	// réglages pour les epub
	/*
	// Title and Identifier are mandatory!
    $book->setTitle("Carnet du Frac");
    //Epub::ISBN
    $book->setIdentifier("http://carnetdufrac.net/test.html", EPub::IDENTIFIER_URI); // Could also be the ISBN number, prefered for published books, or a UUID.
    $book->setLanguage("fr"); // Not needed, but included for the example, Language is mandatory, but EPub defaults to "en". Use RFC3066 Language codes, such as "en", "da", "fr" etc.
    $book->setDescription("This is a brief description\nA test ePub book as an example of building a book in PHP");
    $book->setAuthor("Loïc Horellou / Jérôme Saint Loubert Bié / Yohanna My Nguyen", "Johnson, John Doe");
    $book->setPublisher("John and Jane Doe Publications", "http://JohnJaneDoePublications.com/"); // I hope this is a non existant address :)
    $book->setDate(time()); // Strictly not needed as the book date defaults to time().
    $book->setRights("Copyright and licence information specific for the book."); // As this is generated, this _could_ contain the name or licence information of the user who purchased the book, if needed. If this is used that way, the identifier must also be made unique for the book.
    $book->setSourceURL("http://JohnJaneDoePublications.com/books/TestBookEPub3.html");

    $book->addDublinCoreMetadata(DublinCore::CONTRIBUTOR, "PHP");

    $book->setSubject("test — Carnet du Frac");
    $book->setSubject("keywords");
    $book->setSubject("Chapter levels");

    // Insert custom meta data to the book, in this cvase, Calibre series index information.
    $book->addCustomMetadata("calibre:series", "PHPePub test — Carnet du Frac");
    $book->addCustomMetadata("calibre:series_index", "3");
    */
}




/**
 * [multipublisher_settings_page description]
 * @return [type] [description]
 */
function multipublisher_settings_page() {
	//echo plugins_url('../',__FILE__);
	//echo plugin_dir_path( __FILE__ );
	//echo WP_PLUGIN_DIR;
	include( MultiPublisher::$pluginPath . 'inc/views/option.php' );
}

/**
 * [my_custom_submenu_page_callback description]
 * @return [type] [description]
 */
function my_custom_submenu_page_callback() {
	
	echo '<div class="wrap"><div id="icon-tools" class="icon32"></div>';
		echo '<h2>My Custom Submenu Page</h2>';
	echo '</div>';

}



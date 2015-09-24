

##LIENS

###REFS DES FONCTIONS

- https://codex.wordpress.org/Function_Reference/

###DIVERS

- https://codex.wordpress.org/Function_Reference/plugin_dir_path   --> repertoire du plugin
- https://codex.wordpress.org/Plugin_API/Filter_Reference          --> API ref
- https://codex.wordpress.org/Plugin_API                           --> plugin API
- https://codex.wordpress.org/Plugin_API/Action_Reference
- https://codex.wordpress.org/Function_Reference/add_action        --> add action
- https://codex.wordpress.org/Function_Reference/apply_filters     --> apply filters
- https://codex.wordpress.org/Function_Reference/register_post_type


###METABOX

- https://codex.wordpress.org/Function_Reference/add_meta_box      --> add metaBOX !!!!
- http://wptheming.com/2010/08/custom-metabox-for-post-type/
- https://wordpress.org/ideas/topic/add-meta-box-to-multiple-post-types
- https://gist.github.com/Jonathonbyrd/1880770


###IMAGES

- https://codex.wordpress.org/Function_Reference/add_image_size    --> image size
- https://wordpress.org/support/topic/image-exif-orientation-fix   --> rotation
- https://wordpress.org/support/topic/image-rotation-on-upload
- https://wordpress.org/plugins/imsanity/screenshots/
- http://stackoverflow.com/questions/5301006/image-getting-rotated-automatically-on-upload --> rotate / upload


###EDITOR

- https://codex.wordpress.org/Function_Reference/add_editor_style  --> add editor style
- https://codex.wordpress.org/Plugin_API/Filter_Reference/mce_css  --> editeur MCE

###RELATED POSTS

- http://www.joelsays.com/display-related-posts-without-plugin-wordpress/
- http://www.hongkiat.com/blog/wordpress-related-posts-without-plugins/


###PLUGIN CREATION

- http://www.wpbeginner.com/wp-tutorials/how-to-create-a-wordpress-plugin/
- http://www.smashingmagazine.com/2011/09/30/how-to-create-a-wordpress-plugin/


###PLUGINS 

- https://github.com/scribu/wp-posts-to-posts --> posts 2 posts


###LIBS

- http://phantomjs.org/download.html                               --> phantomJS
- http://phantomjs.org/build.html                                  --> build phantomJS
- http://wkhtmltopdf.org/downloads.html                            --> wkhtml2pdf


###epub :

- META-INF/com.apple.ibooks.display-options.xml --> http://helpman.it-authoring.com/viewtopic.php?f=30&t=12781
- http://www.ebookconverting.com/working-with-apples-fixed-format-layout
- http://stackoverflow.com/questions/28339484/options-for-single-page-view-book-view-in-com-apple-ibooks-display-options-xml
- http://wiki.mobileread.com/wiki/Fixed_layout_ePub
- http://www.mobileread.com/forums/showthread.php?t=192389
- http://www.pigsgourdsandwikis.com/2011/04/embedding-fonts-in-epub-ipad-iphone-and.html?m=1
- http://web.sigil.googlecode.com/git/files/OEBPS/Text/tutorial_embed_fonts.html


### PHANTOMJS

- https://github.com/ariya/phantomjs/issues/12948
- https://github.com/Pyppe/phantomjs2.0-ubuntu14.04x64


###BARCODE

- http://www.ashberg.de/php-barcode/?code=82.231.180.64&scale=6&bar=ANY

###epub Mime Type

- application/epub+zip



// array(
//                     'label'             => __('Éditions'),
//                     'singular_label'    => __('Edition'),
//                     'public'            => true,
//                     'show_ui'           => true,
//                     'show_in_menu'      => 'multipublisher',
//                     //'menu_icon'       => get_bloginfo('template_directory') .'/images/favicon.png',
//                     'menu_icon'         => 'dashicons-calendar',
//                     'show_in_nav_menus' => false,
//                     'capability_type'   => 'post',
//                     'rewrite'           => array("slug" => "edition"),
//                     'hierarchical'      => false,
//                     'query_var'         => false,
//                     'supports'          => array('title','editor','thumbnail'),
//                     'menu_position'     => 20,
//                     //'taxonomies'      => array('category'),
//                 )



// register_post_type(
//                 'chapitre',
//                 array(
//                     'label'             => __('Chapitres'),
//                     'singular_label'    => __('Chapitre'),
//                     'public'            => true,
//                     'show_ui'           => true,
//                     'show_in_menu'      => 'multipublisher',
//                     //'menu_icon'       => get_bloginfo('template_directory') .'/images/favicon.png',
//                     'menu_icon'         => 'dashicons-media-spreadsheet',
//                     'show_in_nav_menus' => false,
//                     'capability_type'   => 'post',
//                     'rewrite'           => array("slug" => "chapitre"),
//                     'hierarchical'      => false,
//                     'query_var'         => false,
//                     'supports'          => array('title','editor','thumbnail'),
//                     'menu_position'     => 20,
//                     //'taxonomies'      => array('category'),
//                 )
//             );



// function plugin_mce_css( $mce_css ) {
//     if ( ! empty( $mce_css ) )
//         $mce_css .= ',';

//     $mce_css .= $this->pluginUrl . 'css/editor-style.css' ;

//     return $mce_css;
// }
// add_filter( 'mce_css', 'plugin_mce_css' );


// function mp_create_custom_posts() {

//     // Edition
//     register_post_type(
//         'edition',
//         array(
//             'label'             => __('Éditions'),
//             'singular_label'    => __('Edition'),
//             'public'            => true,
//             'show_ui'           => true,
//             'show_in_menu'      => 'multipublisher',
//             //'menu_icon'       => get_bloginfo('template_directory') .'/images/favicon.png',
//             'menu_icon'         => 'dashicons-calendar',
//             'show_in_nav_menus' => false,
//             'capability_type'   => 'post',
//             'rewrite'           => array("slug" => "edition"),
//             'hierarchical'      => false,
//             'query_var'         => false,
//             'supports'          => array('title','editor','thumbnail'),
//             'menu_position'     => 20,
//             'taxonomies'        => array('auteur','sujet'),
//         )
//     );  

//     // Chapitre
//     register_post_type(
//         'chapitre',
//         array(
//             'label'             => __('Chapitres'),
//             'singular_label'    => __('Chapitre'),
//             'public'            => true,
//             'show_ui'           => true,
//             'show_in_menu'      => 'multipublisher',
//             //'menu_icon'       => get_bloginfo('template_directory') .'/images/favicon.png',
//             'menu_icon'         => 'dashicons-media-spreadsheet',
//             'show_in_nav_menus' => false,
//             'capability_type'   => 'post',
//             'rewrite'           => array("slug" => "chapitre"),
//             'hierarchical'      => false,
//             'query_var'         => false,
//             'supports'          => array('title','editor','thumbnail'),
//             'menu_position'     => 20,
//             //'taxonomies'      => array('category'),
//         )
//     );  
// }


// function create_mp_taxonomies(){                

//     $labels_auteur = array(
//         'name'              => _x( 'Auteurs', 'taxonomy general name' ),
//         'singular_name'     => _x( 'Auteur',  'taxonomy singular name' ),
//         'search_items'      => __( 'Rechercher un auteur' ),
//         'all_items'         => __( 'Tous les auteurs' ),
//         'parent_item'       => null,
//         'parent_item_colon' => null,
//         //'show_ui'         => false,
//         'menu_name'         => __( 'Auteurs' )
//     ); 

//     register_taxonomy('auteur',array('edition'),array(
//         'hierarchical'      => false,
//         'labels'            => $labels_auteur,
//         'show_ui'           => true,
//         'show_tagcloud'     => false,
//         'query_var'         => true,
//         'show_in_nav_menus' => false,
//         'show_admin_column' => true,
//         'rewrite'           => array( 'slug' => 'auteur' )
//     ));

//     $labels_sujet = array(
//         'name'              => _x( 'Sujets', 'taxonomy general name' ),
//         'singular_name'     => _x( 'Sujet',  'taxonomy singular name' ),
//         'search_items'      => __( 'Rechercher un sujet' ),
//         'all_items'         => __( 'Tous les sujets' ),
//         'parent_item'       => null,
//         'parent_item_colon' => null,
//         //'show_ui'         => false,
//         'menu_name'         => __( 'Sujets' )
//     ); 

//     register_taxonomy('sujet',array('edition'),array(
//         'hierarchical'      => false,
//         'labels'            => $labels_sujet,
//         'show_ui'           => true,
//         'show_tagcloud'     => false,
//         'query_var'         => true,
//         'show_in_nav_menus' => false,
//         'show_admin_column' => true,
//         'rewrite'           => array( 'slug' => 'auteur' )
//     ));
// }



// add_action( 'init', 'mp_create_custom_posts' );
// add_action( 'init', 'create_mp_taxonomies' );



/*foreach (self::$meta_boxes as $meta_box) {
    //var_dump($meta_box);
    $my_box = new My_meta_box($meta_box);
}*/

// Move TinyMCE Editor to the bottom
// https://wordpress.org/support/topic/move-custom-meta-box-above-editor
/*add_action( 'add_meta_boxes', 'action_add_meta_boxes', 0 );
function action_add_meta_boxes() {
    global $_wp_post_type_features;
    if (isset($_wp_post_type_features['edition']['editor']) && $_wp_post_type_features['edition']['editor']) {
        unset($_wp_post_type_features['edition']['editor']);
        add_meta_box(
            'description_section',
            __('Description'),
            'inner_custom_box',
            'edition',
            'normal',
            'low'
        );
    }
    add_action( 'admin_head', 'action_admin_head'); //white background
}
function action_admin_head() {
?>
<style type="text/css">
    .wp-editor-container{background-color:#fff;}
</style>
<?php
}
function inner_custom_box( $post ) {
echo '<div class="wp-editor-wrap">';
//the_editor is deprecated in WP3.3, use instead:
wp_editor($post->post_content, 'content', array('dfw' => true, 'tabindex' => 1) );
//the_editor($post->post_content);
echo '</div>';
}*/


/*add_action( 'admin_footer', 'my_action_javascript' ); // Write our JS below here

function my_action_javascript() { ?>
    <script type="text/javascript" >
    jQuery(document).ready(function($) {

        var data = {
            'action': 'my_action',
            'whatever': 1234
        };

        // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
        $.post(ajaxurl, data, function(response) {
            alert('Got this from the server: ' + response);
        });
    });
    </script> <?php
}*/



/**
 * AJAX DIALOG SEARCH CUSTOM POST
 * http://shibashake.com/wordpress-theme/find-posts-dialog-box
 */

/*add_action("admin_print_styles", 'plugin_admin_styles' );
//add_action("admin_print_scripts", 'plugin_admin_scripts' );


function plugin_admin_styles() {
    wp_enqueue_style('thickbox'); // needed for find posts div
    // https://codex.wordpress.org/Function_Reference/wp_enqueue_style
    wp_enqueue_style('multipublisher_css');
    wp_enqueue_style("wp-jquery-ui-dialog");
    //wp_enqueue_style('mp_editor_css');
    //add_editor_style( MultiPublisher::$pluginUrl .'css/editor-style.css' );
}*/
 
/*function plugin_admin_scripts() {
    wp_enqueue_script('thickbox'); // needed for find posts div
    wp_enqueue_script('media');
    //wp_enqueue_script('wp-ajax-response');
}*/

// http://shibashake.com/wordpress-theme/find-posts-dialog-box
// http://stackoverflow.com/questions/14416409/wordpress-custom-metabox-input-value-with-ajax
// http://stackoverflow.com/questions/23952336/wordpress-ajax-custom-taxonomy
// https://wordpress.org/support/topic/how-to-add-ajaxurl
// https://wordpress.org/support/topic/ajaxurl-is-not-defined
// https://codex.wordpress.org/AJAX
// https://codex.wordpress.org/AJAX_in_Plugins
// https://wordpress.org/support/topic/how-to-activate-a-jquery-ui-dialog
// http://www.wpactions.com/1389/wordpress-tinymce-how-to-create-a-dialog-based-button/
// 
// 
// http://www.deluxeblogtips.com/2010/04/how-to-create-meta-box-wordpress-post.html
// http://www.deluxeblogtips.com/2010/05/howto-meta-box-wordpress.html
// https://wordpress.org/plugins/custom-post-template/
// http://stackoverflow.com/questions/19328475/adding-custom-page-template-from-plugin
// http://themeforest.net/forums/thread/possible-to-add-custom-template-page-in-a-wp-plugin-/71159
// http://www.wpexplorer.com/wordpress-page-templates-plugin/
// 




/*


// =======================
// REDIRECTION DE TEMPLATE
// =======================
// http://stackoverflow.com/questions/4647604/wp-use-file-in-plugin-directory-as-custom-page-template
//Template fallback
add_action("template_redirect", 'my_theme_redirect');

function my_theme_redirect() {
    global $wp;
    $plugindir = dirname( __FILE__ );

    //A Specific Custom Post Type
    if ($wp->query_vars["post_type"] == 'product') {
        $templatefilename = 'single-product.php';
        if (file_exists(TEMPLATEPATH . '/' . $templatefilename)) {
            $return_template = TEMPLATEPATH . '/' . $templatefilename;
        } else {
            $return_template = $plugindir . '/themefiles/' . $templatefilename;
        }
        do_theme_redirect($return_template);

    //A Custom Taxonomy Page
    } elseif ($wp->query_vars["taxonomy"] == 'product_categories') {
        $templatefilename = 'taxonomy-product_categories.php';
        if (file_exists(TEMPLATEPATH . '/' . $templatefilename)) {
            $return_template = TEMPLATEPATH . '/' . $templatefilename;
        } else {
            $return_template = $plugindir . '/themefiles/' . $templatefilename;
        }
        do_theme_redirect($return_template);

    //A Simple Page
    } elseif ($wp->query_vars["pagename"] == 'somepagename') {
        $templatefilename = 'page-somepagename.php';
        if (file_exists(TEMPLATEPATH . '/' . $templatefilename)) {
            $return_template = TEMPLATEPATH . '/' . $templatefilename;
        } else {
            $return_template = $plugindir . '/themefiles/' . $templatefilename;
        }
        do_theme_redirect($return_template);
    }
}

function do_theme_redirect($url) {
    global $post, $wp_query;
    if (have_posts()) {
        include($url);
        die();
    } else {
        $wp_query->is_404 = true;
    }
}





 */
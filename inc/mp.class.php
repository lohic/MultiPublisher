<?php
/**
 *  ┌──────────────────┐
 *  │                  │
 *  │ MULTI PUBLISHER  │
 *  │ CARNET DU FRAC   │
 *  │                  │
 *  └──────────────────┘
 */



if ( ! defined( 'ABSPATH' ) ) {
    die( '-1' );
}


use PHPePub\Core\EPub;
use PHPePub\Core\EPubChapterSplitter;
use PHPePub\Core\Structure\OPF\DublinCore;
use PHPePub\Core\Logger;
use PHPZip\Zip\File\Zip;



if ( ! class_exists( 'MultiPublisher' ) ) {
    class MultiPublisher {

        protected static $instance;

        static $pluginDir;
        static $pluginPath;
        static $pluginUrl;
        static $cachePath;

        static $publicationType = 'html';
        static $xRefCount = 0;

        /**
         * Args for the edition post type
         * @var array
         */
        protected $editionArgs = array(
            'public'          => true,
            'rewrite'         => array( 'slug' => 'edition', 'with_front' => false ),
            'menu_position'   => 6,
            'supports'        => array(
                'title',
                'editor',
                'thumbnail',
                'custom-fields'
            ),
            'capability_type' => array( 'multi_publisher_edition', 'multi_publisher_editions' ),
            'map_meta_cap'    => true
        );


        protected static $meta_boxes = array(
            array(
                'id' => 'edition_additionnal',
                'title' => 'Méta données',
                'pages' => array('edition'),
                'context' => 'normal',
                'priority' => 'high',
                'fields' => array(
                    array(
                        'name' => 'Text box',
                        'desc' => 'Enter something here',
                        'id'   => 'mp_text',
                        'type' => 'text',
                        'std'  => 'Default value 1'
                    )
                )
            ),
            array(
                'id' => 'my-meta-box-2',
                'title' => 'Custom meta box 2',
                'pages' => array('post', 'link'), // custom post type
                'context' => 'normal',
                'priority' => 'high',
                'fields' => array(
                    array(
                        'name' => 'Select box',
                        'id' => 'mp_select',
                        'type' => 'select',
                        'options' => array('Option 1', 'Option 2', 'Option 3')
                    )
                )
            )
        );

        protected static $lang = array(
            'fr-FR'=>'Français',
            'en-EN'=>'English',
            'es-ES'=>'Espagnol',
        );


  


        /**
         * Args for the chapitre post type
         * @var array
         */
        protected $chapitreArgs = array(
            'public'          => true,
            'rewrite'         => array( 'slug' => 'chapitre', 'with_front' => false ),
            'menu_position'   => 6,
            'supports'        => array(
                'title',
                'editor',
                'thumbnail'
            ),
            'capability_type' => array( 'multi_publisher_chapter', 'multi_publisher_chapters' ),
            'map_meta_cap'    => true
        );


        /**
         * Static Singleton Factory Method
         * @return MultiPublisher
         */
        public static function instance() {
            if ( ! isset( self::$instance ) ) {
                $className      = __CLASS__;
                self::$instance = new $className;
            }

            return self::$instance;
        }



        /**
         * Initializes plugin variables and sets up WordPress hooks/actions.
         */
        protected function  __construct() {

            self::$pluginPath = trailingslashit( dirname( dirname( __FILE__ ) ) );
            self::$pluginDir  = trailingslashit( basename( self::$pluginPath ) );
            self::$pluginUrl  = plugins_url( self::$pluginDir );
            self::$cachePath  = self::$pluginPath.'../../mp-cache'; // dans le répertoire wp-content/

            if(!is_dir( self::$cachePath ) ){
                mkdir( self::$cachePath );
            }

            $this->loadLibraries();

            // Rien pour l’instant
            //
            //            
            if(isset($_GET['mp_publication_type'])){
	            switch($_GET['mp_publication_type']){

	                case "epub" :
	                	MultiPublisher::$publicationType = "epub";
	                	break;
	                case "pdf" :
	                	MultiPublisher::$publicationType = "pdf";
	                	break;
	                default :
	                	MultiPublisher::$publicationType = "html";
	                break;

	            }
			} else{
			    MultiPublisher::$publicationType = "html";
			}  
            
            // on ne charge les dépendances que si on est pas en admin
            if(!is_admin()){

                // add_action('wp_head','talm_menu_head',99);
                // wp_enqueue_style('talm_social', '/wp-content/plugins/formidable_talm_social/style.css');
                // wp_enqueue_script('talm_social_js','/wp-content/plugins/formidable_talm_social/script.js',array('jquery'),false,true);
                // add_action('wp_footer','talm_social_html');

            }

            
            // include( $this->pluginPath . '/inc/OLD-mp.My_meta_box.php' );




            add_action( 'add_meta_boxes', array( $this, 'add_meta_box_edition' ) );
            add_action( 'save_post', array( $this, 'save' ) );


            


            /**
             * TEMPLATE REDIRECTION
             */
            
            add_action("template_redirect",  array( $this, 'my_theme_redirect' ) );

		

            /**
             * AJAX
             */
            add_action( 'wp_ajax_dialog_partie', 			 array( $this, 'dialog_partie_callback') );
            add_action( 'wp_ajax_dialog_add_partie',	 	 array( $this, 'dialog_add_partie_callback') );
            add_action( 'wp_ajax_publication_update_parent', array( $this, 'publication_update_parent_callback') );
            add_action( 'wp_ajax_generate_publication', 	 array( $this, 'generate_publication_callback') );
            // FIN AJAX


            /**
             * SHORTCODES
             */
            add_shortcode( 'xref', array( $this, 'xref_shortcode_function') );
            // FIN SHORTCODES


            add_action( 'admin_print_scripts', 'mp_gallery_dialog' );

            function mp_gallery_dialog() { 
                include( MultiPublisher::$pluginPath . 'inc/views/mp-gallery.php' );
            }

            add_action( 'admin_head', 'mp_gallery_js_vars' );
            function mp_gallery_js_vars() {

                // Bring the post type global into scope
                global $post_type;

                // If the current post type doesn't match, return, ie. end execution here
                if( 'publication' != $post_type )
                    return;

                // Else we reach this point and do whatever
                ?>
                <!-- TinyMCE Shortcode Plugin -->
                <script type='text/javascript'>
                var mp_js_vars = {
                    'wp': null,
                    'ed': null,
                    'url': null,
                };
                </script>
                <?php
            }


            add_filter( 'img_caption_shortcode', 'mp_caption_shortcode', 10, 3 );

            function mp_caption_shortcode( $empty, $attr, $content ){
                $attr = shortcode_atts( array(
                    'id'      => '',
                    'align'   => 'alignnone',
                    'width'   => '',
                    'caption' => ''
                ), $attr );

                if ( 1 > (int) $attr['width'] || empty( $attr['caption'] ) ) {
                    return '';
                }

                if ( $attr['id'] ) {
                    $attr['id'] = 'id="' . esc_attr( $attr['id'] ) . '" ';
                }

                return '<figure ' . $attr['id']
                . 'class="wp-caption ' . esc_attr( $attr['align'] ) . '" '
                . 'style="max-width: ' . ( 10 + (int) $attr['width'] ) . 'px;">'
                . do_shortcode( $content )
                . '<figcaption class="wp-caption-text">ok ok ' . $attr['caption'] . '</figcaption>'
                . '</figure>';

            }

            

            // ------------------------------------------



            if( !function_exists('multi_publisher_mce_buttons_2') )
            {
                function multi_publisher_mce_buttons_2( $buttons ) {
                    array_unshift( $buttons, 'styleselect' );
                    return $buttons;
                }
                add_filter( 'mce_buttons_2', 'multi_publisher_mce_buttons_2' );
            }
            

            if( !function_exists('multi_publisher_tiny_mce_before_init') )
            {
                function multi_publisher_tiny_mce_before_init( $settings ) {
                    //
                    $settings['theme_advanced_blockformats'] = 'p,a,div,span,h1,h2,h3,h4,h5,h6,tr,';
                    $style_formats = array(
                        array( 'title' => 'Button',             'inline' => 'span', 'classes' => 'button' ),
                        array( 'title' => 'Green Button',       'inline' => 'span', 'classes' => 'button button-green' ),
                        array( 'title' => 'Rounded Button',     'inline' => 'span', 'classes' => 'button button-rounded' ),
                        array( 'title' => 'Other Options' ),
                        array( 'title' => '½ Col.',             'block'  => 'div',  'classes' => 'one-half' ),
                        array( 'title' => '½ Col. Last',        'block'  => 'div',  'classes' => 'one-half last' ),
                        array( 'title' => 'Callout Box',        'block'  => 'div',  'classes' => 'callout-box' ),
                        array( 'title' => 'Highlight',          'inline' => 'span', 'classes' => 'highlight' ),
                        array( 'title' => 'Chapeau',            'block'  => 'p',    'classes' => 'chapeau' )
                    );
                    $settings['style_formats'] = json_encode( $style_formats );
    
                    // $settings['plugins'] = 'template';
                    // $templates = array(
                    //     array( 'title' => 'test template', 'description' => 'description template', 'content' => 'My content')
                    // );
                    // $settings['templates'] = json_encode( $templates );

                    
                    
                    return $settings;
                }
                add_filter( 'tiny_mce_before_init', 'multi_publisher_tiny_mce_before_init' );
            }


            /**
             * AJOUT DE BOUTON tinyMCE
             */
            add_action( 'admin_init', 'my_tinymce_button' );

            function my_tinymce_button() {
                 if ( current_user_can( 'edit_posts' ) && current_user_can( 'edit_pages' ) ) {
                      add_filter( 'mce_buttons', 'my_register_tinymce_button' );
                      add_filter( 'mce_external_plugins', 'my_add_tinymce_button' );
                 }
            }

            function my_register_tinymce_button( $buttons ) {
                 array_push( $buttons, "button_eek", "button_green", "mp_tab" );
                 return $buttons;
            }

            function my_add_tinymce_button( $plugin_array ) {
                 $plugin_array['my_button_script'] = plugins_url( '/mybuttons.js', __FILE__ ) ;
                 return $plugin_array;
            }

            // function my_default_editor() {
            //     $r = 'html'; // html or tinymce
            //     return $r;
            // }
            // add_filter( 'wp_default_editor', 'my_default_editor' );


        }

        /**
         * Fonction pour ajouter un shortcode de référence croisée
         * [xref txt="le fragment de texte" id="57" ]
         * @param  [type] $atts [description]
         * @return [type]       [description]
         */
        public function xref_shortcode_function( $atts ){
            $compteur = MultiPublisher::$xRefCount ++;

            $a = shortcode_atts( array(
                'txt' => 'something',
                'id' => 0,
            ), $atts );

            return "<a href=\"#{$a['id']}\">{$a['txt']} {$compteur}</a>";
        }



        // AJAX CALLBACK 
        public function publication_update_parent_callback() {
            include( MultiPublisher::$pluginPath . 'inc/views/ajax-publication-update-parent.php' );
        }

        public function dialog_add_partie_callback() {
            include( MultiPublisher::$pluginPath . 'inc/views/ajax-dialog-partie.php' );
        }

        public function dialog_partie_callback() {
            include( MultiPublisher::$pluginPath . 'inc/views/ajax-dialog.php' );
        }

        public function generate_publication_callback(){
        	$this->generate_epub( $_POST['ID'] );
        }


        /**
         * [page_ancestor description]
         * https://wordpress.org/support/topic/get-parent-pages
         * @param  integer $id        [description]
         * @param  integer $id_parent [description]
         * @return [type]             [description]
         */
        private static function page_ancestor($id=0, $id_parent=0){
	        $parentID=$id_parent;

	        $parent_tree[] = intVal($id);

	        while( $parentID != 0 ){
		        $parent=get_post($parentID);

		        array_unshift($parent_tree, $parent->ID);

		        $parentID=$parent->post_parent;
	        }

	        return $parent_tree;
        }


        private static function publication_children($id=0){
	        $my_wp_query  = new WP_Query();
			$all_wp_pages = $my_wp_query->query(array('post_type' => 'publication'));
			$children 	  = get_page_children( $id, $all_wp_pages );
			
			return $children;
        }

        /**
         * [my_theme_redirect description]
         * @return [type] [description]
         */
        public function my_theme_redirect() {
		    global $wp;
		    //$plugindir = dirname( __FILE__ );

		    //A Specific Custom Post Type
		    if ($wp->query_vars["post_type"] == 'edition') {
		        $templatefilename = 'single-edition.php';
		        if (file_exists(TEMPLATEPATH . '/' . $templatefilename)) {
		            $return_template = TEMPLATEPATH . '/' . $templatefilename;
		        } else {
		            $return_template = MultiPublisher::$pluginPath . 'themefiles/carnet-du-frac/' . $templatefilename;
		        }
		        $this->do_theme_redirect($return_template);

		    }elseif ($wp->query_vars["post_type"] == 'chapitre') {
		        $templatefilename = 'single-chapitre.php';
		        if (file_exists(TEMPLATEPATH . '/' . $templatefilename)) {
		            $return_template = TEMPLATEPATH . '/' . $templatefilename;
		        } else {
		            $return_template = MultiPublisher::$pluginPath . 'themefiles/carnet-du-frac/' . $templatefilename;
		        }
		        $this->do_theme_redirect($return_template);
            }elseif ($wp->query_vars["post_type"] == 'publication') {
                $templatefilename = 'single-publication.php';
                if (file_exists(TEMPLATEPATH . '/' . $templatefilename)) {
                    $return_template = TEMPLATEPATH . '/' . $templatefilename;
                } else {
                    $return_template = MultiPublisher::$pluginPath . 'themefiles/carnet-du-frac/' . $templatefilename;
                }
                $this->do_theme_redirect($return_template);

		    // //A Custom Taxonomy Page
		    // } elseif ($wp->query_vars["taxonomy"] == 'product_categories') {
		    //     $templatefilename = 'taxonomy-product_categories.php';
		    //     if (file_exists(TEMPLATEPATH . '/' . $templatefilename)) {
		    //         $return_template = TEMPLATEPATH . '/' . $templatefilename;
		    //     } else {
		    //         $return_template = $plugindir . '/themefiles/' . $templatefilename;
		    //     }
		    //     do_theme_redirect($return_template);

		    // //A Simple Page
		    // } elseif ($wp->query_vars["pagename"] == 'somepagename') {
		    //     $templatefilename = 'page-somepagename.php';
		    //     if (file_exists(TEMPLATEPATH . '/' . $templatefilename)) {
		    //         $return_template = TEMPLATEPATH . '/' . $templatefilename;
		    //     } else {
		    //         $return_template = $plugindir . '/themefiles/' . $templatefilename;
		    //     }
		    //     do_theme_redirect($return_template);
		    }
		}


        /**
         * [do_theme_redirect description]
         * @param  [type] $url [description]
         * @return [type]      [description]
         */
        protected function do_theme_redirect($url) {
		    global $post, $wp_query;
		    if (have_posts()) {
		        include($url);
		        die();
		    } else {
		        $wp_query->is_404 = true;
		    }
		}


        /**
         * Load all the required library files.
         */
        protected function loadLibraries() {
            
            require_once( MultiPublisher::$pluginPath . 'inc/mp.structure.php');
            require_once( MultiPublisher::$pluginPath . 'public/mp.functions.php');
            require_once( MultiPublisher::$pluginPath . 'inc/mp-settings.php' );
            //require_once( MultiPublisher::$pluginPath . 'inc/lib/epub-2014-09-21/Logger.php');
            //require_once( MultiPublisher::$pluginPath . 'inc/lib/epub-2014-09-21/EPub.php');
            require_once( MultiPublisher::$pluginPath . 'vendor/autoload.php');


            mp_structure::instance();

            //add_action( 'admin_init',            array( $this, 'mp_admin_init' ) );

            add_action( 'admin_enqueue_scripts', array( $this, 'mp_scripts' ) );
            add_action( 'admin_print_styles',    array( $this, 'mp_styles' ) );

            // Load Template Tags
            // require_once $this->pluginPath . '/inc/multi-publisher-editions.php';
            // require_once $this->pluginPath . '/inc/multi-publisher-chapitres.php';
            // 
            
            add_action( 'wp_ajax_find_posts', array( $this, 'wp_ajax_find_posts'),1);


            //$this->generate_epub();
        }


        /**
         * [wp_ajax_find_posts description]
         * cf https://developer.wordpress.org/reference/functions/wp_ajax_find_posts/
         * http://codex.wordpress.org/Function_Reference/get_post_types
         * @return [type] [description]
         */
        public function wp_ajax_find_posts() {
            check_ajax_referer( 'find-posts' );

            $post_types = get_post_types( array( 'public' => true, '_builtin' => false ), 'objects' );
            // unset( $post_types['attachment'] );
            // unset( $post_types['post'] );
            // unset( $post_types['page'] );
            // unset( $post_types['revision'] );
            unset( $post_types['edition'] );


            $s = wp_unslash( $_POST['ps'] );
            $args = array(
                'post_type' => array_keys( $post_types ),
                'post_status' => 'any',
                'posts_per_page' => 50,
            );
            if ( '' !== $s )
                $args['s'] = $s;

            $posts = get_posts( $args );

            if ( ! $posts ) {
                wp_send_json_error( __( 'No items found.' ) );
            }

            $html = '<table class="widefat"><thead><tr><th class="found-radio"><br /></th><th>'.__('Title').'</th><th class="no-break">'.__('Type').'</th><th class="no-break">'.__('Date').'</th><th class="no-break">'.__('Status').'</th></tr></thead><tbody>';
            $alt = '';
            foreach ( $posts as $post ) {
                $title = trim( $post->post_title ) ? $post->post_title : __( '(no title)' );
                $alt = ( 'alternate' == $alt ) ? '' : 'alternate';

                switch ( $post->post_status ) {
                    case 'publish' :
                    case 'private' :
                        $stat = __('Published');
                        break;
                    case 'future' :
                        $stat = __('Scheduled');
                        break;
                    case 'pending' :
                        $stat = __('Pending Review');
                        break;
                    case 'draft' :
                        $stat = __('Draft');
                        break;
                }

                if ( '0000-00-00 00:00:00' == $post->post_date ) {
                    $time = '';
                } else {
                    /* translators: date format in table columns, see http://php.net/date */
                    $time = mysql2date(__('Y/m/d'), $post->post_date);
                }

                $html .= '<tr class="' . trim( 'found-posts ' . $alt ) . '"><td class="found-radio"><input type="radio" id="found-'.$post->ID.'" name="found_post_id" value="' . esc_attr($post->ID) . '"></td>';
                $html .= '<td><label for="found-'.$post->ID.'">' . esc_html( $title ) . '</label></td><td class="no-break">' . esc_html( $post_types[$post->post_type]->labels->singular_name ) . '</td><td class="no-break">'.esc_html( $time ) . '</td><td class="no-break">' . esc_html( $stat ). ' </td></tr>' . "\n\n";
            }

            $html .= '</tbody></table>';

            wp_send_json_success( $html );
            }


        /**
         * [mp_admin_init description]
         * @return [type] [description]
         */
        /*public function mp_admin_init(){
            wp_register_style( 'mp_admin_css', MultiPublisher::$pluginUrl .'css/mp-admin.css');
        }*/

        /**
         * [mp_scripts description]
         * @return [type] [description]
         */
        public function mp_scripts() { 
            wp_enqueue_script( 'jquery-ui-sortable' );
            wp_enqueue_script( 'jquery-ui-dialog');
            wp_enqueue_script( 'wpdialogs');
            //wp_enqueue_script( 'wpdialogs-popup');
            wp_enqueue_script( 'thickbox'); // needed for find posts div
            wp_enqueue_script( 'media');

            wp_enqueue_script( 'mp_admin_script', MultiPublisher::$pluginUrl .'js/mp-admin.js', array('jquery') );
        }

        /**
         * [mp_styles description]
         * @return [type] [description]
         */
        public function mp_styles() {
            wp_enqueue_style('thickbox'); // needed for find posts div
            // https://codex.wordpress.org/Function_Reference/wp_enqueue_style
            wp_register_style( 'mp_admin_css', MultiPublisher::$pluginUrl .'css/mp-admin.css');
            wp_enqueue_style( 'mp_admin_css');
            wp_enqueue_style( 'wp-jquery-ui-dialog' );
        }


        public function generate_epub($post_ID=null){

            if( !empty( $post_ID ) ){

                $publication_id = $post_ID;


                $publication_data    = get_post($publication_id); 
                $publication_content = $publication_data->post_content;
                $publication_type 	 = $publication_data->post_type;

                // test partie ID -> 41
                // http://localhost:8888/Site_CDF/?p=41
           
                // -> ARBORESCENCE D'UNE PUBLICATION
                // http://codex.wordpress.org/Class_Reference/wpdb
                /*SELECT p.ID, p.post_title, p.post_name, p.guid, p.post_parent, m.meta_value AS mp_main_parent_id_key, p.menu_order
                FROM wp_posts AS p, wp_postmeta AS m
                WHERE post_type='publication'
                AND m.meta_key = 'mp_main_parent_id_key'
                AND m.meta_value = 51
                AND m.post_id = p.ID
                ORDER BY menu_order*/
               

                if( $publication_type == 'publication' ) {


	                $publication_query = "SELECT p.ID, p.post_title, p.post_name, p.guid, p.post_parent, m.meta_value AS mp_main_parent_id_key, p.menu_order
	                FROM wp_posts AS p, wp_postmeta AS m
	                WHERE post_type='publication'
	                AND m.meta_key = 'mp_main_parent_id_key'
	                AND m.meta_value = $post_ID
	                AND m.post_id = p.ID
	                ORDER BY menu_order";

	                global $wpdb;

	                $structure  = $wpdb->get_results( $publication_query );

	                $main = new StdClass;
	                $main->post_parent = 0;
	                $main->ID = 51;
	                $main->post_title = "MAIN Essai Poirier";
	                $main->child = array();

	                // On ajoute $main à $structure
	                //$structure[] = $main;

	                $structure = array_unshift($structure, $main);

	                //print_r($structure);

	                // STACK
	                // http://stackoverflow.com/questions/2871861/how-to-build-unlimited-level-of-menu-through-php-and-mysql
	                // http://pastebin.com/GAFvSew4

	                $html = '';
					$parent = 0;
					$parent_stack = array();

					// $items contains the results of the SQL query
					$children = array();
					foreach ( $structure as $item ) {
						$item->child = array();
					    $children[ $item->post_parent ][] = $item;						
					}

					//print_r(json_encode($children));

					//print_r("\n___\n\n");
					//
					


					// function generate_structure($child_array){

					// 	$parent = 0;
					// 	$i 		= 0;
						
					// 	foreach($child_array as $parent_id => $child_tree){

					// 		print_r( $parent_id );
					// 		print_r( $child_tree );

					// 		if(is_array($child_tree)){
					// 			generate_structure( $child_tree );
					// 		}
					// 		//

					// 	}

					// }

					// generate_structure($structure);


					print_r(json_encode($structure));

					$i = 0;
					while ( ( $option = each( $children[ $parent ] ) ) || ( $parent > 0 ) ) {
					    if ( !empty( $option ) ) {

					    	//print_r( $option['value']->ID." ".$option['value']->post_parent." ".$option['value']->post_title."\n" );

					        // 1) The item contains children:
					        // store current parent in the stack, and update current parent
					        if ( !empty( $children[ $option['value']->ID ] ) ) {

					        	$i++;
					        	//echo $i. '! ' . $option['value']->ID .' '.$option['value']->post_title."\n";

					            $html .= '<li>' . $option['value']->post_title . '</li>'."\n";
					            $html .= '<ul>'."\n"; 
					            array_push( $parent_stack, $parent );
					            $parent = $option['value']->ID;


					            //echo $i. '  \ ' ."\n";
					            $publication[] = $option['value'];
					        }
					        // 2) The item does not contain children
					        else {
					        	$i++;
					        	//echo $i. '  ' . $option['value']->ID .' '.$option['value']->post_title."\n";


					            $html .= '<li>' . $option['value']->post_title . '</li>'."\n";


					            $publication[] = $option['value'];
					        }
					    }
					    // 3) Current parent has no more children:
					    // jump back to the previous menu level
					    else {
					    	$i++;
					        //echo $i. '  / ' ."\n";

					        $html .= '</ul>'."\n";

					        $parent = array_pop( $parent_stack );
					    }
					}
					//print_r( json_encode($main) );

					// At this point, the HTML is already built
					//echo $html;
					//
					//print_r($publication);


					// END STACK


                    MultiPublisher::$publicationType = "epub";

					$publication_content = apply_filters('the_content', $publication_content);

					$publication_name	= $publication_data->post_name;

					$ISBN               = get_post_meta( $publication_id, 'mp_ISBN_key', true );
		            $langue             = explode("-",get_post_meta( $publication_id, 'mp_langue_key', true ))[0];
		            $afficherParties    = get_post_meta( $publication_id, 'mp_afficherParties_key', true );
		            $structure          = get_post_meta( $publication_id, 'mp_structure_key', true );

					$content_start =
					"<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n"
					. "<html xmlns=\"http://www.w3.org/1999/xhtml\" xmlns:epub=\"http://www.idpf.org/2007/ops\">\n"
					. "<head>"
					. "<meta http-equiv=\"Default-Style\" content=\"text/html; charset=utf-8\" />\n"
					. "<link rel=\"stylesheet\" type=\"text/css\" href=\"../Styles/style.css\" />\n"
					. "<title>" . get_the_title( $publication_id ). "</title>\n"
					. "</head>\n"
					. "<body>\n";

					$bookEnd = "</body>\n</html>\n";

					date_default_timezone_set('Europe/Paris');

					$log = new Logger("Example", TRUE);

					$fileDir = './PHPePub';
					$log->logLine("include EPub");

					// ePub 3 is not fully implemented. but aspects of it is, in order to help inmplementers.
					// ePub 3 uses HTML5, formatted strictly as if it was XHTML but still using just the HTML5 doctype (aka XHTML5)
					$book = new EPub(EPub::BOOK_VERSION_EPUB3, $langue, EPub::DIRECTION_LEFT_TO_RIGHT); // Default is ePub 2

					// SET META
					$book->setTitle( $publication_data->post_title );
					$book->setIdentifier( $ISBN, EPub::IDENTIFIER_ISBN );//"http://carnetdufrac.net/test.html", EPub::IDENTIFIER_URI);
					$book->setLanguage( $langue );
					//$book->setDescription( get_the_content() );
					$book->setDescription( $publication_content );
					$book->setAuthor("Loïc Horellou / Jérôme Saint Loubert Bié / Yohanna My Nguyen", "Johnson, John Doe");
					$book->setPublisher("John and Jane Doe Publications", "http://JohnJaneDoePublications.com/"); 
					$book->setDate( time() );
					$book->setRights("Copyright and licence information specific for the book."); 
					$book->setSourceURL( $publication_data->guid );
					$book->addDublinCoreMetadata(DublinCore::CONTRIBUTOR, "PHP");
					$book->setSubject("test — Carnet du Frac");
					$book->setSubject("keywords");
					$book->setSubject("Chapter levels");
					//$book->addCustomMetadata("calibre:series", "PHPePub test — Carnet du Frac");
					//$book->addCustomMetadata("calibre:series_index", "3");
					$log->logLine("Set up parameters");

					// ADD CSS
					// $cssData = "body{margin:0;}";
					// $log->logLine("Add css");
					// $book->addCSSFile("styles.css", "css1", $cssData);

                    // CHECK FONT
                    $stylesheet = file_get_contents(MultiPublisher::$pluginPath.'/themefiles/style.css');

                    if(preg_match_all("/[\w\d_\-\/.]+\.[ot]tf/", $stylesheet, $font_files)){
                        //print_r($font_files);
                    }

					// ADD CHAPTER
					//$book->addChapter("Chapitre 1: Raymond Hains — les textes", "index.html", "<head></head><body>Contenu du chapitre 1</body>", false);

					// ADD PARTIE
					// $partie_data    = get_post(41); 
                	// $partie_content = $partie_data->post_content;
                	// $partie_content = apply_filters('the_content', $partie_content);
                	// $partie_content = str_replace( ']]>', ']]&gt;', $partie_content );

                	$partie_content = html_entity_decode( file_get_contents("http://localhost:8888/Site_CDF/?p=57&mp_publication_type=epub") );

                	//$book->addChapter("Test", "test.html", $partie_content, false);
					$book->addChapter("Test 2", "test2.html", $partie_content, false, EPub::EXTERNAL_REF_ADD, './images/');

					// addChapter($chapterName, $fileName, $chapterData = null, $autoSplit = false, $externalReferences = EPub::EXTERNAL_REF_IGNORE, $baseDir = "")
					// EPub::EXTERNAL_REF_IGNORE
					// EPub::EXTERNAL_REF_ADD
					// EPub::EXTERNAL_REF_REPLACE_IMAGES
					// attention nettoyer le HTML avant la structure wordpress est surement trop complexe
					// https://github.com/Grandt/PHPePub/blob/master/tests/EPub.ExampleImg.php
					// https://github.com/Grandt/PHPePub/blob/master/src/PHPePub/Core/EPub.php
					// processChapterExternalReferences

					// ADD TOC
					//$book->buildTOC();

					// ADD LOG
					if ($book->isLogging) { // Only used in case we need to debug EPub.php.
						$epuplog = $book->getLog();
						//$book->addChapter("ePubLog", "ePubLog.html", $content_start . $epuplog . "\n</pre>" . $bookEnd);
					}

                    $xml_content =
                    "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n"
                    . "<display_options>\n"
                    . " <platform name=\"*\">\n"
                    . "     <option name=\"fixed-layout\">false</option>\n"
                    . "     <option name=\"open-to-spread\">false</option>\n"
                    . "     <option name=\"specified-fonts\">true</option>\n"
                    . " </platform>\n"
                    . " <platform name=\"iphone\">\n"
                    . "     <option name=\"orientation-lock\">none</option>\n"
                    . " </platform>\n"
                    . "</display_options>";

                    $book->addFileToMETAINF("com.apple.ibooks.display-options.xml",$xml_content);

					$book->finalize();

					$epub_name = $book->saveBook( $publication_name , MultiPublisher::$cachePath);
					

					//$epub_name = $book->saveBook( get_the_title( $_GET['post'] ) , MultiPublisher::$pluginPath.'book/');


					// à la fin on ajoute un document lié 
					// http://codex.wordpress.org/Function_Reference/wp_insert_attachment
					

					// $retour = new StdClass();
					// $retour->ok = 'ok';
					// echo json_encode($retour);

                }else{
                    MultiPublisher::$publicationType = "epub";
                }
            }else{
                MultiPublisher::$publicationType = "epub";
            }
        }



        // Add meta box
        /*function mp_add_box() {
            global $meta_box;
         
            foreach ($meta_box['pages'] as $page) {
                add_meta_box($meta_box['id'], $meta_box['title'], 'mp_show_box', $page, $meta_box['context'], $meta_box['priority']);
            }
        }*/

     

        /**
         * Adds the meta box container.
         */
        public function add_meta_box_edition() {
            add_meta_box(
                'mp_edition_metabox'
                ,__( 'Structure éditoriale et métadonnées', 'mp_textdomain' )
                ,array( $this, 'render_meta_box_edition_content' )
                ,'publication'
                ,'advanced'
                ,'high'
            );
        }

       

        /**
         * Save the meta when the post is saved.
         *
         * @param int $post_id The ID of the post being saved.
         */
        public function save( $post_id ) {
        
            /*
             * We need to verify this came from the our screen and with proper authorization,
             * because save_post can be triggered at other times.
             */

            // Check if our nonce is set.
            if ( ! isset( $_POST['mp_custom_box_nonce'] ) )
                return $post_id;

            $nonce = $_POST['mp_custom_box_nonce'];

            // Verify that the nonce is valid.
            if ( ! wp_verify_nonce( $nonce, 'mp_inner_custom_box' ) )
                return $post_id;

            // If this is an autosave, our form has not been submitted,
                    //     so we don't want to do anything.
            if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
                return $post_id;

            // Check the user's permissions.
            if ( 'page' == $_POST['post_type'] ) {

                if ( ! current_user_can( 'edit_page', $post_id ) )
                    return $post_id;
        
            } else {

                if ( ! current_user_can( 'edit_post', $post_id ) )
                    return $post_id;
            }

            /* OK, its safe for us to save the data now. */

            // $field_value;
            // $field_name;
            // $field_key;

            /*
            // Sanitize the user input.
            $ISBN               = sanitize_text_field( $_POST['ISBN_field'] );
            $langue             = sanitize_text_field( $_POST['langue_field'] );

            // Update the meta field.
            update_post_meta( $post_id, 'mp_ISBN_key', $ISBN );
            update_post_meta( $post_id, 'mp_langue_key', $langue );*/

            $this->check_field( $post_id, 'ISBN_field', 			'mp_ISBN_key');
            $this->check_field( $post_id, 'langue_field', 			'mp_langue_key');
            $this->check_field( $post_id, 'afficherParties_field', 	'mp_afficherParties_key');
            $this->check_field( $post_id, 'structure_field', 		'mp_structure_key');
            $this->check_field( $post_id, 'main_parent_id_field', 	'mp_main_parent_id_key');
            
        }

        /**
         * [check_field description]
         * @param  [type] $_post_id [description]
         * @param  [type] $_field   [description]
         * @param  [type] $_key     [description]
         * @return [type]           [description]
         */
        private function check_field($_post_id, $_field, $_key){

            if( !empty($_post_id) && !empty($_field) && !empty($_key) ){

                $_value  = !empty($_POST[ $_field ]) ? sanitize_text_field( $_POST[ $_field ] ) : '';
                $_old    = get_post_meta( $_post_id, $_key, true);
 
                if ($_value && $_value != $_old) {
                    update_post_meta( $_post_id, $_key, $_value );
                } elseif ('' == $_value && $_old) {
                    delete_post_meta( $_post_id, $_key, $_old);
                }
            }
        }


        /**
         * Render Meta Box content.
         *
         * @param WP_Post $post The post object.
         */
        public function render_meta_box_edition_content( $post ) {
        
            // Add an nonce field so we can check for it later.
            wp_nonce_field( 'mp_inner_custom_box', 'mp_custom_box_nonce' );

            // Use get_post_meta to retrieve an existing value from the database.
            $ISBN               = get_post_meta( $post->ID, 'mp_ISBN_key', true );
            $langue             = get_post_meta( $post->ID, 'mp_langue_key', true );
            $afficherParties    = get_post_meta( $post->ID, 'mp_afficherParties_key', true );
            $structure          = get_post_meta( $post->ID, 'mp_structure_key', true );
            $main_parent_id 	= get_post_meta( $post->ID, 'mp_main_parent_id_key', true );

            $structure_html     = $this->structure_to_html($structure);

            include( MultiPublisher::$pluginPath . 'inc/views/meta-edition.php' );
        }

        /**
         * [structure_to_html description]
         * @param  [type] $json_string [description]
         * @return [type]              [description]
         */
        public function structure_to_html($json_string){

            $structure_json = json_decode($json_string);

            if(count($structure_json) <= 0){
                $structure_json = array();
            }

            $html = '<div class="chapterlist sortEdition clearafter">';

            foreach($structure_json as $item){

                if($item->type == 'partie'){

                    $html.= '<div class="container-wrapper">';
                    $html.= '<h4>'. $item->name .'</h4>';
                    $html.= '<div class="partie sortEdition" id="'. $item->id .'">';
                    // $html.= '<div class="droppin"></div>';

                    foreach($item->chapters as $chapter){
                        $html.= '<div class="item chapter" id="'. $chapter->id .'">'. $chapter->name .'</div>';
                    }

                    $html.= '</div>';
                    $html.= '</div>'; 

                }else if($item->type == 'chapter'){
                    $chapter = $item;
                    $html.= '<div class="item chapter" id="'. $chapter->id .'">'. $chapter->name .'</div>';
                }

            }

            $html.= '</div>';

            return $html;

        }

        public static function mp_public(){
            return "super ça fonctionne";
        }
    }
}



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

if ( ! class_exists( 'mp_structure' ) ) {
    class mp_structure {

        protected static $instance;

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

    
            function mp_create_custom_posts() {
                
                // https://wordpress.org/support/topic/permalinks-404-with-custom-post-type/page/2
                register_post_type(
                    'publication',
                    array(
                        'labels'    => array (
                            'name'                  => __('Publications'),
                            'singular_name'         => __('Publication'),
                            'menu_name'             => __('Publications'),
                            'add_new'               => __('Add Publication'),
                            'add_new_item'          => __('Add New Publication'),
                            'edit'                  => __('Edit'),
                            'edit_item'             => __('Edit Publication'),
                            'new_item'              => __('New Publication'),
                            'view'                  => __('View Publication'),
                            'view_item'             => __('View Publication'),
                            'search_items'          => __('Search Publication'),
                            'not_found'             => __('No Publication Found'),
                            'not_found_in_trash'    => __('No Publication Found in Trash'),
                            'parent'                => __('Parent Publication'),
                        ),
                        //'label'             => __('Publications'),
                        //'singular_label'    => __('Publication'),
                        'public'            => true,
                        'show_ui'           => true,
                        'show_in_menu'      => 'multipublisher',
                        //'menu_icon'       => get_bloginfo('template_directory') .'/images/favicon.png',
                        'menu_icon'         => 'dashicons-media-spreadsheet',
                        'show_in_nav_menus' => true,
                        'capability_type'   => 'page',
                        'rewrite'           => array("slug" => "publication"),
                        'hierarchical'      => true,
                        'query_var'         => false,
                        'supports'          => array('title','editor','thumbnail','page-attributes'),
                        'menu_position'     => 20,
                        //'taxonomies'      => array('category'),
                    )
                );  

            }
            

            function create_mp_taxonomies(){                

                $labels_auteur = array(
                    'name'              => _x( 'Auteurs', 'taxonomy general name' ),
                    'singular_name'     => _x( 'Auteur',  'taxonomy singular name' ),
                    'search_items'      => __( 'Rechercher un auteur' ),
                    'all_items'         => __( 'Tous les auteurs' ),
                    'parent_item'       => null,
                    'parent_item_colon' => null,
                    //'show_ui'         => false,
                    'menu_name'         => __( 'Auteurs' )
                ); 
            
                register_taxonomy('auteur',array(/*'edition',*/'publication'),array(
                    'hierarchical'      => false,
                    'labels'            => $labels_auteur,
                    'show_ui'           => true,
                    'show_tagcloud'     => false,
                    'query_var'         => true,
                    'show_in_nav_menus' => false,
                    'show_admin_column' => true,
                    'rewrite'           => array( 'slug' => 'auteur' )
                ));

                $labels_sujet = array(
                    'name'              => _x( 'Sujets', 'taxonomy general name' ),
                    'singular_name'     => _x( 'Sujet',  'taxonomy singular name' ),
                    'search_items'      => __( 'Rechercher un sujet' ),
                    'all_items'         => __( 'Tous les sujets' ),
                    'parent_item'       => null,
                    'parent_item_colon' => null,
                    //'show_ui'         => false,
                    'menu_name'         => __( 'Sujets' )
                ); 
            
                register_taxonomy('sujet',array(/*'edition',*/'publication'),array(
                    'hierarchical'      => false,
                    'labels'            => $labels_sujet,
                    'show_ui'           => true,
                    'show_tagcloud'     => false,
                    'query_var'         => true,
                    'show_in_nav_menus' => false,
                    'show_admin_column' => true,
                    'rewrite'           => array( 'slug' => 'auteur' )
                ));
            }

            
            add_action( 'init', 'mp_create_custom_posts' );
            add_action( 'init', 'create_mp_taxonomies' );   

        }
    }
}


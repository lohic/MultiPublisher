<?php
/**
* Plugin Name: Multi Publisher
* Plugin URI: http://www.loichorellou.net/multi-publisher
* Description: Le plugin MultiPublisher permet de générer une publication web, epub ou pdf à partir d'un contenu géré en ligne.
* Version: 1.0
* Author: Loïc Horellou
* Author URI: http://www.loichorellou.net
* Licence: GPL2 ???
*/


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

require_once( dirname( __FILE__ ) . '/inc/mp.class.php' );

MultiPublisher::instance();

//register_activation_hook( __FILE__, array( 'TribeEvents', 'flushRewriteRules' ) );
//register_deactivation_hook( __FILE__, 'flush_rewrite_rules' );


 
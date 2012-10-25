<?php
if ( defined( 'OIK_RESPONSIVE_MENU_INCLUDED' ) ) return;
define( 'OIK_RESPONSIVE_MENU_INCLUDED', true );

/*
Plugin Name: oik responsive menu
Plugin URI: http://www.oik-plugins.com/oik-plugins/oik-responsive-menu
Description: Lazy responsive select menu using jQuery
Version: 0.02
Author: bobbingwide
Author URI: http://www.bobbingwide.com
License: GPL2

    Copyright 2011,2012 Bobbing Wide (email : herb@bobbingwide.com )

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License version 2,
    as published by the Free Software Foundation.

    You may NOT assume that you can use any other version of the GPL.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    The license for this software can likely be found here:
    http://www.gnu.org/licenses/gpl-2.0.html

*/

add_action( "oik_loaded", "oik_responsive_menu_init" );

function oik_responsive_menu_init() {
  add_action( "wp_footer", "oik_responsive_menu_wp_footer", 9 );
  add_action( "oik_admin_menu", "oik_responsive_menu_admin_menu" );
}

/**
 * Apply the responsiveMenu jQuery to the required navigation menu
 *
 * Note: Default processing for an Artisteer theme is to select the menu within .art-nav-outer and set the minimum window width to 640px
 */
function oik_responsive_menu_wp_footer() {
  $options = get_option( "oik_responsive_menu" );
  if ( !$options ) {
    oik_require( "admin/oik-responsive-menu.php", "oik-responsive-menu" );
    $options = oikrm_lazy_options();
  }
  wp_enqueue_script( 'oik-responsive-menu-js', plugin_dir_url( __FILE__) . "oik-responsive-menu.js" , array( 'jquery') );
  bw_jquery( $options['selector'], "responsiveMenu",  bw_jkv( $options ) );
}

/**
 * Set the plugin server
 */
function oik_responsive_menu_admin_menu() {
  oik_register_plugin_server( __FILE__ );
  
  oik_require( "admin/oik-responsive-menu.php", "oik-responsive-menu" );
  oikrm_lazy_admin_menu(); 
}

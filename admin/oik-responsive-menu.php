<?php // (C) Copyright Bobbing Wide 2012

/**
 * Set the default selectors for certain known themes
 *
 * Note: When the theme is twentytwelve we have to disable its own functionality. How can the js know this **?**
 */
function oikrm_default_selectors() { 
  $selectors = array();
  $selectors['twentytwelve'] = "nav div.nav-menu"; 
  $selectors['twentyeleven'] = "nav#access" ;    // We need to know the menu name to make this work properly
  $selectors['twentyten'] = "div.menu-header" ;
  return( $selectors );
}

/**
 * Set the default selector for an Artisteer theme
 * 
 */
function oikrm_artisteer_selector( $artisteer_version ) {
 if ( $artisteer_version == "na" ) {
   $selector = null;
 } else {
   $selector = ".art-nav-outer";
 }
 return( $selector );
}   
   
/**
 *  Return the default selector bassed on the currently active theme
 * @return string - selector, defaults to "nav" if not otherwise determined
 */ 
function oikrm_default_selector() {
  $child_theme = is_child_theme();
  if ( $child_theme ) {
    $theme = get_template();
  } else {
    $theme = bw_get_theme(); 
  }
  bw_trace2( $theme, "theme" );
  $selector = bw_array_get( oikrm_default_selectors(), $theme, null );
  if ( !$selector ) {
    $art_version = bw_get_option( 'art-version' );
    if ( $art_version ) {
      $selector = oikrm_artisteer_selector( $art_version );
    }  
  } 
  if ( !$selector ) {
    $selector = "nav";
  }  
  return( $selector );
} 

/**
 * Return the default minWidth, representing the pixel width of the window
 * @return integer 640 
 */
function oikrm_default_minwidth() {
  return( 640 );
}      

/**
 * Return the default options when they have not been set
 */
function oikrm_lazy_options() {
  $options = array();
  $options['selector'] = oikrm_default_selector();
  $options['minWidth'] = oikrm_default_minwidth();
  return( $options );
}

/**
 * Define oik-responsive-menu settings and page
 */
function oikrm_lazy_admin_menu() {
  register_setting( 'oik_responsive_menu_options', 'oik_responsive_menu', 'oik_plugins_validate' ); // No validation for oik-responsive_menu
  add_submenu_page( 'oik_menu', 'responsive_menu', "Responsive menu", 'manage_options', 'oik_responsive_menu', "oikrm_options_do_page" );
}

/**
 * responsive_menu admin page
 */
function oikrm_options_do_page() {
  oik_menu_header( "Responsive menu" );
  oik_box( NULL, NULL, "Responsive menu options", "oikrm_options" );
  oik_menu_footer();
  bw_flush();
}

/**
 * responsive_menu options
 *        
 */
function oikrm_options() {
  $option = 'oik_responsive_menu'; 
  $options = bw_form_start( $option, 'oik_responsive_menu_options' );
  $options['selector'] = bw_array_get_dcb( $options, "selector", null, "oikrm_default_selector" );
  $options['minWidth'] = bw_array_get_dcb( $options, "minWidth", null, "oikrm_default_minwidth" );
  
  bw_textfield_arr( $option, "menu selector", $options, 'selector', 50, null, "required " .kv("placeholder", oikrm_default_selector() ) );
  bw_textfield_arr( $option, "minimum width", $options, 'minWidth', 10, null, "required " . kv( "placeholder", oikrm_default_minwidth() ) );
//  bw_textfield_arr( $option, "thankyou text", $options, 'thankyou', 50, null, "required " . kv( "placeholder", oikrm_default_thankyou() ) ); 
  bw_tablerow( array( "", "<input type=\"submit\" name=\"ok\" value=\"Save changes\" class=\"button-primary\"/>") ); 
  etag( "table" ); 			
  etag( "form" );
  bw_flush();
} 

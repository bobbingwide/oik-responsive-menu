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
   $selector = ".art-nav";
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

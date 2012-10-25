/**
 * jQuery oik responsive menu
 * http://oik-plugins.com/
 *
 * (C) Copyright 2012, Bobbing Wide
 *
 * lazy responsive menu - 
 * When the window width reduces to a minimum width allowed for a normal menu then the items in the unordered list in the menu
 * are displayed as a select field instead of a fancily formatted menu.
 * 
 * This code is lazy; it does not build the select menu until the width reaches the defined minWidth
 * 
 * The minWidth parameter is the first width at which the menu gets converted. 
 * Set it to 640 for an iPhone
 *
 * Attach it to your navigation menu using:
 *
 * <script type="text/javascript">
 * jQuery(document).ready(function() { jQuery( ".art-nav" ).responsiveMenu( {minWidth : 640} ); });
 * </script>
 * 
 */
(function($){
  $.fn.responsiveMenu = function(options) {
  var defaults = {
      defaultText: 'Navigate to...',
      className: 'select-menu',
      subMenuClass: 'sub-menu',
      subMenuDash: '&ndash;', 
      minWidth: 640
		},
  settings = $.extend( defaults, options ),
  el = $(this),
  built = false;

  oikrm_chooseMenu();
  $(window).bind( 'resize', oikrm_chooseMenu );

  /* Convert any nested unordered lists within the selection (el) into a select list
  */
  function oikrm_createSelect() {
    el.find('ul').addClass(settings.subMenuClass);
    // Create base menu
    $('<select />',{ 'class' : settings.className }).insertAfter( el );

    // Create default option
    $('<option />', {"value" : '#', "text": settings.defaultText }).appendTo( '.' + settings.className );

    // Create select option from menu
    el.find('a').each(function() {
      var $this 	= $(this),
          optText	= '&nbsp;' + $this.text(),
          optSub	= $this.parents( '.' + settings.subMenuClass ),
          len     = optSub.length,
          dash;
      // if menu has sub menu
      if( $this.parents('ul').hasClass( settings.subMenuClass ) ) {
        dash = Array( len+1 ).join( settings.subMenuDash );
        optText = dash + optText;
      }
      // Now build menu and append it
      $('<option />', { "value": this.href, "html"	: optText, "selected" : (this.href == window.location.href) }).appendTo( '.' + settings.className );
    }); // End el.find('a').each

    // Change event on select element
    $('.' + settings.className).change(function(){
      var locations = $(this).val();
      if( locations !== '#' ) {
        window.location.href = $(this).val();
      }
    });
  }

  /* Determine which menu to display depending on the width of the window
  */
  function oikrm_chooseMenu() {
     var width = $(window).width();
     if ( width <= settings.minWidth ) {
       if ( false == built ) {
         oikrm_createSelect();
         built = true;
       }
       // alert( el.width() );
       $( "select."+ settings.className ).css( "width", width ).css( "max-width", "100%" ).show();
       el.hide();
       $( "h3.menu-toggle" ).hide();  // For Twenty Twelve theme
     } else {
       $( "select." + settings.className ).hide();
       el.show();
     }
   }

};
})(jQuery);

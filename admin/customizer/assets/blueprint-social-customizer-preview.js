/**
 * Blueprint Social Customizer Preview
 *
 * @package Blueprint Social
 * @since   1.0.0
 *
 */

( function( $ ) {

    var $background;
    var $color;
  
    
    // Preview the MBT Button Background Color
    wp.customize( 'blueprint_social_display[background]', function( value ) {
      value.bind( function( newval ) {
       $background = newval;
        $( 'ul.blueprint-social li a' ).css({
          'background-color' : newval
          
           });
      } );
    } );
  
    // Preview the MBT Button Text Color
    wp.customize( 'blueprint_social_display[color]', function( value ) {
      value.bind( function( newval ) {
        $color = newval;
        $( 'ul.blueprint-social li a' ).css({
          'color' : newval
           });
      } );
    } );
  
    //Hover?
    wp.customize( 'blueprint_social_display[hover_background]', function( value ) {
      value.bind( function( newval ) {
        $( 'ul.blueprint-social li a' ).hover(function() {
          $(this).css({
          'background-color' : newval
           });
          }, function() {
          $(this).css({
          'background-color' : $background
           });
        });
      } );
    } );
  
    // Preview the MBT Button Text Color
    wp.customize( 'blueprint_social_display[hover_color]', function( value ) {
      value.bind( function( newval ) {
        $( 'ul.blueprint-social li a' ).hover(function() { 
          $(this).css({
            'color' : newval
             });
        }, function() {
          $(this).css({
            'color' : $color
             });
  
          });
        } );
    } );
  
   
    // Preview the MBT Button Border Radius
    wp.customize( 'blueprint_social_display[border_radius]', function( value ) {
      value.bind( function( newval ) {
        $( 'ul.blueprint-social li a' ).css({
          'border-radius' : newval + 'px'
           });
      } );
    } );
  
    //socialfriendsy_color_grayscale_button
    wp.customize( 'blueprint_social_display[grayscale]', function( value ) {
      value.bind( function( newval ) {
        
        if (newval === true) {
          $( 'ul.blueprint-social li a' ).css({
            '-webkit-filter' : 'grayscale(100%)',
            'filter' : 'grayscale(100%)'
           });
          $( 'ul.blueprint-social li a' ).hover(function() {
            $(this).css({
            '-webkit-filter' : 'grayscale(0%)',
            'filter' : 'grayscale(0%)'
             });
            }, function() {
            $(this).css({
            '-webkit-filter' : 'grayscale(100%)',
            'filter' : 'grayscale(100%)'
             });
          });
        } else {
          $( 'ul.blueprint-social li a' ).css({
            '-webkit-filter' : 'grayscale(0%)',
            'filter' : 'grayscale(0%)'
           });
  
        }
      } );
    } );
  
  
  } )( jQuery );
  
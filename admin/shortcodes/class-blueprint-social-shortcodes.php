<?php

/**
 * Main Link Shortcode
 *
 * @link       https://memphismckay.com
 * @since      1.0.0
 *
 * @package    Blueprint_Social
 * @subpackage Blueprint_Social/admin
 */


class Blueprint_Social_Shortcodes {


    /**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */


    public function __construct( $plugin_name, $version ) {

        $this->plugin_name = $plugin_name;
        $this->version = $version;
        
        add_shortcode('blueprint_social', array($this, 'define_display_shortcode'));
        add_shortcode('socialfriendsy_links', array($this, 'define_display_shortcode'));
    }
     
    function define_display_shortcode( $atts , $content = null ) {
		/**
		 * SHORTCODE
		 *
		 * 1) Template Use:
		 * if ( shortcode_exists( 'blueprint_social' ) ) {
		 *    // The [blueprint_social] short code exists. 
		 *    echo do_shortcode( '[blueprint_social]' ); }
		 *
		 * 2) Shortcode Attributes:
		 *  - align (justify content - center, start, end etc)
		 *  - wrap (outer container for social navigation, defaults to div)
		 *  - class (outer container class, defaults to 'blueprint-social-wrap')
		 *  - id (outer container id, defaults to 'sf-' - useful to add
		 *  - direction (flex-direction)
		 * specific tag if using)
		 */

		// Attributes
		extract( shortcode_atts(
			array(
			'align' => 'none',
			'wrap' => 'nav', 
			'class' => '',
			'id'  => 'main',
			'direction' => 'row',
			'flexwrap' => 'wrap',
			'float' => 'none',
			'size' => 'normal',
			), $atts )
		);

		$bps_class = esc_attr( $class );
		$bps_class .= esc_attr( ' align-' . $align );
		$bps_class .= esc_attr( ' flex-' . $direction );
		$bps_class .= esc_attr( ' wrap-' . $flexwrap );
		$bps_class .= esc_attr( ' align' . $float );
		$bps_class .= esc_attr( ' size-' . $size );

		
		$bps_id = esc_attr( $id );
		$bps_wrap = strip_tags( $wrap );

		$templates = new Blueprint_Social_Template_Loader;
		
		ob_start();
		$templates->get_template_part( 'blueprint_social','links' );
		
		return '<' . $bps_wrap . ' class="blueprint-social-wrap ' . $bps_class . '" id="bps-' . $bps_id . '">' . ob_get_clean() . '</' . $bps_wrap . '>';
		
      }
}
 


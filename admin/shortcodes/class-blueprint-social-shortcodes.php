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
		 *  - align (justify content - center, start, end )
		 *  - wrap (outer container for social navigation, defaults to div)
		 *  - class (outer container class, defaults to 'blueprint-social-wrap')
		 *  - id (outer container id, defaults to '-' - useful to add
		 *  - direction (flex-direction)
		 *  - size: small(30px), default(40px) large(60px), mini(20px)
		 *
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
			'include' => '',
			'exclude' => '',
			), $atts )
		);

		$bps_class = esc_attr( $class );
		$bps_class .= esc_attr( ' justify-' . $align );
		$bps_class .= esc_attr( ' flex-' . $direction );
		$bps_class .= esc_attr( ' wrap-' . $flexwrap );
		$bps_class .= esc_attr( ' align' . $float );
		$bps_class .= esc_attr( ' size-' . $size );


		$bps_id = esc_attr( $id );
		$bps_wrap = strip_tags( $wrap );


		ob_start();
		Blueprint_Social_Public::get_display_links( $include, $exclude );
		$links = ob_get_contents();
      	ob_end_clean();

		$markup =  sprintf(
			'<%1$s class="blueprint-social-wrap %2$s" id="bps-%3$s">%4$s</%1$s>',
			strip_tags( $bps_wrap ),
			esc_attr( $bps_class ),
			esc_attr( $bps_id ),
			wp_kses_post( $links )
		);

		$markup = apply_filters( 'mmkbp_blueprint_social_shortcode_markup', $markup );
		return $markup;

      }
}

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
	 * Defaults atts for shortcode
	 *
	 * @var array defaults
	 */
	private $defaults;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string $plugin_name       The name of this plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

		add_shortcode( 'blueprint_social', array( $this, 'define_display_shortcode' ) );
		add_shortcode( 'socialfriendsy_links', array( $this, 'define_display_shortcode' ) );

		$defaults = array(
			'align'     => 'none',
			'wrap'      => 'nav',
			'class'     => '',
			'id'        => 'main',
			'direction' => 'row',
			'flexwrap'  => 'wrap',
			'float'     => 'none',
			'size'      => 'normal',
			'include'   => '',
			'exclude'   => '',
		);

		$this->defaults = $defaults;
	}

	/**
	 * Format shortcode output.
	 *
	 * @method define_display_shortcode
	 * @param  array $atts attributes.
	 * @param  mixed $content content.
	 * @return mixed $markup shortcode markup
	 */
	public function define_display_shortcode( $atts, $content = null ) {
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
		 */

		/* Attributes */
		$defaults = $this->defaults;
		$atts     = wp_parse_args( $atts, $defaults );

		$class = $this->define_shortcode_wrap_class( $atts );
		$links = Blueprint_Social_Public::get_display_links( $atts['include'], $atts['exclude'], false );

		$markup = sprintf(
			'<%1$s class="blueprint-social-wrap %2$s" id="bps-%3$s">%4$s</%1$s>',
			wp_strip_all_tags( $atts['wrap'] ),
			esc_attr( $class ),
			esc_attr( $atts['id'] ),
			wp_kses_post( $links )
		);

		$markup = apply_filters( 'mmkbp_blueprint_social_shortcode_markup', $markup );
		return $markup;
	}

	/**
	 * Format the class from the specified args
	 *
	 * @method define_shortcode_wrap_class
	 * @param  array $args shortcode args.
	 * @return string class
	 */
	public function define_shortcode_wrap_class( $args ) {

		if ( ! empty( $args['class'] ) ) {
			$classes[] = esc_attr( $args['class'] );
		}
		if ( ! empty( $args['align'] ) ) {
			$classes[] = esc_attr( 'justify-' . $args['align'] );
		}
		if ( ! empty( $args['direction'] ) ) {
			$classes[] = esc_attr( 'flex-' . $args['direction'] );
		}
		if ( ! empty( $args['flexwrap'] ) ) {
			$classes[] = esc_attr( 'wrap-' . $args['flexwrap'] );
		}
		if ( ! empty( $args['float'] ) ) {
			$classes[] = esc_attr( 'align' . $args['float'] );
		}
		if ( ! empty( $args['size'] ) ) {
			$classes[] = esc_attr( 'size-' . $args['size'] );
		}

		$class = implode( ' ', $classes );

		return $class;
	}
}

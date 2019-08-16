<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://memphismckay.com
 * @since      1.0.0
 *
 * @package    Blueprint_Social
 * @subpackage Blueprint_Social/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Blueprint_Social
 * @subpackage Blueprint_Social/public
 * @author     Memphis McKay <support@memphismckay.com>
 */
class Blueprint_Social_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/blueprint-social-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/blueprint-social-public.js', array( 'jquery' ), $this->version, false );

	}

	public function custom_css() { 

		$defaults = array(
			'bg' => '#484848',
			'color' => '#ffffff',
			'hov_bg' => '#727272',
			'hov_color' =>  '#ffffff',
		);

		$defaults = apply_filters( 'mmkbp_social_color_defaults', $defaults );

		$blueprint_social = get_option('blueprint_social_display');
		
        $button_bg = isset($blueprint_social['color_button_background']) ? $blueprint_social['color_button_background'] : $defaults['bg'];
        $button_color = isset($blueprint_social['color_button_text_color']) ? $blueprint_social['color_button_text_color'] : $defaults['color'];
        $hover_bg = isset($blueprint_social['color_button_hover_background']) ? $blueprint_social['color_button_hover_background'] : $defaults['hov_bg'];
		$hover_color = $blueprint_social['color_button_hover_text_color'] ? $blueprint_social['color_button_hover_text_color'] : $defaults['hov_color'];
		
		$custom_css = isset($blueprint_social['color_custom_css']) ? $blueprint_social['color_custom_css'] : '';
		
		$grayscale = isset($blueprint_social['grayscale']) ? $blueprint_social['grayscale'] : false;
		
        $border_radius = isset($blueprint_social['border_radius']) ? $blueprint_social['border_radius'] : 0;

		$filter = '';
		$hover_filter = '';

			if( $grayscale == true ) {
				$filter = '-webkit-filter: grayscale(100%);filter: grayscale(100%);';
				$hover_filter = '-webkit-filter: grayscale(0%); filter: grayscale(0%);';
			}

			$style = sprintf( 
				'<style type="text/css">
					ul.blueprint-social li a {
						background-color: %1$s;
						color:%2$s;
						border-radius: %3$spx; 
						%4$s
					} 
					ul.blueprint-social li a:hover, 
					ul.blueprint-social li:hover a {
						background-color:%5$s;
						color:%6$s;
						%7$s
					} 
					%8$s
				</style>',
					sanitize_hex_color( $button_bg ),
					sanitize_hex_color( $button_color ),
					intval($border_radius),
					$filter,
					sanitize_hex_color( $hover_bg ),
					sanitize_hex_color( $hover_color ),
					$hover_filter,
					stripslashes( wp_kses_post( $custom_css ) )
				);
			
		echo $style;
		}
				
}





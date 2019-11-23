<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://memphismckay.com
 * @since      1.0.0
 *
 * @package    Blueprint_Social
 * @subpackage Blueprint_Social/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Blueprint_Social
 * @subpackage Blueprint_Social/admin
 * @author     Memphis McKay <support@memphismckay.com>
 */
class Blueprint_Social_Admin {

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
	 * @param      string $plugin_name       The name of this plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Blueprint_Social_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Blueprint_Social_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, BLUEPRINT_SOCIAL_PLUGIN_DIR . 'public/css/blueprint-social-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Blueprint_Social_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Blueprint_Social_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		// wp_enqueue_script( 'jquery-ui-sortable' );

		// wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/blueprint-social-admin.js', array( 'jquery' ), $this->version, false );
	}

	public function add_rest_fields( $rest_fields ) {

		$social_links = get_option( 'blueprint_social', array() );
		$social_links = json_decode( $social_links, true );

		$social_display = get_option( 'blueprint_social_display', array() );

		$networks = Blueprint_Social_Networks::get_networks();

		$rest_fields['blueprint_social'] = array(
			'status'   => 'active',
			'links'    => $social_links,
			'display'  => $social_display,
			'networks' => $networks,
		);

		return $rest_fields;
	}

	public function register_widgets() {

		register_widget( 'Blueprint_Social_Widget' );
	}

	public function register_blocks() {

		wp_enqueue_script( 'wp-api' );

		// Register our block script with WordPress
		wp_register_script(
			'blueprint-social',
			BLUEPRINT_SOCIAL_PLUGIN_URL . 'admin/blocks/dist/blocks.build.js',
			array( 'wp-i18n', 'wp-element', 'wp-blocks', 'wp-components', 'wp-editor' )
		);

		// Register our block's base CSS
		wp_register_style(
			'blueprint-social-style',
			BLUEPRINT_SOCIAL_PLUGIN_URL . 'admin/blocks/dist/blocks.style.build.css',
			array()
		);

		// Register our block's editor-specific CSS
		wp_register_style(
			'blueprint-social-editor-style',
			BLUEPRINT_SOCIAL_PLUGIN_URL . 'admin/blocks/dist/blocks.editor.build.css',
			array( 'wp-edit-blocks' )
		);

		$blocks = array(
			array(
				'name' => 'social-links',
			// 'blueprint_blocks_dynamic_recent_posts_block',
			),
		);

		foreach ( $blocks as $block ) {
			$render_cb = '';

			if ( ! empty( $block['render_callback'] ) ) {
				$render_cb = $block['render_callback'];
			}
			// Enqueue the script in the editor
			register_block_type(
				'blueprint-social/' . $block['name'],
				array(
					'style'           => 'blueprint-social-style',
					'editor_script'   => 'blueprint-social',
					'editor_style'    => 'blueprint-social-editor-style',
					'render_callback' => $render_cb,
				)
			);
		}
	}

}

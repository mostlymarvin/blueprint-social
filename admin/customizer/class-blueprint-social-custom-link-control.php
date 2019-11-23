<?php
/**
 * Custom Customizer Settings
 *
 * @link       https://memphismckay.com
 * @since      1.0.0
 *
 * @package    Blueprint_Social
 * @subpackage Blueprint_Social/admin
 */

add_action( 'customize_register', 'blueprint_social_define_custom_controls' );

/**
 * Define custom control for our customizer.
 *
 * @method blueprint_define_custom_controls
 * @param mixed $wp_customize see WP_Customize_Control.
 */
function blueprint_social_define_custom_controls( $wp_customize ) {

	/**
	 * Add custom control for repeatable social link fields.
	 */
	class Blueprint_Social_Custom_Link_Control extends WP_Customize_Control {
		/**
		 * The type of control being rendered
		 *
		 * @var string $type.
		 */
		public $type = 'social_link_control';

		/**
		 * Constructor
		 *
		 * @method __construct
		 * @param  mixed  $manager see WP_Customize_Control.
		 * @param  string $id see WP_Customize_Control.
		 * @param  array  $args see WP_Customize_Control.
		 * @param  array  $options see WP_Customize_Control.
		 */
		public function __construct( $manager, $id, $args = array(), $options = array() ) {
			parent::__construct( $manager, $id, $args );
		}

		/**
		 * Scripts and styles to enqueue.
		 *
		 * @method enqueue
		 */
		public function enqueue() {

			wp_enqueue_script( 'jquery-ui-sortable' );

			wp_enqueue_script(
				'blueprint-social-customizer',
				plugin_dir_url( __FILE__ ) . 'assets/blueprint-social-customizer.js',
				array(
					'jquery',
					'jquery-ui-sortable',
					'customize-controls',
				),
				BLUEPRINT_SOCIAL_VERSION,
				true
			);

			wp_enqueue_style(
				'blueprint-social-customizer',
				plugin_dir_url( __FILE__ ) . 'assets/blueprint-social-customizer.css',
				array(),
				BLUEPRINT_SOCIAL_VERSION,
				'all'
			);
		}

		/**
		 * Render the control in the customizer
		 */
		public function render_content() {

			$saved_value = $this->get_saved_value();
			$link_input  = $this->get_link_input();
			$empty_input = $this->get_empty_link_input();

			?>
				<div class="drag_and_drop_control">

			<?php if ( ! empty( $this->label ) ) { ?>
						<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
					<?php } ?>

			<?php if ( ! empty( $this->description ) ) { ?>
						<span class="customize-control-description"><?php echo esc_html( $this->description ); ?></span>
					<?php } ?>

					<input type="hidden" id="<?php echo esc_attr( $this->id ); ?>" name="<?php echo esc_attr( $this->id ); ?>" value="<?php echo esc_attr( $this->value() ); ?>" class="customize-control-sortable-repeater" <?php $this->link(); ?> />
					<ul id="blueprint-social-list" class="sortable">

					<?php

					$allowed = array(
						'li'     => array(
							'class' => array(),
						),
						'span'   => array(
							'class' => array(),
						),
						'div'    => array(
							'class' => array(),
						),
						'input'  => array(
							'type'        => array(),
							'value'       => array(),
							'class'       => array(),
							'placeholder' => array(),
						),
						'select' => array(
							'id' => array(),
						),
						'option' => array(
							'value'    => array(),
							'selected' => array(),
						),
					);

					if ( $saved_value ) {
						echo wp_kses( $saved_value, $allowed );
					} else {
						echo wp_kses( $link_input, $allowed );
					}

						echo wp_kses( $empty_input, $allowed );

					?>

					</ul>
					<a id="add_link" class="button">Add Link</a>
					<a id="sort_links" class="button">Sort Links</a>
					<a id="save_sort" class="button">Save Sort Order</a>

							</div>

						</div>
					<?php
		}

		/**
		 * Format the link input field used in the sortable customizer.
		 *
		 * @method get_link_input
		 * @param  string $type default or empty.
		 * @param  array  $args array.
		 * @return mixed formatted link input
		 */
		public function get_link_input( $type = 'default', $args = array() ) {

			$defaults = array(
				'network'     => '',
				'description' => __( 'ie: http:// website.com', 'blueprint-social' ),
				'url'         => '',
			);

							$args        = wp_parse_args( $args, $defaults );
							$class       = 'ui-state-default repeater';
							$network     = $args['network'];
							$description = $args['description'];
							$url         = $args['url'];

			if ( 'empty' === $type ) {
				$class = 'empty-link repeater';
			}
			if ( 'email' === $args['network'] ) {
				$description = __( 'example: email@yourwebsite.com', 'blueprint-social' );
			}

							$markup = sprintf(
								'<li class="%1$s">
                <span class="dashicons dashicons-move sort_handle"></span>
                <div class="network-inputs">%2$s<input type="text" value="%3$s" class="network-url"/></div><div class="remove_link"><span class="dashicons dashicons-dismiss"></span></div></li>',
								esc_attr( $class ),
								$this->get_social_options( $this->id, $network ),
								$url
							);

			return $markup;
		}

		/**
		 * Shortcut to get empty link input field.
		 *
		 * @method get_empty_link_input
		 * @return [type] [description]
		 */
		public function get_empty_link_input() {
			$type = 'empty';
			return $this->get_link_input( $type );
		}

		/**
		 * Get saved link values
		 *
		 * @method get_saved_value
		 * @return [type] [description]
		 */
		public function get_saved_value() {
			$links = get_option( $this->id, false );
			$links = json_decode( $links, true );

			$markup = false;

			if ( $links ) {

				foreach ( $links as $link ) {

					$network     = $link['network'];
					$url         = $link['url'];
					$description = $link['description'];

					if ( $url && $network ) {

						if ( 'email' === $network ) {
							$url         = sanitize_email( $url );
							$description = 'email@yourwebsite.com';
						} else {
							$url = esc_url( $url );
						}

						$markup .= sprintf(
							'<li class="ui-state-default repeater">
								<span class="dashicons dashicons-move sort_handle"></span>
								<div class="network-inputs">%1$s<input type="text" value="%2$s" class="network-url"/></div>
								<div class="remove_link"><span class="dashicons dashicons-dismiss"></span></div></li>',
							$this->get_social_options( $this->id, $network ),
							$url,
							$network
						);
					}
				}
			}
			return $markup;

		}

		/**
		 * Get the social link <options> for the repeatable select field
		 *
		 * @method get_social_options
		 * @param  string $id option id.
		 * @param  string $value option value.
		 * @return html markup
		 */
		public function get_social_options( $id, $value = '' ) {

			$networks = Blueprint_Social_Networks::get_networks();
			$options  = '';

			foreach ( $networks as $network ) {

				$selected = '';

				if ( $value === $network['tag'] ) {
					$selected = "selected='selected'";
				}

				$options .= sprintf(
					'<option value="%1$s" %3$s>%2$s</option>',
					$network['tag'],
					$network['name'],
					$selected
				);
			}

			$markup = sprintf(
				'<select id="%2$s[][network-select]"><option>Choose Network</option>%1$s</select><input type="hidden" value="%3$s" class="network-choice"/>',
				$options,
				$id,
				$value
			);

			return $markup;

		}
	}
}

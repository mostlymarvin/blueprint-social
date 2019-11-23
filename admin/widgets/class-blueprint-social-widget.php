<?php
/**
 * Social Widget
 *
 * @package Blueprint_Social
 */

/**
 * Creates Social Icon widget for use in sidebars and other
 * widgetized areas.
 */
class Blueprint_Social_Widget extends WP_Widget {

	/**
	 * Widget defaults
	 *
	 * @var array defaults
	 */
	private $defaults;

	/**
	 * Acceptable flex-align options
	 *
	 * @var array alignments
	 */
	private $alignments;


	/**
	 * Social Links
	 *
	 * @var mixed links
	 */
	private $social_links;

	/**
	 * Style Preferences
	 *
	 * @var array css prefs
	 */
	private $global_css;

	/**
	 * Default CSS Prefs
	 *
	 * @var array default css
	 */
	private $default_css;

	/**
	 * Construct Widget
	 *
	 * @method __construct
	 */
	public function __construct() {

		parent::__construct(
			'blueprint_social_widget',
			__( 'Blueprint Social Icons', 'blueprint-social' ),
			array(
				'classname'   => 'blueprint_social_widget',
				'description' => __( 'Displays social media links as icons.', 'blueprint-social' ),
			)
		);

		$defaults = array(
			'align'         => 'none',
			'wrap'          => 'div',
			'class'         => '',
			'id'            => '',
			'size'          => 'default',
			'flexwrap'      => 'wrap',
			'direction'     => 'row',
			'float'         => 'none',
			'checked_links' => array(),
			'exclude'       => '',
			'include'       => '',
		);

		$default_css = array(
			'background'       => '#484848',
			'color'            => '#ffffff',
			'hover_background' => '#727272',
			'hover_color'      => '#ffffff',
			'border_radius'    => '0',
			'grayscale'        => 'no',
		);

		$alignments   = array( 'none', 'start', 'end', 'center' );
		$links        = get_option( 'blueprint_social_links' );
		$links        = json_decode( $links, true );
		$css_settings = get_option( 'blueprint_social_display' );

		$this->defaults     = $defaults;
		$this->alignments   = $alignments;
		$this->social_links = $links;
		$this->default_css  = wp_parse_args( $css_settings, $default_css );
		$this->global_css   = $css_settings;
	}

	/**
	 * Enqueue scripts.
	 *
	 * @since 1.0
	 *
	 * @param string $hook_suffix make sure we are only enqueuing if editing widgets.
	 */
	public function enqueue_scripts( $hook_suffix ) {

		if ( 'widgets.php' !== $hook_suffix ) {
			return;
		}

		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'wp-color-picker' );
		wp_enqueue_script( 'underscore' );
	}

	/**
	 * Print scripts (initialize color pickers).
	 *
	 * @since 1.0
	 */
	public function print_scripts() {
		?>
		<script>
			( function( $ ){
				function initColorPicker( widget ) {
					widget.find( '.bps-color-picker' ).wpColorPicker( {
						change: _.throttle( function() { // For Customizer
							$(this).trigger( 'change' );
						}, 3000 )
					});
				}

				function onFormUpdate( event, widget ) {
					initColorPicker( widget );
				}

				$( document ).on( 'widget-added widget-updated', onFormUpdate );

				$( document ).ready( function() {
					$( '.widget:has(.bps-color-picker)' ).each( function () {
						initColorPicker( $( this ) );
					} );
					$( '.bps-color-picker' ).each( function() {
						initColorPicker( $( this ) );
					});
				} );
			}( jQuery ) );
		</script>
		<?php
	}
	/**
	 * Display Widget
	 *
	 * @method widget
	 * @param  array $args widget args.
	 * @param  mixed $instance widget instance.
	 */
	public function widget( $args, $instance ) {

		$instance    = wp_parse_args( $instance, $this->defaults );
		$instance_id = $this->get_instance_id( 10 );

		if ( ! empty( $instance['checked_links'] ) ) {
			$exclude = implode( ',', $instance['checked_links'] );
		}

		/* User-selected settings. */
		$title = isset( $instance['title'] ) ? apply_filters( 'widget_title', $instance['title'] ) : '';

		/* phpcs:ignore */
		echo $args['before_widget'];

		if ( $title ) {
			/* phpcs:ignore */
			echo $args['before_title'] . wp_kses_post( $title ) . $args['after_title'];
		}

		$links     = Blueprint_Social_Public::get_display_links( false, $exclude, false );
		$class     = Blueprint_Social_Shortcodes::define_shortcode_wrap_class( $instance );
		$class    .= ' bps-' . $instance_id;
		$widget_id = ! empty( $instance['id'] ) ? 'id="bps-' . esc_attr( $instance['id'] ) . '"' : '';
		$grayscale = ! empty( $instance['grayscale'] ) ? 'yes' : 'no';

		if ( 'yes' === $grayscale ) {
			$filter       = '-webkit-filter: grayscale(100%);filter: grayscale(100%);';
			$hover_filter = '-webkit-filter: grayscale(0%); filter: grayscale(0%);';
		}

		/* Instance-specific styles to override globals and defaults */
		$style = printf(
			'<style type="text/css" id="bps-%6$s">
				.bps-%6$s ul.blueprint-social li a {
					background-color: %1$s;
					color:%2$s;
					border-radius: %3$s%7$s;
					%8$s
				}
				.bps-%6$s ul.blueprint-social li a:hover,
				.bps-%6$s ul.blueprint-social li:hover a {
					background-color:%4$s;
					color:%5$s;
					%9$s
				}
			</style>',
			esc_html( $instance['background'] ),
			esc_html( $instance['color'] ),
			intval( $instance['border_radius'] ),
			esc_html( $instance['hover_background'] ),
			esc_html( $instance['hover_color'] ),
			esc_attr( $instance_id ),
			esc_html( $instance['radius_unit'] ),
			esc_html( $filter ),
			esc_html( $hover_filter )
		);

		/* Formatted icon list markup */
		$markup = printf(
			'<div class="blueprint-social-wrap %1$s" %2$s> %3$s </div>',
			esc_attr( $class ),
			esc_html( $widget_id ),
			wp_kses_post( $links ),
		);

		/* phpcs:ignore */
		echo $after_widget;
	}

	/**
	 * Update Widget
	 *
	 * @method update
	 * @param  object $new_instance widget instance.
	 * @param  object $old_instance widget instance.
	 * @return object $instance
	 */
	public function update( $new_instance, $old_instance ) {

		$instance = $old_instance;

		/* Icon Settings */
		$instance['align']         = in_array( $new_instance['align'], $this->alignments, true ) ? $new_instance['align'] : 'none';
		$instance['checked_links'] = array_map( 'wp_strip_all_tags', $new_instance['checked_links'] );
		$instance['class']         = esc_attr( $new_instance['class'] );
		$instance['id']            = esc_attr( $new_instance['id'] );
		$instance['size']          = esc_attr( $new_instance['size'] );
		$instance['title']         = wp_strip_all_tags( $new_instance['title'] );

		/* CSS */
		$instance['background']       = sanitize_hex_color( $new_instance['background'] );
		$instance['border_radius']    = intval( $new_instance['border_radius'] );
		$instance['color']            = sanitize_hex_color( $new_instance['color'] );
		$instance['grayscale']        = ! empty( $new_instance['grayscale'] ) ? 'yes' : 'no';
		$instance['hover_background'] = sanitize_hex_color( $new_instance['hover_background'] );
		$instance['hover_color']      = sanitize_hex_color( $new_instance['hover_color'] );
		$instance['radius_unit']      = 'px' === $new_instance['radius_unit'] ? 'px' : '%';

		return $instance;
	}

	/**
	 * Format Widget Form
	 *
	 * @method form
	 * @param  object $instance widget instance.
	 */
	public function form( $instance ) {

		/* Set up default widget settings. */
		$defaults          = $this->defaults;
		$defaults['title'] = '';

		/* merge $instance attributes with defaults */
		$instance = wp_parse_args( $instance, $defaults );

		/* $instance values */
		$align = in_array( $instance['align'], $this->alignments, true ) ? $instance['align'] : 'none';

		$checked_links = array();
		if ( ! empty( $instance['checked_links'] ) && is_array( $instance['checked_links'] ) ) {
			$checked_links = array_map( 'wp_strip_all_tags', $instance['checked_links'] );
		}

		$class        = $instance['class'];
		$id           = $instance['id'];
		$instructions = __( 'Fill in your Social Media URLs in Social Media Settings via the Customizer and place this widget into your sidebar to display social media icons. Social Media links that are left blank will not be displayed.', 'blueprint-social' );
		$link_toggles = '';
		$social_links = $this->social_links;

		$background       = isset( $instance['background'] ) ? $instance['background'] : $this->default_css['background'];
		$color            = isset( $instance['color'] ) ? $instance['color'] : $this->default_css['color'];
		$hover_background = isset( $instance['hover_background'] ) ? $instance['hover_background'] : $this->default_css['hover_background'];
		$hover_color      = isset( $instance['hover_color'] ) ? $instance['hover_color'] : $this->default_css['hover_color'];

		/* Social links, formatted for toggle section, below */
		if ( ! empty( $social_links && is_array( $social_links ) ) ) :

			foreach ( $social_links as $link ) {
				$network = $link['network'];
				$url     = $link['url'];

				if ( ! empty( $url ) ) {
					$link_toggles .= sprintf(
						'<label>
							<input type="checkbox" value="%3$s" name="%1$s" %2$s/>
							%3$s
					</label><br />',
						$this->get_field_name( 'checked_links[]' ),
						in_array( $network, $checked_links, true ) ? 'checked' : '',
						wp_strip_all_tags( $network )
					);
				}
			}

		endif;

		$fields = array();

		/* Widget instructions */
		$fields[] = sprintf(
			'<p>%1$s</p>',
			$instructions
		);

		/* Title */
		$fields[] = sprintf(
			'<p>
				<label for="%1$s">%2$s</label><br />
				<input class="widefat" type="text" id="%1$s" name="%3$s" value="%4$s"  />
			</p>',
			$this->get_field_id( 'title' ),
			__( 'Title:', 'blueprint-social' ),
			$this->get_field_name( 'title' ),
			wp_strip_all_tags( $instance['title'] )
		);

		/* Flex alignment of icon ul */
		$fields[] = sprintf(
			'<p>
				<label for="%1$s">%2$s</label><br />
				<select class="widefat" type="text" id="%1$s" name="%3$s">
					<option %5$s value="center">center</option>
					<option %6$s value="start">left</option>
					<option %7$s value="end">right</option>
					<option %4$s value="none">none</option>
				</select>
			</p>',
			$this->get_field_id( 'align' ),
			__( 'Icon alignment', 'blueprint-social' ),
			$this->get_field_name( 'align' ),
			'none' === $instance['align'] ? 'selected' : '',
			'center' === $instance['align'] ? 'selected' : '',
			'start' === $instance['align'] ? 'selected' : '',
			'end' === $instance['align'] ? 'selected' : ''
		);

		/* Widget CSS class */
		$fields[] = sprintf(
			'<p>
				<label for="%1$s">%2$s</label><br />
				<input class="widefat" type="text" id="%1$s" name="%3$s" value="%4$s"  />
			</p>',
			$this->get_field_id( 'class' ),
			__( 'CSS Class (space separated list of classes):', 'blueprint-social' ),
			$this->get_field_name( 'class' ),
			esc_attr( $instance['class'] )
		);

		/* Widget CSS id */
		$fields[] = sprintf(
			'<p>
				<label for="%1$s">%2$s</label><br />
				<input class="widefat" type="text" id="%1$s" name="%3$s" value="%4$s"  />
			</p>',
			$this->get_field_id( 'id' ),
			__( 'CSS ID:', 'blueprint-social' ),
			$this->get_field_name( 'id' ),
			esc_attr( $instance['id'] ),
		);

		/* Icon size */
		$fields[] = sprintf(
			'<p>
				<label for="%1$s">%2$s</label><br />
				<select class="widefat" type="text" id="%1$s" name="%3$s">
					<option %4$s>default</option>
					<option %5$s>mini</option>
					<option %6$s>small</option>
					<option %7$s>large</option>
				</select>
			</p>',
			$this->get_field_id( 'size' ),
			__( 'Icon size', 'blueprint-social' ),
			$this->get_field_name( 'size' ),
			'default' === $instance['size'] ? 'selected' : '',
			'mini' === $instance['size'] ? 'selected' : '',
			'small' === $instance['size'] ? 'selected' : '',
			'large' === $instance['size'] ? 'selected' : ''
		);

		/**
		 * Checkboxes to hide specific links.
		 * If there are no links created, a prompt will
		 * display instead, with a link to the customizer.
		 */
		if ( ! empty( $social_links ) ) {
			$fields[] = sprintf(
				'<p>%1$s <br /> %2$s</p>',
				__( 'Select Icons to Exclude:', 'blueprint-social' ),
				$link_toggles
			);

		} else {
			$fields[] = sprintf(
				'<p><a href="%1$s">%2$s</a></p>',
				admin_url( '/customize.php?autofocus[section]=blueprint_social_settings_section' ),
				__( 'Click here to add your social media links.' )
			);
		}

		/**
		 * Background - color picker field
		 *
		 * @var mixed background color field
		 */
		$fields[] = sprintf(
			'<h4>Icon Colors:</h4>
			<p>
				<label for="%1$s">%2$s:</label> <br />
				<input class="bps-color-picker" type="text" id="%1$s" name="%3$s" value="%4$s" data-default-color="%5$s"/>
			</p>',
			$this->get_field_id( 'background' ),
			__( 'Background color', 'blueprint-social' ),
			$this->get_field_name( 'background' ),
			sanitize_hex_color( $background ),
			sanitize_hex_color( $this->default_css['background'] )
		);

		/**
		 * Background hover - color picker field
		 *
		 * @var mixed background hover color field
		 */
		$fields[] = sprintf(
			'<p>
				<label for="%1$s">%2$s:</label> <br />
				<input class="bps-color-picker" type="text" id="%1$s" name="%3$s" value="%4$s" data-default-color="%5$s"/>
			</p>',
			$this->get_field_id( 'hover_background' ),
			__( 'Background color (hover)', 'blueprint-social' ),
			$this->get_field_name( 'hover_background' ),
			sanitize_hex_color( $hover_background ),
			sanitize_hex_color( $this->default_css['hover_background'] )
		);

		/**
		 * Icon Color - color picker field
		 *
		 * @var mixed icon color - color field
		 */
		$fields[] = sprintf(
			'<p>
				<label for="%1$s">%2$s:</label> <br />
				<input class="bps-color-picker" type="text" id="%1$s" name="%3$s" value="%4$s" data-default-color="%5$s"/>
			</p>',
			$this->get_field_id( 'color' ),
			__( 'Color', 'blueprint-social' ),
			$this->get_field_name( 'color' ),
			sanitize_hex_color( $color ),
			sanitize_hex_color( $this->default_css['color'] )
		);

		/**
		 * Hover icon color - color picker field
		 *
		 * @var mixed hover icon color - color field
		 */
		$fields[] = sprintf(
			'<p>
				<label for="%1$s">%2$s:</label> <br />
				<input class="bps-color-picker" type="text" id="%1$s" name="%3$s" value="%4$s" data-default-color="%5$s"/>
			</p>',
			$this->get_field_id( 'hover_color' ),
			__( 'Color (hover)', 'blueprint-social' ),
			$this->get_field_name( 'hover_color' ),
			sanitize_hex_color( $hover_color ),
			sanitize_hex_color( $this->default_css['hover_color'] )
		);

		/* Border radius number picker and choice of % or px for border_radius units */
		$fields[] = sprintf(
			'<p>
			<label for="%1$s">%3$s:</label> <br />
			<div style="display:flex; align-items:flex-end;"><input type="number" name="%2$s" min="0" max="100" step="1" value="%4$s" id="%1$s">
			<select style="width:max-content; margin-left:6px;" class="widefat" type="text" id="%5$s" name="%6$s">
				<option %7$s>px</option>
				<option %8$s>&percnt;</option>
			</select></div>
			</p>',
			$this->get_field_id( 'border_radius' ),
			$this->get_field_name( 'border_radius' ),
			__( 'Border radius', 'blueprint-social' ),
			isset( $instance['border_radius'] ) ? intval( $instance['border_radius'] ) : '0',
			$this->get_field_id( 'radius_unit' ),
			$this->get_field_name( 'radius_unit' ),
			'px' === $instance['radius_unit'] ? 'selected' : '',
			'%' === $instance['radius_unit'] ? 'selected' : '',
		);

		/* Checkbox to enable grayscale filter */
		$fields[] = sprintf(
			'<p><label>
				<input type="checkbox" value="yes" id="%4$s" name="%1$s" checked( "yes", %2$s ) />
				%3$s
				</label></p>
				',
			$this->get_field_name( 'grayscale' ),
			$instance['grayscale'],
			__( 'Make Grayscale until hover?', 'blueprint-social' ),
			$this->get_field_id( 'grayscale' ),
		);

		/* Output the fields */
		foreach ( $fields as $field ) {
			/* phpcs:ignore */
			echo $field;
		}
	}

	/**
	 * Create instance specific id to enable unique styling
	 *
	 * @method get_instance_id
	 * @param  number $n number of characters.
	 * @return string random string
	 */
	public function get_instance_id( $n ) {

		$characters  = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$instance_id = '';

		for ( $i = 0; $i < $n; $i++ ) {
				$index        = wp_rand( 0, strlen( $characters ) - 1 );
				$instance_id .= $characters[ $index ];
		}

		return $instance_id;
	}
}

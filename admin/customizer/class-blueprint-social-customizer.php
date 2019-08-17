<?php

/**
 * Customizer Settings
 *
 * @link       https://memphismckay.com
 * @since      1.0.0
 *
 * @package    Blueprint_Social
 * @subpackage Blueprint_Social/admin
 */


class Blueprint_Social_Customizer {

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
    }

    function register_customizer($wp_customize) {

        $wp_customize->add_panel( 'blueprint_social_panel', array(
            'title' => 'Social Media Settings',
            'description' => '',
            'priority' => 1,
        ) );
    
        //social media
        $wp_customize->add_section( 'blueprint_social_settings_section', array(
          'title' => 'Social Media Accounts',
          'description' => 'Enter the full URLs to your social media profiles. Profiles entered will be displayed using the Blueprint Social Follow Widget or by using the shortcode "[blueprint_social]"',
          'priority' => 10,
           'panel' => 'blueprint_social_panel',
        ) );
    
        
    
            $wp_customize->add_setting( 'blueprint_social_links', array(
                'default'           => '',
                'type'              => 'option',
                'capability'        => 'manage_options',
                'transport'         => 'postMessage',
                'sanitize_callback' => array( $this, 'blueprint_social_sanitize_string'),
              ) );
      
              $wp_customize->add_control( 
                new Blueprint_Social_Custom_Link_Control( 
                   $wp_customize, 
                   'blueprint_social_links',
                   array(
                    'description' => '',
                    'label'      => 'Social Media Links',
                    'priority'   => 1,
                    'section'  => 'blueprint_social_settings_section',
                    'settings' =>  'blueprint_social_links',
                   )
                )
             );
    

             $wp_customize->selective_refresh->add_partial( 
               'blueprint_social_links',
                array(
                    'selector' => 'ul.blueprint-social',
                    'container_inclusive' => false,
                    'render_callback' => function() {
                      $this->do_social_links();
                    },
                    'fallback_refresh' => true
                  )
              );
        
    }//end register


      function register_display_customizer( $wp_customize ) {
  
        //social media
           $wp_customize->add_section( 'blueprint_social_display_settings_section', array(
             'title' => 'Icon Customization',
             'description' => 'Customize the colors of the Blueprint Social icons, and (optionally) add custom CSS',
             'priority' => 20,
              'panel' => 'blueprint_social_panel',
           ) );
       
       
           //Custom CSS
           $wp_customize->add_setting('blueprint_social_display[custom_css]', array(
             'default'           => '',
             'type'              => 'option',
             'capability'        => 'manage_options',
             'transport'         => 'postMessage',
             'sanitize_callback' => 'strip_tags'
           ) );
               //Custom CSS Input
               $wp_customize->add_control( 'blueprint_social_display[custom_css]', array(
                 'label'      => __( 'Custom CSS', 'blueprint-social' ),
                 'section'  => 'blueprint_social_display_settings_section',
                 'settings' => 'blueprint_social_display[custom_css]',
                 'type'     => 'textarea',
                 'priority'   => 100
               ) );
       
           //Background Color 
           $wp_customize->add_setting('blueprint_social_display[background]', array(
             'default'           => '#484848',
             'type'              => 'option',
             'capability'        => 'manage_options',
             'transport'         => 'postMessage',
             'sanitize_callback' => 'sanitize_hex_color',
           ) );
               //Background Color Input
               $wp_customize->add_control( 
                 new WP_Customize_Color_Control( 
                   $wp_customize, 
                   'blueprint_social_display[background]', 
                   array(
                     'label'      => __( 'Icons background color', 'blueprint-social' ),
                     'section'    => 'blueprint_social_display_settings_section',
                     'settings'   => 'blueprint_social_display[background]',
                     'priority'   => 10
                     ) ) 
                 );
       
           //Text Color 
           $wp_customize->add_setting('blueprint_social_display[color]', array(
             'default'           => '#ffffff',
             'type'              => 'option',
             'capability'        => 'manage_options',
             'transport'         => 'postMessage',
             'sanitize_callback' => 'sanitize_hex_color',
           ) );
               //Background Color Input
               $wp_customize->add_control( 
                 new WP_Customize_Color_Control( 
                   $wp_customize, 
                   'blueprint_social_display[color]', 
                   array(
                     'label'      => __( 'Icon color', 'blueprint-social' ),
                     'section'    => 'blueprint_social_display_settings_section',
                     'settings'   => 'blueprint_social_display[color]',
                     'priority'   => 20
                     ) ) 
                 );
       
           //Hover State Background
           $wp_customize->add_setting('blueprint_social_display[hover_background]', array(
             'default'           => '#727272',
             'type'              => 'option',
             'capability'        => 'manage_options',
             'transport'         => 'postMessage',
             'sanitize_callback' => 'sanitize_hex_color',
           ) );
               //Hover State Background Color Input
               $wp_customize->add_control( 
                 new WP_Customize_Color_Control( 
                   $wp_customize, 
                   'blueprint_social_display[hover_background]', 
                   array(
                     'label'      => __( 'Icon background hover color', 'blueprint-social' ),
                     'section'    => 'blueprint_social_display_settings_section',
                     'settings'   => 'blueprint_social_display[hover_background]',
                     'priority'   => 30
                     ) ) 
                 );
       
           //Hover Text Color 
           $wp_customize->add_setting('blueprint_social_display[hover_color]', array(
             'default'           => '#ffffff',
             'type'              => 'option',
             'capability'        => 'manage_options',
             'transport'         => 'postMessage',
             'sanitize_callback' => 'sanitize_hex_color',
           ) );
               //Background Color Input
               $wp_customize->add_control( 
                 new WP_Customize_Color_Control( 
                   $wp_customize, 
                   'blueprint_social_display[hover_color]', 
                   array(
                     'label'      => __( 'Icon hover color', 'blueprint-social' ),
                     'section'    => 'blueprint_social_display_settings_section',
                     'settings'   => 'blueprint_social_display[hover_color]',
                     'priority'   => 40
                     ) ) 
                 );
       
           //Grayscale Option
           $wp_customize->add_setting( 'blueprint_social_display[grayscale]', array(
             'default'        => false,
             'type'           => 'option',
             'capability'     => 'manage_options',
             'sanitize_callback' => array( $this,'blueprint_social_display_sanitize_checkbox'),
             'transport'      => 'postMessage'
           ) );
           $wp_customize->add_control( 'blueprint_social_display[grayscale]', array(
             'label'    => __( 'Add grayscale filter?', 'blueprint-social' ),
             'description' => __( 'icons appear grayscale, until hovered over, when custom colors appear.'),
             'section'  => 'blueprint_social_display_settings_section',
             'settings' => 'blueprint_social_display[grayscale]',
             'type' => 'checkbox',
             'priority' => 60
           ) );
       
           //Border Radius
           $wp_customize->add_setting( 'blueprint_social_display[border_radius]', array(
             'default' => 0,
             'type' => 'option',
             'capability' => 'manage_options',
             'transport' => 'postMessage',
             'sanitize_callback' => array($this,'blueprint_social_display_sanitize_integer'),
           ) );
       
           $wp_customize->add_control( 'blueprint_social_display[border_radius]', array(
             'type' => 'range',
             'priority' => 50,
             'section' => 'blueprint_social_display_settings_section',
             'settings' => 'blueprint_social_display[border_radius]',
             'label' => __( 'Icon border-radius', 'blueprint-social' ),
             'description' => '',
             'input_attrs' => array(
                 'min' => 0,
                 'max' => 20,
                 'step' => 1,
             ),
           ) );
       
       }//end register
       
    public static function blueprint_social_display_sanitize_checkbox( $input ) {
          if ( $input == 1 ) {
               return 1;
           } else {
               return '';
           }
       }
       
    public static function blueprint_social_display_sanitize_integer( $input ) {
        return absint( $input );
    }
       
    public static function blueprint_social_display_sanitize_textarea( $text ) {
        $text = strip_tags($text);
        return wp_kses_post( $text );
    }
       
    public static function blueprint_social_sanitize_string($input) {
          return strip_tags( $input );
    }

    public function live_preview() {
       
      wp_enqueue_script( 'blueprint-social-customizer-preview', plugin_dir_url( __FILE__ ) . 'assets/blueprint-social-customizer-preview-min.js', array( 'jquery','customize-preview' ), $this->version,  true );
                
    }

    public function do_social_links() {
      $links = get_option('blueprint_social_links');
      $links = json_decode( $links, true );

      $list = '';

      if( $links ) {
                        
        foreach( $links as $link ) {
          $network = $link['network'];
          $url = $link['url'];
                    
            if( $network || $url ) {

              if( $network === 'email' ) {
                $url = sanitize_email( $link[1] );
              } else {
                $url = esc_url( $url );
              }

              $list .= sprintf(
                '<li><a href="%1$s" class="%2$s icon-%2$s" target="_blank"><span>%2$s</span></a></li>',
                $url,
                esc_attr( $network )
              );

            }
          }
        }

	      echo $list;
    }
}
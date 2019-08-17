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

add_action( 'customize_register', 'blueprint_define_custom_controls' );

function blueprint_define_custom_controls( $wp_customize ) {
    
        class Blueprint_Social_Custom_Link_Control extends WP_Customize_Control {
            /**
            * The type of control being rendered
            */
            //public $type = 'sortable_repeater';
            public $type = 'social_link_control';
            
            /**
            * Constructor
            */
            public function __construct( $manager, $id, $args = array(), $options = array() ) {
            parent::__construct( $manager, $id, $args );        
            }

            public function enqueue() {
                wp_enqueue_script( 'jquery-ui-sortable' );
            
                wp_enqueue_script( 'blueprint-social-customizer', plugin_dir_url( __FILE__ ) . 'assets/blueprint-social-customizer.js', array( 'jquery', 'jquery-ui-sortable', 'customize-controls' ), BLUEPRINT_SOCIAL_VERSION,  true );
                
                wp_enqueue_style( 'blueprint-social-customizer', plugin_dir_url( __FILE__ ) . 'assets/blueprint-social-customizer.css', array(), BLUEPRINT_SOCIAL_VERSION, 'all' );

            }
            
            /**
            * Render the control in the customizer
            */
            public function render_content() {

                $saved_value = $this->get_saved_value();
                $link_input = $this->get_link_input();
                $empty_input = $this->get_link_input( $type = 'empty' );
                
                    ?>
                        <div class="drag_and_drop_control">
                            <?php if( !empty( $this->label ) ) { ?>
                                <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
                            <?php } ?>
                            <?php if( !empty( $this->description ) ) { ?>
                                <span class="customize-control-description"><?php echo esc_html( $this->description ); ?></span>
                            <?php } ?>
                            <input type="hidden" id="<?php echo esc_attr( $this->id ); ?>" name="<?php echo esc_attr( $this->id ); ?>" value="<?php echo esc_attr( $this->value() ); ?>" class="customize-control-sortable-repeater" <?php $this->link(); ?> />
                            <ul id="blueprint-social-list" class="sortable">

                            <?php if( $saved_value ) {
                                echo $saved_value;
                            } else { ?>

                                echo $link_input;
                            <?php } 

                            echo $empty_input;

                            ?>

                    </ul>
                    <a id="add_link" class="button">Add Link</a> 
                    <a id="sort_links" class="button">Sort Links</a> 
                    <a id="save_sort" class="button">Save Sort Order</a> 
                    
                            </div>
                
                        </div>
                    <?php
            }

            function get_link_input( $type = 'default', $network = '', $placeholder = 'http://... or mailto://...', $url = '' ) {

                $class = 'ui-state-default repeater';

                if( $type === 'empty' ) {
                $class = 'empty-link repeater';
                }

                $markup = sprintf(
                '<li class="%1$s">
                <span class="dashicons dashicons-move sort_handle"></span>
                <div class="network-inputs">%2$s<input type="text" value="%4$s" placeholder="%3$s" class="network-url"/></div><div class="remove_link"><span class="dashicons dashicons-dismiss"></span></div></li>',
                esc_attr( $class ),
                $this->get_social_options( $this->id, $network ),
                $placeholder,
                $url
                );

                return $markup;
            }


            function get_saved_value() {
                $links = get_option( $this->id, false);
                $links = json_decode( $links, true );

                $markup = false;

                if( $links ) {
                
                foreach($links as $link) {
                   
                    $network = $link['network'];
                    $url = $link['url'];

                    if( $url && $network ) {
                        $placeholder = 'http://website.com';
                        
                        if( $network === 'email' ) {
                            $url = sanitize_email( $url);
                            $placeholder = 'email@yourwebsite.com';
                        } else {
                            $url = esc_url( $url );
                        }
                    
                    $markup .= sprintf(
                        '<li class="ui-state-default repeater">
                        <span class="dashicons dashicons-move sort_handle"></span>
                        <div class="network-inputs">%1$s<input type="text" value="%2$s" placeholder="%3$s" class="network-url"/></div>
                        <div class="remove_link"><span class="dashicons dashicons-dismiss"></span></div></li>',
                        $this->get_social_options( $this->id, $network ),
                        $url,
                        $placeholder,
                        $network
                    );
                    }
                }

                }
                return $markup;

            }


            function get_social_options( $id, $value = '' ) { 

                $networks = array (
                array(
                    'name' => 'Amazon', 
                    'tag' => 'amazon'),
                array(
                    'name' => 'Behance', 
                    'tag' => 'behance'),
                array(
                    'name' => 'Book + Main Bites', 
                    'tag' => 'bites'),
                array(
                    'name' => 'Bookbub', 
                    'tag' => 'bookbub'),
                array(
                    'name' => 'Ello', 
                    'tag' => 'ello'),
                array(
                    'name' => 'Email Address', 
                    'tag' => 'email'),
                array(
                    'name' => 'Evernote', 
                    'tag' => 'evernote'),
                array(
                    'name' => 'Facebook', 
                    'tag' => 'facebook'),
                array(
                    'name' => 'Flickr', 
                    'tag' => 'flickr'),
                array(
                    'name' => 'Goodreads', 
                    'tag' => 'goodreads'),
                array(
                    'name' => 'Google Plus', 
                    'tag' => 'gplus'),
                array(
                    'name' => 'Instagram', 
                    'tag' => 'instagram'),
                array(
                    'name' => 'iTunes Podcast', 
                    'tag' => 'itunes-podcast'),
                array(
                    'name' => 'I Heart Radio', 
                    'tag' => 'iheartradio'),
                array(
                    'name' => 'LinkedIn', 
                    'tag' => 'linkedin'),
                array(
                    'name' => 'Newsletter', 
                    'tag' => 'newsletter'),
                array(
                    'name' => 'Medium', 
                    'tag' => 'medium'),
                array(
                    'name' => 'MeetUp', 
                    'tag' => 'meetup'),
                array(
                    'name' => 'Periscope', 
                    'tag' => 'periscope'),
                array(
                    'name' => 'Picasa', 
                    'tag' => 'picasa'),
                array(
                    'name' => 'Pinterest', 
                    'tag' => 'pinterest'),
                    array(
                    'name' => 'Pocket', 
                    'tag' => 'pocket'),
                array(
                    'name' => 'RSS', 
                    'tag' => 'rss'),
                array(
                    'name' => 'Snapchat', 
                    'tag' => 'snapchat'),
                array(
                    'name' => 'Slack', 
                    'tag' => 'slack'),
                array(
                    'name' => 'Soundcloud', 
                    'tag' => 'soundcloud'),
                array(
                    'name' => 'Spotify', 
                    'tag' => 'spotify'),
                array(
                    'name' => 'Stitcher', 
                    'tag' => 'stitcher'),
                array(
                    'name' => 'Tsu', 
                    'tag' => 'tsu'),
                array(
                    'name' => 'Tumblr', 
                    'tag' => 'tumblr'),
                array(
                    'name' => 'Twitter', 
                    'tag' => 'twitter'),
                array(
                    'name' => 'Vimeo', 
                    'tag' => 'vimeo'),
                array(
                    'name' => 'Vine', 
                    'tag' => 'vine'),
                array(
                    'name' => 'YouTube', 
                    'tag' => 'youtube'),
                array(
                    'name' => 'Custom', 
                    'tag' => 'custom')
                );
            
                $networks = apply_filters( 'mmkbp_social_networks', $networks );
                $options = '';    
                
                foreach( $networks as $network ) {
                    
                    $selected = '';
                    $icon_class = '';
                    

                    if( $value === $network['tag'] ) {
                    $selected = "selected='selected'";
                    }
                    
                    
                    if( !empty( $value ) ) {
                        $icon_class = esc_attr('admin-icon icon-' . $value);
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
<?php

/**
 * The List of Available Social Networks
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
class Blueprint_Social_Networks {

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

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public static function get_networks() {

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
        'name' => 'The Dots',
        'tag' => 'dots',),
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
        'name' => 'Github',
        'tag' => 'github',),
    array(
        'name' => 'Goodreads',
        'tag' => 'goodreads'),
    array(
        'name' => 'Google Plus',
        'tag' => 'google-plus'),
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
        'name' => 'JSFiddle',
        'tag' => 'jsfiddle',),
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
        'name' => 'Mix',
        'tag' => 'mix'),
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
        'name' => 'Ravelry',
        'tag' => 'ravelry'),
    array(
        'name' => 'RSS',
        'tag' => 'rss'),
    array(
        'name' => 'Shop',
        'tag' => 'shop',),
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
        'name' => 'Wattpad',
        'tag' => 'wattpad',),
    array(
        'name' => 'Wikipedia',
        'tag' => 'wikipedia'),
    array(
        'name' => 'YouTube',
        'tag' => 'youtube')
    );

    $networks = apply_filters( 'mmkbp_blueprint_social_networks', $networks );

    return $networks;
	}

}

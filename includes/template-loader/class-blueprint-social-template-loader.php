<?php
 
/**
 * Template loader for Outline Blueprint_Social Plugin
 *
 * Only need to specify class properties here.
 *
 */
class Blueprint_Social_Template_Loader extends Gamajo_Template_Loader {
 
  /**
   * Prefix for filter names.
   *
   * @since 1.0.0
   * @type string
   */
  protected $filter_prefix = 'blueprint_social';
 
  /**
   * Directory name where custom templates for this plugin should be found in the theme.
   *
   * @since 1.0.0
   * @type string
   */
  protected $theme_template_directory = 'blueprint-social';
 
  /**
   * Reference to the root directory path of this plugin.
   *
   * @since 1.0.0
   * @type string
   */
  protected $plugin_directory = BLUEPRINT_SOCIAL_PLUGIN_DIR;
 
}

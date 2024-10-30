<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://mrkalathiya.wordpress.com/
 * @since      1.0.0
 *
 * @package    Contact_Form_Shortcode_Finder
 * @subpackage Contact_Form_Shortcode_Finder/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Contact_Form_Shortcode_Finder
 * @subpackage Contact_Form_Shortcode_Finder/includes
 * @author     Hardik Kalathiya <hardikkalathiya93@gmail.com>
 */
class Contact_Form_Shortcode_Finder_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'contact-form-shortcode-finder',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}

<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://github.com/bhoot-biswas
 * @since      1.0.0
 *
 * @package    Firebase_Auth
 * @subpackage Firebase_Auth/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Firebase_Auth
 * @subpackage Firebase_Auth/includes
 * @author     Mithun Biswas <bhoot.biswas@gmail.com>
 */
class Firebase_Auth_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'firebase-auth',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}

<?php

/** Requiere the JWT token verifier library. */
use Firebase\Auth\Token\Verifier;

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://github.com/bhoot-biswas
 * @since      1.0.0
 *
 * @package    Firebase_Auth
 * @subpackage Firebase_Auth/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Firebase_Auth
 * @subpackage Firebase_Auth/public
 * @author     Mithun Biswas <bhoot.biswas@gmail.com>
 */
class Firebase_Auth_Public {

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
		$this->version     = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Firebase_Auth_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Firebase_Auth_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/firebase-auth-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Firebase_Auth_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Firebase_Auth_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/firebase-auth-public.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * [validate_token description]
	 * @return [type] [description]
	 */
	public function validate_token() {
		/**
		 * Looking for the HTTP_AUTHORIZATION header, if not present just
		 * return the user.
		 * @var [type]
		 */
		$auth = isset( $_SERVER['HTTP_AUTHORIZATION'] ) ? $_SERVER['HTTP_AUTHORIZATION'] : false;

		/* Double check for different auth header string (server dependent) */
		if ( ! $auth ) {
			$auth = isset( $_SERVER['REDIRECT_HTTP_AUTHORIZATION'] ) ? $_SERVER['REDIRECT_HTTP_AUTHORIZATION'] : false;
		}

		if ( ! auth ) {
			return new WP_Error(
				'firebase_auth_no_auth_header',
				__( 'Authorization header not found.', 'firebase-auth' ),
				array(
					'status' => 403,
				)
			);
		}

		/**
		 * The HTTP_AUTHORIZATION is present verify the format
		 * if the format is wrong return the user.
		 * @var [type]
		 */
		list($token) = sscanf( $auth, 'Bearer %s' );
		if ( ! $token ) {
			return new WP_Error(
				'firebase_auth_bad_auth_header',
				__( 'Authorization header malformed.', 'firebase-auth' ),
				array(
					'status' => 403,
				)
			);
		}

		/** Get the Secret Key */
		$secret_key = defined( 'FIREBASE_AUTH_SECRET_KEY' ) ? FIREBASE_AUTH_SECRET_KEY : false;
		if ( ! $secret_key ) {
			return new WP_Error(
				'firebase_auth_bad_config',
				__( 'Firebase Auth is not configurated properly, please contact the admin.', 'firebase-auth' ),
				array(
					'status' => 403,
				)
			);
		}

		/** Try to decode the token */
		$verifier = new Verifier( $secret_key );
		try {
			$verified_id_token = $verifier->verifyIdToken( $token );

			/** Everything looks good, send back the success */
			return array(
				'code' => 'firebase_auth_valid_token',
				'sub'  => $verified_id_token->getClaim( 'sub' ),
				'data' => array(
					'status' => 200,
				),
			);
		} catch ( \Firebase\Auth\Token\Exception\ExpiredToken $e ) {
			/** Expired token, send back the error */
			return new WP_Error(
				'firebase_auth_expired_token',
				$e->getMessage(),
				array(
					'status' => 403,
				)
			);
		} catch ( \Firebase\Auth\Token\Exception\IssuedInTheFuture $e ) {
			/** Issued in future, send back the error */
			return new WP_Error(
				'firebase_auth_issued_in_the_future',
				$e->getMessage(),
				array(
					'status' => 403,
				)
			);
		} catch ( \Firebase\Auth\Token\Exception\InvalidToken $e ) {
			/** Something is wrong trying to decode the token, send back the error */
			return new WP_Error(
				'firebase_auth_invalid_token',
				$e->getMessage(),
				array(
					'status' => 403,
				)
			);
		}
	}

}

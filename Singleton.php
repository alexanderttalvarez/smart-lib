<?php
/**
 * Trait Singleton
 *
 * @package    WordPress
 * @subpackage Smart
 * @since      1.0.0
 */

namespace Kec\Smart;

/**
 * Trait Singleton
 *
 * @package Smart
 */
trait Singleton {
	/**
	 * Instance of class.
	 *
	 * @var Object
	 */
	protected static $instance;

	/**
	 * Create instance only once.
	 *
	 * @since 1.0.0
	 *
	 * @return Object Current class object.
	 */
	final public static function get_instance() {
		if ( null === static::$instance ) {
			static::$instance = new static();
		}

		return static::$instance;
	}

	/**
	 * Singleton constructor.
	 *
	 * @since 1.0.0
	 */
	final private function __construct() {
		$this->init();
	}

	/**
	 * Action / Filters to be declare here.
	 *
	 * @since 1.0.0
	 */
	protected function init() {}

	/**
	 * Cloning is forbidden.
	 *
	 * @since 1.0.0
	 */
	final public function __clone() {
		_doing_it_wrong( __FUNCTION__, esc_html__( 'Cheatin&#8217; huh?' ), '1.0.0' );
	}

	/**
	 * Unserializing instances of this class is forbidden.
	 *
	 * @since 1.0.0
	 */
	final public function __wakeup() {
		_doing_it_wrong( __FUNCTION__, esc_html__( 'Cheatin&#8217; huh?' ), '1.0.0' );
	}

	/**
	 * Verify nonce request
	 *
	 * @param string $action    Action.
	 * @param string $query_arg Query args.
	 *
	 * @return bool|false|int
	 */
	private function verify_nonce_request( $action = '', $query_arg = 'kec_nonce' ) {

		// Check the nonce
		$result = isset( $_REQUEST[ $query_arg ] ) ? wp_verify_nonce( $_REQUEST[ $query_arg ], $action ) : false; // WPCS: Input var ok, sanitization ok

		// Nonce check failed
		if ( empty( $result ) || empty( $action ) ) {
			$result = false;
		}

		// Do extra things
		do_action( 'smart/verify_nonce_request', $action, $result );

		return $result;
	}
}

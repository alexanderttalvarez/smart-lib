<?php
/**
 * Disables trackbacks/pingbacks
 *
 * You can enable/disable this feature in app/setup.php:
 * add_theme_support('smart-disable-trackbacks');
 *
 * @package    WordPress
 * @subpackage Smart
 * @since      1.0.0
 */

namespace Kec\Smart\Modules\Module\Disable;

use Kec\Smart\Singleton;

/**
 * Trackbacks Class
 *
 * @since 1.0.0
 */
final class Trackbacks {
    use Singleton;

    /**
     * Initialize hooks
     */
    private function init() {
        add_filter( 'xmlrpc_methods', [ $this, 'filter_xmlrpc_method' ], 10, 1 );
        add_filter( 'wp_headers', [ $this, 'filter_headers' ], 10, 1 );
        add_filter( 'rewrite_rules_array', [ $this, 'filter_rewrites' ] );
        add_filter( 'bloginfo_url', [ $this, 'kill_pingback_url' ], 10, 2 );
        add_action( 'xmlrpc_call', [ $this, 'kill_xmlrpc' ] );
    }

    /**
     * Disable pingback XMLRPC method
     *
     * @param array $methods XMLRPC methods.
     *
     * @return mixed
     */
    public function filter_xmlrpc_method( $methods ) {
        unset( $methods['pingback.ping'] );

        return $methods;
    }

    /**
     * Remove pingback header
     *
     * @param array $headers HTML headers.
     *
     * @return mixed
     */
    public function filter_headers( $headers ) {
        if ( isset( $headers['X-Pingback'] ) ) {
            unset( $headers['X-Pingback'] );
        }

        return $headers;
    }

    /**
     * Kill trackback rewrite rule
     *
     * @param array $rules Rewrite rules.
     *
     * @return mixed
     */
    public function filter_rewrites( $rules ) {
        foreach ( $rules as $rule => $rewrite ) {
            if ( preg_match( '/trackback\/\?\$$/i', $rule ) ) {
                unset( $rules[ $rule ] );
            }
        }

        return $rules;
    }

    /**
     * Kill bloginfo('pingback_url')
     *
     * @param string $output Output string.
     * @param string $show   Option name.
     *
     * @return string
     */
    public function kill_pingback_url( $output, $show ) : string {
        if ( 'pingback_url' === $show ) {
            $output = '';
        }

        return $output;
    }

    /**
     * Disable XMLRPC call
     *
     * @param string $action Action name.
     */
    public function kill_xmlrpc( $action ) {
        if ( 'pingback.ping' === $action ) {
            // phpcs:disable
            wp_die(
                'Pingbacks are not supported',
                'Not Allowed!',
                [ 'response' => 403 ]
            );
            // phpcs:enable
        }
    }
}

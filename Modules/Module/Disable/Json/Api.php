<?php
/**
 * Disable json api and remove link from header
 *
 * You can enable/disable this feature in app/setup.php:
 * add_theme_support('smart-disable-json-api');
 *
 * @package    WordPress
 * @subpackage Smart
 * @since      1.0.0
 */

namespace Kec\Smart\Modules\Module\Disable\Json;

use Kec\Smart\Singleton;

/**
 * Api Class
 *
 * @since 1.0.0
 */
final class Api {
    use Singleton;

    /**
     * Initialize hooks
     */
    private function init() {
        if ( ! is_admin() ) {
            remove_action( 'wp_head', 'rest_output_link_wp_head', 10 );
            remove_action( 'wp_head', 'wp_oembed_add_discovery_links', 10 );
            remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
            remove_action( 'wp_head', 'wp_oembed_add_host_js' );
            remove_action( 'wp_head', 'rest_output_link_wp_head', 10 );
        }

        remove_action( 'rest_api_init', 'wp_oembed_register_route' );
        add_filter( 'embed_oembed_discover', '__return_false' );
        remove_filter( 'oembed_dataparse', 'wp_filter_oembed_result', 10 );
        remove_action( 'template_redirect', 'rest_output_link_header', 11 );

        // disable json_api
        add_filter( 'json_enabled', '__return_false' );
        add_filter( 'json_jsonp_enabled', '__return_false' );

        // Notice: rest_enabled is deprecated since version 4.7.0! Use rest_authentication_errors instead.
        add_filter( 'rest_jsonp_enabled', '__return_false' );

        // The REST API can no longer be completely disabled, the rest_authentication_errors can be used to restrict access to the API
        add_filter(
            'rest_authentication_errors',
            function ( $access ) {
                return new \WP_Error(
                    'rest_disabled',
                    _x( 'The REST API an this site has been disabled.', 'user message', 'smart' ),
                    [
                        'status' => rest_authorization_required_code(),
                    ]
                );
            }
        );

    }
}

<?php
/**
 * This file includes helper functions for optional modules
 *
 * @package    WordPress
 * @subpackage Smart
 * @since      1.0.0
 */

namespace Kec\Smart\Modules;

/**
 * Utils Class
 *
 * @package Smart
 * @since 1.0.0
 */
final class Utils {

    /**
     * Make a URL relative
     *
     * @param string $input URL input.
     *
     * @return string
     */
    public static function relative_url( $input ) : string {
        if ( is_feed() ) {
            return $input;
        }

        $url = parse_url( $input );
        if ( ! isset( $url['host'], $url['path'] ) ) {
            return $input;
        }

        $site_url = parse_url( network_home_url() );  // falls back to home_url
        if ( ! isset( $url['scheme'] ) ) {
            $url['scheme'] = $site_url['scheme'];
        }

        $hosts_match   = $site_url['host'] === $url['host'];
        $schemes_match = $site_url['scheme'] === $url['scheme'];
        $ports_exist   = isset( $site_url['port'], $url['port'] );
        $ports_match   = $ports_exist ? $site_url['port'] === $url['port'] : true;

        if ( $hosts_match && $schemes_match && $ports_match ) {
            return wp_make_link_relative( $input );
        }

        return $input;
    }


    /**
     * Compare URL against relative URL
     *
     * @param string $url Original URL.
     * @param string $rel Relative URL.
     *
     * @return bool
     */
    public static function url_compare( $url, $rel ) : bool {
        $url = trailingslashit( $url );
        $rel = trailingslashit( $rel );

        return ( ( 0 === strcasecmp( $url, $rel ) ) || $rel === self::relative_url( $url ) );
    }

    /**
     * Hooks a single callback to multiple tags
     *
     * @param array  $tags          Tags array.
     * @param string $function      Function name.
     * @param int    $priority      Priority.
     * @param int    $accepted_args Accepted args.
     */
    public static function add_filters( $tags, $function, $priority = 10, $accepted_args = 1 ) {
        foreach ( (array) $tags as $tag ) {
            add_filter( $tag, $function, $priority, $accepted_args );
        }
    }

    /**
     * Display error alerts in admin panel
     *
     * @param array  $errors Errors array.
     * @param string $capability Capability.
     *
     * @return mixed
     */
    public static function alerts( $errors, $capability = 'activate_plugins' ) {
        if ( ! did_action( 'init' ) ) {
            return add_action(
                'init', function () use ( $errors, $capability ) {
                    self::alerts( $errors, $capability );
                }
            );
        }

        $alert = function ( $message ) {
            echo '<div class="error"><p>' . $message . '</p></div>'; // phpcs:disable
        };

        if ( \call_user_func_array( 'current_user_can', (array) $capability ) ) {
            add_action(
                'admin_notices',
                function () use ( $alert, $errors ) {
                    array_map( $alert, $errors );
                }
            );
        }
    }
}

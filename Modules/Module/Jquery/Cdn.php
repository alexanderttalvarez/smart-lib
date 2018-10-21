<?php
/**
 * Load jQuery from jQuery's CDN with a local fallback
 *
 * You can enable/disable this feature in app/setup.php:
 * add_theme_support('smart-jquery-cdn');
 *
 * @package    WordPress
 * @subpackage Smart
 * @since      1.0.0
 */

namespace Kec\Smart\Modules\Module\Jquery;

use Kec\Smart\Singleton;

/**
 * Cdn Class
 *
 * @since 1.0.0
 */
final class Cdn {
    use Singleton;

    /**
     * Initialize hooks
     */
    private function init() {
        add_action( 'wp_enqueue_scripts', [ $this, 'register_jquery' ], 9997 );
        add_action( 'wp_head', [ $this, 'jquery_local_fallback' ] );
    }

    /**
     * Register jQuery
     */
    public function register_jquery() {
        $jquery_version = wp_scripts()->registered['jquery']->ver;

        wp_deregister_script( 'jquery' );

        wp_register_script(
            'jquery',
            'https://code.jquery.com/jquery-' . $jquery_version . '.min.js',
            [],
            $jquery_version,
            false
        );

        add_filter(
            'wp_resource_hints',
            function ( $urls, $relation_type ) {
                if ( $relation_type === 'dns-prefetch' ) {
                    $urls[] = 'code.jquery.com';
                }

                return $urls;
            }, 10, 2
        );

        add_filter( 'script_loader_src',  [ $this, 'jquery_local_fallback' ], 10, 2 );
    }

    /**
     * Output the local fallback immediately after jQuery's <script>
     *
     * @param string $src    Script source.
     * @param null   $handle Script handle.
     *
     * @return mixed
     * @link http://wordpress.stackexchange.com/a/12450
     */
    public function jquery_local_fallback( $src, $handle = null ) {
        static $add_jquery_fallback = false;

        if ( $add_jquery_fallback ) {
            // phpcs:disable
            echo '<script>(window.jQuery && jQuery.noConflict()) || document.write(\'<script src="' . $add_jquery_fallback . '"><\/script>\')</script>' . "\n";
            // phpcs:enable
            $add_jquery_fallback = false;
        }

        if ( $handle === 'jquery' ) {
            $add_jquery_fallback = apply_filters( 'script_loader_src', \includes_url( '/js/jquery/jquery.js' ), 'jquery-fallback' );
        }

        return $src;
    }
}

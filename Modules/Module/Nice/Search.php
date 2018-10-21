<?php
/**
 * Redirects search results from /?s=query to /search/query/, converts %20 to +
 *
 * @link       http://txfx.net/wordpress-plugins/nice-search/
 *
 * You can enable/disable this feature in app/setup.php:
 * add_theme_support('smart-nice-search');
 *
 * @package    WordPress
 * @subpackage Smart
 * @since      1.0.0
 */

namespace Kec\Smart\Modules\Module\Nice;

use Kec\Smart\Singleton;

/**
 * Search Class
 *
 * @since 1.0.0
 */
final class Search {
    use Singleton;

    /**
     * Initialize hooks
     */
    private function init() {
        add_action( 'template_redirect', [ $this, 'redirect' ] );
        add_filter( 'wpseo_json_ld_search_url', [ $this, 'rewrite' ] );
    }

    /**
     * Redirects search results from /?s=query to /search/query/, converts %20 to +
     *
     * @link       http://txfx.net/wordpress-plugins/nice-search/
     */
    public function redirect() {
        global $wp_rewrite;
        if ( null === $wp_rewrite || ! \is_object( $wp_rewrite ) || ! $wp_rewrite->get_search_permastruct() ) {
            return;
        }

        $search_base  = $wp_rewrite->search_base;
        $_request_uri = filter_input( INPUT_SERVER, 'REQUEST_URI', FILTER_SANITIZE_URL );

        if ( \is_string( $_request_uri )
             && is_search()
             && ! is_admin()
             && false === strpos( $_request_uri, "/{$search_base}/" )
             && false === strpos( $_request_uri, '&' ) ) {
            wp_redirect( get_search_link() );
            exit();
        }
    }

    /**
     * WP SEO Support
     *
     * @param string $url Search URL.
     *
     * @return string
     */
    public function rewrite( $url ) : string {
        return str_replace( '/?s=', '/search/', $url );
    }
}

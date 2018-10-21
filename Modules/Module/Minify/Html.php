<?php
/**
 * Minifies the output html
 *
 * You can enable/disable this feature in app/setup.php:
 * add_theme_support('smart-minify-html');
 *
 * @package    WordPress
 * @subpackage Smart
 * @since      1.0.0
 */

namespace Kec\Smart\Modules\Module\Minify;

use Kec\Smart\Singleton;

/**
 * Html Class
 *
 * @since 1.0.0
 */
final class Html {
    use Singleton;

    /**
     * Initialize hooks
     */
    private function init() {
        add_action( 'init', [ $this, 'minify_html' ], 1 );
    }

    /**
     * Minify HTML
     */
    public function minify_html() {
        if ( ! ( ( \defined( 'WP_CLI' ) && WP_CLI ) || ( \defined( 'WP_DEBUG' ) && WP_DEBUG ) || is_admin() ) ) {
            ob_start( 'smart_minify_html_output' );
        }
    }
}

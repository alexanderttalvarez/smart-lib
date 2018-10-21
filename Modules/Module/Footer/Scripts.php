<?php
/**
 * Moves all scripts to wp_footer action
 *
 * You can enable/disable this feature in app/setup.php:
 * add_theme_support('smart-footer-scripts');
 *
 * @package    WordPress
 * @subpackage Smart
 * @since      1.0.0
 */

namespace Kec\Smart\Modules\Module\Footer;

use Kec\Smart\Singleton;

/**
 * Scripts Class
 *
 * @since 1.0.0
 */
final class Scripts {
    use Singleton;

    /**
     * Initialize hooks
     */
    private function init() {
        add_action( 'wp_enqueue_scripts', [ $this, 'js_to_footer' ], 9999 );
    }

    /**
     * Load javascript on footer
     */
    public function js_to_footer() {
        remove_action( 'wp_head', 'wp_print_scripts' );
        remove_action( 'wp_head', 'wp_print_head_scripts', 9 );
        remove_action( 'wp_head', 'wp_enqueue_scripts', 1 );
    }
}

<?php
/**
 * Remove version query string from all styles and scripts
 *
 * You can enable/disable this feature in app/setup.php:
 * add_theme_support('smart-disable-asset-versioning');
 *
 * @package    WordPress
 * @subpackage Smart
 * @since      1.0.0
 */

namespace Kec\Smart\Modules\Module\Disable\Asset;

use Kec\Smart\Singleton;

/**
 * Versioning Class
 *
 * @since 1.0.0
 */
final class Versioning {
    use Singleton;

    /**
     * Initialize hooks
     */
    private function init() {
        add_filter( 'script_loader_src', [ $this, 'remove_script_version' ], 15, 1 );
        add_filter( 'style_loader_src', [ $this, 'remove_script_version' ], 15, 1 );
    }

    /**
     * Remove version query string from all styles and scripts
     *
     * @param string $src Script source.
     *
     * @return bool|string
     */
    public function remove_script_version( $src ) {
        return $src ? esc_url( remove_query_arg( 'ver', $src ) ) : false;
    }
}

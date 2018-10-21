<?php
/**
 * This file includes the loader for optional modules
 *
 * @package    WordPress
 * @subpackage Smart
 * @since      1.0.0
 */

namespace Kec\Smart;

use Kec\Smart\Modules\Options;

/**
 * Minion Class
 *
 * @package Almirall
 * @since   1.0.0
 */
final class Modules {
    use Singleton;

    /**
     * Initialize hooks
     */
    private function init() {
        add_action( 'after_setup_theme', [ $this, 'load_modules' ], 100 );
    }

    /**
     * Load modules when enabled
     */
    public function load_modules() {
        global $_wp_theme_features;

        // Skip loading modules in the admin.
        if ( ! is_admin() ) {
            foreach ( Options::MODULES as $module => $class ) {
                $feature = 'smart-' . $module;
                if ( isset( $_wp_theme_features[ $feature ] ) ) {

	                Options::init( $feature, $_wp_theme_features[ $feature ] );

                    $class::get_instance();
                }
            }
        }
    }
}

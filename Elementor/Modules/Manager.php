<?php
/**
 * Manager class
 *
 * @package    WordPress
 * @subpackage Smart
 * @since      1.0.0
 */

namespace Kec\Smart\Elementor\Modules;

use Kec\Smart\Singleton;

class Manager {
    use Singleton;

    /**
     * @var array
     */
    private $modules = [];

    protected function init() {
        $this->register_modules();
    }

    /**
     * @since 1.0.0
     */
    private function register_modules() {

        $modules = [
            'query-post',
        ];

        // If Advanced Custom Fields
        if ( class_exists( 'acf' ) ) {
            $modules[] = 'acf';
        }

        // If Caldera Forms
        if ( class_exists( 'Caldera_Forms' ) ) {
            $modules[] = 'caldera-forms';
        }

        // If Contact Form 7
        if ( class_exists( 'WPCF7_ContactForm' ) ) {
            $modules[] = 'contact-form';
        }

        // If Gravity Forms
        if ( class_exists( 'GFCommon' ) ) {
            $modules[] = 'gravity-forms';
        }

        // If Ninja Forms
        if ( class_exists( 'Ninja_Forms' ) ) {
            $modules[] = 'ninja-forms';
        }

        // If WPForms
        if ( class_exists( 'WPForms' ) ) {
            $modules[] = 'wpforms';
        }

        foreach ( $modules as $module_name ) {
            $class_name = str_replace( '-', ' ', $module_name );
            $class_name = str_replace( ' ', '', ucwords( $class_name ) );
            $class_name = __NAMESPACE__ . '\\' . $class_name . '\Module';

            $this->modules[ $module_name ] = $class_name::get_instance();
        }
    }
}

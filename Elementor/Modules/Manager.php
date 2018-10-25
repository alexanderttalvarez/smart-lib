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
        $thia->register_modules();
    }

    /**
     * @since 1.0.0
     */
    private function register_modules() {

        // If Advanced Custom Fields
        if ( self::is_acf_active() ) {
            $modules[] = 'acf';
        }

        // If Contact Form 7
        if ( self::is_contact_form_7_active() ) {
            $modules[] = 'contact-form';
        }

        // If WPForms
        if ( self::is_wpforms_active() ) {
            $modules[] = 'wpforms';
        }

        // If Gravity Forms
        if ( self::is_gravity_forms_active() ) {
            $modules[] = 'gravity-forms';
        }

        // If Caldera Forms
        if ( self::is_caldera_forms_active() ) {
            $modules[] = 'caldera-forms';
        }

        // If Ninja Forms
        if ( self::is_ninja_forms_active() ) {
            $modules[] = 'ninja-forms';
        }

        foreach ( $modules as $module_name ) {
            $class_name = str_replace( '-', ' ', $module_name );
            $class_name = str_replace( ' ', '', ucwords( $class_name ) );
            $class_name = __NAMESPACE__ . '\\' . $class_name . '\Module';

            $this->modules[ $module_name ] = $class_name::get_instance();
        }
    }

    /**
     * Check if Advanced Custom Fields plugin is active
     *
     * @since 1.0.0
     *
     */
    public static function is_acf_active() {
        $return = false;

        if ( class_exists( 'acf' ) ) {
            $return = true;
        }

        return $return;
    }

    /**
     * Check if Contact Form 7 plugin is active
     *
     * @since 1.0.0
     *
     */
    public static function is_contact_form_7_active() {
        $return = false;

        if ( class_exists( 'WPCF7_ContactForm' ) ) {
            $return = true;
        }

        return $return;
    }

    /**
     * Check if WPForms plugin is active
     *
     * @since 1.0.0
     *
     */
    public static function is_wpforms_active() {
        $return = false;

        if ( class_exists( 'WPForms' ) ) {
            $return = true;
        }

        return $return;
    }

    /**
     * Check if Gravity Forms plugin is active
     *
     * @since 1.0.0
     *
     */
    public static function is_gravity_forms_active() {
        $return = false;

        if ( class_exists( 'GFCommon' ) ) {
            $return = true;
        }

        return $return;
    }

    /**
     * Check if Caldera Forms plugin is active
     *
     * @since 1.0.0
     *
     */
    public static function is_caldera_forms_active() {
        $return = false;

        if ( class_exists( 'Caldera_Forms' ) ) {
            $return = true;
        }

        return $return;
    }

    /**
     * Check if Ninja Forms plugin is active
     *
     * @since 1.0.0
     *
     */
    public static function is_ninja_forms_active() {
        $return = false;

        if ( class_exists( 'Ninja_Forms' ) ) {
            $return = true;
        }

        return $return;
    }
}

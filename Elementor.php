<?php
/**
 * Elementor class
 *
 * @package    WordPress
 * @subpackage Smart
 * @since      1.0.0
 */

namespace Kec\Smart;

use Elementor\Plugin;
use Elementor\Core\Files\CSS\Post;
use Kec\Smart\Elementor\Modules\Manager;
use Kec\Smart\Elementor\Compatibility\WPML;

/**
 * Class Elementor
 *
 * @package Smart
 * @uses    \Elementor\Plugin
 * @uses    \Elementor\Core\Files\CSS\Post
 */
final class Elementor {
    use Singleton;

    /**
     * @var Manager
     */
    public $modules_manager;

    /**
     * @var WPML
     */
    public $wpml_compatibility;

    /**
     * Initialize hooks
     *
     * @since 1.0.0
     */
    private function init() {
        add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_styles' ] );

        add_action( 'elementor/init', function () {
            $this->modules_manager    = Manager::get_instance();
            $this->wpml_compatibility = WPML::get_instance();
        }, 0 );
        add_action( 'elementor/init', [ $this, 'init_panel_section' ], 0 );
        add_action( 'elementor/elements/categories_registered', [ $this, 'init_panel_section' ] );

        // Add support for Elementor Pro locations
        add_action( 'elementor/theme/register_locations', [ $this, 'register_locations' ] );
    }

    /**
     * Sections init
     *
     * @since  1.0.0
     *
     * @access private
     */
    public function init_panel_section() {
        // Add element category in panel
        Plugin::instance()->elements_manager->add_category(
            'smart-elements',
            [ 'title' => esc_html_x( 'Smart Elements', 'Elementor', 'smart' ), ],
            1
        );
    }

    /**
     * Add support for Elementor Pro locations
     *
     * @since 1.0.0
     *
     * @param \ElementorPro\Modules\ThemeBuilder\Classes\Locations_Manager $elementor_theme_manager Elementor Theme Manager.
     */
    public function register_locations( $elementor_theme_manager ) {
        $elementor_theme_manager->register_all_core_location();
    }

    /**
     * Check if Elementor Plugin is active
     *
     * @return bool
     */
    public static function is_active(): bool {
        return class_exists( 'Elementor\Plugin' );
    }

    /**
     * Check if Elementor PRO Plugin is active
     *
     * @return bool
     */
    public static function is_pro_active(): bool {
        return class_exists( 'ElementorPro\Plugin' );
    }

    /**
     * Get the top bar template ID.
     *
     * @since 1.0.0
     *
     * @return bool|string
     */
    public static function get_topbar_id() {
        // Template
        $id = get_theme_mod( 'smart_top_bar_template' );

        // If template is selected
        if ( ! empty( $id ) ) {
            return $id;
        }

        // Return
        return false;
    }

    /**
     * Get the header template ID.
     *
     * @since 1.0.0
     *
     * @return bool|mixed
     */
    public static function get_header_id() {
        // Template
        $id = get_theme_mod( 'smart_header_template' );

        // If template is selected
        if ( ! empty( $id ) ) {
            return $id;
        }

        // Return
        return false;
    }

    /**
     * Get the footer ID.
     *
     * @since 1.0.0
     *
     * @return bool|string
     */
    public static function get_footer_id() {

        // Template
        $id = get_theme_mod( 'smart_footer_template' );

        // If template is selected
        if ( ! empty( $id ) ) {
            return $id;
        }

        // Return
        return false;
    }

    /**
     * Get the 404 error page ID.
     *
     * @since 1.0.0
     *
     * @return bool|string
     */
    public static function get_error_page_id() {

        // Template
        $id = get_theme_mod( 'smart_error_page_template' );

        // If template is selected
        if ( ! empty( $id ) ) {
            return $id;
        }

        // Return
        return false;
    }

    /**
     * Enqueue styles
     *
     * @since 1.0.0
     */
    public static function enqueue_styles() {

        if ( class_exists( '\Elementor\Core\Files\CSS\Post' ) ) {

            $topbar_id = self::get_topbar_id();
            $header_id = self::get_header_id();
            $footer_id = self::get_footer_id();
            $error_id  = self::get_error_page_id();

            // Enqueue top bar content css file
            if ( false !== $topbar_id ) {
                $topbar_css = new Post( $topbar_id );
                $topbar_css->enqueue();
            }

            // Enqueue nav css file
            if ( false !== $header_id ) {
                $nav_css = new Post( $header_id );
                $nav_css->enqueue();
            }

            // Enqueue footer css file
            if ( false !== $footer_id ) {
                $footer_css = new Post( $footer_id );
                $footer_css->enqueue();
            }

            // Enqueue 404 error page css file
            if ( false !== $error_id ) {
                $error_css = new Post( $error_id );
                $error_css->enqueue();
            }
        }
    }

    /**
     * Prints the top bar content.
     *
     * @since 1.0.0
     */
    public static function get_topbar_content() {
        echo Plugin::instance()->frontend->get_builder_content_for_display( self::get_topbar_id() ); // WPCS: XSS OK
    }

    /**
     * Prints the header content.
     *
     * @since 1.0.0
     */
    public static function get_header_content() {
        echo Plugin::instance()->frontend->get_builder_content_for_display( self::get_header_id() ); // WPCS: XSS OK
    }

    /**
     * Prints the footer content.
     *
     * @since 1.0.0
     */
    public static function get_footer_content() {
        echo Plugin::instance()->frontend->get_builder_content_for_display( self::get_footer_id() ); // WPCS: XSS OK
    }

    /**
     * Prints the 404 error page content.
     *
     * @since 1.0.0
     */
    public static function get_error_page_content() {
        echo Plugin::instance()->frontend->get_builder_content_for_display( self::get_error_page_id() ); // WPCS: XSS OK
    }

}


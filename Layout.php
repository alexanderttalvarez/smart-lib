<?php

namespace Kec\Smart;

use function App\post_id;

class Layout {
	use Singleton;

	protected function init() {
		add_action( 'smart/top_bar', [ __CLASS__, 'top_bar_template' ] );
		add_action( 'smart/header', [ __CLASS__, 'header_template' ] );
		add_action( 'smart/page_header', [ __CLASS__, 'page_header_template' ] );
		add_action( 'smart/display_sidebar', [ __CLASS__, 'display_sidebar' ] );
		add_action( 'smart/footer', [ __CLASS__, 'footer_template' ] );

		add_filter( 'smart/page_title', [ __CLASS__, 'page_header_title' ] );
		add_filter( 'smart/page_subheading', [ __CLASS__, 'page_header_subheading' ] );
		add_filter( 'smart/page_header_classes', [ __CLASS__, 'page_header_classes' ] );

		add_filter( 'smart/footer_classes', [ __CLASS__, 'footer_classes' ] );
		add_filter( 'smart/footer_widgets_classes', [ __CLASS__, 'footer_widgets_classes' ] );
		add_filter( 'smart/footer_widgets_inner_classes', [ __CLASS__, 'footer_widgets_inner_classes' ] );
		add_filter( 'smart/footer_bottom_classes', [ __CLASS__, 'footer_bottom_classes' ] );
	}

	/**
	 * Top bar template
	 *
	 * @since 1.0.0
	 */
	public static function top_bar_template() {

		// Return if no top bar
		if ( ! self::display_top_bar() ) {
			return;
		}

		get_template_part( 'views/partials/topbar/layout' );
	}

	/**
	 * Returns top bar template content
	 *
	 * @since 1.0.0
	 */
	public static function top_bar_template_content() {

		// Get the template ID
		$content = get_theme_mod( 'smart_top_bar_template' );

		// Get template content
		if ( ! empty( $content ) ) {

			$template = get_post( $content );

			if ( $template && ! is_wp_error( $template ) ) {
				$content = $template->post_content;
			}
		}

		// Apply filters and return content
		return apply_filters( 'smart/top_bar_template_content', $content );
	}

	/**
	 * Header template
	 *
	 * @since 1.0.0
	 */
	public static function header_template() {

		// Return if no header
		if ( ! self::display_header() ) {
			return;
		}

		get_template_part( 'views/partials/header/layout' );
	}

	/**
	 * Page header template
	 *
	 * @since 1.0.0
	 */
	public static function page_header_template() {

		// Return if no header
		if ( ! self::display_page_header() ) {
			return;
		}

		get_template_part( 'views/partials/page', 'header' );
	}

	/**
	 * @param $classes
	 *
	 * @return string
	 */
	public static function page_header_classes( $classes ): string {

		// Get header style
		$style = self::get_page_header_style();

		// Add classes for title style
		if ( $style ) {
			$classes[ $style . '-page-header' ] = $style . '-page-header';
		}

		// Visibility
		$visibility = get_theme_mod( 'smart_page_header_visibility', 'all-devices' );
		if ( 'all-devices' !== $visibility ) {
			$classes[] = $visibility;
		}

		// Turn into space separated list
		$classes = implode( ' ', $classes );

		return $classes;
	}

	/**
	 * Page header title
	 *
	 * @since  1.0.0
	 *
	 * @param string $title Page header title.
	 *
	 * @return mixed
	 */
	public static function page_header_title( $title ): string {

		// Return if no heading
		if ( ! self::has_page_header_heading() ) {
			return '';
		}

		if ( $meta = get_post_meta( post_id(), 'smart_post_title', true ) ) {
			$title = $meta;
		}

		return $title;
	}

	/**
	 * Page header subheading
	 *
	 * @since  1.0.0
	 *
	 * @param string $subheading Page header subheading.
	 *
	 * @return string
	 */
	public static function page_header_subheading( $subheading ): string {

		// Return if no heading
		if ( ! self::has_page_header_heading() ) {
			return '';
		}

		if ( $meta = get_post_meta( post_id(), 'smart_post_subheading', true ) ) {
			$subheading = $meta;
		}

		return $subheading;
	}

	/**
	 * Footer template
	 *
	 * @since 1.0.0
	 */
	public static function footer_template() {

		// Return if no footer
		if ( ! self::display_footer_widgets() && ! self::display_footer_bottom() ) {
			return;
		}

		get_template_part( 'views/partials/footer/layout' );
	}

	/**
	 * Returns footer template content
	 *
	 * @since 1.0.0
	 */
	public static function footer_template_content() {

		// Return false if disabled via Customizer
		if ( ! self::display_footer_widgets() ) {
			return null;
		}

		// Get template ID from Customizer
		$content = self::custom_footer_template();

		// Get template content
		if ( ! empty( $content ) ) {

			$template = get_post( $content );

			if ( $template && ! is_wp_error( $template ) ) {
				$content = $template->post_content;
			}
		}

		// Apply filters and return content
		return apply_filters( 'smart/footer_template_content', $content );
	}

	/**
	 * Custom footer style template
	 *
	 * @since 1.0.0
	 */
	public static function custom_footer_template() {

		// Get template from customizer setting
		$template = get_theme_mod( 'smart_footer_widgets_template' );

		// Apply filters and return
		return apply_filters( 'smart/custom_footer_template', $template );
	}

	/**
	 * Add classes to the footer wrap
	 *
	 * @since 1.0.0
	 * @param $classes
	 *
	 * @return string
	 */
	public static function footer_classes( $classes ) : string {

		// Set keys equal to values
		$classes = array_combine( $classes, $classes );

		// Turn into space separated list
		$classes = implode( ' ', $classes );

		// return classes
		return $classes;
	}

	/**
	 * Add classes to the footer widgets wrap
	 *
	 * @since 1.0.0
	 * @param $classes
	 *
	 * @return string
	 */
	public static function footer_widgets_classes( $classes ) : string {

		// Responsive columns
		$tablet_columns = get_theme_mod( 'smart_footer_widgets_tablet_columns' );
		$mobile_columns = get_theme_mod( 'smart_footer_widgets_mobile_columns' );

		// Visibility
		$visibility = get_theme_mod( 'smart_footer_widgets_visibility', 'all-devices' );

		if ( ! empty( $tablet_columns ) ) {
			$classes[] = 'tablet-' . $tablet_columns . '-col';
		}

		if ( ! empty( $mobile_columns ) ) {
			$classes[] = 'mobile-' . $mobile_columns . '-col';
		}

		if ( 'all-devices' !== $visibility ) {
			$classes[] = $visibility;
		}

		$classes = implode( ' ', $classes );

		return $classes;
	}

	/**
	 * Add classes to the footer widgets container
	 *
	 * @since 1.0.0
	 * @param $classes
	 *
	 * @return string
	 */
	public static function footer_widgets_inner_classes( $classes ) : string {

		// Add container class
		if ( true === get_theme_mod( 'smart_footer_widgets_container', true ) ) {
			$classes[] = 'container';
		}

		// Turn inner classes into space separated string
		$classes = implode( ' ', $classes );

		return $classes;
	}

	/**
	 * Add classes to the footer bottom wrap
	 *
	 * @since 1.0.0
	 * @param $classes
	 *
	 * @return string
	 */
	public static function footer_bottom_classes( $classes ) : string {

		// Visibility
		$visibility = get_theme_mod( 'smart_footer_bottom_visibility', 'all-devices' );

		if ( 'all-devices' !== $visibility ) {
			$classes[] = $visibility;
		}

		$classes = implode( ' ', $classes );

		return $classes;
	}

	/**
	 * Returns error page template content
	 *
	 * @since 1.0.0
	 */
	public static function error_page_template_content() {

		// Get template ID from Customizer
		$content = get_theme_mod( 'smart_error_page_template' );

		// Get template content
		if ( ! empty( $content ) ) {

			$template = get_post( $content );

			if ( $template && ! is_wp_error( $template ) ) {
				$content = $template->post_content;
			}
		}

		// Apply filters and return content
		return apply_filters( 'smart/error_page_template_content', $content );
	}

	/**
	 * Display top bar
	 *
	 * @since 1.0.0
	 * @return bool
	 */
	public static function display_top_bar(): bool {

		// Return true by default
		$return = true;

		// Return false if disabled via Customizer
		if ( get_theme_mod( 'smart_top_bar', true ) !== true ) {
			$return = false;
		}

		// Apply filters and return
		return apply_filters( 'smart/display_top_bar', $return );
	}

	/**
	 * Display header
	 *
	 * @since 1.0.0
	 * @return bool
	 */
	public static function display_header(): bool {

		// Return true by default
		$return = true;

		// Return false if disabled via Customizer
		if ( get_theme_mod( 'smart_header', true ) !== true ) {
			$return = false;
		}

		// Apply filters and return
		return (bool) apply_filters( 'smart/display_header', $return );
	}

	/**
	 * Display header
	 *
	 * @since 1.0.0
	 * @return bool
	 */
	public static function display_page_header(): bool {

		// Return true by default
		$return = true;

		// Return false if disabled via Customizer
		if ( get_theme_mod( 'smart_page_header', true ) !== true ) {
			$return = false;
		}

		// Return false if disabled via custom field
		if ( ! self::has_page_header() ) {
			$return = false;
		}

		// Apply filters and return
		return (bool) apply_filters( 'smart/display_page_header', $return );
	}

	/**
	 * Returns the sidebar
	 *
	 * @since  1.0.0
	 */
	public static function display_sidebar() {

		// Return if full width or full screen
		if ( \in_array( self::get_current(), [ 'full-screen', 'full-width' ] ) ) {
			return;
		}

		// Add the second sidebar
		if ( 'both-sidebars' === self::get_current() ) {
			get_sidebar( 'left' );
		}

		// Add the default sidebar
		get_sidebar();
	}

	/**
	 * Display footer widgets
	 *
	 * @since 1.0.0
	 * @return bool
	 */
	public static function display_footer_widgets() : bool {

		// Return true by default
		$return = true;

		// Return false if disabled via Customizer
		if ( get_theme_mod( 'smart_footer_widgets', true ) !== true ) {
			$return = false;
		}

		// Apply filters and return
		return apply_filters( 'smart/display_footer_widgets', $return );
	}

	/**
	 * Display footer
	 *
	 * @since 1.0.0
	 * @return bool
	 */
	public static function display_footer_bottom(): bool {

		// Return true by default
		$return = true;

		// Return false if disabled via Customizer
		if ( get_theme_mod( 'smart_footer_bottom', true ) !== true ) {
			$return = false;
		}

		// Apply filters and return
		return apply_filters( 'smart/display_footer_bottom', $return );
	}

	/**
	 * Determine whether to show the sidebar
	 *
	 * @return bool
	 *
	 * @param string $sidebar
	 *
	 * @return bool
	 */
	public static function has_sidebar( $sidebar = 'sidebar-primary' ): bool {
		static $display;

		$display[ $sidebar ] !== null || $display[ $sidebar ] = apply_filters( sprintf( 'smart/has_sidebar-%s', $sidebar ), false );

		return $display[ $sidebar ];
	}

	/**
	 * Returns correct both sidebars classes
	 *
	 * @since 1.0.0
	 */
	public static function both_sidebars_classes() {

		// Meta
		$meta = get_post_meta( post_id(), 'smart_both_sidebars_style', true );

		// Check meta first to override and return (prevents filters from overriding meta)
		if ( $meta ) {
			return $meta;
		}

		// Singular Page
		if ( is_page() ) {
			$class = get_theme_mod( 'smart_page_single_both_sidebars_style', 'scs-style' );
		}

		// Home
		elseif ( is_home()
		         || is_category()
		         || is_tag()
		         || is_date()
		         || is_author() ) {
			$class = get_theme_mod( 'smart_blog_archives_both_sidebars_style', 'scs-style' );
		}

		// Singular Post
		elseif ( is_singular( 'post' ) ) {
			$class = get_theme_mod( 'smart_blog_single_both_sidebars_style', 'scs-style' );
		}

		// Search
		elseif ( is_search() ) {
			$class = get_theme_mod( 'smart_search_both_sidebars_style', 'scs-style' );
		}

		// All else
		else {
			$class = 'scs-style';
		}

		// Class should never be empty
		if ( empty( $class ) ) {
			$class = 'scs-style';
		}

		// Apply filters and return
		return apply_filters( 'smart/both_sidebars_classes', $class );
	}

    /**
     * @return bool
     */
    public static function has_page_header(): bool {
        return !( get_post_meta( post_id(), 'smart_disable_title', true ) !== 'on' );
    }

    /**
     * @return bool
     */
    public static function has_page_header_heading(): bool {
        return !( get_post_meta( post_id(), 'smart_disable_heading', true ) !== 'on' );
    }

	/**
	 * @param string $context
	 *
	 * @return string
	 */
	public static function get_current( $context = 'post' ): string {

		if ( 'main' === $context ) {
			return get_theme_mod( 'smart_main_layout_style', 'wide' );
		}

		static $layout;

		if ( $layout === null ) {
			// Define variables
			$class = 'right-sidebar';
			$meta  = get_post_meta( post_id(), 'smart_post_layout', true );

			// Check meta first to override and return (prevents filters from overriding meta)
			if ( $meta ) {
				return $meta;
			}

			// Singular Page
			if ( is_page() ) {

				// Landing template
				if ( is_page_template( 'views/landing.php' ) ) {
					$class = 'full-width';
				} // Attachment
				elseif ( is_attachment() ) {
					$class = 'full-width';
				} // All other pages
				else {
					$class = get_theme_mod( 'smart_single_page_layout', 'right-sidebar' );
				}

			} // Home
			elseif ( is_home() || is_category() || is_tag() || is_date() || is_author() ) {
				$class = get_theme_mod( 'smart_blog_archives_layout', 'right-sidebar' );
			} // Singular Post
			elseif ( is_singular( 'post' ) ) {
				$class = get_theme_mod( 'smart_blog_single_layout', 'right-sidebar' );
			} // Library and Elementor template
			elseif ( is_singular( 'smart_library' ) || is_singular( 'elementor_library' ) ) {
				$class = 'full-width';
			} // Search
			elseif ( is_search() ) {
				$class = get_theme_mod( 'smart_search_page_layout', 'right-sidebar' );
			} // 404 page
			elseif ( is_404() ) {
				$class = get_theme_mod( 'smart_error_page_layout', 'full-width' );
			} // All else
			else {
				$class = 'right-sidebar';
			}

			// Class should never be empty
			if ( empty( $class ) ) {
				$class = 'right-sidebar';
			}

			// Apply filters
			$layout = apply_filters( 'smart/post_layout_class', $class );
		}

		return $layout;
	}

	/**
	 * Returns page header style
	 *
	 * @since 1.0.0
	 */
	public static function get_page_header_style() {

		// Get default page header style defined in Customizer
		$style = get_theme_mod( 'smart_page_header_style' );

		// Sanitize data
		$style = 'default' === $style ? '' : $style;

		// Apply filters and return
		return apply_filters( 'smart/page_header_style', $style );
	}

	/**
	 * Returns the correct class name for any specific column grid
	 *
	 * @since 1.0.0
	 * @param string $col
	 *
	 * @return string
	 */
	public static function grid_class( $col = '4' ) : string {
		return esc_attr( apply_filters( 'smart/grid_class', 'span_1_of_'. $col ) );
	}
}

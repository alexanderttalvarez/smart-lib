<?php
/**
 * You can enable/disable this feature in app/setup.php:
 * add_theme_support('smart-clean-hooks');
 *
 * @package    WordPress
 * @subpackage Smart
 * @since      1.0.0
 */

namespace Kec\Smart\Modules\Module\Clean;

use Kec\Smart\Singleton;

/**
 * CleanUp Class
 *
 * @since 1.0.0
 */
final class Hooks {
    use Singleton;

    /**
     * Initialize hooks
     */
    private function init() {
        if ( is_admin() ) {
            $this->admin_hooks();
        } else {
            $this->public_hooks();
        }

        $this->common_hooks();
    }

    /**
     * Remove empty p tags from WordPress posts
     *
     * @param string $content Content HTML.
     *
     * @return string
     */
    public function remove_empty_p( $content ) : string {
        // clean up p tags around block elements
        $content = preg_replace(
            [
                '#<p>\s*<(div|aside|section|article|header|footer)#',
                '#</(div|aside|section|article|header|footer)>\s*</p>#',
                '#</(div|aside|section|article|header|footer)>\s*<br ?/?>#',
                '#<(div|aside|section|article|header|footer)(.*?)>\s*</p>#',
                '#<p>\s*</(div|aside|section|article|header|footer)#',
            ],
            [
                '<$1',
                '</$1>',
                '</$1>',
                '<$1$2>',
                '</$1',
            ],
            $content
        );

        return preg_replace( '#<p>(\s|&nbsp;)*+(<br\s*/*>)*(\s|&nbsp;)*</p>#i', '', $content );
    }

    /**
     * Clean up language_attributes() used in <html> tag
     *
     * Remove dir="ltr"
     *
     * @since 1.0.0
     *
     * @return string
     */
    public function language_attributes() : string {
        $attributes = [];

        if ( is_rtl() ) {
            $attributes[] = 'dir="rtl"';
        }

        $lang = get_bloginfo( 'language' );

        if ( $lang ) {
            $attributes[] = "lang=\"$lang\"";
        }

        $output = implode( ' ', $attributes );
        $output = apply_filters( 'smart/language_attributes', $output );

        return $output;
    }

    /**
     * Clean up output of stylesheet <link> tags
     *
     * @since 1.0.0
     *
     * @param string $input Input string.
     *
     * @return string
     */
    public function clean_style_tag( $input ) : string {

        // phpcs:disable
        preg_match_all( "!<link rel='stylesheet'\s?(id='[^']+')?\s+href='(.*)' type='text/css' media='(.*)' />!", $input, $matches );

        if ( empty( $matches[2] ) ) {
            return $input;
        }

        // Only display media if it is meaningful
        $media = '' !== $matches[3][0] && 'all' !== $matches[3][0] ? ' media="' . $matches[3][0] . '"' : '';

        return '<link ' . $matches[1][0] . ' rel="stylesheet" href="' . $matches[2][0] . '"' . $media . '>' . "\n";
        // phpcs:enable
    }

    /**
     * Clean up output of <script> tags
     *
     * @since 1.0.0
     *
     * @param string $input Input string.
     *
     * @return mixed
     */
    public function clean_script_tag( $input ) {
        $input = str_replace( "type='text/javascript' ", '', $input );

        return str_replace( "'", '"', $input );
    }

    /**
     * Remove body_class() classes
     *
     * @since 1.0.0
     *
     * @param array $classes Current classes.
     *
     * @return array
     */
    public function body_class( $classes ) : array {

        // Remove unnecessary classes
        $home_id_class  = 'page-id-' . get_option( 'page_on_front' );
        $remove_classes = [
            'page-template-default',
            $home_id_class,
        ];

        $classes = array_diff( $classes, $remove_classes );

        return $classes;
    }

    /**
     * Remove unnecessary self-closing tags
     *
     * @since 1.0.0
     *
     * @param string $input Input string.
     *
     * @return string
     */
    public function remove_self_closing_tags( $input ) : string {
        return str_replace( ' />', '>', $input );
    }

    /**
     * Don't return the default description in the RSS feed if it hasn't been changed
     *
     * @since 1.0.0
     *
     * @param string $bloginfo Blog description.
     *
     * @return string
     */
    public function remove_default_description( $bloginfo ) : string {
        $default_tagline = __( 'Just another WordPress site' );

        return ( $bloginfo === $default_tagline ) ? '' : $bloginfo;
    }

    /**
     * Remove jQuery Migrate script from the jQuery bundle only in front end.
     *
     * @since 1.0.0
     *
     * @param \WP_Scripts $scripts \WP_Scripts object.
     */
    public function remove_jquery_migrate( $scripts ) {
        if ( isset( $scripts->registered['jquery'] ) && ! is_admin() ) {
            $script = $scripts->registered['jquery'];

            // Check whether the script has any dependencies
            if ( $script->deps ) {
                $script->deps = array_diff( $script->deps, [ 'jquery-migrate' ] );
            }
        }
    }

    /**
     * Public hooks
     */
    private function public_hooks() {
        /**
         * Remove unnecessary <link>'s
         * Remove inline CSS and JS from WP emoji support
         * Remove inline CSS used by Recent Comments widget
         * Remove inline CSS used by posts with galleries
         * Remove self-closing tag
         */
        add_action( 'wp_head', 'ob_start', 1, 0 );
        add_action(
            'wp_head',
            function () {
                $pattern = '/.*' . preg_quote( esc_url( get_feed_link( 'comments_' . get_default_feed() ) ), '/' ) . '.*[\r\n]+/';
                echo preg_replace( $pattern, '', ob_get_clean() ); // WPCS: XSS OK
            }, 3, 0
        );

        // remove really simple discovery link
        remove_action( 'wp_head', 'rsd_link' );

        // remove wlwmanifest.xml (needed to support windows live writer)
        remove_action( 'wp_head', 'wlwmanifest_link' );

        // remove rss feed and exta feed links
        // (make sure you add them in yourself if you are using as RSS service
        remove_action( 'wp_head', 'feed_links', 2 );
        remove_action( 'wp_head', 'feed_links_extra', 3 );

        // remove the next and previous post links
        remove_action( 'wp_head', 'adjacent_posts_rel_link', 10 );
        remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10 );

        // remove the shortlink url from header
        remove_action( 'wp_head', 'wp_shortlink_wp_head', 10 );
        remove_action( 'template_redirect', 'wp_shortlink_header', 11 );

        // remove wordpress generator version
        remove_action( 'wp_head', 'wp_generator' );

        // Remove the annoying:
        // <style type="text/css">.recentcomments a{display:inline !important;padding:0 !important;margin:0 !important;}</style>
        // added in the header
        add_filter( 'show_recent_comments_widget_style', '__return_false' );

        // remove s.w.org dns-prefetch
        remove_action( 'wp_head', 'wp_resource_hints', 2 );

        // remove default gallery style
        add_filter( 'use_default_gallery_style', '__return_false' );

        // Remove duplicate ids
        add_filter( 'nav_menu_item_id', '__return_false' );

        remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
        remove_action( 'wp_print_styles', 'print_emoji_styles' );
        remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
        remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
        remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );

        add_filter( 'emoji_svg_url', '__return_false' );
    }

    /**
     * Admin hooks
     */
    private function admin_hooks() {
        remove_action( 'admin_print_styles', 'print_emoji_styles' );
        remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
        remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
        add_filter(
            'tiny_mce_plugins',
            function ( $plugins ) {
                if ( \is_array( $plugins ) ) {
                    return array_diff( $plugins, [ 'wpemoji' ] );
                }

                return [];
            }
        );

        // Slow default heartbeat
        add_filter(
            'heartbeat_settings',
            function ( $settings ) {
                $settings['interval'] = 60;

                return $settings;
            }
        );
    }

    /**
     * Common hooks
     */
    private function common_hooks() {
        /**
         * Hide or create new menus and items in the admin bar.
         * Indentation shows sub-items.
         *
         * @link https://codex.wordpress.org/Class_Reference/WP_Admin_Bar/add_menu
         */
        add_action(
            'wp_before_admin_bar_render',
            function () {
                global $wp_admin_bar;

                /* @var \WP_Admin_Bar $wp_admin_bar */
                $wp_admin_bar->remove_node( 'wp-logo' );          // Remove the WordPress logo
                $wp_admin_bar->remove_node( 'about' );            // Remove the about WordPress link
                $wp_admin_bar->remove_node( 'wporg' );            // Remove the about WordPress link
                $wp_admin_bar->remove_node( 'documentation' );    // Remove the WordPress documentation link
                $wp_admin_bar->remove_node( 'support-forums' );   // Remove the support forums link
                $wp_admin_bar->remove_node( 'feedback' );         // Remove the feedback link

                $wp_admin_bar->remove_node( 'site-name' );        // Remove the site name menu
                $wp_admin_bar->remove_node( 'view-site' );        // Remove the view site link
                $wp_admin_bar->remove_node( 'dashboard' );        // Remove the dashboard link
                $wp_admin_bar->remove_node( 'menus' );            // Remove the menus link

                $wp_admin_bar->remove_node( 'updates' );          // Remove the updates link
                $wp_admin_bar->remove_node( 'comments' );         // Remove the comments link

                $wp_admin_bar->remove_node( 'new-content' );      // Remove the content link
                $wp_admin_bar->remove_node( 'new-post' );         // Remove the new post link
                $wp_admin_bar->remove_node( 'new-media' );        // Remove the new media link
                $wp_admin_bar->remove_node( 'new-page' );         // Remove the new page link
                $wp_admin_bar->remove_node( 'new-user' );         // Remove the new user link

                // $wp_admin_bar->remove_node( 'edit' );             // Remove the edit link
                // $wp_admin_bar->remove_node( 'my-account' );       // Remove the user details tab
                $wp_admin_bar->remove_node( 'search' );           // Remove the search tab
            }, 999
        ); // Needs to have low priority

        /** Remove the capital_P_dangit filter */
        foreach ( [ 'the_content', 'the_title', 'wp_title', 'comment_text' ] as $filter ) {
            $priority = has_filter( $filter, 'capital_P_dangit' );
            if ( false !== $priority ) {
                remove_filter( $filter, 'capital_P_dangit', $priority );
            }
        }

	    /** Custom Login Error Message */
	    add_filter( 'login_errors',  function () {
		    return __( 'Oops! Incorrect input', 'smart' );
	    } );

	    /** Remove the WordPress version from RSS feeds */
	    add_filter( 'the_generator', '__return_false' );

	    /** Disable all XML-RPC methods requiring authentication */
	    add_filter( 'xmlrpc_enabled', '__return_false' );

	    /** Remove empty p tags from WordPress posts */
        add_filter( 'the_content', [ $this, 'remove_empty_p' ], 20, 1 );

        /** Clean up language_attributes() used in <html> tag */
        add_filter( 'language_attributes', [ $this, 'language_attributes' ] );

        /** Clean up output of stylesheet <link> tags */
        add_filter( 'style_loader_tag', [ $this, 'clean_style_tag' ] );

        /** Clean up output of <script> tags */
        add_filter( 'script_loader_tag', [ $this, 'clean_script_tag' ] );

        /** Remove body_class() classes */
        add_filter( 'body_class', [ $this, 'body_class' ] );

        /** Remove unnecessary self-closing tags */
        add_filter( 'get_avatar', [ $this, 'remove_self_closing_tags' ] ); // <img />
        add_filter( 'comment_id_fields', [ $this, 'remove_self_closing_tags' ] ); // <input />
        add_filter( 'post_thumbnail_html', [ $this, 'remove_self_closing_tags' ] ); // <img />

        /** Don't return the default description in the RSS feed if it hasn't been changed */
        add_filter( 'get_bloginfo_rss', [ $this, 'remove_default_description' ] );

        // Remove jQuery Migrate script from the jQuery bundle only in front end
        add_action( 'wp_default_scripts', [ $this, 'remove_jquery_migrate' ] );
    }
}

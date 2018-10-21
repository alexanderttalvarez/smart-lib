<?php
/**
 * Relative URLs
 *
 * WordPress likes to use absolute URLs on everything - let's clean that up.
 * Inspired by http://www.456bereastreet.com/archive/201010/how_to_make_wordpress_urls_root_relative/
 *
 * You can enable/disable this feature in app/setup.php:
 * add_theme_support('smart-relative-urls');
 *
 * @package    WordPress
 * @subpackage Smart
 * @since      1.0.0
 */

namespace Kec\Smart\Modules\Module\Relative;

use Kec\Smart\Singleton;
use Kec\Smart\Modules\Utils;

/**
 * Urls Class
 *
 * @since 1.0.0
 */
final class Urls {
    use Singleton;

    /**
     * Initialize hooks
     */
    private function init() {
        if ( isset( $_GET['sitemap'] ) || is_admin() || \in_array( $GLOBALS['pagenow'], [ 'wp-login.php', 'wp-register.php' ] ) ) {
            return;
        }

        $root_rel_filters = apply_filters(
            'alm_relative_url_filters', [
                'bloginfo_url',
                'the_permalink',
                'wp_list_pages',
                'wp_list_categories',
                'wp_get_attachment_url',
                'the_content_more_link',
                'the_tags',
                'get_pagenum_link',
                'get_comment_link',
                'month_link',
                'day_link',
                'year_link',
                'term_link',
                'the_author_posts_link',
                'script_loader_src',
                'style_loader_src',
                'theme_file_uri',
                'parent_theme_file_uri',
            ]
        );

        Utils::add_filters( $root_rel_filters, 'Kec\\Smart\\Modules\\Utils::relative_url' );

        add_filter(
            'wp_calculate_image_srcset',
            function ( $sources ) {
                foreach ( (array) $sources as $source => $src ) {
                    $sources[ $source ]['url'] = Utils::relative_url( $src['url'] );
                }

                return $sources;
            }
        );

        /**
         * Compatibility with The SEO Framework
         */
        add_action(
            'the_seo_framework_do_before_output',
            function () {
                remove_filter( 'wp_get_attachment_url', 'Kec\\Smart\\Modules\\Utils::relative_url' );
            }
        );

        add_action(
            'the_seo_framework_do_after_output',
            function () {
                add_filter( 'wp_get_attachment_url', 'Kec\\Smart\\Modules\\Utils::relative_url' );
            }
        );
    }
}

<?php
/**
 * Disable RSS feeds
 *
 * You can enable/disable this feature in app/setup.php:
 * add_theme_support('smart-disable-feeds');
 *
 * @package    WordPress
 * @subpackage Smart
 * @since      1.0.0
 */

namespace Kec\Smart\Modules\Module\Disable;

use Kec\Smart\Singleton;

/**
 * Feeds Class
 *
 * @since 1.0.0
 */
final class Feeds {
    use Singleton;

    /**
     * Initialize hooks
     */
    private function init() {
        add_action( 'do_feed', [ $this, 'disable_feed' ], 1 );
        add_action( 'do_feed_rdf', [ $this, 'disable_feed' ], 1 );
        add_action( 'do_feed_rss', [ $this, 'disable_feed' ], 1 );
        add_action( 'do_feed_rss2', [ $this, 'disable_feed' ], 1 );
        add_action( 'do_feed_atom', [ $this, 'disable_feed' ], 1 );
    }

    /**
     * Disable feed message
     */
    public function disable_feed() {
        // phpcs:disable
        wp_die(
            sprintf(
                /* Translators: %s site url */
                _x( 'No feed available, please visit our <a href="%s">homepage</a>!', 'user message', 'smart' ),
                get_bloginfo( 'url' )
            )
        );
        // phpcs:enable
    }
}

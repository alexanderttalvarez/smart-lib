<?php
/**
 * Google Analytics snippet from HTML5 Boilerplate
 *
 * Cookie domain is 'auto' configured. See: http://goo.gl/VUCHKM
 * You can enable/disable this feature in app/setup.php:
 * add_theme_support('smart-google-analytics', 'UA-XXXXX-Y', 'wp_footer');
 *
 * @package    WordPress
 * @subpackage Smart
 * @since      1.0.0
 */

namespace Kec\Smart\Modules\Module\Google;

use Kec\Smart\Singleton;
use Kec\Smart\Modules\Options;

/**
 * Google\Analytics Class
 *
 * @since 1.0.0
 */
final class Analytics {
    use Singleton;

    /**
     * Initialize hooks
     */
    private function init() {

        $hook = $this->options( 'hook' );

        add_action( $hook, [ $this, 'load_script' ], 20 );
    }

    /**
     * Load Google Analytics script
     *
     * - Only loads if UA is defined
     * - Only loads in production if WP_ENV is defined (disabled if WP_ENV is not defined)
     * - Only loads if current user can't manage_option
     * - Lastly it can be enabled by filter hook smart/load_ga
     * - When not enabled the script logs the ga calls to browser console
     */
    public function load_script() {
        $ga_id = $this->options( 'gaID' );

        if ( ! $ga_id || $ga_id === 'UA-XXXXX-Y' || ! is_allowed_cookie( '_ga' ) ) {
            return;
        }

        $load_ga = ( ! \defined( 'WP_ENV' ) || \WP_ENV === 'production' ) && ! current_user_can( 'manage_options' );
        $load_ga = apply_filters( 'smart/load_ga', $load_ga );

        // phpcs:disable
        ?>
        <script>
            <?php if ( $load_ga ) : ?>
            window.ga = window.ga || function () {
                (ga.q = ga.q || []).push(arguments)
            };
            ga.l = +new Date;
            <?php else : ?>
            (function (w, c, m, s) {
                w.ga = function () {
                    w.ga.q.push(arguments);
                    if (c['log']) { c.log(m + s.call(arguments)); }
                };
                w.ga.q = [];
                w.ga.l = +new Date;
            }(window, console, 'Google Analytics: ', [].slice));
            <?php endif; ?>

            ga('create', '<?php echo esc_attr( $ga_id ); ?>', 'auto');

            ga('send', {
                hitType: 'pageview',
                location: '<?php echo get_permalink();?>'
            });
        </script>
        <?php if ( $load_ga ) : ?>
            <script src="https://www.google-analytics.com/analytics.js" async defer></script>
        <?php
        endif;
        // phpcs:enable
    }

    /**
     * Script options
     *
     * @param string|null $option Option name.
     *
     * @return array|mixed
     */
    private function options( $option = null ) {
        static $options;
        if ( null === $options ) {
            $options         = Options::get_by_key( 'google-analytics' ) + [ '', 'wp_footer' ];
            $options['gaID'] = &$options[0];
            $options['hook'] = &$options[1];
        }

        return null === $option ? $options : $options[ $option ];
    }
}

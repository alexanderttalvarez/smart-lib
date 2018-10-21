<?php
/**
 * Google gtag.js snippet from HTML5 Boilerplate
 *
 * Cookie domain is 'auto' configured. See: http://goo.gl/VUCHKM
 * You can enable/disable this feature in app/setup.php:
 * add_theme_support('smart-google-gtag', 'UA-XXXXX-Y', 'wp_head');
 *
 * @package    WordPress
 * @subpackage Smart
 * @since      1.0.0
 */

namespace Kec\Smart\Modules\Module\Google;

use Kec\Smart\Singleton;
use Kec\Smart\Modules\Options;

/**
 * Google\Gtag Class
 *
 * @since 1.0.0
 */
final class Gtag {
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
     * - Lastly it can be enabled by filter hook smart/load_gtag
     * - When not enabled the script logs the ga calls to browser console
     */
    public function load_script() {
        $gtag_id = $this->options( 'gtagID' );

        if ( ! $gtag_id || $gtag_id === 'UA-XXXXX-Y' || ! is_allowed_cookie( '_ga' ) ) {
            return;
        }

        $load_gtag = ( ! \defined( 'WP_ENV' ) || \WP_ENV === 'production' ) && ! current_user_can( 'manage_options' );
        $load_gtag = apply_filters( 'smart/load_gtag', $load_gtag );

        // phpcs:disable
        ?>
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <?php if ( $load_gtag ) : ?>
            <script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo esc_attr( $gtag_id ); ?>"></script>
        <?php endif; ?>

        <script>
            window.dataLayer = window.dataLayer || [];

            <?php if ( $load_gtag ) : ?>
            function gtag(){dataLayer.push(arguments);}
            <?php else : ?>
            (function (w, c, m, s) {
                w.gtag = function () {
                    dataLayer.push(arguments);
                    if (c['log']) { c.log.apply(c, [m, s.call(arguments)]); }
                };
            }(window, console, 'Google Analytics (gtag.js): ', [].slice));
            <?php endif; ?>

            gtag('js', new Date());
            gtag('config', '<?php echo esc_attr( $gtag_id ); ?>');
        </script>
        <?php
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
        if ( $options === null ) {
            $options         = Options::get_by_key( 'google-gtag' ) + [ '', 'wp_head' ];
            $options['gtagID'] = &$options[0];
            $options['hook']   = &$options[1];
        }

        return $option === null ? $options : $options[ $option ];
    }
}

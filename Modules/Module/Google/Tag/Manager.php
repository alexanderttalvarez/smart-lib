<?php
/**
 * Google Tag Manager tools
 *
 * You can enable/disable this feature in app/setup.php:
 * add_theme_support('smart-google-tag-manager', 'UA-XXXXX-Y');
 *
 * @package    WordPress
 * @subpackage Smart
 * @since      1.0.0
 */

namespace Kec\Smart\Modules\Module\Google\Tag;

use Kec\Smart\Singleton;
use Kec\Smart\Modules\Options;

/**
 * Manager Class
 *
 * @since 1.0.0
 */
final class Manager {
    use Singleton;

    /**
     * The name to use for the dataLayer variable.
     *
     * @var string
     */
    private $data_layer_var;

    /**
     * Initialize hooks
     */
    private function init() {

        /**
         * Filter the dataLayer variable name. Tag manager allow for
         * custom variable names to avoid collisions and scope container events.
         */
        $this->data_layer_var = apply_filters( 'smart/gtm_data_layer_var', 'dataLayer' );

        $hook = $this->options( 'hook' );

        add_action( $hook, [ $this, 'load_script' ], 20 );
        add_action( 'alm_before_outer_wrap', [ $this, 'load_script' ], 20 );
    }

    /**
     * Outputs the gtm tag, place this immediately after the opening <body> tag
     *
     * - Only loads if UA is defined
     * - Only loads in production if WP_ENV is defined (disabled if WP_ENV is not defined)
     * - Only loads if current user can't manage_option
     * - Lastly it can be enabled by filter hook smart/load_gtm
     */
    public function load_script() {
        $gtm_id = $this->options( 'gtmID' );

        if ( ! $gtm_id || $gtm_id === 'GTM-123ABC' || ! is_allowed_cookie( '_ga' ) ) {
            return;
        }

        $load_gtm = ( ! \defined( 'WP_ENV' ) || \WP_ENV === 'production' ) && ! current_user_can( 'manage_options' );
        $load_gtm = apply_filters( 'smart/load_gtm', $load_gtm );

        if ( $load_gtm ) {
            $output = '';

            if ( doing_action( 'wp_head' ) ) {
                // If it's the head action output the JS and dataLayer.
                $output .= $this->data_layer();
                $tag    = '
			<!-- Google Tag Manager -->
			<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({\'gtm.start\':
			new Date().getTime(),event:\'gtm.js\'});var f=d.getElementsByTagName(s)[0],
			j=d.createElement(s),dl=l!=\'%2$s\'?\'&l=\'+l:\'\';j.async=true;j.src=
			\'https://www.googletagmanager.com/gtm.js?id=\'+i+dl;f.parentNode.insertBefore(j,f);
			})(window,document,\'script\',\'%2$s\',\'%1$s\');</script>
			<!-- End Google Tag Manager -->
			';
            } else {
                // If the tag is called directly or on another action output the noscript fallback.
                // This gives us back compat and noscript support in one go.
                $tag = '
			<!-- Google Tag Manager (noscript) -->
			<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=%1$s"
			height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
			<!-- End Google Tag Manager (noscript) -->
			';
            }

            if ( $gtm_id ) {
                $output .= sprintf( $tag, esc_attr( $gtm_id ), sanitize_key( $this->data_layer_var ) );
            }

            if ( is_multisite() ) {
                $net_id = $this->options( 'netID' );
                if ( $net_id ) {
                    $output .= sprintf( $tag, esc_attr( $net_id ), sanitize_key( $this->data_layer_var ) );
                }
            }

            // phpcs:disable
            echo $output;
            // phpcs:enable
        }
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
            $options          = Options::get_by_key( 'google-tag-manager' ) + [ '', '', 'wp_head' ];
            $options['gtmID'] = &$options[0];
            $options['netID'] = &$options[1];
            $options['hook']  = &$options[2];
        }

        return null === $option ? $options : $options[ $option ];
    }

    /**
     * Outputs the dataLayer object
     *
     * Use the below to add custom values to the dataLayer
     *
     * add_filter( 'smart/gtm_data_layer', function( $data ) {
     *     $data['my_var'] = 'hello';
     *     return $data;
     * } );
     *
     * @return mixed
     */
    public function data_layer() {
        /**
         * Filter the initial dataLayer variable data.
         *
         * @param array $data
         */
        $data = apply_filters( 'smart/gtm_data_layer', [] );

        if ( ! empty( $data ) ) {
            return sprintf(
                '<script>var %s = %s;</script>',
                sanitize_key( $this->data_layer_var ),
                wp_json_encode( [ $data ] )
            );
        }

        return '';
    }
}

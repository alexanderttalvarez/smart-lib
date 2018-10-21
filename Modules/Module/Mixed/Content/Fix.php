<?php
/**
 * Fixes http/https urls to avoid mixed content errors
 *
 * You can enable/disable this feature in app/setup.php:
 * add_theme_support('smart-mixed-content-fix');
 *
 * @package    WordPress
 * @subpackage Smart
 * @since      1.0.0
 */

namespace Kec\Smart\Modules\Module\Mixed\Content;

use Kec\Smart\Singleton;

/**
 * Fix Class
 *
 * @since 1.0.0
 */
final class Fix {
    use Singleton;

    /**
     * Initialize hooks
     */
    private function init() {

        /* Do not fix mixed content when call is coming from wp_api or from xmlrpc */
        if ( \defined( 'JSON_REQUEST' ) && JSON_REQUEST ) {
            return;
        }

        if ( \defined( 'XMLRPC_REQUEST' ) && XMLRPC_REQUEST ) {
            return;
        }

        /**
         * Take care with modifications to hooks here: hooks tend to differ between front and back-end.
         */
        if ( is_admin() ) {
            add_action( 'admin_init', [ $this, 'start_buffer' ], 100 );
        } else {
            add_action( 'init', [ $this, 'start_buffer' ] );
        }

        add_action( 'shutdown', [ $this, 'end_buffer' ], 999 );
    }

    /**
     * Apply the mixed content fixer.
     *
     * @since 1.0.0
     *
     * @param string $buffer Output buffer.
     *
     * @return mixed
     */
    public function filter_buffer( $buffer ) {
        $buffer = $this->replace_insecure_links( $buffer );

        return $buffer;
    }

    /**
     * Start buffering the output
     *
     * @since 1.0.0
     */
    public function start_buffer() {
        ob_start( [ $this, 'filter_buffer' ] );
    }

    /**
     * Flush the output buffer
     *
     * @since 1.0.0
     */
    public function end_buffer() {
        if ( ob_get_length() ) {
            ob_end_flush();
        }
    }

    /**
     * Creates an array of insecure links that should be https and an array of secure links to replace with
     *
     * @since  1.0.0
     * @return array
     */
    public function build_url_list() : array {
        $home         = str_replace( 'https://', 'http://', get_option( 'home' ) );
        $home_no_www  = str_replace( '://www.', '://', $home );
        $home_yes_www = str_replace( '://', '://www.', $home_no_www );

        // for the escaped version, we only replace the home_url, not it's www or non www counterpart, as it is most likely not used
        $escaped_home = str_replace( '/', '\\/', $home );

        return [
            $home_yes_www,
            $home_no_www,
            $escaped_home,
            "src='http://",
            'src="http://',
            "srcset='http://",
            'srcset="http://',
        ];
    }

    /**
     * Just before the page is sent to the visitor's browser, all home url links are replaced with https.
     *
     * @since  1.0.0
     *
     * @param string|array|null $str Output string.
     *
     * @return mixed
     */
    public function replace_insecure_links( $str ) {
        $search_array = apply_filters( 'smart/replace_url_args', $this->build_url_list() );
        $ssl_array    = str_replace( [ 'http://', 'http:\\/\\/' ], [ 'https://', 'https:\\/\\/' ], $search_array );

        // now replace these links
        $str = str_replace( $search_array, $ssl_array, $str );

        // replace all http links except hyperlinks
        // all tags with src attr are already fixed by str_replace
        $pattern = [
            '/url\([\'"]?\K(http:\/\/)(?=[^)]+)/i',
            '/<link [^>]*?href=[\'"]\K(http:\/\/)(?=[^\'"]+)/i',
            '/<meta property="og:image" [^>]*?content=[\'"]\K(http:\/\/)(?=[^\'"]+)/i',
            '/<form [^>]*?action=[\'"]\K(http:\/\/)(?=[^\'"]+)/i',
        ];

        $str = preg_replace( $pattern, 'https://', $str );
        $str = str_replace( '<body ', '<body data-mcf=1 ', $str );

        return apply_filters( 'smart/fixer_output', $str );
    }
}

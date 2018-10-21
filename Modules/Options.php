<?php
/**
 * Module Options
 *
 * @package    WordPress
 * @subpackage Smart
 * @since      1.0.0
 */

namespace Kec\Smart\Modules;

/**
 * Class Options
 *
 * @package Smart
 */
final class Options {

	/**
	 * Available modules
	 */
	const MODULES = [
		'clean-hooks'               => '\\Kec\\Smart\\Modules\\Module\\Clean\\Hooks',
		'disable-assets-versioning' => '\\Kec\\Smart\\Modules\\Module\\Disable\\Asset\\Versioning',
		'disable-feeds'             => '\\Kec\\Smart\\Modules\\Module\\Disable\\Feeds',
		'disable-json-api'          => '\\Kec\\Smart\\Modules\\Module\\Disable\\Json\\Api',
		'disable-trackbacks'        => '\\Kec\\Smart\\Modules\\Module\\Disable\\Trackbacks',
		'google-analytics'          => '\\Kec\\Smart\\Modules\\Module\\Google\\Analytics',
		'google-gtag'               => '\\Kec\\Smart\\Modules\\Module\\Google\\Gtag',
		'google-tag-manager'        => '\\Kec\\Smart\\Modules\\Module\\Google\\Tag\\Manager',
		'jquery-cdn'                => '\\Kec\\Smart\\Modules\\Module\\Jquery\\Cdn',
		'footer-scripts'            => '\\Kec\\Smart\\Modules\\Module\\Footer\\Scripts',
		'minify-html'               => '\\Kec\\Smart\\Modules\\Module\\Minify\\Html',
		'mixed-content-fix'         => '\\Kec\\Smart\\Modules\\Module\\Mixed\\Content\\Fix',
		'nav-walker'                => '\\Kec\\Smart\\Modules\\Module\\Nav\\Walker',
		'nice-search'               => '\\Kec\\Smart\\Modules\\Module\\Nice\\Search',
		'relative-urls'             => '\\Kec\\Smart\\Modules\\Module\\Relative\\Urls',
	];

	/**
     * Loaded modules
     *
     * @var array
     */
    private static $modules = [];

    /**
     * Module options
     *
     * @var array
     */
    private $options = [];

    /**
     * Initialize options
     *
     * @param string $module  Modules name.
     * @param mixed  $options Modules options.
     *
     * @return mixed
     */
    public static function init( $module, $options = [] ) {
        if ( ! isset( self::$modules[ $module ] ) ) {
            self::$modules[ $module ] = new static( $options );
        }

        return self::$modules[ $module ];
    }

    /**
     * Get options by array key
     *
     * @param string $key Key name.
     *
     * @return array
     */
    public static function get_by_key( $key ) : array {
        if ( array_key_exists( $key, self::MODULES ) ) {
            return self::get( 'smart-' . $key );
        }

        return [];
    }

    /**
     * Options getter
     *
     * @param string|array $module Module name.
     *
     * @return array
     */
    public static function get( $module ) : array {
        if ( isset( self::$modules[ $module ] ) ) {
            return self::$modules[ $module ]->options;
        }

        if ( strpos( $module, 'smart-' ) !== 0 ) {
            return self::get( 'smart-' . $module );
        }

        return [];
    }

    /**
     * Options setter
     *
     * @param array $options Options array.
     */
    public function set( $options ) {
        $this->options = $options;
    }

    /**
     * Options constructor.
     *
     * @param array $options Options array.
     */
    private function __construct( $options ) {
        $this->set( $options );
    }
}

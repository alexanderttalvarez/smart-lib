<?php
/**
 * Trait Kec\Smart\Contracts\EnumTrait
 *
 * @package Kec\Smart\Contracts
 */

namespace Kec\Smart\Contracts;

use ReflectionClass;

/**
 * Trait for an enum.
 *
 * @since 1.0.0
 */
trait EnumTrait {
    /**
     * List of constants.
     *
     * @since 1.0.0
     * @var array
     */
    protected static $const_list;

    /**
     * Gets all possible values as an array.
     *
     * @since 1.0.0
     *
     * @return array List of constants.
     * @throws \ReflectionException If the class does not exist.
     */
    public static function get_const_list() : array {
        if ( static::$const_list === null ) {
            $reflection        = new ReflectionClass( static::class );
            static::$const_list = array_values( $reflection->getConstants() );
        }

        return static::$const_list;
    }
}

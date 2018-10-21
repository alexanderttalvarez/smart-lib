<?php
/**
 * Interface Kec\Smart\Contracts\Enum
 *
 * @package Kec\Smart\Contracts
 */

namespace Kec\Smart\Contracts;

/**
 * Interface for an enum.
 *
 * @since 1.0.0
 */
interface Enum {
    /**
     * Gets all possible values as an array.
     *
     * @since 1.0.0
     *
     * @return array List of constants.
     */
    public static function get_const_list() : array;
}

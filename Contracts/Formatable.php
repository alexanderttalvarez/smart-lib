<?php
/**
 * Interface Kec\Smart\Contracts\Formatable
 *
 * @package Kec\Smart\Contracts
 */

namespace Kec\Smart\Contracts;

/**
 * Interface for a formatable.
 *
 * @since 1.0.0
 */
interface Formatable {
    /**
     * Formats the instance.
     *
     * @since 1.0.0
     *
     * @param int $flags Optional. Bitwise flags to adjust formatting. Default 0.
     *
     * @return mixed Formatted data.
     */
    public function format( int $flags = 0 );
}

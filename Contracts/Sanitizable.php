<?php
/**
 * Interface Kec\Smart\Contracts\Sanitizable
 *
 * @package Kec\Smart\Contracts
 */

namespace Kec\Smart\Contracts;

/**
 * Interface for a sanitizable.
 *
 * @since 1.0.0
 */
interface Sanitizable {
    /**
     * Sanitizes the instance.
     *
     * @since 1.0.0
     *
     * @return mixed Sanitized data.
     */
    public function sanitize();
}

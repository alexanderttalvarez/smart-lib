<?php
/**
 * Interface Kec\Smart\Contracts\Registerable
 *
 * @package Kec\Smart\Contracts
 */

namespace Kec\Smart\Contracts;

use Kec\Smart\Exception\RegistrationException;

/**
 * Interface for a registerable.
 *
 * @since 1.0.0
 */
interface Registerable {
    /**
     * Register the instance.
     *
     * @since 1.0.0
     *
     * @throws RegistrationException Thrown if registration fails.
     */
    public function register();
}

<?php
/**
 * Interface Kec\Smart\Contracts\Validatable
 *
 * @package Kec\Smart\Contracts
 */

namespace Kec\Smart\Contracts;

use Kec\Smart\Exception\ValidationException;

/**
 * Interface for a validatable.
 *
 * @since 1.0.0
 */
interface Validatable
{
    /**
     * Validates the instance.
     *
     * @since 1.0.0
     *
     * @throws ValidationException Thrown if validation fails.
     */
    public function validate();
}

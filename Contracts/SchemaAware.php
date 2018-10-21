<?php
/**
 * Interface Kec\Smart\Contracts\SchemaAware
 *
 * @package Kec\Smart\Contracts
 */

namespace Kec\Smart\Contracts;

/**
 * Interface for a class that uses a schema.
 *
 * @since 1.0.0
 */
interface SchemaAware
{
    /**
     * Gets the schema that defines behavior of the instance.
     *
     * @since 1.0.0
     *
     * @return Schema The schema for the instance.
     */
    public function get_schema() : Schema;
}

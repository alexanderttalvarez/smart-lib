<?php
/**
 * Trait Kec\Smart\Contracts\SchemaAwareTrait
 *
 * @package Kec\Smart\Contracts
 */

namespace Kec\Smart\Contracts;

/**
 * Trait for a class that uses a schema
 *
 * @since 1.0.0
 */
trait SchemaAwareTrait {
    /**
     * The schema for the instance.
     *
     * @since 1.0.0
     * @var Schema
     */
    protected $schema;

    /**
     * Gets the schema that defines behavior of the instance.
     *
     * @since 1.0.0
     *
     * @return Schema The schema for the instance.
     */
    public function get_schema() : Schema {
        return $this->schema;
    }

    /**
     * Sets the schema to define behavior of the instance.
     *
     * @since 1.0.0
     *
     * @param Schema $schema The schema for the instance.
     */
    protected function set_schema( Schema $schema ) {
        $this->schema = $schema;
    }
}

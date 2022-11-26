<?php

namespace App\Helper\Traits;

use stdClass;

/**
 * stdClass object -> object(using set method) mapping
 *
 * Trait StdObjectMapper
 */
trait StdObjectMapper
{
    use ObjectTrait;

    /**
     * mapping with object which has a snake_case naming
     *
     * @param stdClass $obj
     * @param bool $objSnakeCase
     */
    public function map(stdClass $obj, bool $objSnakeCase = true)
    {
        $this->fillByObj($this, get_object_vars($this), $obj, $objSnakeCase);
    }

    /**
     * mapping with \stdClass object which has a snake_case naming
     *
     * @param stdClass $obj
     */
    public function snakeMap(stdClass $obj)
    {
        $this->map($obj);
    }

    /**
     * mapping with \stdClass object which has a camelCase naming
     *
     * @param stdClass $obj
     */
    public function camelMap(stdClass $obj)
    {
        $this->map($obj, false);
    }
}

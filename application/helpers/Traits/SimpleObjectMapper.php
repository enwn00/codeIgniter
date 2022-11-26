<?php

namespace App\Helper\Traits;

use App\Helper\CollectionHelper;

class SimpleObjectMapper
{
    public static function mapEach($data, $type, $snakeCase = true): array
    {
        $results = array();
        foreach ($data as $v) {
            $results[] = self::map($v, $type, $snakeCase);
        }
        return $results;
    }

    public static function map($data, $type, $snakeCase = true) {
        if ($data === null) return null;

        $result = new $type();

        $result->map($data, $snakeCase);

        return $result;
    }

    public static function mapEachToCollection($data, $type, $snakeCase = true): CollectionHelper
    {
        $results = new CollectionHelper($type);
        foreach ($data as $value) {
            $results->push(self::map($value, $type, $snakeCase));
        }
        return $results;
    }
}

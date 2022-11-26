<?php

namespace App\Helper\Traits;

use App\Helper\StringHelper;

trait ArrayTrait
{
    public function toSnakeArray(): array
    {
        $data = [];
        foreach (get_object_vars($this) as $key => $val) {
            $key = StringHelper::snakeCase($key);
            $data[$key] = $val;
        }
        return $data;
    }

    public function toArray(): array
    {
        $data = [];
        foreach (get_object_vars($this) as $key => $val) {
            $data[$key] = $val;
        }
        return $data;
    }
}


<?php

namespace App\Helper\Traits;

use App\Helper\StringHelper;

trait ObjectTrait
{
    /**
     * fillByObj will set the member value of the caller with the member value of stdClass
     *
     * @param $caller
     * @param array $vars
     * @param \stdClass $obj
     * @param bool $objSnakeCase
     */
    public function fillByObj($caller, array $vars, \stdClass $obj, bool $objSnakeCase = true)
    {
        foreach ($vars as $key => $val) {
            if ($objSnakeCase) {
                $objKey = StringHelper::snakeCase($key);
            } else {
                $objKey = StringHelper::camelCase($key);
            }

            if (!isset($obj->{$objKey})) {
                continue;
            }

            $method = join(["set", StringHelper::camelCase($objKey, true)], "");
            if (!method_exists($caller, $method)) {
                continue;
            }

            call_user_func_array(array($caller, $method), [$obj->{$objKey}]);
        }
    }
}

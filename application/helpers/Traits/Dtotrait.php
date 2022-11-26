<?php

namespace App\Helper\Traits;

use App\Helper\StringHelper;

trait DtoTrait
{
    public function pull($obj)
    {
        foreach (get_object_vars($this) as $objKey => $val) {
            $method = join(["set", StringHelper::camelCase($objKey, true)], "");
            if (!method_exists($obj, $method)) {
                continue;
            }

            call_user_func_array(array($this, $method), [$obj->{$objKey}]);
        }

        return $this;
    }
}

<?php

namespace App\Controller;

class PriceCalculator
{
//    public function total($items)
//    {
//        $total = 0;
//        foreach ($items as $item) {
//            $total += $item['price'];
//        }
//        return $total;
//    }

    // Refactoring
    public function total($items)
    {
        return array_reduce($items, function ($carry, $item) {
            return $carry + $item['price'];
        }, 0);
    }
}

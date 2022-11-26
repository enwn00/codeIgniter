<?php

namespace App\Helper;

use InvalidArgumentException;
use TypeError;

class CollectionHelper
{
    protected $type = null;
    protected $collection = [];

    /**
     * @param $type
     */
    public function __construct($type)
    {
        $this->type = $type;
    }

    /**
     * @param $item
     */
    public function push($item)
    {
        if (!$item instanceof $this->type) {
            throw new TypeError("not same instance in CollectionHelper class");
        }

        $this->collection[] = $item;
    }

    /**
     * @return array
     */
    public function toSnakeArray(): array
    {
        $results = array();
        foreach ($this->collection as $key => $val) {
            $results[$key] = $val->toSnakeArray();
        }
        return $results;
    }

    public function shuffle()
    {
        shuffle($this->collection);
    }

    /**
     * @param int $length
     */
    public function slice(int $length)
    {
        $this->collection = array_slice($this->collection, 0, $length);
    }

    /**
     * @param int $key
     */
    public function unset(int $key){
        unset($this->collection[$key]);
    }

    /**
     * @param $item
     */
    public function unshift($item){
        if (!$item instanceof $this->type) {
            throw new TypeError("not same instance in CollectionHelper class");
        }

        array_unshift($this->collection, $item);
    }

    /**
     * @return int
     */
    public function count(): int
    {
        return count($this->collection);
    }

    /**
     * @param int $flags
     */
    public function unique(int $flags = SORT_STRING){
        $this->collection = array_unique($this->collection, $flags);
    }

    public function arrayValues(){
        $this->collection = array_values($this->collection);
    }


    /**
     * @param CollectionHelper $paramItems
     */
//    public function diff(CollectionHelper $paramItems)
//    {
//        $start = $this->get_time();
//
//        foreach ($paramItems->toSnakeArray() as $paramItem) {
//            foreach ($this->toSnakeArray() as $rowKey => $item) {
//                if ($paramItem == $item){
//                    $this->unset($rowKey);
//                }
//            }
//        }
//
//        $this->arrayValues();
//
//        $end = $this->get_time();
//
//        $time = $end - $start;
//
//        debugPrint($time);
//
//    }

    /**
     * @param CollectionHelper $paramItems
     */
    public function diff(CollectionHelper $paramItems)
    {
        $paramItemsArray = $paramItems->toSnakeArray();
        $findArray = array_filter($this->toSnakeArray(), function($var) use($paramItemsArray) {
            return in_array($var, $paramItemsArray);
        });

        foreach ($findArray as $key => $val) {
            $this->unset($key);
        }

        $this->arrayValues();
    }

    /**
     * @param $item
     */
    public function fixedTop($item)
    {
        if (empty($item))
            return;

        if (!$item instanceof $this->type) {
            throw new TypeError("not same instance in CollectionHelper class");
        }

        $this->unshift($item);
        $this->unique(SORT_REGULAR);
        $this->arrayValues();
    }

    /**
     * @param $method
     * @return bool
     */
    public function isExistsMethodInDto($method): bool
    {
        if (method_exists($this->type, $method)) {
            return true;
        }

        throw new InvalidArgumentException("[$method] not supported in {$this->type} Dto.");
    }

    /**
     * @param array $needle
     * @param array $compare
     */
    public function filterTheseValues(array $needle, $compare = array())
    {
        $result = [];
        foreach ($this->collection as $rowKey => $rowDto) {
            $test = $this->hasTheseValues($rowDto, $needle, $compare);
            if ($test) $result[$rowKey] = $rowDto;
        }

        unset($this->collection);
        $this->collection = $result;
    }

    /**
     * @param array $needle
     * @param array $compare
     */
    public function removeTheseValues(array $needle, $compare = array())
    {
        foreach ($this->collection as $rowKey => $rowDto) {
            if ($this->hasTheseValues($rowDto, $needle, $compare)) {
                $this->unset($rowKey);
            }
        }
    }

    /**
     * @param $item
     * @param array $needle
     * @param array $compare
     * @return bool
     */
    private function hasTheseValues($item, array $needle, $compare = array()): bool
    {
        if (!$item instanceof $this->type) {
            throw new TypeError("not same instance in CollectionHelper class");
        }

        $isMatched = true;

        foreach ($needle as $colKey => $colVal) {
            $method = 'get' . $colKey;
            if (!$this->isExistsMethodInDto($method)){
                $isMatched = false;
                break;
            }

            if (!empty($compare)) {
                switch ($compare[$colKey]) {
                    case '==':  $compareResult = ($item->$method() == $colVal); break;
                    case '!=':  $compareResult = ($item->$method() != $colVal); break;
                    case '>':   $compareResult = ($item->$method() > $colVal);  break;
                    case '<':   $compareResult = ($item->$method() < $colVal);  break;
                    case '>=': 	$compareResult = ($item->$method() >= $colVal); break;
                    case '<=': 	$compareResult = ($item->$method() <= $colVal); break;
                    default:    $compareResult = ($item->$method() == $colVal); break;
                }

                if (!$compareResult) {
                    $isMatched = false;
                    break;
                }
            } else {
                if ($item->$method() != $colVal) {
                    $isMatched = false;
                    break;
                }
            }
        }

        return $isMatched;
    }

    function get_time() { $t=explode(' ',microtime()); return (float)$t[0]+(float)$t[1]; }
}

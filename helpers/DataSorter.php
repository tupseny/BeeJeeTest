<?php


class DataSorter
{
    const ASC_MODE = 1;
    const DESC_MODE = -1;

    private  $original;

    function __construct($data)
    {
        $this->original = $data;
    }

    function sort($key, $mode = self::ASC_MODE)
    {
        switch ($mode) {
            case self::DESC_MODE:
            case self::ASC_MODE:
                return $this->_sort($key, $mode);
            default:
                throw new Exception('invalid sort mode', MyExceptions::INTERNAL_ERROR);
        }
    }

    private function _sort($key, $mode)
    {
        $sorted_array = array_values($this->original);
        usort($sorted_array, $this->_cmp($key, $mode));
        return $sorted_array;
    }


    /**
     * Comparing function
     * @param $key - Field name to sort
     * @param $mode - true - asc, false - desc
     * @return Closure
     */
    private function _cmp($key, int $mode)
    {
        return function ($a, $b) use ($key, $mode) {
            if (!isset($a[$key]) or !isset($b[$key])){
                throw new Exception('no such key', MyExceptions::REQUEST_INVALID_FIELD_VALUE);
            }

            if ($mode) {
                return $mode * strcasecmp($a[$key], $b[$key]);
            } else {
                return $mode * strcasecmp($b[$key], $a[$key]);
            }
        };
    }
}
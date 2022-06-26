<?php


namespace Ml\Fuzzy\Operators\TNorm;


class Min
{
    public static function compute($r,$l)
    {
        return min($r, $l);
    }
}
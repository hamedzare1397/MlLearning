<?php


namespace Ml\Fuzzy\Operators\TNorm;


use Illuminate\Support\Collection;

class Min
{
    public static function compute($r,$l=null)
    {
        if (is_null($l)) {
            return $r->min();
        }
        return min($r, $l);
    }
}

<?php


namespace Ml\Fuzzy\Operators\TNorm;


use Illuminate\Support\Collection;

class DotProduct
{
    public static function compute($r,$l=null)
    {
        if (is_null($l)) {
            $temp = 1;
            foreach ($r as $val) {
                $temp = $val * $temp;
            }
            $r = $temp;
        }
        else{
            $r = $r * $l;
        }
        return $r;
    }
}

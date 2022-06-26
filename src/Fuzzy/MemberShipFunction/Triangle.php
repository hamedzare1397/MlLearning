<?php

namespace Ml\Fuzzy\MemberShipFunction;

class Triangle extends MemberShipFunctions
{
    public function __construct(protected $a,protected $b,protected $c){}

    public function handle($x)
    {
        if ($x<=$this->a)
            return 0;
        elseif ($this->a<=$x and $x<= $this->b) {
            return (($x - $this->a) / ($this->b - $this->a));
        }
        elseif ($this->b<=$x and $x<= $this->c) {
            return (($this->c - $x) / ($this->c - $this->b));
        }
        elseif ($this->c<=$x) {
            return 0;
        }
        return null;
    }
}
<?php

namespace Ml\Fuzzy\MemberShipFunction;

class Trapezoidal extends MemberShipFunctions
{
    public function __construct(protected $a,protected $b,protected $c,protected $d)
    {

    }
    public function handle($x)
    {
        if ($this->a<=0) {
            return 0;
        }
        elseif($this->a<=$x and $x<= $this->b)
        {
            return (($x - $this->a) / ($this->b - $this->a));
        }

        else if ($this->b<=$x and $x<= $this->c) {
            return 1;
        }
        elseif ($this->c<=$x and $x<= $this->d) {
            return (($this->d - $x) / ($this->d - $this->c));
        }
        elseif ($this->d<=$x){
            return 0;
        }
        return null;
    }
}
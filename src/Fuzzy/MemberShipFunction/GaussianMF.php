<?php

namespace Ml\Fuzzy\MemberShipFunction;

class GaussianMF extends MemberShipFunctions
{
    public function __construct(protected $sigma, protected $c)
    {

    }
    public function handle($x)
    {
        return exp(-0.5*pow((($x-$this->c)/$this->sigma),2));
    }
}
<?php


namespace Ml\Fuzzy\Datasets;


use Ml\Fuzzy\Fuzzifier\FuzzyTransformer;

class FuzzyLabeled extends \Rubix\ML\Datasets\Labeled
{
    protected $isFuzzyNormal=false;

    public function transformToFuzzyRange()
    {
        $this->isFuzzyNormal = true;
        return $this->apply(new FuzzyTransformer());
    }

}

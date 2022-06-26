<?php


namespace Ml\Fuzzy;


use Ml\Fuzzy\Fuzzifier\Fuzzifier;

class FuzzyInferenceSystem
{
    protected $inputs;
    protected $rules;
    protected $inferenceSystem;

    public function __construct($inputs,$inferenceSystem=null,$rules=null)
    {
        $this->inputs = $inputs;
        $this->fuzzyRangeData = $inferenceSystem;
        $this->rules = $rules;
    }

    /**
     * @param mixed $inferenceSystem
     */
    public function setInferenceSystem($inferenceSystem)
    {
        $this->inferenceSystem = $inferenceSystem;
    }




}
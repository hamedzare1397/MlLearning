<?php


namespace Ml\Fuzzy\Models;


use Illuminate\Support\Collection;
use Ml\Fuzzy\Fuzzifier\Fuzzifier;
use Ml\Fuzzy\Fuzzifier\FuzzyTransformer;
use Ml\Fuzzy\MemberShipFunction\Triangle;
use Ml\Fuzzy\Rule\Rule;
use Rubix\ML\Datasets\Dataset;
use Rubix\ML\Datasets\Labeled;
use function Amp\Promise\rethrow;

class MamdaniModel
{
    protected $input;
    public function __construct(protected $samples=null, protected $rules=null){}

    public function getRules()
    {
        return $this->rules;
    }

    public function setInput($samples)
    {
        $this->samples = $samples;
    }

    public function addRules($rule)
    {
        if (is_null($this->rules)) {
            $this->rules = collect();
        }
        $this->rules->add($rule);
    }

    public function fuzzification(Dataset $input)
    {
        $this->input = $input->apply(new FuzzyTransformer());
        return $input;
    }

    public function learn(Labeled $samples)
    {
        $this->samples = $samples;//->apply(new FuzzyTransformer());
        $info = $this->samples->describeByLabel();

        foreach ($info as $label=>$attrs) {
            $rule = new Rule($label);
            foreach ($attrs as $attr => $data) {
                $min = $data['min'] > .05 ? $data['min'] - .05 : 0;
                $max = $data['max'] < .95 ? $data['max'] + .05 : 1;
                $mf = new Triangle($min, $data['mean'], $max);
                $rule->addMemberShip($mf);
            }
            $this->addRules($rule);
        }
    }

    public function evaluation($input)
    {
        $temp = collect();
        /** @var Rule $rule */
        foreach ($this->rules as $rule) {
            $temp->add($rule->apply($input));
        }
        return $this->aggregation($temp);
    }


    /** @param Collection $firing */
    public function aggregation($firing)
    {
        $max = null;
        foreach ($firing as $item) {
            if (is_null($max))
                $max = $item;
            else if ($max->getFiring()<=$item->getFiring()){
                $max = $item;
            }
        }
        return $max;
    }


    public function defuzzification()
    {

    }
}

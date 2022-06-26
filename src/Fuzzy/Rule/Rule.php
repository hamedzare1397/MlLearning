<?php


namespace Ml\Fuzzy\Rule;


use Ml\Fuzzy\MemberShipFunction\GaussianMF;
use Ml\Fuzzy\Operators\IOperator;
use Ml\Fuzzy\Operators\TNorm\TNorm;

class Rule implements IRule
{
    protected $antecedents = null;
    protected $consequent = null;
    protected $description = "";
    protected $mf = null;
    public function getAntecedent()
    {
        return $this->antecedents;
    }

    public function getConsequent()
    {
        return $this->consequent;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description=$description;
    }

    public function thisAnd($rule ,$operator = null): IRule
    {
        if (is_null($operator)) {
            $operator = new TNorm(TNorm::TNORM_MIN);
        }
        return $operator->handle($this->getAntecedent(),$rule);
    }

    public function setMemberShipFunction(MemberShipFunction $mf=null)
    {
        if (is_null($mf)) {
            $mf = new GaussianMF(1, .5);
        }
        $this->mf = $mf;
    }
}
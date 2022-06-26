<?php


namespace Ml\Fuzzy\Rule;


use Ml\Fuzzy\Operators\IOperator;

interface IRule
{
    public function getAntecedent();

    public function getConsequent();

    public function getDescription();

    public function thisAnd(IRule $rule,IOperator $operator=null):IRule;

    public function thisOr(IRule $rule,IOperator $operator=null):IRule;

    public function setMemberShipFunction(MemberShipFunction $mf);
}
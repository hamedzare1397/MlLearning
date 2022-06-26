<?php


namespace Ml\Fuzzy\Operators\TNorm;


use Ml\Fuzzy\Operators\IOperator;

class TNorm implements IOperator
{
    const TNORM_MIN = Min::class;
    protected $rules=[];
    protected $operand;

    public function __construct($operand=self::TNORM_MIN)
    {
        $this->operand = $operand;
    }

    public function handle($ri,$li)
    {
        $result = collect();
        foreach ($ri as $rKey=>$rValue) {
            $result=$this->operand::compute($rValue, $li[$rKey]);
        }
        return $result;
    }
}
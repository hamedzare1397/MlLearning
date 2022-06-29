<?php


namespace Ml\Fuzzy\Operators\TNorm;


use Illuminate\Support\Collection;
use Ml\Fuzzy\Operators\IOperator;

class TNorm implements IOperator
{
    const TNORM_MIN = Min::class;
    const DotProduct = DotProduct::class;
    protected $ri;
    protected $operand;

    public function __construct($operand=self::TNORM_MIN)
    {
        /** @var Min operand */
        $this->operand = new $operand();
    }

    public function handle($li)
    {
        if (get_class($li)===Collection::class) {
            /** @var Collection $li */
            $this->ri=$this->operand->compute($li);
        }
        else if (is_null($this->ri)) {
            $this->ri = $li;
        }
        else{
            $this->ri=$this->operand->compute($this->ri, $li);
        }
        return $this->ri;
    }
}

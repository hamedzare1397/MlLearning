<?php


namespace Ml\Fuzzy\Rule;


use Illuminate\Support\Collection;
use Ml\Fuzzy\MemberShipFunction\GaussianMF;
use Ml\Fuzzy\MemberShipFunction\MemberShipFunctions;
use Ml\Fuzzy\Operators\IOperator;
use Ml\Fuzzy\Operators\TNorm\TNorm;

class Rule
{
    protected $memberShips;
    protected $y;
    protected $firing;

    /**
     * @return mixed
     */
    public function getFiring()
    {
        return $this->firing;
    }
    public function __construct($label)
    {
        $this->y = $label;
        $this->memberShips=new Collection();
    }

    public function addMemberShip(MemberShipFunctions $memberShip)
    {
        $this->memberShips->add($memberShip);
    }

    public function apply($X)
    {
        $temp = collect();
        $operand = new TNorm(TNorm::DotProduct);
        /**
         * @var  $index
         * @var MemberShipFunctions $memberShip
         */
        foreach ($this->memberShips as $index=>$memberShip) {
            if(count($X)==$index+1)
                continue;
            $result = $memberShip->handle($X[$index]);
            $temp->add($result);
        }
        $this->firing=$operand->handle($temp);
        return $this;
    }

    public function getLabel()
    {
        return $this->y;
    }
}

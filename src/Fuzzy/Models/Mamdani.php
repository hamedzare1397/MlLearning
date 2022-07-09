<?php

namespace Ml\Fuzzy\Models;

use Ml\Fuzzy\Fuzzifier\FuzzyTransformer;
use Ml\Fuzzy\MemberShipFunction\Triangle;
use Ml\Fuzzy\Rule\Rule;
use Rubix\ML\AnomalyDetectors\RobustZScore;
use Rubix\ML\Datasets\Dataset;
use Rubix\ML\Datasets\Labeled;
use Rubix\ML\DataType;
use Rubix\ML\EstimatorType;
use Ml\Fuzzy\FICEstimater;
use Rubix\ML\Transformers\NumericStringConverter;
use Rubix\ML\Transformers\L2Normalizer;
use Rubix\ML\Transformers\MinMaxNormalizer;

class Mamdani extends FICEstimater
{
    protected $describeByLabel;
    protected $describe;
    protected $rules;
    protected $transformer;
    protected static $trained;

    public function __construct()
    {
        $this->rules = collect();
        $this->transformer = new L2Normalizer();
    }

    /**
     * @inheritDoc
     */
    public function __toString(): string
    {
        return 'fuzzy classifier by Hamed Ana Mostafa';
    }

    /**
     * @inheritDoc
     */
    public function type(): EstimatorType
    {
        return EstimatorType::classifier();
    }

    /**
     * @inheritDoc
     */
    public function compatibility(): array
    {
        return DataType::all();
    }

    /**
     * @inheritDoc
     */
    public function params(): array
    {
        return [
            'describe' => $this->describe,
            'describeByLabel' => $this->describeByLabel,
            'rules' => $this->rules,
        ];
    }

    /**
     * @inheritDoc
     */
    public function predict(Dataset $dataset): array
    {
        $dataset->apply($this->transformer);
        $result = collect();
        foreach ($dataset as $index=>$data) {
            $result->add($this->predictSample($data));
        }
        return $result->toArray();
    }

    public function predictSample($sample)
    {
        $temp = collect();
        /** @var Rule $rule */
        foreach ($this->rules as $rule) {
            $temp->add($rule->apply($sample));
        }
        return $this->aggregation($temp);
    }

    /**
     * @inheritDoc
     */
    public function train(Dataset $dataset): void
    {
        self::$trained = false;
        /** @var Labeled $dataset */
        $dataset->transformLabels(function($row){
            return "typeWine-$row";
        });
        $dataset->apply(new NumericStringConverter());
        $dataset->apply($this->transformer);
        $this->describe = $dataset->describe();
        $this->describeByLabel = $dataset->describeByLabel();

        foreach ($this->describeByLabel as $label => $data) {
            $rule = new Rule($label);
            foreach ($data as $dim => $values) {
                extract($values);
                if ($type==='categorical') continue;
                $mf = new Triangle($min, $mean, $max);
                $rule->addMemberShip($mf);

            }
            $this->rules->add($rule);
        }
        self::$trained = true;
    }

    /**
     * @inheritDoc
     */
    public function trained(): bool
    {
        return self::$trained??false;
    }

    public function aggregation($firing)
    {
        $max = new Rule('NoneType');
        foreach ($firing as $item) {
            if ($max->getFiring()<$item->getFiring()){
                $max = $item;
            }
        }
        return $max;
    }
}

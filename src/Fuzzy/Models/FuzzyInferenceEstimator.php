<?php


namespace Ml\Fuzzy\Models;


use Rubix\ML\Datasets\Dataset;
use Rubix\ML\Datasets\Labeled;
use Rubix\ML\DataType;
use Rubix\ML\Estimator;
use Rubix\ML\EstimatorType;
use Rubix\ML\Learner;

abstract class FuzzyInferenceEstimator implements Estimator,Learner
{

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
        return [
            DataType::continuous(),
        ];
    }

    /**
     * @inheritDoc
     */
    public function params(): array
    {
        return [
            'rules' => $this->rules,
            'fuzz' => $this->fuzz,
        ];
    }

    /**
     * @inheritDoc
     */
    public function predict(Dataset $dataset): array
    {
        $result = collect();
        foreach ($dataset as $index => $value) {
            $result->put($index, $this->predictSample($value->sample()));
        }
        return $result->toArray();
    }

    /**
     * @inheritDoc
     */
    public function __toString()
    {
    }

    public function predictSample($sample)
    {
        dd($sample);
        return $this->evaluate($sample);
    }

    /**
     * @param Labeled,Dataset $dataset
     */
    public function train(Dataset $dataset): void
    {
        $describeByLabel = $dataset->describeByLabel();
        $describe = $dataset->describe();

        $describeByLabel = $dataset->describeByLabel();
        foreach ($dataset as $index => $value) {

        }
        $this->learn($dataset);
    }
}

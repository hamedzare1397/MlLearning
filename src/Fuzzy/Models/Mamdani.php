<?php

namespace Ml\Fuzzy\Models;

use Rubix\ML\Datasets\Dataset;
use Rubix\ML\DataType;
use Rubix\ML\EstimatorType;
use \Ml\Fuzzy\FICEstimater;

class Mamdani extends FICEstimater
{
    protected $describeByLabel;
    /**
     * @inheritDoc
     */
    public function __toString(): string
    {
        // TODO: Implement __toString() method.
    }

    /**
     * @inheritDoc
     */
    public function type(): EstimatorType
    {
        // TODO: Implement type() method.
    }

    /**
     * @inheritDoc
     */
    public function compatibility(): array
    {
        // TODO: Implement compatibility() method.
    }

    /**
     * @inheritDoc
     */
    public function params(): array
    {
        // TODO: Implement params() method.
    }

    /**
     * @inheritDoc
     */
    public function predict(Dataset $dataset): array
    {
        // TODO: Implement predict() method.
    }

    /**
     * @inheritDoc
     */
    public function train(Dataset $dataset): void
    {
        $dataset->apply(new FuzzyTransformer());
        $this->describeByLabel = $dataset->describeByLabel();
        dd($this->describeByLabel);
    }

    /**
     * @inheritDoc
     */
    public function trained(): bool
    {
        // TODO: Implement trained() method.
    }
}

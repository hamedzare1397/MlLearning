<?php

namespace Ml\Fuzzy\Fuzzifier;

use Rubix\ML\DataType;

class FuzzyTransformer implements \Rubix\ML\Transformers\Transformer
{

    protected $samples=[];
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
    public function compatibility(): array
    {
        // TODO: Implement compatibility() method.
    }

    /**
     * @inheritDoc
     */
    public function transform(array &$samples): void
    {
        $samples=Fuzzifier::normalize($samples)->toArray();

    }
}
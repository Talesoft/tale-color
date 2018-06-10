<?php
declare(strict_types=1);

namespace Tale\Color\Scheme;

use Tale\Color;
use Tale\ColorInterface;

abstract class AbstractContinousScheme extends Color\AbstractScheme
{
    private $amount;
    private $step;

    /**
     * ContinousSchemeBase constructor.
     * @param ColorInterface|string|int $baseColor
     * @param int $amount
     * @param float $step
     */
    public function __construct($baseColor, int $amount, float $step)
    {
        $this->amount = $amount;
        $this->step = $step;
        parent::__construct($baseColor);
    }

    /**
     * @return int
     */
    public function getAmount(): int
    {
        return $this->amount;
    }

    /**
     * @return float
     */
    public function getStep(): float
    {
        return $this->step;
    }

    /**
     * @param ColorInterface $baseColor
     * @return \Generator
     */
    protected function generate(ColorInterface $baseColor): \Generator
    {
        yield $baseColor;
        for ($i = 1; $i <= $this->amount; $i++) {
            yield $this->generateStep($baseColor, $i, $this->step);
        }
    }

    /**
     * @param ColorInterface|string|int $baseColor
     * @param int $i
     * @param float $step
     * @return mixed
     */
    abstract protected function generateStep(ColorInterface $baseColor, int $i, float $step);
}
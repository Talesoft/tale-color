<?php
declare(strict_types=1);

namespace Tale\Color;

use Tale\Color;

trait AlphaTrait
{
    protected $alpha = 1.0;

    /**
     * @return float
     */
    public function getAlpha(): float
    {
        return $this->alpha;
    }

    /**
     * @param float $alpha
     * @return $this
     */
    public function setAlpha(float $alpha)
    {
        $this->alpha = Color::capValue($alpha, 0.0, 1.0);
        return $this;
    }
}
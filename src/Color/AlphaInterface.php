<?php
declare(strict_types=1);

namespace Tale\Color;

interface AlphaInterface
{
    /**
     * @return float
     */
    public function getAlpha(): float;

    /**
     * @param float $alpha
     * @return $this
     */
    public function setAlpha(float $alpha);
}
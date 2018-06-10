<?php
declare(strict_types=1);

namespace Tale\Color\Scheme;

use Tale\Color;
use Tale\ColorInterface;

class HueRotationScheme extends AbstractContinousScheme
{
    protected function generateStep(ColorInterface $baseColor, int $i, float $step): \Generator
    {
        return Color::complement($baseColor, $i * $step);
    }
}
<?php
declare(strict_types=1);

namespace Tale\Color\Scheme;

use Tale\Color;
use Tale\ColorInterface;

class ShadeScheme extends AbstractContinousScheme
{
    protected function generateStep(ColorInterface $baseColor, int $i, float $step)
    {
        return Color::darken($baseColor, $i * $step);
    }
}
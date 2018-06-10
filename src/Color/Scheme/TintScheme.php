<?php
declare(strict_types=1);

namespace Tale\Color\Scheme;

use Tale\Color;
use Tale\ColorInterface;

class TintScheme extends AbstractContinousScheme
{
    protected function generateStep(ColorInterface $baseColor, int $i, float $step)
    {
        return Color::lighten($baseColor, $i * $step);
    }
}
<?php
declare(strict_types=1);

namespace Tale\Color\Scheme;

use Tale\Color;
use Tale\ColorInterface;

class AnalogousScheme extends Color\AbstractScheme
{
    /**
     * @param ColorInterface $baseColor
     * @return \Generator
     */
    protected function generate(ColorInterface $baseColor): \Generator
    {
        yield Color::complement($baseColor, -30);
        yield $baseColor;
        yield Color::complement($baseColor, 30);
    }
}
<?php
declare(strict_types=1);

namespace Tale\Color\Scheme;

use Tale\Color;
use Tale\ColorInterface;

class SquareScheme extends Color\AbstractScheme
{
    /**
     * @param ColorInterface $baseColor
     * @return \Generator
     */
    protected function generate(ColorInterface $baseColor): \Generator
    {
        yield $baseColor;
        yield Color::complement($baseColor, 90);
        yield Color::complement($baseColor, 180);
        yield Color::complement($baseColor, -90);
    }
}
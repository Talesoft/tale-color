<?php
declare(strict_types=1);

namespace Tale\Color\Scheme;

use Tale\Color;
use Tale\ColorInterface;

class ComplementaryScheme extends Color\AbstractScheme
{
    /**
     * @param ColorInterface $baseColor
     * @return \Generator
     */
    protected function generate(ColorInterface $baseColor): \Generator
    {
        yield $baseColor;
        yield Color::complement($baseColor);
    }
}
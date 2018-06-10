<?php
declare(strict_types=1);

namespace Tale\Color;

use Tale\Color;
use Tale\ColorInterface;

abstract class AbstractScheme implements SchemeInterface
{
    use SchemeTrait;

    /**
     * SchemeBase constructor.
     * @param ColorInterface|string|int $baseColor
     */
    public function __construct($baseColor)
    {
        $this->baseColor = Color::get($baseColor);
        foreach ($this->generate($this->baseColor) as $color) {
            $this[] = $color;
        }
    }

    /**
     * @param ColorInterface $baseColor
     * @return \Generator
     */
    abstract protected function generate(ColorInterface $baseColor): \Generator;
}
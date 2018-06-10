<?php
declare(strict_types=1);

namespace Tale\Color\Scheme;

use Tale\Color;
use Tale\ColorInterface;

class MonochromaticScheme extends Color\AbstractScheme
{
    private $tintScheme;
    private $shadeScheme;

    public function __construct($baseColor, int $amount, float $step)
    {
        $this->tintScheme = new TintScheme($baseColor, $amount, $step);
        $this->shadeScheme = new ShadeScheme($baseColor, $amount, $step);
        parent::__construct($baseColor);
    }

    /**
     * @return TintScheme
     */
    public function getTintScheme(): TintScheme
    {
        return $this->tintScheme;
    }

    /**
     * @return ShadeScheme
     */
    public function getShadeScheme(): ShadeScheme
    {
        return $this->shadeScheme;
    }

    /**
     * @param ColorInterface $baseColor
     * @return \Generator
     */
    protected function generate(ColorInterface $baseColor): \Generator
    {
        //First the shaded scheme in reverse order, excluding the base color
        $i = \count($this->shadeScheme);
        while (--$i > 0) {
            yield $this->shadeScheme[$i];
        }

        //Now all tints, including our base color
        foreach ($this->tintScheme as $color) {
            yield $color;
        }
    }
}
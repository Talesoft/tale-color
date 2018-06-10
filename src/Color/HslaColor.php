<?php
declare(strict_types=1);

namespace Tale\Color;

use Tale\Color;

class HslaColor extends HslColor implements HslaColorInterface
{
    use AlphaColorTrait;

    public function __construct($hue, $saturation, $lightness, $alpha)
    {
        parent::__construct($hue, $saturation, $lightness);;
        $this->setAlpha($alpha);
    }

    public function toRgba(): RgbaColorInterface
    {
        return parent::toRgba()->setAlpha($this->alpha);
    }

    public function toHsla(): HslaColorInterface
    {
        return new static($this->hue, $this->saturation, $this->lightness, $this->alpha);
    }

    public function toHsva(): HsvaColorInterface
    {
        return parent::toHsva()->setAlpha($this->alpha);
    }

    public function __toString()
    {
        $s = round($this->saturation * 100, 3, PHP_ROUND_HALF_DOWN);
        $l = round($this->lightness * 100, 3, PHP_ROUND_HALF_DOWN);
        $a = round($this->alpha, 3, PHP_ROUND_HALF_DOWN);
        return sprintf(
            'hsla(%s,%s,%s,%s)',
            Color::formatValue($this->hue, 3),
            Color::formatValue($s, 3).'%',
            Color::formatValue($l, 3).'%',
            Color::formatValue($a, 3)
        );
    }
}
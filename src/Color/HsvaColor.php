<?php
declare(strict_types=1);

namespace Tale\Color;

use Tale\Color;

class HsvaColor extends HsvColor implements HsvaColorInterface
{
    use AlphaTrait;

    public function __construct(float $hue, float $saturation, float $value, float $alpha)
    {
        parent::__construct($hue, $saturation, $value);;
        $this->setAlpha($alpha);
    }

    public function toRgba(): RgbaColorInterface
    {
        return parent::toRgba()->setAlpha($this->alpha);
    }

    public function toHsla(): HslaColorInterface
    {
        return parent::toHsla()->setAlpha($this->alpha);
    }

    public function toHsva(): HsvaColorInterface
    {
        return new HsvaColor($this->hue, $this->saturation, $this->value, $this->alpha);
    }

    public function __toString()
    {
        $s = round($this->saturation * 100, 3, PHP_ROUND_HALF_DOWN);
        $v = round($this->value * 100, 3, PHP_ROUND_HALF_DOWN);
        $a = round($this->alpha, 3, PHP_ROUND_HALF_DOWN);
        return sprintf(
            'hsva(%s,%s,%s,%s)',
            Color::formatValue($this->hue, 3),
            Color::formatValue($s, 3).'%',
            Color::formatValue($v, 3).'%',
            Color::formatValue($a, 3)
        );
    }
}
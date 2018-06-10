<?php
declare(strict_types=1);

namespace Tale\Color;

use Tale\Color;
use Tale\ColorInterface;

class HsvColor extends AbstractHsColor implements HsvColorInterface
{
    protected $value = 0.0;

    public function __construct(float $hue, float $saturation, float $value)
    {
        parent::__construct($hue, $saturation);
        $this->setValue($value);
    }

    /**
     * @return float
     */
    public function getValue(): float
    {
        return $this->value;
    }

    /**
     * @param float $value
     * @return $this
     */
    public function setValue(float $value)
    {
        $this->value = Color::capValue($value, 0.0, 1.0);
        return $this;
    }

    /**
     * @return HsvaColorInterface
     */
    public function toAlpha(): AlphaColorInterface
    {
        return $this->toHsva();
    }

    /**
     * @return HsvColorInterface
     */
    public function toOpaque(): ColorInterface
    {
        return $this->toHsv();
    }

    public function toRgb(): RgbColorInterface
    {
        $h = $this->hue / 360;
        $s = $this->saturation;
        $v = $this->value;

        $r = $g = $b = 0;

        $i = floor($h * 6);
        $f = $h * 6 - $i;
        $p = $v * (1 - $s);
        $q = $v * (1 - $f * $s);
        $t = $v * (1 - (1 - $f) * $s);

        switch ($i % 6) {
            case 0: $r = $v; $g = $t; $b = $p; break;
            case 1: $r = $q; $g = $v; $b = $p; break;
            case 2: $r = $p; $g = $v; $b = $t; break;
            case 3: $r = $p; $g = $q; $b = $v; break;
            case 4: $r = $t; $g = $p; $b = $v; break;
            case 5: $r = $v; $g = $p; $b = $q; break;
        }
        return new RgbColor(
            (int)round($r * 255, 0, PHP_ROUND_HALF_DOWN),
            (int)round($g * 255, 0, PHP_ROUND_HALF_DOWN),
            (int)round($b * 255, 0, PHP_ROUND_HALF_DOWN)
        );
    }

    public function toRgba(): RgbaColorInterface
    {
        return $this->toRgb()->toAlpha();
    }

    public function toHsl(): HslColorInterface
    {
        $h = $this->hue;
        $s = $this->saturation;
        $v = $this->value;

        $l = (2 - $s) * $v;
        $s *= $v;
        if ($l !== 0.0 && $l !== 2.0) {
            $s /= ($l <= 1.0) ? $l : 2.0 - $l;
        }
        $l /= 2;
        /*
        $l = (2 - $s) * $v / 2;
        if ($l !== 0.0) {
            if ($l === 1.0) {
                $s = 0.0;
            } else if ($l < .5) {
                $s = $s * $v / ($l * 2);
            } else {
                $s = $s * $v / (2 - $l * 2);
            }
        }*/
        return new HslColor($h, $s, $l);
    }

    public function toHsla(): HslaColorInterface
    {

        return $this->toHsl()->toAlpha();
    }

    public function toHsv(): HsvColorInterface
    {
        return new self($this->hue, $this->saturation, $this->value);
    }

    public function toHsva(): HsvaColorInterface
    {
        return new HsvaColor($this->hue, $this->saturation, $this->value, 1.0);
    }

    public function toXyz(): XyzColorInterface
    {

        return $this->toRgb()->toXyz();
    }

    public function toLab(): LabColorInterface
    {

        return $this->toRgb()->toLab();
    }

    public function __toString()
    {
        $s = round($this->saturation * 100, 3);
        $v = round($this->value * 100, 3);
        return sprintf(
            'hsv(%s,%s,%s)',
            Color::formatValue($this->hue, 3),
            Color::formatValue($s, 3).'%',
            Color::formatValue($v, 3).'%'
        );
    }
}
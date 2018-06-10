<?php
declare(strict_types=1);

namespace Tale\Color;

use Tale\Color;
use Tale\ColorInterface;

class HslColor extends AbstractHsColor implements HslColorInterface
{
    protected $lightness = 0.0;

    public function __construct(float $hue, float $saturation, float $lightness)
    {
        parent::__construct($hue, $saturation);
        $this->setLightness($lightness);
    }

    /**
     * @return float
     */
    public function getLightness(): float
    {
        return $this->lightness;
    }

    /**
     * @param float $lightness
     * @return $this
     */
    public function setLightness(float $lightness)
    {
        $this->lightness = Color::capValue($lightness, 0.0, 1.0);
        return $this;
    }

    /**
     * @return HslaColorInterface
     */
    public function toAlpha(): AlphaColorInterface
    {
        return $this->toHsla();
    }

    /**
     * @return HslColorInterface
     */
    public function toOpaque(): ColorInterface
    {
        return $this->toHsl();
    }

    private function getRgbFromHue(float $p, float $q, float $t)
    {
        //Normalize
        if ($t < 0) {
            $t++;
        } else if ($t > 1) {
            $t--;
        }

        if ($t < 1/6) {
            return $p + ($q - $p) * 6 * $t;
        }

        if ($t < 1/2) {
            return $q;
        }

        if ($t < 2/3) {
            return $p + ($q - $p) * (2 / 3 - $t) * 6;
        }

        return $p;
    }

    public function toRgb(): RgbColorInterface
    {
        $r = $g = $b = 0;
        $h = $this->hue / 360;
        $s = $this->saturation;
        $l = $this->lightness;

        if ($s === 0.0) {
            $r = $g = $b = $l;
        } else {
            $q = $l < 0.5 ? $l * (1 + $s) : $l + $s - $l * $s;
            $p = 2 * $l - $q;

            $r = $this->getRgbFromHue($p, $q, $h + 1 / 3);
            $g = $this->getRgbFromHue($p, $q, $h);
            $b = $this->getRgbFromHue($p, $q, $h - 1 / 3);
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
        return new self($this->hue, $this->saturation, $this->lightness);
    }

    public function toHsla(): HslaColorInterface
    {
        return new HslaColor($this->hue, $this->saturation, $this->lightness, 1.0);
    }

    public function toHsv(): HsvColorInterface
    {
        $l = $this->lightness;
        $s = $this->saturation;

        $l *= 2;
        $s *= ($l <= 1) ? $l : 2 - $l;
        $v = ($l + $s) / 2;
        if ($l !== 0.0) {
            $s = (2 * $s) / ($l + $s);
        }
        return new HsvColor($this->hue, $s, $v);
    }

    public function toHsva(): HsvaColorInterface
    {
        return $this->toHsv()->toAlpha();
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
        $l = round($this->lightness * 100, 3);
        return sprintf(
            'hsl(%s,%s,%s)',
            Color::formatValue($this->hue, 3),
            Color::formatValue($s, 3).'%',
            Color::formatValue($l, 3).'%'
        );
    }
}
<?php
declare(strict_types=1);

namespace Tale\Color;

use Tale\Color;
use Tale\ColorInterface;

class RgbColor implements RgbColorInterface
{
    protected $red = 0;
    protected $green = 0;
    protected $blue = 0;

    public function __construct(int $red, int $green, int $blue)
    {
        $this->setRed($red);
        $this->setGreen($green);
        $this->setBlue($blue);
    }

    /**
     * @return int
     */
    public function getRed(): int
    {
        return $this->red;
    }

    /**
     * @param int $red
     * @return $this
     */
    public function setRed(int $red)
    {
        $this->red = (int)Color::capValue($red, 0, 255);
        return $this;
    }

    /**
     * @return int
     */
    public function getGreen(): int
    {
        return $this->green;
    }

    /**
     * @param int $green
     * @return $this
     */
    public function setGreen(int $green)
    {
        $this->green = (int)Color::capValue($green, 0, 255);
        return $this;
    }

    /**
     * @return int
     */
    public function getBlue(): int
    {
        return $this->blue;
    }

    /**
     * @param int $blue
     * @return $this
     */
    public function setBlue(int $blue)
    {
        $this->blue = (int)Color::capValue($blue, 0, 255);
        return $this;
    }

    public function toAlpha(): AlphaColorInterface
    {
        return $this->toRgba();
    }

    public function toOpaque(): ColorInterface
    {
        return $this->toRgb();
    }

    public function toRgb(): RgbColorInterface
    {
        return new self($this->red, $this->green, $this->blue);
    }

    public function toRgba(): RgbaColorInterface
    {
        return new RgbaColor($this->red, $this->green, $this->blue, 1);
    }

    public function toHsl(): HslColorInterface
    {
        $r = $this->red / 255;
        $g = $this->green / 255;
        $b = $this->blue / 255;

        $max = max($r, $g, $b);
        $min = min($r, $g, $b);
        $h = $s = 0;
        $l = ($max + $min) / 2;

        if ($max !== $min) {

          $d = $max - $min;
          $s = $l > 0.5 ? $d / (2 - $max - $min) : $d / ($max + $min);

          switch ($max) {
              case $r: $h = ($g - $b) / $d + ($g < $b ? 6 : 0); break;
              case $g: $h = ($b - $r) / $d + 2; break;
              case $b: $h = ($r - $g) / $d + 4; break;
          }

          $h /= 6;
        }
        return new HslColor($h * 360, $s, $l);
    }

    public function toHsla(): HslaColorInterface
    {
        return $this->toHsl()->toAlpha();
    }

    public function toHsv(): HsvColorInterface
    {
        $r = $this->red / 255;
        $g = $this->green / 255;
        $b = $this->blue / 255;

        $max = max($r, $g, $b);
        $min = min($r, $g, $b);
        $d = $max - $min;

        $h = $s = 0;
        $s = $max === 0 ? 0 : $d / $max;
        $v = $max;

        if ($max !== $min) {
            switch ($max) {
                case $r: $h = ($g - $b) / $d + ($g < $b ? 6 : 0); break;
                case $g: $h = ($b - $r) / $d + 2; break;
                case $b: $h = ($r - $g) / $d + 4; break;
            }
            $h /= 6;
        }
        return new HsvColor($h * 360, $s, $v);
    }

    public function toHsva(): HsvaColorInterface
    {
        return $this->toHsv()->toAlpha();
    }

    public function toXyz(): XyzColorInterface
    {
        $r = ($this->red / 255);    //R from 0 to 255
        $g = ($this->green / 255);  //G from 0 to 255
        $b = ($this->blue / 255);   //B from 0 to 255


        //assume sRGB
        $r = $r > 0.04045 ? (($r + 0.055) / 1.055) ** 2.4 : ($r / 12.92);
        $g = $g > 0.04045 ? (($g + 0.055) / 1.055) ** 2.4 : ($g / 12.92);
        $b = $b > 0.04045 ? (($b + 0.055) / 1.055) ** 2.4 : ($b / 12.92);

        //Observer. = 2°, Illuminant = D65
        $x = $r * 0.4124 + $g * 0.3576 + $b * 0.1805;
        $y = $r * 0.2126 + $g * 0.7152 + $b * 0.0722;
        $z = $r * 0.0193 + $g * 0.1192 + $b * 0.9505;
        return new XyzColor($x * 100, $y * 100, $z * 100);
    }

    public function toLab(): LabColorInterface
    {
        return $this->toXyz()->toLab();
    }

    public function __toString()
    {
        return sprintf('rgb(%d,%d,%d)', $this->red, $this->green, $this->blue);
    }
}
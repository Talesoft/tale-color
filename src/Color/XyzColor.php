<?php
declare(strict_types=1);

namespace Tale\Color;

use Tale\Color;
use Tale\ColorInterface;

class XyzColor implements XyzColorInterface
{
    protected $x = 0.0;
    protected $y = 0.0;
    protected $z = 0.0;

    public function __construct(float $x, float $y, float $z)
    {
        $this->setX($x);
        $this->setY($y);
        $this->setZ($z);
    }

    /**
     * @return float
     */
    public function getX(): float
    {
        return $this->x;
    }

    /**
     * @param float $x
     *
     * @return $this
     */
    public function setX(float $x)
    {
        $this->x = Color::capValue($x, 0, XyzColorInterface::REF_X);
        return $this;
    }

    /**
     * @return float
     */
    public function getY(): float
    {
        return $this->y;
    }

    /**
     * @param float $y
     *
     * @return $this
     */
    public function setY(float $y)
    {
        $this->y = Color::capValue($y, 0, XyzColorInterface::REF_Y);
        return $this;
    }

    /**
     * @return float
     */
    public function getZ(): float
    {
        return $this->z;
    }

    /**
     * @param float $z
     *
     * @return $this
     */
    public function setZ(float $z)
    {
        $this->z = Color::capValue($z, 0, XyzColorInterface::REF_Z);
        return $this;
    }

    public function toAlpha(): AlphaColorInterface
    {
        return $this->toRgba();
    }

    public function toOpaque(): ColorInterface
    {
        return $this->toXyz();
    }

    public function toRgb(): RgbColorInterface
    {
        $x = $this->x / 100; //X from 0 to self::REF_X
        $y = $this->y / 100; //Y from 0 to self::REF_Y
        $z = $this->z / 100; //Z from 0 to self::REF_Z

        //Observer = 2°, Illuminant = D65
        $r = $x * 3.2406 + $y * -1.5372 + $z * -0.4986;
        $g = $x * -0.9689 + $y * 1.8758 + $z * 0.0415;
        $b = $x * 0.0557 + $y * -0.2040 + $z * 1.0570;

        //Assume sRGB
        $r = $r > 0.0031308 ? ((1.055 * ($r ** (1.0 / 2.4))) - 0.055) : $r * 12.92;
        $g = $g > 0.0031308 ? ((1.055 * ($g ** (1.0 / 2.4))) - 0.055) : $g * 12.92;
        $b = $b > 0.0031308 ? ((1.055 * ($b ** (1.0 / 2.4))) - 0.055) : $b * 12.92;
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
        return $this->toRgb()->toHsl();
    }

    public function toHsla(): HslaColorInterface
    {
        return $this->toHsl()->toAlpha();
    }

    public function toHsv(): HsvColorInterface
    {
        return $this->toRgb()->toHsv();
    }

    public function toHsva(): HsvaColorInterface
    {
        return $this->toHsv()->toAlpha();
    }

    public function toXyz(): XyzColorInterface
    {
        return new self($this->x, $this->y, $this->z);
    }

    public function toLab(): LabColorInterface
    {
        $x = $this->x / self::REF_X;
        $y = $this->y / self::REF_Y;
        $z = $this->z / self::REF_Z;

        $x = $x > 0.008856 ? $x ** (1 / 3) : (7.787 * $x) + (16 / 116);
        $y = $y > 0.008856 ? $y ** (1 / 3) : (7.787 * $y) + (16 / 116);
        $z = $z > 0.008856 ? $z ** (1 / 3) : (7.787 * $z) + (16 / 116);

        $l = (116 * $y) - 16;
        $a = 500 * ($x - $y);
        $b = 200 * ($y - $z);
        return new LabColor($l, $a, $b);
    }

    public function __toString()
    {
        return sprintf(
            'xyz(%s,%s,%s)',
            number_format($this->x, 2, '.', null),
            number_format($this->y, 2, '.', null),
            number_format($this->z, 2, '.', null)
        );
    }
}
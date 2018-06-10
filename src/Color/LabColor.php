<?php
declare(strict_types=1);

namespace Tale\Color;

//http://www.easyrgb.com/index.php?X=MATH&H=07#text7
use Tale\Color;
use Tale\ColorInterface;

class LabColor implements LabColorInterface
{

    protected $l = 0.0;
    protected $a = 0.0;
    protected $b = 0.0;

    public function __construct(float $l, float $a, float $b)
    {
        $this->setL($l);
        $this->setA($a);
        $this->setB($b);
    }

    /**
     * @return float
     */
    public function getL(): float
    {
        return $this->l;
    }

    /**
     * @param float $l
     * @return $this
     */
    public function setL(float $l)
    {
        $this->l = Color::capValue($l, 0.0, 100.0);
        return $this;
    }

    /**
     * @return float
     */
    public function getA(): float
    {
        return $this->a;
    }

    /**
     * @param float $a
     * @return $this
     */
    public function setA(float $a)
    {
        $this->a = Color::capValue($a, -128.0, 127.0);
        return $this;
    }

    /**
     * @return int
     */
    public function getB(): float
    {

        return $this->b;
    }

    /**
     * @param float $b
     * @return $this
     */
    public function setB(float $b)
    {
        $this->b = Color::capValue($b, -128.0, 127.0);
        return $this;
    }

    /**
     * @return RgbaColorInterface
     */
    public function toAlpha(): AlphaColorInterface
    {
        return $this->toRgba();
    }

    /**
     * @return LabColorInterface
     */
    public function toOpaque(): ColorInterface
    {
        return $this->toLab();
    }

    public function toRgb(): RgbColorInterface
    {
        return $this->toXyz()->toRgb();
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
        $y = ($this->l + 16) / 116;
        $x = $this->a / 500 + $y;
        $z = $y - $this->b / 200;

        $y2 = $y ** 3;
        $x2 = $x ** 3;
        $z2 = $z ** 3;

        $y = $y2 > 0.008856 ? $y2 : ($y - 16 / 116) / 7.787;
        $x = $x2 > 0.008856 ? $x2 : ($x - 16 / 116) / 7.787;
        $z = $z2 > 0.008856 ? $z2 : ($z - 16 / 116) / 7.787;

        return new XyzColor($x * XyzColor::REF_X, $y * XyzColor::REF_Y, $z * XyzColor::REF_Z);
    }

    public function toLab(): LabColorInterface
    {
        return new self($this->l, $this->a, $this->b);
    }

    public function __toString()
    {
        return sprintf(
            'lab(%s,%s,%s)',
            number_format($this->l, 2, '.', null),
            number_format($this->a, 2, '.', null),
            number_format($this->b, 2, '.', null)
        );
    }
}
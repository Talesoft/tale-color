<?php
declare(strict_types=1);

namespace Tale\Color;

class RgbaColor extends RgbColor implements RgbaColorInterface
{
    use AlphaColorTrait;

    public function __construct(int $red, int $green, int $blue, float $alpha)
    {
        parent::__construct($red, $green, $blue);
        $this->setAlpha($alpha);
    }

    public function toRgba(): RgbaColorInterface
    {
        return new RgbaColor($this->red, $this->green, $this->blue, $this->alpha);
    }

    public function toHsla(): HslaColorInterface
    {
        return parent::toHsla()->setAlpha($this->alpha);
    }

    public function toHsva(): HsvaColorInterface
    {
        return parent::toHsva()->setAlpha($this->alpha);
    }

    public function __toString()
    {
        return sprintf(
            'rgba(%d,%d,%d,%s)',
            $this->red,
            $this->green,
            $this->blue,
            number_format($this->alpha, 2, '.', null)
        );
    }
}
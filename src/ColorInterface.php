<?php

namespace Tale;

use Tale\Color\AlphaColorInterface;
use Tale\Color\LabColorInterface;
use Tale\Color\HslaColorInterface;
use Tale\Color\HslColorInterface;
use Tale\Color\HsvaColorInterface;
use Tale\Color\HsvColorInterface;
use Tale\Color\RgbaColorInterface;
use Tale\Color\RgbColorInterface;
use Tale\Color\XyzColorInterface;

interface ColorInterface
{
    public function toAlpha(): AlphaColorInterface;
    public function toOpaque(): ColorInterface;

    public function toRgb(): RgbColorInterface;
    public function toRgba(): RgbaColorInterface;
    public function toHsl(): HslColorInterface;
    public function toHsla(): HslaColorInterface;
    public function toHsv(): HsvColorInterface;
    public function toHsva(): HsvaColorInterface;

    public function toXyz(): XyzColorInterface;

    public function toLab(): LabColorInterface;

    public function __toString();
}
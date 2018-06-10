<?php

namespace Tale\Color;

use Tale\ColorInterface;

interface XyzColorInterface extends ColorInterface
{
    //Observer= 2°, Illuminant= D65
    public const REF_X = 95.047;
    public const REF_Y = 100.0;
    public const REF_Z = 108.883;

    /**
     * @return RgbaColorInterface
     */
    public function toAlpha(): AlphaColorInterface;

    /**
     * @return XyzColorInterface
     */
    public function toOpaque(): ColorInterface;

    public function getX(): float;
    public function setX(float $x);

    public function getY(): float;
    public function setY(float $y);

    public function getZ(): float;
    public function setZ(float $z);
}
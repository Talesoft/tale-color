<?php
declare(strict_types=1);

namespace Tale\Color;

use Tale\ColorInterface;

interface LabColorInterface extends ColorInterface
{
    /**
     * @return RgbaColorInterface
     */
    public function toAlpha(): AlphaColorInterface;

    /**
     * @return LabColorInterface
     */
    public function toOpaque(): ColorInterface;

    public function getL(): float;
    public function setL(float $l);

    public function getA(): float;
    public function setA(float $a);

    public function getB(): float;
    public function setB(float $b);
}
<?php
declare(strict_types=1);

namespace Tale\Color;

use Tale\ColorInterface;

interface RgbColorInterface extends ColorInterface
{
    /**
     * @return RgbaColorInterface
     */
    public function toAlpha(): AlphaColorInterface;

    /**
     * @return RgbColorInterface
     */
    public function toOpaque(): ColorInterface;

    public function getRed(): int;
    public function setRed(int $red);

    public function getBlue(): int;
    public function setBlue(int $blue);

    public function getGreen(): int;
    public function setGreen(int $green);
}
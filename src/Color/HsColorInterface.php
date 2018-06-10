<?php
declare(strict_types=1);

namespace Tale\Color;

use Tale\ColorInterface;

interface HsColorInterface extends ColorInterface
{
    public function getHue(): float;
    public function setHue(float $hue);

    public function getSaturation(): float;
    public function setSaturation(float $saturation);
}
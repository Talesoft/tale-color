<?php
declare(strict_types=1);

namespace Tale\Color;

use Tale\ColorInterface;

interface HsvColorInterface extends HsColorInterface
{
    /**
     * @return HsvaColorInterface
     */
    public function toAlpha(): AlphaColorInterface;

    /**
     * @return HsvColorInterface
     */
    public function toOpaque(): ColorInterface;

    /**
     * @param $hue
     * @return HslColorInterface
     */
    public function setHue(float $hue);

    /**
     * @param $saturation
     * @return HslColorInterface
     */
    public function setSaturation(float $saturation);

    public function getValue(): float;
    public function setValue(float $value);
}
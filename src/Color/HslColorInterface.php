<?php
declare(strict_types=1);

namespace Tale\Color;

use Tale\ColorInterface;

interface HslColorInterface extends HsColorInterface
{
    /**
     * @return HslaColorInterface
     */
    public function toAlpha(): AlphaColorInterface;

    /**
     * @return HslColorInterface
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

    public function getLightness(): float;
    public function setLightness(float $lightness);
}
<?php
declare(strict_types=1);

namespace Tale\Color;

use Tale\Color;

abstract class AbstractHsColor implements HsColorInterface
{
    protected $hue = 0.0;
    protected $saturation = 0.0;

    public function __construct(float $hue, float $saturation)
    {
        $this->setHue($hue);
        $this->setSaturation($saturation);
    }

    /**
     * @return float
     */
    public function getHue(): float
    {
        return $this->hue;
    }

    /**
     * @param float $hue
     * @return $this
     */
    public function setHue(float $hue)
    {
        $this->hue = Color::rotateValue($hue, 360);
        return $this;
    }

    /**
     * @return int
     */
    public function getSaturation(): float
    {

        return $this->saturation;
    }

    /**
     * @param float $saturation
     * @return $this
     */
    public function setSaturation(float $saturation)
    {
        $this->saturation = Color::capValue($saturation, 0.0, 1.0);
        return $this;
    }
}
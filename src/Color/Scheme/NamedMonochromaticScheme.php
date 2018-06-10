<?php
declare(strict_types=1);

namespace Tale\Color\Scheme;

class NamedMonochromaticScheme extends MonochromaticScheme
{
    public function __construct($baseColor, float $step)
    {
        parent::__construct($baseColor, 3, $step);
    }

    public function getDarkestShade()
    {
        return $this[0];
    }

    public function getDarkerShade()
    {
        return $this[1];
    }

    public function getDarkShade()
    {
        return $this[2];
    }

    public function getLightTint()
    {
        return $this[4];
    }

    public function getLighterTint()
    {
        return $this[5];
    }

    public function getLightestTint()
    {
        return $this[6];
    }
}
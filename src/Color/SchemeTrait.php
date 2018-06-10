<?php
declare(strict_types=1);

namespace Tale\Color;

use Tale\ColorInterface;

trait SchemeTrait
{
    use PaletteTrait;

    /**
     * @var ColorInterface
     */
    private $baseColor;

    public function getBaseColor(): ColorInterface
    {
        return $this->baseColor;
    }
}
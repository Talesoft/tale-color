<?php
declare(strict_types=1);

namespace Tale\Color;

use Tale\ColorInterface;

interface SchemeInterface extends PaletteInterface
{
    public function getBaseColor(): ColorInterface;
}
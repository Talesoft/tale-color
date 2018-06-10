<?php
declare(strict_types=1);

namespace Tale\Color;

use ArrayAccess;
use Countable;
use IteratorAggregate;
use Tale\ColorInterface;

interface PaletteInterface extends ArrayAccess, IteratorAggregate, Countable
{

    public function getMaxSize(): ?int;

    /**
     * @return ColorInterface[]
     */
    public function getColors(): array;
}
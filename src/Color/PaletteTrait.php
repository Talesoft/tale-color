<?php
declare(strict_types=1);

namespace Tale\Color;

use RuntimeException;
use Tale\Color;
use Tale\ColorInterface;

trait PaletteTrait
{
    private $maxSize ;
    private $colors = [];

    /**
     * @return int|null
     */
    public function getMaxSize(): ?int
    {
        return $this->maxSize;
    }

    /**
     * @param int|null $maxSize
     *
     * @return PaletteTrait
     */
    public function setMaxSize($maxSize): PaletteTrait
    {
        $this->maxSize = $maxSize;
        return $this;
    }

    /**
     * @return ColorInterface[]
     */
    public function getColors(): array
    {
        return $this->colors;
    }

    public function getIterator(): \Generator
    {
        foreach ($this->colors as $color) {
            yield $color;
        }
    }

    public function count(): int
    {
        return \count($this->colors);
    }

    public function offsetExists($offset): bool
    {
        return isset($this->colors[$offset]);
    }

    /**
     * @param $offset
     * @return ColorInterface
     */
    public function offsetGet($offset): ColorInterface
    {
        return $this->colors[$offset];
    }

    public function offsetSet($offset, $color): void
    {
        if ($offset === null) {
            $offset = $this->count();
        }

        if ($this->maxSize && $offset > $this->maxSize - 1) {
            throw new \OutOfBoundsException(
                "Tried to set offset $offset in a palette that fits only {$this->maxSize} values"
            );
        }

        $color = Color::get($color);
        if (!($color instanceof ColorInterface)) {
            throw new RuntimeException('The color you passed to PaletteTrait->offsetSet() is not valid');
        }
        $this->colors[$offset] = $color;
    }

    public function offsetUnset($offset): void
    {
        unset($this->colors[$offset]);
    }
}
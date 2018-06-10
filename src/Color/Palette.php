<?php
declare(strict_types=1);

namespace Tale\Color;

use Tale\Color;
use Tale\ColorInterface;

class Palette implements PaletteInterface
{
    use PaletteTrait;

    /**
     * constructor.
     *
     * @param iterable $colors
     * @param int $maxSize
     */
    public function __construct(iterable $colors = null, int $maxSize = null)
    {
        $this->setMaxSize($maxSize);
        if ($colors) {
            foreach ($colors as $color) {
                $this[] = $color;
            }
        }
    }

    public static function merge(PaletteInterface $palette, PaletteInterface $mergePalette, bool $prepend = false): PaletteInterface
    {
        $paletteColors = $palette->getColors();
        $mergePaletteColors = $mergePalette->getColors();
        $totalCount = \count($paletteColors) + \count($mergePaletteColors);
        
        return new Color\Palette(
            $prepend
                ? array_merge($mergePaletteColors, $paletteColors)
                : array_merge($paletteColors, $mergePaletteColors),
            $totalCount
        );
    }

    /**
     * @param PaletteInterface $palette
     * @param callable $filterCallback
     * @return PaletteInterface
     */
    public static function filter(PaletteInterface $palette, callable $filterCallback): PaletteInterface
    {
        $filter = function(PaletteInterface $palette) use ($filterCallback) {
            foreach ($palette as $i => $color) {
                if (!$filterCallback($color, $i)) {
                    continue;
                }
                yield $color;
            }
        };

        return new Color\Palette(new \CallbackFilterIterator($filter($palette), $filterCallback));
    }

    /**
     * @param PaletteInterface $palette
     * @param string $hueRange
     * @return PaletteInterface
     */
    public static function filterByHueRange(PaletteInterface $palette, string $hueRange): PaletteInterface
    {
        return self::filter($palette, function(ColorInterface $color) use ($hueRange) {
            return Color::isColorHueRange($color, $hueRange);
        });
    }

    /**
     * @param PaletteInterface $palette
     * @param float $requiredDifference
     * @return PaletteInterface
     */
    public static function filterSimilarColors(PaletteInterface $palette, float $requiredDifference = 8.0): PaletteInterface
    {
        $distinctColors = [];
        foreach ($palette as $color) {
            $exists = false;
            foreach ($distinctColors as $dColor) {
                if (Color::equals($color, $dColor, $requiredDifference)) {
                    $exists = true;
                    break;
                }
            }

            if (!$exists) {
                $distinctColors[] = $color;
            }
        }
        return new Color\Palette($distinctColors);
    }

    public static function toHtml(PaletteInterface $palette, ?int $columns = null, int $width = 120, int $height = 120): string
    {
        $html = '';
        foreach ($palette as $i => $color) {
            $html .= Color::toHtml($color, $width, $height);
            if ($columns !== null && ($i + 1) % $columns === 0) {
                $html .= '<br>';
            }
        }

        return $html;
    }
}
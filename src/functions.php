<?php
declare(strict_types=1);

namespace Tale;

use Tale\Color\Palette;
use Tale\Color\PaletteInterface;
use Tale\Color\Scheme\AnalogousScheme;
use Tale\Color\Scheme\ComplementaryScheme;
use Tale\Color\Scheme\HueRotationScheme;
use Tale\Color\Scheme\MonochromaticScheme;
use Tale\Color\Scheme\NamedMonochromaticScheme;
use Tale\Color\Scheme\ShadeScheme;
use Tale\Color\Scheme\SplitComplementaryScheme;
use Tale\Color\Scheme\SquareScheme;
use Tale\Color\Scheme\TetradicScheme;
use Tale\Color\Scheme\TintScheme;
use Tale\Color\Scheme\ToneScheme;
use Tale\Color\Scheme\TriadicScheme;

/** Color functions **/

/**
 * @return array
 */
function color_get_names(): array
{
    return Color::getNames();
}

/**
 * @param ColorInterface|string|int $color
 * @return string
 */
function color_to_name($color): string
{
    return Color::toName(color_get($color));
}

function color_from_name(string $name): ?ColorInterface
{
    return Color::fromName($name);
}

/**
 * @param string $name
 * @param ColorInterface|string|int $color
 */
function color_register_name(string $name, $color): void
{
    Color::registerName($name, color_get($color));
}

/**
 * @param ColorInterface|string|int $color
 * @param bool $expand
 * @return string
 */
function color_to_hex_string($color, bool $expand = false): string
{
    return Color::toHexString(color_get($color), $expand);
}

/**
 * @param string $hexString
 * @return ColorInterface|null
 */
function color_from_hex_string(string $hexString): ?ColorInterface
{
    return Color::fromHexString($hexString);
}

/**
 * @param int $intValue
 * @return ColorInterface
 */
function color_from_int(int $intValue): ColorInterface
{
    return Color::fromInt($intValue);
}

/**
 * @param ColorInterface|string|int $color
 * @return int
 */
function color_to_int($color): int
{
    return Color::toInt(color_get($color));
}

/**
 * @return array
 */
function color_get_functions(): array
{
    return Color::getFunctions();
}

/**
 * @param string $functionString
 * @return ColorInterface|null
 */
function color_from_function_string(string $functionString): ?ColorInterface
{
    return Color::fromFunctionString($functionString);
}

/**
 * @param ColorInterface|string|int $value
 *
 * @return ColorInterface|null
 */
function color_get($value): ?ColorInterface
{
    return Color::get($value);
}

/**
 * @param ColorInterface|string|int $color
 * @return int
 */
function color_get_max($color)
{
    return Color::getMax(color_get($color));
}

/**
 * @param ColorInterface|string|int $color
 * @return int
 */
function color_get_min($color)
{
    return Color::getMin(color_get($color));
}

/**
 * @param ColorInterface|string|int $color
 * @return float
 */
function color_get_average($color)
{
    return Color::getAverage(color_get($color));
}

/**
 * @return array
 */
function color_get_hue_ranges(): array
{
    return Color::HUE_RANGES;
}

/**
 * @param float $hue
 * @return string
 */
function color_get_hue_range(float $hue)
{
    return Color::getHueRange($hue);
}

/**
 * @param float $hue
 * @param string $range
 * @return bool
 */
function color_is_hue_range(float $hue, string $range): bool
{
    return Color::isHueRange($hue, $range);
}

/**
 * @param ColorInterface|string|int $color
 * @return string
 */
function color_get_color_hue_range($color): string
{

    return Color::getColorHueRange(color_get($color));
}

/**
 * @param ColorInterface|string|int $color
 * @param string $range
 * @return bool
 */
function color_is_color_hue_range($color, string $range): bool
{
    return Color::isColorHueRange(color_get($color), $range);
}

/**
 * @param ColorInterface|string|int $color
 * @param ColorInterface|string|int $mixColor
 * @return ColorInterface
 */
function color_mix($color, $mixColor): ColorInterface
{
    return Color::mix(color_get($color), color_get($mixColor));
}

/**
 * @param ColorInterface|string|int $color
 * @return ColorInterface
 */
function color_inverse($color): ColorInterface
{
    return Color::inverse(color_get($color));
}

/**
 * @param ColorInterface|string|int $color
 * @param float $ratio
 * @return ColorInterface
 */
function color_lighten($color, float $ratio): ColorInterface
{

    return Color::lighten(color_get($color), $ratio);
}

/**
 * @param ColorInterface|string|int $color
 * @param float $ratio
 * @return ColorInterface
 */
function color_darken($color, float $ratio): ColorInterface
{
    return Color::darken(color_get($color), $ratio);
}

/**
 * @param ColorInterface|string|int $color
 * @param float $ratio
 * @return ColorInterface
 */
function color_saturate($color, float $ratio): ColorInterface
{
    return Color::saturate(color_get($color), $ratio);
}

/**
 * @param ColorInterface|string|int $color
 * @param float $ratio
 * @return ColorInterface
 */
function color_desaturate($color, float $ratio): ColorInterface
{
    return Color::desaturate(color_get($color), $ratio);
}

/**
 * @param ColorInterface|string|int $color
 * @return ColorInterface
 */
function color_greyscale($color): ColorInterface
{
    return Color::greyscale(color_get($color));
}

/**
 * @param ColorInterface|string|int $color
 * @param int $degrees
 * @return ColorInterface
 */
function color_complement($color, int $degrees = 180): ColorInterface
{
    return Color::complement(color_get($color), $degrees);
}

/**
 * @param ColorInterface|string|int $color
 * @param float $ratio
 * @return ColorInterface
 */
function color_fade($color, float $ratio): ColorInterface
{
    return Color::fade(color_get($color), $ratio);
}

/**
 * @param ColorInterface|string|int $color
 * @param ColorInterface|string|int $compareColor
 * @return float
 */
function color_get_difference($color, $compareColor): float
{
    return Color::getDifference(color_get($color), color_get($compareColor));
}

/**
 * @param ColorInterface|string|int $color
 * @param ColorInterface|string|int $compareColor
 * @param float $tolerance
 * @return bool
 */
function color_equals($color, $compareColor, float $tolerance = 0.0): bool
{
    return Color::equals(color_get($color), color_get($compareColor), $tolerance);
}

/**
 * @param ColorInterface|string|int $color
 * @param int $width
 * @param int $height
 * @return string
 */
function color_to_html($color, int $width = 120, int $height = 120): string
{
    return Color::toHtml(color_get($color), $width, $height);
}


/**
 * @param PaletteInterface $palette
 * @param PaletteInterface $mergePalette
 * @return PaletteInterface
 */
function color_palette_merge(PaletteInterface $palette, PaletteInterface $mergePalette): PaletteInterface
{
    return Palette::merge($palette, $mergePalette);
}

/**
 * @param PaletteInterface $palette
 * @param $hueRange
 * @return PaletteInterface
 */
function color_palette_filter_by_hue_range(PaletteInterface $palette, $hueRange): PaletteInterface
{
    return Palette::filterByHueRange($palette, $hueRange);
}

/**
 * @param PaletteInterface $palette
 * @param float $tolerance
 * @return PaletteInterface
 */
function color_palette_filter_similar_colors(PaletteInterface $palette, float $tolerance = 8.0): PaletteInterface
{
    return Palette::filterSimilarColors($palette, $tolerance);
}

/**
 * @param PaletteInterface $palette
 * @param int|null $columns
 * @param int $width
 * @param int $height
 * @return string
 */
function color_palette_get_html(PaletteInterface $palette, ?int $columns = null, int $width = null, int $height = null): string
{
    return Palette::toHtml($palette, $columns, $width, $height);
}

/**
 * @param ColorInterface|string|int $baseColor
 * @return AnalogousScheme
 */
function color_scheme_analogous($baseColor): AnalogousScheme
{
    return new AnalogousScheme($baseColor);
}

/**
 * @param ColorInterface|string|int $baseColor
 * @return ComplementaryScheme
 */
function color_scheme_complementary($baseColor): ComplementaryScheme
{
    return new ComplementaryScheme($baseColor);
}

/**
 * @param ColorInterface|string|int $baseColor
 * @param int $amount
 * @param float $step
 * @return HueRotationScheme
 */
function color_scheme_hue_rotation($baseColor, int $amount, float $step): HueRotationScheme
{
    return new HueRotationScheme($baseColor, $amount, $step);
}

/**
 * @param ColorInterface|string|int $baseColor
 * @param int $amount
 * @param float $step
 * @return MonochromaticScheme
 */
function color_scheme_monochromatic($baseColor, int $amount, float $step): MonochromaticScheme
{
    return new MonochromaticScheme($baseColor, $amount, $step);
}

function color_scheme_named_monochromatic($baseColor, float $step): NamedMonochromaticScheme
{
    return new NamedMonochromaticScheme($baseColor, $step);
}

/**
 * @param ColorInterface|string|int $baseColor
 * @param int $amount
 * @param float $step
 * @return ShadeScheme
 */
function color_scheme_shades($baseColor, int $amount, float $step): ShadeScheme
{
    return new ShadeScheme($baseColor, $amount, $step);
}

/**
 * @param ColorInterface|string|int $baseColor
 * @return SplitComplementaryScheme
 */
function color_scheme_split_complementary($baseColor): SplitComplementaryScheme
{
    return new SplitComplementaryScheme($baseColor);
}

/**
 * @param ColorInterface|string|int $baseColor
 * @return TetradicScheme
 */
function color_scheme_tetradic($baseColor): TetradicScheme
{
    return new TetradicScheme($baseColor);
}

/**
 * @param ColorInterface|string|int $baseColor
 * @return SquareScheme
 */
function color_scheme_square($baseColor): SquareScheme
{
    return new SquareScheme($baseColor);
}

/**
 * @param ColorInterface|string|int $baseColor
 * @param int $amount
 * @param float $step
 * @return TintScheme
 */
function color_scheme_tints($baseColor, int $amount, float $step): TintScheme
{
    return new TintScheme($baseColor, $amount, $step);
}

/**
 * @param ColorInterface|string|int $baseColor
 * @param int $amount
 * @param float $step
 * @return ToneScheme
 */
function color_scheme_tones($baseColor, int $amount, float $step): ToneScheme
{
    return new ToneScheme($baseColor, $amount, $step);
}

/**
 * @param ColorInterface|string|int $baseColor
 * @return TriadicScheme
 */
function color_scheme_triadic($baseColor): TriadicScheme
{
    return new TriadicScheme($baseColor);
}
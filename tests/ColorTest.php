<?php
declare(strict_types=1);

namespace Tale\Test;

use PHPUnit\Framework\TestCase;
use Tale\Color;
use Tale\ColorInterface;

/**
 * @coversDefaultClass \Tale\Color
 */
class ColorTest extends TestCase
{
    /**
     * @covers ::getNames
     */
    public function testGetNames(): void
    {
        $names = Color::getNames();
        $this->assertArrayHasKey('yellow', $names);
        $this->assertEquals(Color::YELLOW, $names['yellow']);
    }

    /**
     * @covers ::get
     * @covers ::fromFunctionString
     * @covers ::toName
     * @covers ::toInt
     * @covers ::getLongIntType
     * @covers ::getIntType
     *
     * @dataProvider toNameProvider
     *
     * @param string|int $color
     * @param string $name
     */
    public function testToName($color, string $name): void
    {
        $this->assertEquals($name, Color::toName(Color::get($color)));
    }

    public function toNameProvider(): array
    {
        return [
            [Color::RED, 'red'],
            ['rgb(0, 255, 0)', 'electric-green'],
            ['rgba(0, 255, 0, .5)', 'electric-green'],
            ['rgb(0, 0, 255)', 'blue'],
            ['rgb(24, 52, 56)', '0x183438']
        ];
    }

    /**
     * @covers ::fromName
     * @covers ::fromInt
     * @covers ::getLongIntType
     * @covers ::getIntType
     *
     * @dataProvider fromNameProvider
     *
     * @param string $name
     * @param array|null $rgb
     */
    public function testFromName(string $name, ?array $rgb): void
    {
        $color = Color::fromName($name);

        if ($rgb === null) {
            $this->assertNull($color);
            return;
        }

        $this->assertNotNull($color);
        $this->assertEquals($rgb, [$color->getRed(), $color->getGreen(), $color->getBlue()]);
    }

    public function fromNameProvider(): array
    {
        return [
            ['red', [255, 0, 0]],
            ['electric-green', [0, 255, 0]],
            ['blue', [0, 0, 255]],
            ['$', null]
        ];
    }

    /**
     * @covers ::get
     * @covers ::fromName
     * @covers ::registerName
     * @covers ::toInt
     * @covers ::getLongIntType
     * @covers ::getIntType
     */
    public function testRegisterName(): void
    {
        Color::registerName('my-custom-name', new Color\RgbColor(35, 123, 67));
        /** @var Color\RgbColorInterface $color */
        $color = Color::get('my-custom-name');

        $this->assertNotNull($color);
        $this->assertEquals(35, $color->getRed());
        $this->assertEquals(123, $color->getGreen());
        $this->assertEquals(67, $color->getBlue());
    }

    /**
     * @covers ::get
     * @covers ::fromName
     * @covers ::fromHexString
     * @covers ::toHexString
     *
     * @dataProvider toHexStringProvider
     *
     * @param $color
     * @param string $hexString
     * @param bool $expand
     * @param bool $alpha
     */
    public function testToHexString($color, string $hexString, bool $expand, bool $alpha): void
    {
        $color = Color::get($color);
        $this->assertNotNull($color);
        $this->assertEquals($hexString, Color::toHexString($color, $expand, $alpha));
    }

    public function toHexStringProvider(): array
    {
        return [
            ['red', '#f00', false, false],
            ['red', '#ff0000', true, false],
            ['#ccaabb33', '#cab3', false, true],
            ['#cab3', '#ccaabb33', true, true],
            ['#ccaabb33', '#cab', false, false],
            ['#cab3', '#ccaabb', true, false]
        ];
    }

    /**
     * @covers ::fromHexString
     * @covers ::fromInt
     * @covers ::getLongIntType
     * @covers ::getIntType
     *
     * @dataProvider fromHexStringProvider
     *
     * @param string $name
     * @param array|null $rgb
     * @param int $endian
     */
    public function testFromHexString(string $name, ?array $rgb, int $endian): void
    {
        $color = Color::fromHexString($name, $endian);

        if ($rgb === null) {
            $this->assertNull($color);
            return;
        }

        $this->assertNotNull($color);
        $this->assertEquals($rgb, [$color->getRed(), $color->getGreen(), $color->getBlue()]);
    }

    public function fromHexStringProvider(): array
    {
        return [
            ['#010101', [1, 1, 1], Color::ENDIAN_BIG],
            ['#ffffff', [255, 255, 255], Color::ENDIAN_BIG],
            ['#fff', [255, 255, 255], Color::ENDIAN_BIG],
            ['#f00', [255, 0, 0], Color::ENDIAN_BIG],
            ['#f00', [0, 0, 255], Color::ENDIAN_LITTLE],
            ['#00ff00', [0, 255, 0], Color::ENDIAN_BIG],
            ['#ff0000', [0, 0, 255], Color::ENDIAN_LITTLE],
            ['#ff00ff00', [0, 255, 0], Color::ENDIAN_LITTLE],
            ['#00f', [0, 0, 255], Color::ENDIAN_BIG],
            ['#f0f0', [0, 255, 0], Color::ENDIAN_LITTLE],
            ['#a', [0, 0, 10], Color::ENDIAN_BIG],
            ['#a', [0, 0, 0], Color::ENDIAN_LITTLE], //As an int has 4 bytes, with little-endian the first one is ignored (it would me alpha)
            ['#aa', [0, 0, 0], Color::ENDIAN_LITTLE], //Same for this, as it's basically the first byte of the int with 2 nibbles
            ['#0a', [0, 0, 10], Color::ENDIAN_BIG], //Switching endian with a slightly different, but same pattern
            ['test', null, Color::ENDIAN_BIG]
        ];
    }

    /**
     * @covers ::get
     * @covers ::toInt
     * @covers ::getIntType
     *
     * @dataProvider toIntProvider
     *
     * @param $color
     * @param string $int
     * @param int $endian
     */
    public function testToInt($color, string $int, int $endian): void
    {
        $color = Color::get($color);
        $this->assertNotNull($color);
        $this->assertEquals($int, Color::toInt($color, false, $endian)); //We can test alpha ints on 64-bit systems only, as PHP turns them into floats at that point
    }

    public function toIntProvider(): array
    {
        return [
            ['red', 0xff0000, Color::ENDIAN_BIG],
            ['red', 0xff00, Color::ENDIAN_LITTLE], //For little endian we have to display the whole int
            ['electric-green', 0x00ff00, Color::ENDIAN_BIG],
            ['electric-green', 0xff0000, Color::ENDIAN_LITTLE],
            ['blue', 0x0000ff, Color::ENDIAN_BIG],
            //['blue', 0xff000000, Color::ENDIAN_LITTLE],  //blue can't be correctly displayed on 64-bit systems with little endian
        ];
    }

    /**
     * @covers ::fromName
     * @covers ::fromInt
     * @covers ::getIntType
     *
     * @dataProvider fromIntProvider
     *
     * @param int $int
     * @param array|null $rgb
     * @param int $endian
     */
    public function testFromInt(int $int, array $rgb, int $endian): void
    {
        $color = Color::fromInt($int, false, $endian);
        $this->assertEquals($rgb, [$color->getRed(), $color->getGreen(), $color->getBlue()]);
    }

    public function fromIntProvider(): array
    {
        return [
            [0x010101, [1, 1, 1], Color::ENDIAN_BIG],
            [0xffffff, [255, 255, 255], Color::ENDIAN_BIG],
            [0xff0000, [255, 0, 0], Color::ENDIAN_BIG],
            [0xff00, [255, 0, 0], Color::ENDIAN_LITTLE],
            [0x00ff00, [0, 255, 0], Color::ENDIAN_BIG],
            [0xff0000, [0, 255, 0], Color::ENDIAN_LITTLE],
            [0x0000ff, [0, 0, 255], Color::ENDIAN_BIG],
            //[0xff000000, [0, 0, 255], Color::ENDIAN_LITTLE], //blue on little endian can't be tested on 64bit systems
            [0xff, [0, 0, 255], Color::ENDIAN_BIG],
            [0xa, [0, 0, 10], Color::ENDIAN_BIG],
            [0xa, [0, 0, 0], Color::ENDIAN_LITTLE], //As an int has 4 bytes, with little-endian the first one is ignored (it would me alpha)
            [0xaa, [0, 0, 0], Color::ENDIAN_LITTLE], //Same for this, as it's basically the first byte of the int with 2 nibbles
            [0x0a, [0, 0, 10], Color::ENDIAN_BIG], //Switching endian with a slightly different, but same pattern
        ];
    }

    /**
     * @covers ::getFunctions
     */
    public function testGetFunctions(): void
    {
        $functions = Color::getFunctions();
        $this->assertArrayHasKey('rgb', $functions);
        $this->assertInternalType('array', $functions['rgb']);
        $this->assertArrayHasKey('className', $functions['rgb']);
        $this->assertEquals(Color\RgbColor::class, $functions['rgb']['className']);
    }

    /**
     * @covers ::fromFunctionString
     * @covers ::convertValue
     * @covers ::convertValueWithUnit
     *
     * @dataProvider fromFunctionStringProvider
     *
     * @param string $functionString
     * @param string $className
     * @param array|null $values
     */
    public function testFromFunctionString(string $functionString, ?string $className, ?array $values): void
    {
        $color = Color::fromFunctionString($functionString);

        if ($values === null) {
            $this->assertNull($color);
            return;
        }

        $this->assertNotNull($color);
        $this->assertInstanceOf($className, $color);
        switch ($className) {
            case Color\RgbColor::class:
                /** @var Color\RgbColor $color */
                $this->assertEquals($values, [$color->getRed(), $color->getGreen(), $color->getBlue()]);
                break;
            case Color\RgbaColor::class:
                /** @var Color\RgbaColor $color */
                $this->assertEquals($values, [$color->getRed(), $color->getGreen(), $color->getBlue(), $color->getAlpha()]);
                break;
            case Color\HslColor::class:
                /** @var Color\HslColor $color */
                $this->assertEquals($values, [$color->getHue(), $color->getSaturation(), $color->getLightness()]);
                break;
            case Color\HslaColor::class:
                /** @var Color\HslaColor $color */
                $this->assertEquals($values, [$color->getHue(), $color->getSaturation(), $color->getLightness(), $color->getAlpha()]);
                break;
            case Color\HsvColor::class:
                /** @var Color\HsvColor $color */
                $this->assertEquals($values, [$color->getHue(), $color->getSaturation(), $color->getValue()]);
                break;
            case Color\HsvaColor::class:
                /** @var Color\HsvaColor $color */
                $this->assertEquals($values, [$color->getHue(), $color->getSaturation(), $color->getValue(), $color->getAlpha()]);
                break;
            case Color\LabColor::class:
                /** @var Color\LabColor $color */
                $this->assertEquals($values, [$color->getL(), $color->getA(), $color->getB()]);
                break;
            case Color\XyzColor::class:
                /** @var Color\XyzColor $color */
                $this->assertEquals($values, [$color->getX(), $color->getY(), $color->getZ()]);
                break;
        }
    }

    public function fromFunctionStringProvider(): array
    {
        return [
            ['rgb(255, 0, 0)', Color\RgbColor::class, [255, 0, 0]],
            ['rgb(     151    ,     12    , 64    )', Color\RgbColor::class, [151, 12, 64]],
            ['rgb(0%, 67%, 100%)', Color\RgbColor::class, [0, 171, 255]],
            ['rgb(12, 46%, 768‰)', Color\RgbColor::class, [12, 117, 196]],

            ['rgba(64, 67, 134, .7)', Color\RgbaColor::class, [64, 67, 134, .7]],
            ['rgba(51, 43, 28, 60%)', Color\RgbaColor::class, [51, 43, 28, .6]],

            ['hsl(50.7, .5, 0.6)', Color\HslColor::class, [50.7, .5, .6]],
            ['hsl(64%, .46, 1)', Color\HslColor::class, [230.4, .46, 1.0]],
            ['hsl(187°, 20%, 60%)', Color\HslColor::class, [187.0, .2, .6]],

            ['hsla(50.7, .5, 0.6, .5)', Color\HslaColor::class, [50.7, .5, .6, .5]],
            ['hsla(64%, .46, 1, 60%)', Color\HslaColor::class, [230.4, .46, 1.0, .6]],

            ['hsv(50.7, .5, 0.6)', Color\HsvColor::class, [50.7, .5, .6]],
            ['hsv(64%, .46, 1)', Color\HsvColor::class, [230.4, .46, 1.0]],
            ['hsv(187°, 20%, 60%)', Color\HsvColor::class, [187.0, .2, .6]],
            ['hsv(187deg, 20%, 60%)', Color\HsvColor::class, [187.0, .2, .6]],
            ['hsv(2.346rad, 20%, 60%)', Color\HsvColor::class, [134.416, .2, .6]],

            ['hsva(50.7, .5, 0.6, .5)', Color\HsvaColor::class, [50.7, .5, .6, .5]],
            ['hsva(64%, .46, 1, 60%)', Color\HsvaColor::class, [230.4, .46, 1.0, .6]],

            ['xyz(12.3, 5.6, 20.3)', Color\XyzColor::class, [12.3, 5.6, 20.3]],
            ['xyz(8%, 5%, 60%)', Color\XyzColor::class, [7.603759999999999, 5.0, 65.32979999999999]],

            ['lab(12.3, 5.6, -20.3)', Color\LabColor::class, [12.3, 5.6, -20.3]],
            ['lab(88%, 20%, 30%)', Color\LabColor::class, [88.0, .2, .3]],

            ['test(12.3, 5e', null, null]
        ];
    }

    /**
     * @covers ::fromFunctionString
     *
     * @dataProvider fromFunctionThrowsExceptionOnInvalidNumberOfArgumentsProvider
     *
     * @param string $functionString
     */
    public function testFromFunctionThrowsExceptionOnInvalidNumberOfArguments(string $functionString): void
    {
        $this->expectException(Color\Exception\BadFunctionArgumentsException::class);
        Color::fromFunctionString($functionString);

    }

    public function fromFunctionThrowsExceptionOnInvalidNumberOfArgumentsProvider(): array
    {
        return [
            ['rgb(255, 0)'],
            ['rgb(255, 0, 5, 3)'],

            ['rgba(64, 67, 134, .7, .7)'],
            ['rgba(51, 43, 28)'],

            ['hsl(50.7, .5)'],
            ['hsl(64%, .46, 1, .5)'],

            ['hsla(50.7, .5, 0.6)'],
            ['hsla(64%, .46, 1, 60%, .9)'],

            ['hsv(50.7, .5)'],
            ['hsv(64%, .46, 1, .9)'],

            ['hsva(50.7, .5, 0.6)'],
            ['hsva(64%, .46, 1, 60%, .4)'],

            ['xyz(12.3, 5.6)'],
            ['xyz(12.3, 5.6, 20.3, .8)'],

            ['lab(12.3, 5.6)'],
            ['lab(12.3, 5.6, -20.3, .3)']
        ];
    }

    /**
     * @covers ::fromFunctionString
     */
    public function testFromFunctionStringThrowsExceptionOnInvalidName(): void
    {
        $this->expectException(Color\Exception\InvalidFunctionNameException::class);
        Color::fromFunctionString('test(5)');
    }

    /**
     * @covers ::fromFunctionString
     * @covers ::convertValueWithUnit
     */
    public function testFromFunctionStringThrowsExceptionOnInvalidArguments(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        Color::fromFunctionString('rgb(testdeg, 0, 0)'); //"deg" will match a unit, but its not a valid value
    }

    /**
     * @covers ::get
     * @covers ::fromName
     * @covers ::fromHexString
     * @covers ::fromFunctionString
     *
     * @dataProvider getProvider
     *
     * @param ColorInterface|string|int $value
     * @param string $className
     * @param array|null $values
     */
    public function testGet($value, ?string $className, ?array $values): void
    {
        $color = Color::get($value);

        if ($values === null) {
            $this->assertNull($color);
            return;
        }

        $this->assertNotNull($color);
        $this->assertInstanceOf($className, $color);
        switch ($className) {
            case Color\RgbColor::class:
                /** @var Color\RgbColor $color */
                $this->assertEquals($values, [$color->getRed(), $color->getGreen(), $color->getBlue()]);
                break;
            case Color\RgbaColor::class:
                /** @var Color\RgbaColor $color */
                $this->assertEquals($values, [$color->getRed(), $color->getGreen(), $color->getBlue(), $color->getAlpha()]);
                break;
            case Color\HslColor::class:
                /** @var Color\HslColor $color */
                $this->assertEquals($values, [$color->getHue(), $color->getSaturation(), $color->getLightness()]);
                break;
            case Color\HslaColor::class:
                /** @var Color\HslaColor $color */
                $this->assertEquals($values, [$color->getHue(), $color->getSaturation(), $color->getLightness(), $color->getAlpha()]);
                break;
            case Color\HsvColor::class:
                /** @var Color\HsvColor $color */
                $this->assertEquals($values, [$color->getHue(), $color->getSaturation(), $color->getValue()]);
                break;
            case Color\HsvaColor::class:
                /** @var Color\HsvaColor $color */
                $this->assertEquals($values, [$color->getHue(), $color->getSaturation(), $color->getValue(), $color->getAlpha()]);
                break;
            case Color\LabColor::class:
                /** @var Color\LabColor $color */
                $this->assertEquals($values, [$color->getL(), $color->getA(), $color->getB()]);
                break;
            case Color\XyzColor::class:
                /** @var Color\XyzColor $color */
                $this->assertEquals($values, [$color->getX(), $color->getY(), $color->getZ()]);
                break;
        }
    }

    public function getProvider(): array
    {
        return array_merge([
            [new Color\HslColor(.4, .2, .8), Color\HslColor::class, [.4, .2, .8]],
            [0xff0000, Color\RgbColor::class, [255, 0, 0]],
            ['red', Color\RgbColor::class, [255, 0, 0]],
            ['electric-green', Color\RgbColor::class, [0, 255, 0]],
            ['blue', Color\RgbColor::class, [0, 0, 255]],
            ['#abc', Color\RgbColor::class, [170, 187, 204]],
            ['#aabbcc', Color\RgbColor::class, [170, 187, 204]],
            ['#abcf', Color\RgbaColor::class, [170, 187, 204, 1.0]],
            ['#aabbccff', Color\RgbaColor::class, [170, 187, 204, 1.0]]
        ], $this->fromFunctionStringProvider());
    }

    /**
     * @covers ::getMax
     */
    public function testGetMax(): void
    {
        $this->assertEquals(240, Color::getMax(new Color\RgbColor(25, 240, 154)));
    }

    /**
     * @covers ::getMin
     */
    public function testGetMin(): void
    {
        $this->assertEquals(25, Color::getMin(new Color\RgbColor(25, 240, 154)));
    }

    /**
     * @covers ::getAverage
     */
    public function testGetAverage(): void
    {
        $this->assertEquals(80.0, Color::getAverage(new Color\RgbColor(30, 90, 120)));
    }

    /**
     * @covers ::getHueRange
     *
     * @dataProvider getHueRangeProvider
     *
     * @param float $hue
     * @param string $hueRange
     */
    public function testGetHueRange(float $hue, string $hueRange): void
    {
        $this->assertEquals($hueRange, Color::getHueRange($hue));
    }

    public function getHueRangeProvider(): array
    {
        return [
            [330.0, Color::HUE_RANGE_RED],
            [29.9, Color::HUE_RANGE_RED],
            [30.0, Color::HUE_RANGE_YELLOW],
            [89.9, Color::HUE_RANGE_YELLOW],
            [90.0, Color::HUE_RANGE_GREEN],
            [149.9, Color::HUE_RANGE_GREEN],
            [150.0, Color::HUE_RANGE_CYAN],
            [209.9, Color::HUE_RANGE_CYAN],
            [210.0, Color::HUE_RANGE_BLUE],
            [269.9, Color::HUE_RANGE_BLUE],
            [270.0, Color::HUE_RANGE_MAGENTA],
            [329.9, Color::HUE_RANGE_MAGENTA]
        ];
    }

    /**
     * @covers ::isHueRange
     */
    public function testIsHueRange(): void
    {
        $this->assertTrue(Color::isHueRange(330.0, Color::HUE_RANGE_RED));
    }

    /**
     * @covers ::getColorHueRange
     * @covers ::fromInt
     *
     * @dataProvider getColorHueRangeProvider
     *
     * @param int $colorInt
     * @param string $hueRange
     */
    public function testGetColorHueRange(int $colorInt, string $hueRange): void
    {
        $color = Color::fromInt($colorInt);
        $this->assertNotNull($color);
        $this->assertEquals($hueRange, Color::getColorHueRange($color));
    }

    public function getColorHueRangeProvider(): array
    {
        return [
            [Color::RED, Color::HUE_RANGE_RED],
            [Color::YELLOW, Color::HUE_RANGE_YELLOW],
            [Color::ELECTRIC_GREEN, Color::HUE_RANGE_GREEN],
            [Color::CYAN, Color::HUE_RANGE_CYAN],
            [Color::BLUE, Color::HUE_RANGE_BLUE],
            [Color::MAGENTA, Color::HUE_RANGE_MAGENTA]
        ];
    }

    /**
     * @covers ::isColorHueRange
     */
    public function testIsColorHueRange(): void
    {
        $this->assertTrue(Color::isColorHueRange(Color::get(Color::RED), Color::HUE_RANGE_RED));
    }

    /**
     * @covers ::mix
     */
    public function testMix(): void
    {
        $color = Color::get(Color::RED);
        $mixColor = Color::get(Color::BLUE);
        $mixedColor = Color::mix($color, $mixColor);
        $this->assertEquals(127, $mixedColor->getRed());
        $this->assertEquals(0, $mixedColor->getGreen());
        $this->assertEquals(127, $mixedColor->getBlue());

        $color = new Color\RgbaColor(255, 0, 0, 1.0);
        $mixColor = new Color\RgbaColor(0, 0, 255, 0.0);
        /** @var Color\RgbaColor $mixedColor */
        $mixedColor = Color::mix($color, $mixColor);
        $this->assertEquals(127, $mixedColor->getRed());
        $this->assertEquals(0, $mixedColor->getGreen());
        $this->assertEquals(127, $mixedColor->getBlue());
        $this->assertEquals(.5, $mixedColor->getAlpha());

    }

    /**
     * @covers ::inverse
     */
    public function testInverse(): void
    {
        $color = Color::get(Color::RED);
        $inversedColor = Color::inverse($color);
        $this->assertEquals(0, $inversedColor->getRed());
        $this->assertEquals(255, $inversedColor->getGreen());
        $this->assertEquals(255, $inversedColor->getBlue());

        $color = new Color\RgbaColor(255, 0, 0, .5);
        /** @var Color\RgbaColor $inversedColor */
        $inversedColor = Color::inverse($color);
        $this->assertEquals(0, $inversedColor->getRed());
        $this->assertEquals(255, $inversedColor->getGreen());
        $this->assertEquals(255, $inversedColor->getBlue());
        $this->assertEquals(.5, $inversedColor->getAlpha());
    }

    /**
     * @covers ::lighten
     */
    public function testLighten(): void
    {
        $color = Color::get(Color::RED);
        $lightColor = Color::lighten($color, .2);
        $this->assertEquals(0.0, $lightColor->getHue());
        $this->assertEquals(1.0, $lightColor->getSaturation());
        $this->assertEquals(.7, $lightColor->getLightness());

        $lighterColor = Color::lighten($lightColor, .2);
        $this->assertEquals(0.0, $lighterColor->getHue());
        $this->assertEquals(1.0, $lighterColor->getSaturation());
        $this->assertEquals(.9, $lighterColor->getLightness());
    }

    /**
     * @covers ::darken
     */
    public function testDarken(): void
    {
        $color = Color::get(Color::RED);
        $darkColor = Color::darken($color, .2);
        $this->assertEquals(0.0, $darkColor->getHue());
        $this->assertEquals(1.0, $darkColor->getSaturation());
        $this->assertEquals(.3, $darkColor->getLightness());

        $darkerColor = Color::darken($darkColor, .2);
        $this->assertEquals(0.0, $darkerColor->getHue());
        $this->assertEquals(1.0, $darkerColor->getSaturation());
        $this->assertEquals(.1, $darkerColor->getLightness());
    }

    /**
     * @covers ::saturate
     */
    public function testSaturate(): void
    {
        $color = Color::get(0x884444);
        $satColor = Color::saturate($color, .2);
        $this->assertEquals(0.0, $satColor->getHue());
        $this->assertEquals(.53, $satColor->getSaturation(), '', .01);
        $this->assertEquals(.4, $satColor->getLightness());

        $satterColor = Color::saturate($satColor, .2);
        $this->assertEquals(0.0, $satterColor->getHue());
        $this->assertEquals(.73, $satterColor->getSaturation(), '', .01);
        $this->assertEquals(.4, $satterColor->getLightness());
    }

    /**
     * @covers ::desaturate
     */
    public function testDesaturate(): void
    {
        $color = Color::get(Color::RED);
        $unsatColor = Color::desaturate($color, .2);
        $this->assertEquals(0.0, $unsatColor->getHue());
        $this->assertEquals(.8, $unsatColor->getSaturation());
        $this->assertEquals(.5, $unsatColor->getLightness());

        $unsatterColor = Color::desaturate($unsatColor, .2);
        $this->assertEquals(0.0, $unsatterColor->getHue());
        $this->assertEquals(.6, $unsatterColor->getSaturation());
        $this->assertEquals(.5, $unsatterColor->getLightness());
    }

    /**
     * @covers ::greyscale
     */
    public function testGreyscale(): void
    {
        $color = Color::get(Color::RED);
        $greyColor = Color::greyscale($color);
        $this->assertEquals(.0, $greyColor->getHue());
        $this->assertEquals(.0, $greyColor->getSaturation());
        $this->assertEquals(.5, $greyColor->getLightness());
    }

    /**
     * @covers ::complement
     */
    public function testComplement(): void
    {
        $color = Color::get(Color::RED);
        $complementaryColor = Color::complement($color);
        $this->assertEquals(180.0, $complementaryColor->getHue());
        $this->assertEquals(1.0, $complementaryColor->getSaturation());
        $this->assertEquals(.5, $complementaryColor->getLightness());

        $neighbourColor = Color::complement($color, 90);
        $this->assertEquals(90, $neighbourColor->getHue());
        $this->assertEquals(1.0, $neighbourColor->getSaturation());
        $this->assertEquals(.5, $neighbourColor->getLightness());
    }

    /**
     * @covers ::fade
     */
    public function testFade(): void
    {
        $color = Color::get(Color::RED);
        $fadedColor = Color::fade($color, .2);
        $this->assertEquals(.8, $fadedColor->getAlpha());

        $fadedColor = Color::fade($fadedColor, .4);
        $this->assertEquals(.4, $fadedColor->getAlpha());
    }

    /**
     * @covers ::getHueRange
     * @covers ::cieLabToHue
     *
     * @dataProvider getDifferenceProvider
     *
     * @param int $colorInt
     * @param int $compareColorInt
     * @param float $expectedDifference
     * @param float $precision
     */
    public function testGetDifference(int $colorInt, int $compareColorInt, float $expectedDifference, float $precision): void
    {
        $color = Color::fromInt($colorInt);
        $compareColor = Color::fromInt($compareColorInt);
        $difference = Color::getDifference($color, $compareColor);
        $this->assertEquals($expectedDifference, $difference, '', $precision);
    }

    public function getDifferenceProvider(): array
    {
        return [
            [Color::RED, Color::RED, 0.0, 0.0],
            [Color::RED, Color::RED_BROWN, 18.928, .001],
            [Color::RED, Color::RED_DEVIL, 25.452, .001],
            [Color::RED, Color::BLUE, 52.878, .001],
            [Color::RED, Color::ELECTRIC_GREEN, 86.615, .001],
            [Color::RED, Color::YELLOW, 64.307, .001],
            [Color::RED, Color::MAGENTA, 42.59, .001],
            [Color::RED, Color::CYAN, 70.96, .001]
        ];
    }

    /**
     * @covers ::equals
     * @covers ::getDifference
     * @covers ::cieLabToHue
     *
     * @dataProvider equalsProvider
     *
     * @param int $colorInt
     * @param int $compareColorInt
     * @param bool $equals
     * @param float $tolerance
     */
    public function testEquals(int $colorInt, int $compareColorInt, bool $equals, float $tolerance): void
    {
        $color = Color::fromInt($colorInt);
        $compareColor = Color::fromInt($compareColorInt);
        $this->assertEquals($equals, Color::equals($color, $compareColor, $tolerance));
    }

    public function equalsProvider(): array
    {
        return [
            [Color::RED, Color::RED, true, 0.0],
            [Color::RED, Color::RED_BROWN, true, 20.0],
            [Color::RED, Color::RED_DEVIL, false, 20.0],
            [Color::RED, Color::BLUE, false, 20.0],
            [Color::RED, Color::ELECTRIC_GREEN, false, 20.0],
            [Color::RED, Color::YELLOW, false, 20.0],
            [Color::RED, Color::MAGENTA, true, 50.0],
            [Color::RED, Color::CYAN, false, 60.0]
        ];
    }

    /**
     * @covers ::toHtml
     */
    public function testToHtml(): void
    {
        $html = Color::toHtml(Color::get('red'));
        $this->assertEquals('<div style="display: inline-block; vertical-align: middle; width: 120px; height: 120px; background: rgba(255,0,0,1.00); color: rgba(0,255,255,1.00); font-size: 12px; font-family: Arial, sans-serif; text-align: center; line-height: 30px;">rgb(255,0,0)<br>#f00<br>red->0<br>red</div>', $html);
    }

    /**
     * @covers ::validateDivisor
     */
    public function testValidateDivisor(): void
    {
        $this->expectException(Color\Exception\ZeroDivisionException::class);
        Color::validateDivisor(0);
    }

    /**
     * @covers ::capValue
     */
    public function testCapValue(): void
    {
        $this->assertEquals(20.0, Color::capValue(5.0, 20.0, 150.0));
        $this->assertEquals(150.0, Color::capValue(600.0, 20.0, 150.0));
    }

    /**
     * @covers ::rotateValue
     */
    public function testRotateValue(): void
    {
        $this->assertEquals(116.0, Color::rotateValue(-64, 180));
        $this->assertEquals(67.0, Color::rotateValue(247, 180));
    }
}

<?php
declare(strict_types=1);

namespace Tale\Test;

use PHPUnit\Framework\TestCase;
use Tale\Color\AlphaColorInterface;
use Tale\Color\HslaColor;
use Tale\Color\HslColor;

/**
 * @coversDefaultClass \Tale\Color\HslColor
 */
class HslColorTest extends TestCase
{
    /**
     * @covers ::__construct
     * @covers \Tale\Color\AbstractHsColor::__construct
     * @covers ::getHue
     * @covers \Tale\Color\AbstractHsColor::getHue
     * @covers ::setHue
     * @covers \Tale\Color\AbstractHsColor::setHue
     * @covers ::getSaturation
     * @covers \Tale\Color\AbstractHsColor::getSaturation
     * @covers ::setSaturation
     * @covers \Tale\Color\AbstractHsColor::setSaturation
     * @covers ::getLightness
     * @covers ::setLightness
     *
     */
    public function testGettersAndSetters(): void
    {
        $color = new HslColor(240.0, .4, .8);
        $this->assertEquals(240.0, $color->getHue());
        $this->assertEquals(.4, $color->getSaturation());
        $this->assertEquals(.8, $color->getLightness());

        $color->setHue(-60);
        $this->assertEquals(300, $color->getHue());
        $color->setHue(600);
        $this->assertEquals(240.0, $color->getHue());

        $color->setSaturation(-12.0);
        $this->assertEquals(0.0, $color->getSaturation());
        $color->setSaturation(34.0);
        $this->assertEquals(1.0, $color->getSaturation());

        $color->setLightness(-12.0);
        $this->assertEquals(0.0, $color->getLightness());
        $color->setLightness(34.0);
        $this->assertEquals(1.0, $color->getLightness());
    }

    /**
     * @covers ::__construct
     * @covers \Tale\Color\AbstractHsColor::__construct
     * @covers ::toAlpha
     * @covers ::toOpaque
     * @covers ::getHue
     * @covers \Tale\Color\AbstractHsColor::getHue
     * @covers ::getSaturation
     * @covers \Tale\Color\AbstractHsColor::getSaturation
     * @covers ::getLightness
     */
    public function testToAlphaAndOpaque(): void
    {
        $color = new HslColor(240., .4, .8);
        $alphaColor = $color->toAlpha();
        $this->assertInstanceOf(HslaColor::class, $alphaColor);
        $this->assertEquals($color->getHue(), $alphaColor->getHue());
        $this->assertEquals($color->getSaturation(), $alphaColor->getSaturation());
        $this->assertEquals($color->getLightness(), $alphaColor->getLightness());
        $this->assertEquals(1.0, $alphaColor->getAlpha());

        $opaqueColor = $color->toOpaque();
        $this->assertInstanceOf(HslColor::class, $opaqueColor);
        $this->assertNotInstanceOf(AlphaColorInterface::class, $opaqueColor);
        $this->assertNotSame($color, $opaqueColor);
        $this->assertEquals($color->getHue(), $opaqueColor->getHue());
        $this->assertEquals($color->getSaturation(), $opaqueColor->getSaturation());
        $this->assertEquals($color->getLightness(), $opaqueColor->getLightness());
    }

    /**
     * @covers ::__construct
     * @covers \Tale\Color\AbstractHsColor::__construct
     * @covers ::toRgb
     * @covers ::toRgba
     * @covers ::getRgbFromHue
     *
     * @dataProvider toRgbAndRgbaProvider
     *
     * @param array $hsl
     * @param array $rgb
     */
    public function testToRgbAndRgba(array $hsl, array $rgb): void
    {
        [$h, $s, $l] = $hsl;
        $color = new HslColor($h, $s, $l);
        $rgbColor = $color->toRgb();
        $this->assertEquals($rgb, [
            $rgbColor->getRed(),
            $rgbColor->getGreen(),
            $rgbColor->getBlue()
        ]);

        $rgbaColor = $color->toRgba();
        $this->assertEquals(array_merge($rgb, [1.0]), [
            $rgbaColor->getRed(),
            $rgbaColor->getGreen(),
            $rgbaColor->getBlue(),
            $rgbaColor->getAlpha()
        ]);
    }

    public function toRgbAndRgbaProvider(): array
    {
        return [
            [[0.0, 0.0, 0.0], [0, 0, 0]],
            [[0.0, 1.0, .5], [255, 0, 0]],
            [[120.0, 1.0, .5], [0, 255, 0]],
            [[240.0, 1.0, .5], [0, 0, 255]],
            [[60.0, 1.0, .5], [255, 255, 0]],
            [[180.0, 1.0, .5], [0, 255, 255]],
            [[300.0, 1.0, .5], [255, 0, 255]],
            [[0.0, 0.0, 1.0], [255, 255, 255]],
            [[0.0, 1.0, .25], [127, 0, 0]],
            [[120.0, 1.0, .25], [0, 127, 0]],
            [[240.0, 1.0, .25], [0, 0, 127]],
            [[60.0, 1.0, .25], [127, 127, 0]],
            [[180.0, 1.0, .25], [0, 127, 127]],
            [[300.0, 1.0, .25], [127, 0, 127]],
            [[0.0, 0.0, .5], [127, 127, 127]],
            [[0.0, 0.0, .25], [64, 64, 64]]
        ];
    }

    /**
     * @covers ::__construct
     * @covers \Tale\Color\AbstractHsColor::__construct
     * @covers ::toHsl
     * @covers ::toHsla
     * @covers ::getHue
     * @covers \Tale\Color\AbstractHsColor::getHue
     * @covers ::getSaturation
     * @covers \Tale\Color\AbstractHsColor::getSaturation
     * @covers ::getLightness
     */
    public function testToHslAndHsla(): void
    {
        $color = new HslColor(240., .4, .8);
        $hslColor = $color->toHsl();
        $this->assertNotSame($color, $hslColor);
        $this->assertEquals($color->getHue(), $hslColor->getHue());
        $this->assertEquals($color->getSaturation(), $hslColor->getSaturation());
        $this->assertEquals($color->getLightness(), $hslColor->getLightness());

        $hslaColor = $color->toHsla();
        $this->assertNotSame($color, $hslaColor);
        $this->assertEquals($color->getHue(), $hslaColor->getHue());
        $this->assertEquals($color->getSaturation(), $hslaColor->getSaturation());
        $this->assertEquals($color->getLightness(), $hslaColor->getLightness());
        $this->assertEquals(1.0, $hslaColor->getAlpha());
    }

    /**
     * @covers ::__construct
     * @covers \Tale\Color\AbstractHsColor::__construct
     * @covers ::toHsv
     * @covers ::toHsva
     *
     * @dataProvider toHsvAndHsvaProvider
     *
     * @param array $hsl
     * @param array $hsv
     */
    public function testToHsvAndHsva(array $hsl, array $hsv): void
    {
        [$h, $s, $l] = $hsl;
        $color = new HslColor($h, $s, $l);
        $hsvColor = $color->toHsv();
        $this->assertEquals($hsv, [
            $hsvColor->getHue(),
            $hsvColor->getSaturation(),
            $hsvColor->getValue()
        ]);

        $hsvaColor = $color->toHsva();
        $this->assertEquals(array_merge($hsv, [1.0]), [
            $hsvaColor->getHue(),
            $hsvaColor->getSaturation(),
            $hsvaColor->getValue(),
            $hsvaColor->getAlpha()
        ]);
    }

    public function toHsvAndHsvaProvider(): array
    {
        return [
            [[0.0, 0.0, 0.0], [0.0, 0.0, 0.0]],
            [[0.0, 1.0, .5], [0.0, 1.0, 1.0]],
            [[120.0, 1.0, .5], [120.0, 1.0, 1.0]],
            [[240.0, 1.0, .5], [240.0, 1.0, 1.0]],
            [[60.0, 1.0, .5], [60.0, 1.0, 1.0]],
            [[180.0, 1.0, .5], [180.0, 1.0, 1.0]],
            [[300.0, 1.0, .5], [300.0, 1.0, 1.0]],
            [[0.0, 0.0, 1.0], [0.0, 0.0, 1.0]],
            [[0.0, 1.0, .25], [0.0, 1.0, .5]],
            [[120.0, 1.0, .25], [120.0, 1.0, .5]],
            [[240.0, 1.0, .25], [240.0, 1.0, .5]],
            [[60.0, 1.0, .25], [60.0, 1.0, .5]],
            [[180.0, 1.0, .25], [180.0, 1.0, .5]],
            [[300.0, 1.0, .25], [300.0, 1.0, .5]],
            [[0.0, 0.0, .5], [0.0, 0.0, .5]],
            [[0.0, 0.0, .25], [0.0, 0.0, .25]]
        ];
    }

    /**
     * @covers ::__construct
     * @covers \Tale\Color\AbstractHsColor::__construct
     * @covers ::toXyz
     * @covers ::toLab
     */
    public function testToXyzAndLab(): void
    {
        //There's no need to test the conversion too hard here, as it's running through the RGB conversion
        //(those are tested well instead)
        $color = new HslColor(240., .4, .8);
        $xyzColor = $color->toXyz();
        $this->assertNotSame($color, $xyzColor);
        $this->assertEquals(50.362, $xyzColor->getX(), '', .001);
        $this->assertEquals(49.853, $xyzColor->getY(), '', .001);
        $this->assertEquals(77.489, $xyzColor->getZ(), '', .001);

        $labColor = $color->toLab();
        $this->assertNotSame($color, $labColor);
        $this->assertEquals(75.979, $labColor->getL(), '', .001);
        $this->assertEquals(8.138, $labColor->getA(), '', .001);
        $this->assertEquals(-19.978, $labColor->getB(), '', .001);
    }

    /**
     * @covers ::__construct
     * @covers \Tale\Color\AbstractHsColor::__construct
     * @covers ::__toString
     * @covers \Tale\Color::formatValue
     *
     * @dataProvider toStringProvider
     *
     * @param array $hsl
     * @param string $hslString
     */
    public function testToString(array $hsl, string $hslString): void
    {
        [$h, $s, $l] = $hsl;
        $color = new HslColor($h, $s, $l);
        $this->assertEquals($hslString, (string)$color);
    }

    public function toStringProvider(): array
    {
        return [
            [[0.0, 0.0, 0.0], 'hsl(0,0%,0%)'],
            [[0.0, 1.0, .5], 'hsl(0,100%,50%)'],
            [[120.0, 1.0, .5], 'hsl(120,100%,50%)'],
            [[240.0, 1.0, .5], 'hsl(240,100%,50%)'],
            [[60.0, 1.0, .5], 'hsl(60,100%,50%)'],
            [[180.0, 1.0, .5], 'hsl(180,100%,50%)'],
            [[300.0, 1.0, .5], 'hsl(300,100%,50%)'],
            [[0.0, 0.0, 1.0], 'hsl(0,0%,100%)'],
            [[0.0, 1.0, .25], 'hsl(0,100%,25%)'],
            [[120.0, 1.0, .25], 'hsl(120,100%,25%)'],
            [[240.0, 1.0, .25], 'hsl(240,100%,25%)'],
            [[60.0, 1.0, .25], 'hsl(60,100%,25%)'],
            [[180.0, 1.0, .25], 'hsl(180,100%,25%)'],
            [[300.0, 1.0, .25], 'hsl(300,100%,25%)'],
            [[0.0, 0.0, .5], 'hsl(0,0%,50%)'],
            [[0.0, 0.0, .25], 'hsl(0,0%,25%)'],
            [[243.64734, .468734, .253146], 'hsl(243.647,46.873%,25.315%)']
        ];
    }
}

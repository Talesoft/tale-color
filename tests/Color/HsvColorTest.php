<?php
declare(strict_types=1);

namespace Tale\Test;

use PHPUnit\Framework\TestCase;
use Tale\Color\AlphaColorInterface;
use Tale\Color\HslaColor;
use Tale\Color\HslColor;
use Tale\Color\HsvaColor;
use Tale\Color\HsvColor;

/**
 * @coversDefaultClass \Tale\Color\HsvColor
 */
class HsvColorTest extends TestCase
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
     * @covers ::getValue
     * @covers ::setValue
     *
     */
    public function testGettersAndSetters(): void
    {
        $color = new HsvColor(240.0, .4, .8);
        $this->assertEquals(240.0, $color->getHue());
        $this->assertEquals(.4, $color->getSaturation());
        $this->assertEquals(.8, $color->getValue());

        $color->setHue(-60);
        $this->assertEquals(300, $color->getHue());
        $color->setHue(600);
        $this->assertEquals(240.0, $color->getHue());

        $color->setSaturation(-12.0);
        $this->assertEquals(0.0, $color->getSaturation());
        $color->setSaturation(34.0);
        $this->assertEquals(1.0, $color->getSaturation());

        $color->setValue(-12.0);
        $this->assertEquals(0.0, $color->getValue());
        $color->setValue(34.0);
        $this->assertEquals(1.0, $color->getValue());
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
     * @covers ::getValue
     */
    public function testToAlphaAndOpaque(): void
    {
        $color = new HsvColor(240., .4, .8);
        $alphaColor = $color->toAlpha();
        $this->assertInstanceOf(HsvaColor::class, $alphaColor);
        $this->assertEquals($color->getHue(), $alphaColor->getHue());
        $this->assertEquals($color->getSaturation(), $alphaColor->getSaturation());
        $this->assertEquals($color->getValue(), $alphaColor->getValue());
        $this->assertEquals(1.0, $alphaColor->getAlpha());

        $opaqueColor = $color->toOpaque();
        $this->assertInstanceOf(HsvColor::class, $opaqueColor);
        $this->assertNotInstanceOf(AlphaColorInterface::class, $opaqueColor);
        $this->assertNotSame($color, $opaqueColor);
        $this->assertEquals($color->getHue(), $opaqueColor->getHue());
        $this->assertEquals($color->getSaturation(), $opaqueColor->getSaturation());
        $this->assertEquals($color->getValue(), $opaqueColor->getValue());
    }

    /**
     * @covers ::__construct
     * @covers \Tale\Color\AbstractHsColor::__construct
     * @covers ::toRgb
     * @covers ::toRgba
     *
     * @dataProvider toRgbAndRgbaProvider
     *
     * @param array $hsl
     * @param array $rgb
     */
    public function testToRgbAndRgba(array $hsl, array $rgb): void
    {
        [$h, $s, $v] = $hsl;
        $color = new HsvColor($h, $s, $v);
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
            [[0.0, 1.0, 1.0], [255, 0, 0]],
            [[120.0, 1.0, 1.0], [0, 255, 0]],
            [[240.0, 1.0, 1.0], [0, 0, 255]],
            [[60.0, 1.0, 1.0], [255, 255, 0]],
            [[180.0, 1.0, 1.0], [0, 255, 255]],
            [[300.0, 1.0, 1.0], [255, 0, 255]],
            [[0.0, 0.0, 1.0], [255, 255, 255]],
            [[0.0, 1.0, .5], [127, 0, 0]],
            [[120.0, 1.0, .5], [0, 127, 0]],
            [[240.0, 1.0, .5], [0, 0, 127]],
            [[60.0, 1.0, .5], [127, 127, 0]],
            [[180.0, 1.0, .5], [0, 127, 127]],
            [[300.0, 1.0, .5], [127, 0, 127]],
            [[0.0, 0.0, .5], [127, 127, 127]],
            [[0.0, 0.0, .25], [64, 64, 64]]
        ];
    }

    /**
     * @covers ::__construct
     * @covers \Tale\Color\AbstractHsColor::__construct
     * @covers ::toHsl
     * @covers ::toHsla
     *
     * @dataProvider toHslAndHslaProvider
     *
     * @param array $hsv
     * @param array $hsl
     */
    public function testToHslAndHsla(array $hsv, array $hsl): void
    {
        [$h, $s, $v] = $hsv;
        $color = new HsvColor($h, $s, $v);
        $hslColor = $color->toHsl();
        $this->assertEquals($hsl, [
            $hslColor->getHue(),
            $hslColor->getSaturation(),
            $hslColor->getLightness()
        ]);

        $hslaColor = $color->toHsla();
        $this->assertEquals(array_merge($hsl, [1.0]), [
            $hslaColor->getHue(),
            $hslaColor->getSaturation(),
            $hslaColor->getLightness(),
            $hslaColor->getAlpha()
        ]);
    }

    public function toHslAndHslaProvider(): array
    {
        return [
            [[0.0, 0.0, 0.0], [0.0, 0.0, 0.0]],
            [[0.0, 1.0, 1.0], [0.0, 1.0, .5]],
            [[120.0, 1.0, 1.0], [120.0, 1.0, .5]],
            [[240.0, 1.0, 1.0], [240.0, 1.0, .5]],
            [[60.0, 1.0, 1.0], [60.0, 1.0, .5]],
            [[180.0, 1.0, 1.0], [180.0, 1.0, .5]],
            [[300.0, 1.0, 1.0], [300.0, 1.0, .5]],
            [[0.0, 0.0, 1.0], [0.0, 0.0, 1.0]],
            [[0.0, 1.0, .5], [0.0, 1.0, .25]],
            [[120.0, 1.0, .5], [120.0, 1.0, .25]],
            [[240.0, 1.0, .5], [240.0, 1.0, .25]],
            [[60.0, 1.0, .5], [60.0, 1.0, .25]],
            [[180.0, 1.0, .5], [180.0, 1.0, .25]],
            [[300.0, 1.0, .5], [300.0, 1.0, .25]],
            [[0.0, 0.0, .5], [0.0, 0.0, .5]],
            [[0.0, 0.0, .25], [0.0, 0.0, .25]]
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
     * @covers ::getValue
     */
    public function testToHsvAndHsva(): void
    {
        $color = new HsvColor(240., .4, .8);
        $hsvColor = $color->toHsv();
        $this->assertNotSame($color, $hsvColor);
        $this->assertEquals($color->getHue(), $hsvColor->getHue());
        $this->assertEquals($color->getSaturation(), $hsvColor->getSaturation());
        $this->assertEquals($color->getValue(), $hsvColor->getValue());

        $hsvaColor = $color->toHsva();
        $this->assertNotSame($color, $hsvaColor);
        $this->assertEquals($color->getHue(), $hsvaColor->getHue());
        $this->assertEquals($color->getSaturation(), $hsvaColor->getSaturation());
        $this->assertEquals($color->getValue(), $hsvaColor->getValue());
        $this->assertEquals(1.0, $hsvaColor->getAlpha());
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
        $color = new HsvColor(240., .4, .8);
        $xyzColor = $color->toXyz();
        $this->assertNotSame($color, $xyzColor);
        $this->assertEquals(25.884, $xyzColor->getX(), '', .001);
        $this->assertEquals(22.416, $xyzColor->getY(), '', .001);
        $this->assertEquals(60.089, $xyzColor->getZ(), '', .001);

        $labColor = $color->toLab();
        $this->assertNotSame($color, $labColor);
        $this->assertEquals(54.465, $labColor->getL(), '', .001);
        $this->assertEquals(20.361, $labColor->getA(), '', .001);
        $this->assertEquals(-42.556, $labColor->getB(), '', .001);
    }

    /**
     * @covers ::__construct
     * @covers \Tale\Color\AbstractHsColor::__construct
     * @covers ::__toString
     * @covers \Tale\Color::formatValue
     *
     * @dataProvider toStringProvider
     *
     * @param array $hsv
     * @param string $hsvString
     */
    public function testToString(array $hsv, string $hsvString): void
    {
        [$h, $s, $v] = $hsv;
        $color = new HsvColor($h, $s, $v);
        $this->assertEquals($hsvString, (string)$color);
    }

    public function toStringProvider(): array
    {
        return [
            [[0.0, 0.0, 0.0], 'hsv(0,0%,0%)'],
            [[0.0, 1.0, .5], 'hsv(0,100%,50%)'],
            [[120.0, 1.0, .5], 'hsv(120,100%,50%)'],
            [[240.0, 1.0, .5], 'hsv(240,100%,50%)'],
            [[60.0, 1.0, .5], 'hsv(60,100%,50%)'],
            [[180.0, 1.0, .5], 'hsv(180,100%,50%)'],
            [[300.0, 1.0, .5], 'hsv(300,100%,50%)'],
            [[0.0, 0.0, 1.0], 'hsv(0,0%,100%)'],
            [[0.0, 1.0, .25], 'hsv(0,100%,25%)'],
            [[120.0, 1.0, .25], 'hsv(120,100%,25%)'],
            [[240.0, 1.0, .25], 'hsv(240,100%,25%)'],
            [[60.0, 1.0, .25], 'hsv(60,100%,25%)'],
            [[180.0, 1.0, .25], 'hsv(180,100%,25%)'],
            [[300.0, 1.0, .25], 'hsv(300,100%,25%)'],
            [[0.0, 0.0, .5], 'hsv(0,0%,50%)'],
            [[0.0, 0.0, .25], 'hsv(0,0%,25%)'],
            [[243.64734, .468734, .253146], 'hsv(243.647,46.873%,25.315%)']
        ];
    }
}

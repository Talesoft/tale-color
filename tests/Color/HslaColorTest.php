<?php
declare(strict_types=1);

namespace Tale\Test;

use PHPUnit\Framework\TestCase;
use Tale\Color\AlphaColorInterface;
use Tale\Color\HslaColor;
use Tale\Color\HslColor;
use Tale\Color\RgbaColor;

/**
 * @coversDefaultClass \Tale\Color\HslaColor
 */
class HslaColorTest extends TestCase
{
    /**
     * @covers ::__construct
     * @covers \Tale\Color\HslColor::__construct
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
     * @covers ::getAlpha
     * @covers \Tale\Color\AlphaTrait::getAlpha
     * @covers ::setAlpha
     * @covers \Tale\Color\AlphaTrait::setAlpha
     *
     */
    public function testGettersAndSetters(): void
    {
        $color = new HslaColor(240.0, .4, .8, .5);
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

        $color->setAlpha(-12.0);
        $this->assertEquals(0.0, $color->getAlpha());
        $color->setAlpha(34.0);
        $this->assertEquals(1.0, $color->getAlpha());
    }

    /**
     * @covers ::__construct
     * @covers \Tale\Color\HslColor::__construct
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
        $color = new HslaColor(240., .4, .8, .5);
        $alphaColor = $color->toAlpha();
        $this->assertInstanceOf(HslaColor::class, $alphaColor);
        $this->assertNotSame($color, $alphaColor);
        $this->assertEquals($color->getHue(), $alphaColor->getHue());
        $this->assertEquals($color->getSaturation(), $alphaColor->getSaturation());
        $this->assertEquals($color->getLightness(), $alphaColor->getLightness());
        $this->assertEquals($color->getAlpha(), $alphaColor->getAlpha());

        $opaqueColor = $color->toOpaque();
        $this->assertInstanceOf(HslColor::class, $opaqueColor);
        $this->assertNotInstanceOf(AlphaColorInterface::class, $opaqueColor);
        $this->assertEquals($color->getHue(), $opaqueColor->getHue());
        $this->assertEquals($color->getSaturation(), $opaqueColor->getSaturation());
        $this->assertEquals($color->getLightness(), $opaqueColor->getLightness());
    }

    /**
     * @covers ::__construct
     * @covers \Tale\Color\HslColor::__construct
     * @covers \Tale\Color\AbstractHsColor::__construct
     * @covers ::toRgba
     */
    public function testToRgba(): void
    {
        //There's no need to test the conversion too hard here, as it's running through the HSL conversions
        //(those are tested well instead)
        $color = new HslaColor(240., .4, .8, .5);
        $rgbaColor = $color->toRgba();
        $this->assertEquals(184, $rgbaColor->getRed());
        $this->assertEquals(184, $rgbaColor->getGreen());
        $this->assertEquals(224, $rgbaColor->getBlue());
        $this->assertEquals(.5, $rgbaColor->getAlpha());
    }

    /**
     * @covers ::__construct
     * @covers \Tale\Color\HslColor::__construct
     * @covers \Tale\Color\AbstractHsColor::__construct
     * @covers ::toHsla
     */
    public function testToHsla(): void
    {
        //There's no need to test the conversion too hard here, as it's running through the HSL conversions
        //(those are tested well instead)
        $color = new HslaColor(240., .4, .8, .5);
        $hslaColor = $color->toHsla();
        $this->assertNotSame($color, $hslaColor);
        $this->assertEquals(240.0, $hslaColor->getHue());
        $this->assertEquals(.4, $hslaColor->getSaturation());
        $this->assertEquals(.8, $hslaColor->getLightness());
        $this->assertEquals(.5, $hslaColor->getAlpha());
    }

    /**
     * @covers ::__construct
     * @covers \Tale\Color\HslColor::__construct
     * @covers \Tale\Color\AbstractHsColor::__construct
     * @covers ::toHsva
     */
    public function testToHsva(): void
    {
        //There's no need to test the conversion too hard here, as it's running through the HSL conversions
        //(those are tested well instead)
        $color = new HslaColor(240., .4, .8, .5);
        $hslaColor = $color->toHsva();
        $this->assertNotSame($color, $hslaColor);
        $this->assertEquals(240.0, $hslaColor->getHue());
        $this->assertEquals(0.18181, $hslaColor->getSaturation(), '', .00001);
        $this->assertEquals(0.88, $hslaColor->getValue(), '', .0001);
        $this->assertEquals(.5, $hslaColor->getAlpha());
    }

    /**
     * @covers ::__construct
     * @covers \Tale\Color\AbstractHsColor::__construct
     * @covers ::__toString
     * @covers \Tale\Color::formatValue
     *
     * @dataProvider toStringProvider
     *
     * @param array $hsla
     * @param string $hslaString
     */
    public function testToString(array $hsla, string $hslaString): void
    {
        [$h, $s, $l, $a] = $hsla;
        $color = new HslaColor($h, $s, $l, $a);
        $this->assertEquals($hslaString, (string)$color);
    }

    public function toStringProvider(): array
    {
        return [
            [[0.0, 0.0, 0.0, .4], 'hsla(0,0%,0%,0.4)'],
            [[0.0, 1.0, .5, .4], 'hsla(0,100%,50%,0.4)'],
            [[120.0, 1.0, .5, .4], 'hsla(120,100%,50%,0.4)'],
            [[240.0, 1.0, .5, .4], 'hsla(240,100%,50%,0.4)'],
            [[60.0, 1.0, .5, .4], 'hsla(60,100%,50%,0.4)'],
            [[180.0, 1.0, .5, .4], 'hsla(180,100%,50%,0.4)'],
            [[300.0, 1.0, .5, .4], 'hsla(300,100%,50%,0.4)'],
            [[0.0, 0.0, 1.0, .4], 'hsla(0,0%,100%,0.4)'],
            [[0.0, 1.0, .25, .4], 'hsla(0,100%,25%,0.4)'],
            [[120.0, 1.0, .25, .4], 'hsla(120,100%,25%,0.4)'],
            [[240.0, 1.0, .25, .4], 'hsla(240,100%,25%,0.4)'],
            [[60.0, 1.0, .25, .4], 'hsla(60,100%,25%,0.4)'],
            [[180.0, 1.0, .25, .4], 'hsla(180,100%,25%,0.4)'],
            [[300.0, 1.0, .25, .4], 'hsla(300,100%,25%,0.4)'],
            [[0.0, 0.0, .5, .4], 'hsla(0,0%,50%,0.4)'],
            [[0.0, 0.0, .25, .4], 'hsla(0,0%,25%,0.4)'],
            [[243.64734, .468734, .253146, .24556], 'hsla(243.647,46.873%,25.315%,0.246)']
        ];
    }
}

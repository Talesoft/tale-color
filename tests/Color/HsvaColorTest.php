<?php
declare(strict_types=1);

namespace Tale\Test;

use PHPUnit\Framework\TestCase;
use Tale\Color\AlphaColorInterface;
use Tale\Color\HslaColor;
use Tale\Color\HslColor;
use Tale\Color\HsvaColor;
use Tale\Color\HsvColor;
use Tale\Color\RgbaColor;

/**
 * @coversDefaultClass \Tale\Color\HsvaColor
 */
class HsvaColorTest extends TestCase
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
     * @covers ::getValue
     * @covers ::setValue
     * @covers ::getAlpha
     * @covers \Tale\Color\AlphaTrait::getAlpha
     * @covers ::setAlpha
     * @covers \Tale\Color\AlphaTrait::setAlpha
     *
     */
    public function testGettersAndSetters(): void
    {
        $color = new HsvaColor(240.0, .4, .8, .5);
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
     * @covers ::getValue
     */
    public function testToAlphaAndOpaque(): void
    {
        $color = new HsvaColor(240., .4, .8, .5);
        $alphaColor = $color->toAlpha();
        $this->assertInstanceOf(HsvaColor::class, $alphaColor);
        $this->assertNotSame($color, $alphaColor);
        $this->assertEquals($color->getHue(), $alphaColor->getHue());
        $this->assertEquals($color->getSaturation(), $alphaColor->getSaturation());
        $this->assertEquals($color->getValue(), $alphaColor->getValue());
        $this->assertEquals($color->getAlpha(), $alphaColor->getAlpha());

        $opaqueColor = $color->toOpaque();
        $this->assertInstanceOf(HsvColor::class, $opaqueColor);
        $this->assertNotInstanceOf(AlphaColorInterface::class, $opaqueColor);
        $this->assertEquals($color->getHue(), $opaqueColor->getHue());
        $this->assertEquals($color->getSaturation(), $opaqueColor->getSaturation());
        $this->assertEquals($color->getValue(), $opaqueColor->getValue());
    }

    /**
     * @covers ::__construct
     * @covers \Tale\Color\HslColor::__construct
     * @covers \Tale\Color\AbstractHsColor::__construct
     * @covers ::toRgba
     */
    public function testToRgba(): void
    {
        //There's no need to test the conversion too hard here, as it's running through the HSV conversions
        //(those are tested well instead)
        $color = new HsvaColor(240., .4, .8, .5);
        $rgbaColor = $color->toRgba();
        $this->assertEquals(122, $rgbaColor->getRed());
        $this->assertEquals(122, $rgbaColor->getGreen());
        $this->assertEquals(204, $rgbaColor->getBlue());
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
        //There's no need to test the conversion too hard here, as it's running through the HSV conversions
        //(those are tested well instead)
        $color = new HsvaColor(240., .4, .8, .5);
        $hslaColor = $color->toHsla();
        $this->assertNotSame($color, $hslaColor);
        $this->assertEquals(240.0, $hslaColor->getHue());
        $this->assertEquals(0.44444, $hslaColor->getSaturation(), '', .00001);
        $this->assertEquals(0.64, $hslaColor->getLightness(), '', .00001);
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
        //There's no need to test the conversion too hard here, as it's running through the HSV conversions
        //(those are tested well instead)
        $color = new HsvaColor(240., .4, .8, .5);
        $hsvaColor = $color->toHsva();
        $this->assertNotSame($color, $hsvaColor);
        $this->assertEquals(240.0, $hsvaColor->getHue());
        $this->assertEquals(.4, $hsvaColor->getSaturation());
        $this->assertEquals(.8, $hsvaColor->getValue());
        $this->assertEquals(.5, $hsvaColor->getAlpha());
    }

    /**
     * @covers ::__construct
     * @covers \Tale\Color\AbstractHsColor::__construct
     * @covers ::__toString
     * @covers \Tale\Color::formatValue
     *
     * @dataProvider toStringProvider
     *
     * @param array $hsva
     * @param string $hsvaString
     */
    public function testToString(array $hsva, string $hsvaString): void
    {
        [$h, $s, $v, $a] = $hsva;
        $color = new HsvaColor($h, $s, $v, $a);
        $this->assertEquals($hsvaString, (string)$color);
    }

    public function toStringProvider(): array
    {
        return [
            [[0.0, 0.0, 0.0, .4], 'hsva(0,0%,0%,0.4)'],
            [[0.0, 1.0, .5, .4], 'hsva(0,100%,50%,0.4)'],
            [[120.0, 1.0, .5, .4], 'hsva(120,100%,50%,0.4)'],
            [[240.0, 1.0, .5, .4], 'hsva(240,100%,50%,0.4)'],
            [[60.0, 1.0, .5, .4], 'hsva(60,100%,50%,0.4)'],
            [[180.0, 1.0, .5, .4], 'hsva(180,100%,50%,0.4)'],
            [[300.0, 1.0, .5, .4], 'hsva(300,100%,50%,0.4)'],
            [[0.0, 0.0, 1.0, .4], 'hsva(0,0%,100%,0.4)'],
            [[0.0, 1.0, .25, .4], 'hsva(0,100%,25%,0.4)'],
            [[120.0, 1.0, .25, .4], 'hsva(120,100%,25%,0.4)'],
            [[240.0, 1.0, .25, .4], 'hsva(240,100%,25%,0.4)'],
            [[60.0, 1.0, .25, .4], 'hsva(60,100%,25%,0.4)'],
            [[180.0, 1.0, .25, .4], 'hsva(180,100%,25%,0.4)'],
            [[300.0, 1.0, .25, .4], 'hsva(300,100%,25%,0.4)'],
            [[0.0, 0.0, .5, .4], 'hsva(0,0%,50%,0.4)'],
            [[0.0, 0.0, .25, .4], 'hsva(0,0%,25%,0.4)'],
            [[243.64734, .468734, .253146, .24556], 'hsva(243.647,46.873%,25.315%,0.246)']
        ];
    }
}

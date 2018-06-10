
Tale Color
===========

What is Tale Color?
--------------------

Tale Color is a lightweight implementation of color conversion algorithms and 
manipulation utilities for PHP.

It can convert colors from and to different color spaces, generate 
schemes/arrays of colors automatically and it can also compare colors 
visually through the CIEDE2000 algorithm.

Installation
------------

```bash
composer require talesoft/tale-color
```

Usage
-----

### Color parsing

Tale Color can handle many different color formats and modify them on 
a very detailed level.

Any color Tale Color provides will be of type `Tale\ColorInterface`. They usually
have a higher-level class which defines what color space the color is in.

Tale Color is designed so that you don't need to care about what color 
space your color is in. If you need a different
one to modify the color, just use one of the `to{Space}`-functions.

It all starts with the `Color::get()` function, which will take a string, 
integer or ColorInterface instance and providea valid color of type 
`ColorInterface` for you.

You can pass color names, integer values, hex-strings and function-literals freely.

```php
use Tale\Color;

//By name
Color::get('red'); //RgbColor(255,0,0)
Color::get(Color::MAROON); //RgbColor(128, 0, 0)


//By hex string
Color::get('#00ff00'); //RgbColor(0, 255, 0)
Color::get('#00f'); //RgbColor(0, 0, 255)
Color::get('#000a'); //RgbaColor(0, 0, 0, 0.1)


//By integer
Color::get(0x00ff00); //RgbColor(0, 255, 0)
Color::get(0x00ff00ff); //RgbaColor(0, 255, 0, 1.0)


//By function literals
Color::get('rgb(14, 24, 100)'); //RgbColor(14, 24, 100)
Color::get('hsl(120, .5, 1.0)'); //HslColor(120, 0.5, 1.0)
Color::get('lab(50, 40, 22)'); //LabColor(50, 40, 22)


//Percent-values are allowed and will scale automatically
Color::get('rgba(50%, 100, 20%, 50%)'); //RgbaColor(127.5, 100, 51, 0.5)
Color::get('hsl(50%, 50%, 1.0)'); //HslColor(180, 0.5, 1.0)

//You can also just create them manually (better performance)

use Tale\Color\RgbColor;
use Tale\Color\HslaColor;

$myRgbColor = new RgbColor(0, 100, 0);
$myHslaColor = new HslaColor(120, .5, .1, 1.0);
```

---

### Color conversion

Every color in Tale Color can be converted to any other color 
space instantly.

```php
$color->toHsl()->getLightness();

$color->toRgb()->getGreen();

$color->toLab()->getL();
```

If you have a set of RGB values and want to get the HSL values, the easiest approach
would look like this:

```php
use Tale\Color\RgbColor;

$hsl = (new RgbColor(117, 20, 67))->toHsl();

echo $hsl->getHue();
echo $hsl->getSaturation();
echo $hsl->getLightness();

```


Here's a list of the supported color spaces with their respective 
getters/setters for their values.

- RgbColor (`toRgb()`)
    - `getRed() | setRed($red)`
    - `getGreen() | setGreen($green)`
    - `getBlue() | setBlue($blue)`
    - `toAlpha() -> RgbaColor`
- RgbaColor (`toRgba()`)
    - `getRed() | setRed($red)`
    - `getGreen() | setGreen($green)`
    - `getBlue() | setBlue($blue)`
    - `getAlpha() | setAlpha($alpha)`
    - `toOpaque() -> RgbColor`
- HslColor (`toHsl()`)
    - `getHue() | setHue($hue)`
    - `getSaturation() | setSaturation($saturation)`
    - `getLightness() | setLightness($lightness)`
    - `toAlpha() -> HslaColor`
- HslaColor (`getHsla()`)
    - `getHue() | setHue($hue)`
    - `getSaturation() | setSaturation($saturation)`
    - `getLightness() | setLightness($lightness)`
    - `getAlpha() | setAlpha($alpha)`
    - `toOpaque() -> HslColor`
- HsvColor (`toHsv()`)
    - `getHue() | setHue($hue)`
    - `getSaturation() | setSaturation($saturation)`
    - `getValue() | setValue($value)`
    - `toAlpha() -> HsvaColor`
- HsvaColor (`toHsva()`)
    - `getHue() | setHue($hue)`
    - `getSaturation() | setSaturation($saturation)`
    - `getLightness() | setLightness($lightness)`
    - `getAlpha() | setAlpha($alpha)`
    - `toOpaque() -> HsvColor`
- XyzColor (`toXyz()`)
    - `getX() | setX($x)`
    - `getY() | setY($y)`
    - `getZ() | setZ($z)`
    - `toAlpha() -> RgbaColor`
- CIE L\*a\*b\* (`toLab()`)
    - `getL() | setL($l)`
    - `getA() | setA($a)`
    - `getB() | setB($b)`
    - `toAlpha() -> RgbaColor`

With this system, you can easily manipulate colors through a really expressive 
API. Let's have a quick look.

```php
$lightTurquoise = Color::get('blue')
    ->toRgb()
        ->setGreen(50) //Mix some green in
    ->toHsl()
        ->setLightness(.6) //Make it lighter
    ->toAlpha()
        ->setAlpha(.4) //Add 40% transparency
    ->toRgba(); //Make sure it's a RGBA color in the end
    
echo $lightTurquoise; //"rgba(50,90,255,0.4)"
```

> There is no CMYK conversion. CMYK conversion depends on color profiles
  and I can't just put them into this repository. Everything else would only be approximations
  which are useless in most real-world cases.

We will now look at the possibilities in detail.

---

### Color modification

Color modification is done by converting to specific color spaces and modifying 
their values. e.g. the HSL color space is very handy for reducing lightness or 
increasing saturation of a color.

The `Tale\Color`-class will shorten most operations for you. You don't need to 
convert the color to any space when using the `Color`-class static methods, it 
automatically converts them to the space it needs for the operation.

> Notice that these will almost always change the return type of your color. Convert back and forth to the format you require in your application, double-conversions have a really low memory profile.

```php
//Lightening and darkening (Added, not multiplied)
Color::lighten($color, .4);
Color::darken($color, .2);

//Get the complementary color (180° rotated hue)
Color::complement($color);

//Convert to grayscale
Color::grayscale($color);

//Fade in or out (Added, not multiplied)
Color::fade($color, .1);
Color::fade($color, -.1);

//Mix two colors
Color::mix($color, $mixColor);

//Inverse a color
Color::inverse($color);

//Saturate/Desaturate
Color::saturate($color, .4);
Color::desaturate($color, .2);
```

---

### Color information

The `Color` static class also contains useful utilities that help receiving information of the color you pass to them.

```php
//Get the hue range the color resides in (basically, "what base color is this color"?)
//Supported hue ranges are: RED, YELLOW, GREEN, CYAN, BLUE and MAGENTA.
Color::getColorHueRange(Color::get('rgba(80, 0, 0)')); //Color::HUE_RANGE_RED

//Gets the hexadecimal representation of a color.
//Notice that it will turn an Alpha-color into a 4-channel hexadecimal string, because it can also parse them.
//If you want to use the hex value in CSS or HTML, use `toRgb()` on the color before to strip the alpha channel
Color::toHexString($color);

//Gets the integer representation of a color (alpha channel only on 64bit systems)
Color::toInt($color);

//Get the name of a color. Many colors don't have names, it will return a hex-representation in this case
Color::toName($color);
```

---

### Color comparison

Through the implementation of CIE XYZ, CIE L\*a\*b\* and the CIEDE2000 standard 
for color comparison, you can compare colors visually easily

```php
$red = Color::get('red'); //rgb(255, 0, 0)

Color::getDifference($red, Color::get('blue')); //52.878674140461

Color::getDifference($red, Color::get('maroon')); //25.857031489394

Color::getDifference($red, Color::get('rgb(250, 0, 0)')); //1.0466353226581
```

To compare colors with a tolerance, you can use the `equals`-method

```php
$red = Color::get('red');

foreach ($otherColors as $otherColor) {

    //Using a tolerance of 2, so the maximum difference between the colors is 2
    if (Color::equals($red, $otherColor, 2)) {
        echo "Well, this is almost the same color!";
    }
}
```


**But wait, there's more!**

---

### Color palettes

Palettes are basically arrays of colors. You can add anything to the array that 
is supported by `Color::get()` and the values will automatically convert to 
ColorInterface instances.

The maximum size can be limited with the second parameter to `Palette`.

```php
use Phim\Color\Palette;

$palette = new Palette([
    'red',
    'green',
    'blue',
    Color::YELLOW,
    'hsl(50, .5, .9)',
    'black'
]);

$palette[] = 'rgb(120, 35, 56)';

$palette[0]; //RgbColor(255, 0, 0)
$palette[6]; //RgbColor(120, 35, 56)
```

You can iterate palettes with a normal `foreach`-loop.

The `Palette`-class also provides some utilities to ease up handling the palettes.

#### Merging palettes

```php
use Phim\Color\Palette;

$mergedPalette = Palette::merge($somePalette, $someOtherPalette);
```

#### Filtering palettes

```php
use Phim\Color\Palette;
use Phim\ColorInterface;

//Filter all colors that have a lightness below .4
$filteredPalette = Palette::filter(function(ColorInterface $color) 
{
    return $color->getHsl()->getLightness() >= .4;
});
```

#### Pre-defined filters

Filter all colors based on a hue range. You'll only get colors in the given hue range.

```php
use Phim\Color\Palette;

//Would only yield colors that have a red-ish hue
$palette = Palette::filterByHueRange($palette, Color::HUE_RANGE_RED);
```

Filter out colors that _look_ similar (Uses CIEDE2000 for color comparison)
```php
use Phim\Color\Palette;

//Colors would need to have a difference of at least 4 to all other colors
//in the palette in order to be put in the result collection.
$palette = Palette::filterSimilarColors($palette, 4);
```

---

#### Color Schemes

Schemes are pre-defined, generated palettes. They take a base color and generate a bunch of related colors out of them. For more information, you may read [this](http://www.tigercolor.com/color-lab/color-theory/color-theory-intro.htm).
This is also where I got the following images from (including permission to do so).

Notice that any scheme is always a palette like above, too. You can iterate it with `foreach`.

Tale Color can generate the following schemes for you:

#### Schemes with fixed size

##### Complementary Scheme

![Complementary Scheme](http://www.tigercolor.com/Images/Complementary.gif)
```php
use Phim\Color\Scheme\ComplementaryScheme;

$colors = new ComplementaryScheme($baseColor); //2 colors
```

##### Analogous Scheme

![Analogous Scheme](http://www.tigercolor.com/Images/Analogous.gif)
```php
use Phim\Color\Scheme\AnalogousScheme;

$colors = new AnalogousScheme($baseColor); //3 colors
```

##### Triadic Scheme

![Triadic Scheme](http://www.tigercolor.com/Images/Triad.gif)
```php
use Phim\Color\Scheme\TriadicScheme;

$colors = new TriadicScheme($baseColor); //3 colors
```

##### Split-Complementary Scheme

![Split-Complementary Scheme](http://www.tigercolor.com/Images/SplitComplementary.gif)
```php
use Phim\Color\Scheme\SplitComplementaryScheme;

$colors = new SplitComplementaryScheme($baseColor); //3 colors
```

##### Tetradic Scheme

![Tetradic Scheme](http://www.tigercolor.com/Images/Tetrad.gif)
```php
use Phim\Color\Scheme\TetradicScheme;

$colors = new TetradicScheme($baseColor); //4 colors
```

#### Square Scheme

![Square Scheme](http://www.tigercolor.com/Images/Square.gif)
```php
use Phim\Color\Scheme\SquareScheme;

$colors = new SquareScheme($baseColor); //4 colors
```

##### Named Monochromatic Scheme

Generates 3 shades and 3 tints of a color that you can access via a method. The second parameter is `step` which defines the amount of darkening/lightening between each color.

```php
use Phim\Color\Scheme\NamedMonochromaticScheme;

$colors = new NamedMonochromaticScheme($baseColor, .3); //7 colors

$colors->getDarkestShade();
$colors->getDarkerShader();
$colors->getDarkShade();
$colors->getBaseColor();
$colors->getLightTint();
$colors->getLighterTint();
$colors->getLightestTint();
```


#### Generated schemes (dynamic size)

These take an `amount` and `step`. `amount` specifies the total amount of colors to generate. Specifying `5` will yield a palette with 5 colors (Including the base-color, mostly)

##### Hue Rotation Scheme

Adds adjacent colors in the hue circle.

The code below would generate 5 colors, the base color and 4 further colors each rotated by +5° in hue.

```php
use Phim\Color\Scheme\HueRotationScheme;

$colors = new HueRotationScheme($baseColor, 5, 5); //5 colors, +5° hue per color
```

##### Tint Scheme

Generates lighter tints of the color.

```php
use Phim\Color\Scheme\TintScheme;

$colors = new TintScheme($baseColor, 6, .3); //6 colors, +.3 lightness per color
```

##### Shade Scheme

Generates darker shades of the color.

```php
use Phim\Color\Scheme\ShadeScheme;

$colors = new ShadeScheme($baseColor, 6, .3); //6 colors, -.3 lightness per color
```

##### Tone Scheme

Generates less saturated tones of the color.

```php
use Phim\Color\Scheme\ToneScheme;

$colors = new ToneScheme($baseColor, 6, .3); //6 colors, -.3 saturation per color
```

If you are not sure what colors a scheme will end up with, you can always dump a visual representation of the whole palette by using

```php
echo Palette::toHtml($myPalette);
```

This will print a little table containing all colors in the palette 
including basic information about the colors.

To roll your own scheme, you have many possibilities, the most 
simple one is extending `Tale\Color\AbstractScheme` 
or `Tale\Color\Scheme\AbstractContinousScheme`

```php
<?php

namespace YourApp;

use Tale\Color;
use Tale\ColorInterface;

class MyCustomScheme extends Color\AbstractScheme
{
    protected function generate(ColorInterface $baseColor): \Generator
    {
    	//Generates the passed base-color with 5 different lightness values
    	yield $baseColor->toHsl()->setLightness(.1);
    	yield $baseColor->toHsl()->setLightness(.2);
    	yield $baseColor->toHsl()->setLightness(.3);
    	yield $baseColor->toHsl()->setLightness(.4);
    	yield $baseColor->toHsl()->setLightness(.5);
    }
}
```

or with the continous scheme

```php
<?php

namespace YourApp;

use Tale\Color;
use Tale\ColorInterface;

class MyCustomContinousScheme extends Color\Scheme\AbstractContinousScheme
{
    protected function generateStep(ColorInterface $baseColor, int $i, float $step): ColorInterface
    {
    	//Does the same as above, but both, the amount and step-value can be passed to the constructor
        return Color::lighten($baseColor, $i * $step);
    }
}
```

---

### Putting it all together

Notice that you can combine and filter the result of a scheme, since they are 
also palettes. The result will always be a `PaletteInterface` instance 
(Even in the `NameMonochromaticScheme`, so beware, you'll loose 
the naming functionality completely)

You can combine all that stuff above into some awesome color operations.

```php
use Tale\Color\Palette;

$colors = [Color::RED, Color::BLUE, Color::GREEN, Color::YELLOW];

$palette = new Palette();

foreach ($colors as $color) {
    //Add the tetradic scheme for each color
    $palette = Palette::merge($palette, new TetradicScheme($color));
}

//Only take blue-ish colors
$palette = Palette::filterByHueRange($palette, Color::HUE_RANGE_BLUE);

//Avoid similar colors
$palette = Palette::filterSimilarColors($palette, 8);

//Print a nice HTML representation with 4 columns of the palette for debugging
Palette::toHtml($palette, 4);
```

This will yield the colors `blue` and `navy`. Reducing the required range on `filterSimilarColors` will yield more and different blue-ish colors.

---

### Using a color in CSS

The colors mostly convert to their best CSS representation automatically when casted to a string.

```php
echo Color::get('red'); //'rgb(255, 0, 0)'
echo Color::get('hsl(120, .5, .2)'); //'hsl(120, 50%, 20%)'
```

Given that some browsers don't support `hsl()` CSS colors, it's best to always convert to RGB or RGBA before casting to a string.

```php
echo Color::get('red')->getRgba(); //rgba(255, 0, 0, 1)
```

It's not automatically done to give you the ability to also use the `hsl()` writing style. We also don't know, if CSS will implement further color constructors in the future.

> Notice that most literals you pass to `Color::get` return an `RgbaColor`-instance, as most systems (hex, int, names) are designed based on RGB values.




## Examples, Code, Contribution, Support

If you have questions, problems with the code or you want to contribue, either 
write an [issue](https://github.com/Talesoft/phim/issues) 
or [send me an E-Mail](mailto:torben@talesoft.codes).
You can also contribute via pull requests, just send them in.

If you like my work, it helped you in some way, eased up work for you or anything like that, think about supporting me by [spending me a coffee](https://www.paypal.me/TorbenKoehn).

## Credits

- http://wikipedia.com
- http://www.easyrgb.com                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    
- http://www.tigercolor.com/color-lab/color-theory/color-theory-intro.htm
- https://gist.github.com/mjackson/5311256
- https://raw.githubusercontent.com/RnbwNoise/ImageAffineMatrix/master/ImageAffineMatrix.php
- https://github.com/Qix-/color-convert/blob/master/conversions.js

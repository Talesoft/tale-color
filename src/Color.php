<?php
declare(strict_types=1);

namespace Tale;

use Tale\Color\AlphaColorInterface;
use Tale\Color\Exception\BadFunctionArgumentsException;
use Tale\Color\Exception\InvalidFunctionNameException;
use Tale\Color\Exception\InvalidPlatformException;
use Tale\Color\Exception\ZeroDivisionException;
use Tale\Color\HslaColor;
use Tale\Color\HslColor;
use Tale\Color\HslColorInterface;
use Tale\Color\HsvaColor;
use Tale\Color\HsvColor;
use Tale\Color\LabColor;
use Tale\Color\RgbaColor;
use Tale\Color\RgbColor;
use Tale\Color\RgbColorInterface;
use Tale\Color\XyzColor;
use Tale\Color\XyzColorInterface;

class Color
{
    public const UNIT_PERCENT = '%';
    public const UNIT_PERMILLE = '‰';
    public const UNIT_RADIANS = 'rad';
    public const UNIT_DEGREES = 'deg';
    public const UNIT_DEGREES_SYBOL = '°';
    public const UNITS = [ //Sorted in order of probable occurence
        self::UNIT_PERCENT,
        self::UNIT_RADIANS,
        self::UNIT_DEGREES,
        self::UNIT_DEGREES_SYBOL,
        self::UNIT_PERMILLE
    ];

    public const ENDIAN_MACHINE = 0;
    public const ENDIAN_LITTLE = 1;
    public const ENDIAN_BIG = 2;
    
    public const FUNCTION_REGEX = '/(\w+)\(([^)]+)\)/';

    public const HUE_RANGE_RED = 'red';
    public const HUE_RANGE_YELLOW = 'yellow';
    public const HUE_RANGE_GREEN = 'green';
    public const HUE_RANGE_CYAN = 'cyan';
    public const HUE_RANGE_BLUE = 'blue';
    public const HUE_RANGE_MAGENTA = 'magenta';
    public const HUE_RANGES = [
        self::HUE_RANGE_RED,
        self::HUE_RANGE_YELLOW,
        self::HUE_RANGE_GREEN,
        self::HUE_RANGE_CYAN,
        self::HUE_RANGE_BLUE,
        self::HUE_RANGE_MAGENTA
    ];

    #region Colors
    public const AIR_FORCE_BLUE_RAF = 0x5d8aa8;
    public const AIR_FORCE_BLUE_USAF = 0x00308f;
    public const AIR_SUPERIORITY_BLUE = 0x72a0c1;
    public const ALABAMA_CRIMSON = 0xa32638;
    public const ALICE_BLUE = 0xf0f8ff;
    public const ALIZARIN_CRIMSON = 0xe32636;
    public const ALLOY_ORANGE = 0xc46210;
    public const ALMOND = 0xefdecd;
    public const AMARANTH = 0xe52b50;
    public const AMBER = 0xffbf00;
    public const AMBER_SAE_ECE = 0xff7e00;
    public const AMERICAN_ROSE = 0xff033e;
    public const AMETHYST = 0x9966cc;
    public const ANDROID_GREEN = 0xa4c639;
    public const ANTI_FLASH_WHITE = 0xf2f3f4;
    public const ANTIQUE_BRASS = 0xcd9575;
    public const ANTIQUE_FUCHSIA = 0x915c83;
    public const ANTIQUE_RUBY = 0x841b2d;
    public const ANTIQUE_WHITE = 0xfaebd7;
    public const AO_ENGLISH = 0x008000;
    public const APPLE_GREEN = 0x8db600;
    public const APRICOT = 0xfbceb1;
    public const AQUA = 0x00ffff;
    public const AQUAMARINE = 0x7fffd4;
    public const ARMY_GREEN = 0x4b5320;
    public const ARSENIC = 0x3b444b;
    public const ARYLIDE_YELLOW = 0xe9d66b;
    public const ASH_GREY = 0xb2beb5;
    public const ASPARAGUS = 0x87a96b;
    public const ATOMIC_TANGERINE = 0xff9966;
    public const AUBURN = 0xa52a2a;
    public const AUREOLIN = 0xfdee00;
    public const AUROMETALSAURUS = 0x6e7f80;
    public const AVOCADO = 0x568203;
    public const AZURE = 0x007fff;
    public const AZURE_MIST_WEB = 0xf0ffff;
    public const BABY_BLUE = 0x89cff0;
    public const BABY_BLUE_EYES = 0xa1caf1;
    public const BABY_PINK = 0xf4c2c2;
    public const BALL_BLUE = 0x21abcd;
    public const BANANA_MANIA = 0xfae7b5;
    public const BANANA_YELLOW = 0xffe135;
    public const BARN_RED = 0x7c0a02;
    public const BATTLESHIP_GREY = 0x848482;
    public const BAZAAR = 0x98777b;
    public const BEAU_BLUE = 0xbcd4e6;
    public const BEAVER = 0x9f8170;
    public const BEIGE = 0xf5f5dc;
    public const BIG_DIP_O_RUBY = 0x9c2542;
    public const BISQUE = 0xffe4c4;
    public const BISTRE = 0x3d2b1f;
    public const BITTERSWEET = 0xfe6f5e;
    public const BITTERSWEET_SHIMMER = 0xbf4f51;
    public const BLACK = 0x000000;
    public const BLACK_BEAN = 0x3d0c02;
    public const BLACK_LEATHER_JACKET = 0x253529;
    public const BLACK_OLIVE = 0x3b3c36;
    public const BLANCHED_ALMOND = 0xffebcd;
    public const BLAST_OFF_BRONZE = 0xa57164;
    public const BLEU_DE_FRANCE = 0x318ce7;
    public const BLIZZARD_BLUE = 0xace5ee;
    public const BLOND = 0xfaf0be;
    public const BLUE = 0x0000ff;
    public const BLUE_BELL = 0xa2a2d0;
    public const BLUE_CRAYOLA = 0x1f75fe;
    public const BLUE_GRAY = 0x6699cc;
    public const BLUE_GREEN = 0x0d98ba;
    public const BLUE_MUNSELL = 0x0093af;
    public const BLUE_NCS = 0x0087bd;
    public const BLUE_PIGMENT = 0x333399;
    public const BLUE_RYB = 0x0247fe;
    public const BLUE_SAPPHIRE = 0x126180;
    public const BLUE_VIOLET = 0x8a2be2;
    public const BLUSH = 0xde5d83;
    public const BOLE = 0x79443b;
    public const BONDI_BLUE = 0x0095b6;
    public const BONE = 0xe3dac9;
    public const BOSTON_UNIVERSITY_RED = 0xcc0000;
    public const BOTTLE_GREEN = 0x006a4e;
    public const BOYSENBERRY = 0x873260;
    public const BRANDEIS_BLUE = 0x0070ff;
    public const BRASS = 0xb5a642;
    public const BRICK_RED = 0xcb4154;
    public const BRIGHT_CERULEAN = 0x1dacd6;
    public const BRIGHT_GREEN = 0x66ff00;
    public const BRIGHT_LAVENDER = 0xbf94e4;
    public const BRIGHT_MAROON = 0xc32148;
    public const BRIGHT_PINK = 0xff007f;
    public const BRIGHT_TURQUOISE = 0x08e8de;
    public const BRIGHT_UBE = 0xd19fe8;
    public const BRILLIANT_LAVENDER = 0xf4bbff;
    public const BRILLIANT_ROSE = 0xff55a3;
    public const BRINK_PINK = 0xfb607f;
    public const BRITISH_RACING_GREEN = 0x004225;
    public const BRONZE = 0xcd7f32;
    public const BROWN_TRADITIONAL = 0x964b00;
    public const BROWN_WEB = 0xa52a2a;
    public const BUBBLE_GUM = 0xffc1cc;
    public const BUBBLES = 0xe7feff;
    public const BUFF = 0xf0dc82;
    public const BULGARIAN_ROSE = 0x480607;
    public const BURGUNDY = 0x800020;
    public const BURLYWOOD = 0xdeb887;
    public const BURNT_ORANGE = 0xcc5500;
    public const BURNT_SIENNA = 0xe97451;
    public const BURNT_UMBER = 0x8a3324;
    public const BYZANTINE = 0xbd33a4;
    public const BYZANTIUM = 0x702963;
    public const CADET = 0x536872;
    public const CADET_BLUE = 0x5f9ea0;
    public const CADET_GREY = 0x91a3b0;
    public const CADMIUM_GREEN = 0x006b3c;
    public const CADMIUM_ORANGE = 0xed872d;
    public const CADMIUM_RED = 0xe30022;
    public const CADMIUM_YELLOW = 0xfff600;
    public const CAF_AU_LAIT = 0xa67b5b;
    public const CAF_NOIR = 0x4b3621;
    public const CAL_POLY_GREEN = 0x1e4d2b;
    public const CAMBRIDGE_BLUE = 0xa3c1ad;
    public const CAMEL = 0xc19a6b;
    public const CAMEO_PINK = 0xefbbcc;
    public const CAMOUFLAGE_GREEN = 0x78866b;
    public const CANARY_YELLOW = 0xffef00;
    public const CANDY_APPLE_RED = 0xff0800;
    public const CANDY_PINK = 0xe4717a;
    public const CAPRI = 0x00bfff;
    public const CAPUT_MORTUUM = 0x592720;
    public const CARDINAL = 0xc41e3a;
    public const CARIBBEAN_GREEN = 0x00cc99;
    public const CARMINE = 0x960018;
    public const CARMINE_M_P = 0xd70040;
    public const CARMINE_PINK = 0xeb4c42;
    public const CARMINE_RED = 0xff0038;
    public const CARNATION_PINK = 0xffa6c9;
    public const CARNELIAN = 0xb31b1b;
    public const CAROLINA_BLUE = 0x99badd;
    public const CARROT_ORANGE = 0xed9121;
    public const CATALINA_BLUE = 0x062a78;
    public const CEIL = 0x92a1cf;
    public const CELADON = 0xace1af;
    public const CELADON_BLUE = 0x007ba7;
    public const CELADON_GREEN = 0x2f847c;
    public const CELESTE_COLOUR = 0xb2ffff;
    public const CELESTIAL_BLUE = 0x4997d0;
    public const CERISE = 0xde3163;
    public const CERISE_PINK = 0xec3b83;
    public const CERULEAN = 0x007ba7;
    public const CERULEAN_BLUE = 0x2a52be;
    public const CERULEAN_FROST = 0x6d9bc3;
    public const CG_BLUE = 0x007aa5;
    public const CG_RED = 0xe03c31;
    public const CHAMOISEE = 0xa0785a;
    public const CHAMPAGNE = 0xfad6a5;
    public const CHARCOAL = 0x36454f;
    public const CHARM_PINK = 0xe68fac;
    public const CHARTREUSE_TRADITIONAL = 0xdfff00;
    public const CHARTREUSE_WEB = 0x7fff00;
    public const CHERRY = 0xde3163;
    public const CHERRY_BLOSSOM_PINK = 0xffb7c5;
    public const CHESTNUT = 0xcd5c5c;
    public const CHINA_PINK = 0xde6fa1;
    public const CHINA_ROSE = 0xa8516e;
    public const CHINESE_RED = 0xaa381e;
    public const CHOCOLATE_TRADITIONAL = 0x7b3f00;
    public const CHOCOLATE_WEB = 0xd2691e;
    public const CHROME_YELLOW = 0xffa700;
    public const CINEREOUS = 0x98817b;
    public const CINNABAR = 0xe34234;
    public const CINNAMON = 0xd2691e;
    public const CITRINE = 0xe4d00a;
    public const CLASSIC_ROSE = 0xfbcce7;
    public const COBALT = 0x0047ab;
    public const COCOA_BROWN = 0xd2691e;
    public const COFFEE = 0x6f4e37;
    public const COLUMBIA_BLUE = 0x9bddff;
    public const CONGO_PINK = 0xf88379;
    public const COOL_BLACK = 0x002e63;
    public const COOL_GREY = 0x8c92ac;
    public const COPPER = 0xb87333;
    public const COPPER_CRAYOLA = 0xda8a67;
    public const COPPER_PENNY = 0xad6f69;
    public const COPPER_RED = 0xcb6d51;
    public const COPPER_ROSE = 0x996666;
    public const COQUELICOT = 0xff3800;
    public const CORAL = 0xff7f50;
    public const CORAL_PINK = 0xf88379;
    public const CORAL_RED = 0xff4040;
    public const CORDOVAN = 0x893f45;
    public const CORN = 0xfbec5d;
    public const CORNELL_RED = 0xb31b1b;
    public const CORNFLOWER_BLUE = 0x6495ed;
    public const CORNSILK = 0xfff8dc;
    public const COSMIC_LATTE = 0xfff8e7;
    public const COTTON_CANDY = 0xffbcd9;
    public const CREAM = 0xfffdd0;
    public const CRIMSON = 0xdc143c;
    public const CRIMSON_GLORY = 0xbe0032;
    public const CYAN = 0x00ffff;
    public const CYAN_PROCESS = 0x00b7eb;
    public const DAFFODIL = 0xffff31;
    public const DANDELION = 0xf0e130;
    public const DARK_BLUE = 0x00008b;
    public const DARK_BROWN = 0x654321;
    public const DARK_BYZANTIUM = 0x5d3954;
    public const DARK_CANDY_APPLE_RED = 0xa40000;
    public const DARK_CERULEAN = 0x08457e;
    public const DARK_CHESTNUT = 0x986960;
    public const DARK_CORAL = 0xcd5b45;
    public const DARK_CYAN = 0x008b8b;
    public const DARK_ELECTRIC_BLUE = 0x536878;
    public const DARK_GOLDENROD = 0xb8860b;
    public const DARK_GRAY = 0xa9a9a9;
    public const DARK_GREEN = 0x013220;
    public const DARK_IMPERIAL_BLUE = 0x00416a;
    public const DARK_JUNGLE_GREEN = 0x1a2421;
    public const DARK_KHAKI = 0xbdb76b;
    public const DARK_LAVA = 0x483c32;
    public const DARK_LAVENDER = 0x734f96;
    public const DARK_MAGENTA = 0x8b008b;
    public const DARK_MIDNIGHT_BLUE = 0x003366;
    public const DARK_OLIVE_GREEN = 0x556b2f;
    public const DARK_ORANGE = 0xff8c00;
    public const DARK_ORCHID = 0x9932cc;
    public const DARK_PASTEL_BLUE = 0x779ecb;
    public const DARK_PASTEL_GREEN = 0x03c03c;
    public const DARK_PASTEL_PURPLE = 0x966fd6;
    public const DARK_PASTEL_RED = 0xc23b22;
    public const DARK_PINK = 0xe75480;
    public const DARK_POWDER_BLUE = 0x003399;
    public const DARK_RASPBERRY = 0x872657;
    public const DARK_RED = 0x8b0000;
    public const DARK_SALMON = 0xe9967a;
    public const DARK_SCARLET = 0x560319;
    public const DARK_SEA_GREEN = 0x8fbc8f;
    public const DARK_SIENNA = 0x3c1414;
    public const DARK_SLATE_BLUE = 0x483d8b;
    public const DARK_SLATE_GRAY = 0x2f4f4f;
    public const DARK_SPRING_GREEN = 0x177245;
    public const DARK_TAN = 0x918151;
    public const DARK_TANGERINE = 0xffa812;
    public const DARK_TAUPE = 0x483c32;
    public const DARK_TERRA_COTTA = 0xcc4e5c;
    public const DARK_TURQUOISE = 0x00ced1;
    public const DARK_VIOLET = 0x9400d3;
    public const DARK_YELLOW = 0x9b870c;
    public const DARTMOUTH_GREEN = 0x00703c;
    public const DAVY_S_GREY = 0x555555;
    public const DEBIAN_RED = 0xd70a53;
    public const DEEP_CARMINE = 0xa9203e;
    public const DEEP_CARMINE_PINK = 0xef3038;
    public const DEEP_CARROT_ORANGE = 0xe9692c;
    public const DEEP_CERISE = 0xda3287;
    public const DEEP_CHAMPAGNE = 0xfad6a5;
    public const DEEP_CHESTNUT = 0xb94e48;
    public const DEEP_COFFEE = 0x704241;
    public const DEEP_FUCHSIA = 0xc154c1;
    public const DEEP_JUNGLE_GREEN = 0x004b49;
    public const DEEP_LILAC = 0x9955bb;
    public const DEEP_MAGENTA = 0xcc00cc;
    public const DEEP_PEACH = 0xffcba4;
    public const DEEP_PINK = 0xff1493;
    public const DEEP_RUBY = 0x843f5b;
    public const DEEP_SAFFRON = 0xff9933;
    public const DEEP_SKY_BLUE = 0x00bfff;
    public const DEEP_TUSCAN_RED = 0x66424d;
    public const DENIM = 0x1560bd;
    public const DESERT = 0xc19a6b;
    public const DESERT_SAND = 0xedc9af;
    public const DIM_GRAY = 0x696969;
    public const DODGER_BLUE = 0x1e90ff;
    public const DOGWOOD_ROSE = 0xd71868;
    public const DOLLAR_BILL = 0x85bb65;
    public const DRAB = 0x967117;
    public const DUKE_BLUE = 0x00009c;
    public const EARTH_YELLOW = 0xe1a95f;
    public const EBONY = 0x555d50;
    public const ECRU = 0xc2b280;
    public const EGGPLANT = 0x614051;
    public const EGGSHELL = 0xf0ead6;
    public const EGYPTIAN_BLUE = 0x1034a6;
    public const ELECTRIC_BLUE = 0x7df9ff;
    public const ELECTRIC_CRIMSON = 0xff003f;
    public const ELECTRIC_CYAN = 0x00ffff;
    public const ELECTRIC_GREEN = 0x00ff00;
    public const ELECTRIC_INDIGO = 0x6f00ff;
    public const ELECTRIC_LAVENDER = 0xf4bbff;
    public const ELECTRIC_LIME = 0xccff00;
    public const ELECTRIC_PURPLE = 0xbf00ff;
    public const ELECTRIC_ULTRAMARINE = 0x3f00ff;
    public const ELECTRIC_VIOLET = 0x8f00ff;
    public const ELECTRIC_YELLOW = 0xffff00;
    public const EMERALD = 0x50c878;
    public const ENGLISH_LAVENDER = 0xb48395;
    public const ETON_BLUE = 0x96c8a2;
    public const FALLOW = 0xc19a6b;
    public const FALU_RED = 0x801818;
    public const FANDANGO = 0xb53389;
    public const FASHION_FUCHSIA = 0xf400a1;
    public const FAWN = 0xe5aa70;
    public const FELDGRAU = 0x4d5d53;
    public const FERN_GREEN = 0x4f7942;
    public const FERRARI_RED = 0xff2800;
    public const FIELD_DRAB = 0x6c541e;
    public const FIRE_ENGINE_RED = 0xce2029;
    public const FIREBRICK = 0xb22222;
    public const FLAME = 0xe25822;
    public const FLAMINGO_PINK = 0xfc8eac;
    public const FLAVESCENT = 0xf7e98e;
    public const FLAX = 0xeedc82;
    public const FLORAL_WHITE = 0xfffaf0;
    public const FLUORESCENT_ORANGE = 0xffbf00;
    public const FLUORESCENT_PINK = 0xff1493;
    public const FLUORESCENT_YELLOW = 0xccff00;
    public const FOLLY = 0xff004f;
    public const FOREST_GREEN_TRADITIONAL = 0x014421;
    public const FOREST_GREEN_WEB = 0x228b22;
    public const FRENCH_BEIGE = 0xa67b5b;
    public const FRENCH_BLUE = 0x0072bb;
    public const FRENCH_LILAC = 0x86608e;
    public const FRENCH_LIME = 0xccff00;
    public const FRENCH_RASPBERRY = 0xc72c48;
    public const FRENCH_ROSE = 0xf64a8a;
    public const FUCHSIA = 0xff00ff;
    public const FUCHSIA_CRAYOLA = 0xc154c1;
    public const FUCHSIA_PINK = 0xff77ff;
    public const FUCHSIA_ROSE = 0xc74375;
    public const FULVOUS = 0xe48400;
    public const FUZZY_WUZZY = 0xcc6666;
    public const GAINSBORO = 0xdcdcdc;
    public const GAMBOGE = 0xe49b0f;
    public const GHOST_WHITE = 0xf8f8ff;
    public const GINGER = 0xb06500;
    public const GLAUCOUS = 0x6082b6;
    public const GLITTER = 0xe6e8fa;
    public const GOLD_METALLIC = 0xd4af37;
    public const GOLD_WEB_GOLDEN = 0xffd700;
    public const GOLDEN_BROWN = 0x996515;
    public const GOLDEN_POPPY = 0xfcc200;
    public const GOLDEN_YELLOW = 0xffdf00;
    public const GOLDENROD = 0xdaa520;
    public const GRANNY_SMITH_APPLE = 0xa8e4a0;
    public const GRAY = 0x808080;
    public const GRAY_ASPARAGUS = 0x465945;
    public const GRAY_HTML_CSS_GRAY = 0x808080;
    public const GRAY_X11_GRAY = 0xbebebe;
    public const GREEN_COLOR_WHEEL_X11_GREEN = 0x00ff00;
    public const GREEN_CRAYOLA = 0x1cac78;
    public const GREEN_HTML_CSS_GREEN = 0x008000;
    public const GREEN_MUNSELL = 0x00a877;
    public const GREEN_NCS = 0x009f6b;
    public const GREEN_PIGMENT = 0x00a550;
    public const GREEN_RYB = 0x66b032;
    public const GREEN_YELLOW = 0xadff2f;
    public const GRULLO = 0xa99a86;
    public const GUPPIE_GREEN = 0x00ff7f;
    public const HALAY_BE = 0x663854;
    public const HAN_BLUE = 0x446ccf;
    public const HAN_PURPLE = 0x5218fa;
    public const HANSA_YELLOW = 0xe9d66b;
    public const HARLEQUIN = 0x3fff00;
    public const HARVARD_CRIMSON = 0xc90016;
    public const HARVEST_GOLD = 0xda9100;
    public const HEART_GOLD = 0x808000;
    public const HELIOTROPE = 0xdf73ff;
    public const HOLLYWOOD_CERISE = 0xf400a1;
    public const HONEYDEW = 0xf0fff0;
    public const HONOLULU_BLUE = 0x007fbf;
    public const HOOKER_S_GREEN = 0x49796b;
    public const HOT_MAGENTA = 0xff1dce;
    public const HOT_PINK = 0xff69b4;
    public const HUNTER_GREEN = 0x355e3b;
    public const ICEBERG = 0x71a6d2;
    public const ICTERINE = 0xfcf75e;
    public const IMPERIAL_BLUE = 0x002395;
    public const INCHWORM = 0xb2ec5d;
    public const INDIA_GREEN = 0x138808;
    public const INDIAN_RED = 0xcd5c5c;
    public const INDIAN_YELLOW = 0xe3a857;
    public const INDIGO = 0x6f00ff;
    public const INDIGO_DYE = 0x00416a;
    public const INDIGO_WEB = 0x4b0082;
    public const INTERNATIONAL_KLEIN_BLUE = 0x002fa7;
    public const INTERNATIONAL_ORANGE_AEROSPACE = 0xff4f00;
    public const INTERNATIONAL_ORANGE_ENGINEERING = 0xba160c;
    public const INTERNATIONAL_ORANGE_GOLDEN_GATE_BRIDGE = 0xc0362c;
    public const IRIS = 0x5a4fcf;
    public const ISABELLINE = 0xf4f0ec;
    public const ISLAMIC_GREEN = 0x009000;
    public const IVORY = 0xfffff0;
    public const JADE = 0x00a86b;
    public const JASMINE = 0xf8de7e;
    public const JASPER = 0xd73b3e;
    public const JAZZBERRY_JAM = 0xa50b5e;
    public const JET = 0x343434;
    public const JONQUIL = 0xfada5e;
    public const JUNE_BUD = 0xbdda57;
    public const JUNGLE_GREEN = 0x29ab87;
    public const KELLY_GREEN = 0x4cbb17;
    public const KENYAN_COPPER = 0x7c1c05;
    public const KHAKI_HTML_CSS_KHAKI = 0xc3b091;
    public const KHAKI_X11_LIGHT_KHAKI = 0xf0e68c;
    public const KU_CRIMSON = 0xe8000d;
    public const LA_SALLE_GREEN = 0x087830;
    public const LANGUID_LAVENDER = 0xd6cadd;
    public const LAPIS_LAZULI = 0x26619c;
    public const LASER_LEMON = 0xfefe22;
    public const LAUREL_GREEN = 0xa9ba9d;
    public const LAVA = 0xcf1020;
    public const LAVENDER_BLUE = 0xccccff;
    public const LAVENDER_BLUSH = 0xfff0f5;
    public const LAVENDER_FLORAL = 0xb57edc;
    public const LAVENDER_GRAY = 0xc4c3d0;
    public const LAVENDER_INDIGO = 0x9457eb;
    public const LAVENDER_MAGENTA = 0xee82ee;
    public const LAVENDER_MIST = 0xe6e6fa;
    public const LAVENDER_PINK = 0xfbaed2;
    public const LAVENDER_PURPLE = 0x967bb6;
    public const LAVENDER_ROSE = 0xfba0e3;
    public const LAVENDER_WEB = 0xe6e6fa;
    public const LAWN_GREEN = 0x7cfc00;
    public const LEMON = 0xfff700;
    public const LEMON_CHIFFON = 0xfffacd;
    public const LEMON_LIME = 0xe3ff00;
    public const LICORICE = 0x1a1110;
    public const LIGHT_APRICOT = 0xfdd5b1;
    public const LIGHT_BLUE = 0xadd8e6;
    public const LIGHT_BROWN = 0xb5651d;
    public const LIGHT_CARMINE_PINK = 0xe66771;
    public const LIGHT_CORAL = 0xf08080;
    public const LIGHT_CORNFLOWER_BLUE = 0x93ccea;
    public const LIGHT_CRIMSON = 0xf56991;
    public const LIGHT_CYAN = 0xe0ffff;
    public const LIGHT_FUCHSIA_PINK = 0xf984ef;
    public const LIGHT_GOLDENROD_YELLOW = 0xfafad2;
    public const LIGHT_GRAY = 0xd3d3d3;
    public const LIGHT_GREEN = 0x90ee90;
    public const LIGHT_KHAKI = 0xf0e68c;
    public const LIGHT_PASTEL_PURPLE = 0xb19cd9;
    public const LIGHT_PINK = 0xffb6c1;
    public const LIGHT_RED_OCHRE = 0xe97451;
    public const LIGHT_SALMON = 0xffa07a;
    public const LIGHT_SALMON_PINK = 0xff9999;
    public const LIGHT_SEA_GREEN = 0x20b2aa;
    public const LIGHT_SKY_BLUE = 0x87cefa;
    public const LIGHT_SLATE_GRAY = 0x778899;
    public const LIGHT_TAUPE = 0xb38b6d;
    public const LIGHT_THULIAN_PINK = 0xe68fac;
    public const LIGHT_YELLOW = 0xffffe0;
    public const LILAC = 0xc8a2c8;
    public const LIME_COLOR_WHEEL = 0xbfff00;
    public const LIME_GREEN = 0x32cd32;
    public const LIME_WEB_X11_GREEN = 0x00ff00;
    public const LIMERICK = 0x9dc209;
    public const LINCOLN_GREEN = 0x195905;
    public const LINEN = 0xfaf0e6;
    public const LION = 0xc19a6b;
    public const LITTLE_BOY_BLUE = 0x6ca0dc;
    public const LIVER = 0x534b4f;
    public const LUST = 0xe62020;
    public const MAGENTA = 0xff00ff;
    public const MAGENTA_DYE = 0xca1f7b;
    public const MAGENTA_PROCESS = 0xff0090;
    public const MAGIC_MINT = 0xaaf0d1;
    public const MAGNOLIA = 0xf8f4ff;
    public const MAHOGANY = 0xc04000;
    public const MAIZE = 0xfbec5d;
    public const MAJORELLE_BLUE = 0x6050dc;
    public const MALACHITE = 0x0bda51;
    public const MANATEE = 0x979aaa;
    public const MANGO_TANGO = 0xff8243;
    public const MANTIS = 0x74c365;
    public const MARDI_GRAS = 0x880085;
    public const MAROON_CRAYOLA = 0xc32148;
    public const MAROON_HTML_CSS = 0x800000;
    public const MAROON_X11 = 0xb03060;
    public const MAUVE = 0xe0b0ff;
    public const MAUVE_TAUPE = 0x915f6d;
    public const MAUVELOUS = 0xef98aa;
    public const MAYA_BLUE = 0x73c2fb;
    public const MEAT_BROWN = 0xe5b73b;
    public const MEDIUM_AQUAMARINE = 0x66ddaa;
    public const MEDIUM_BLUE = 0x0000cd;
    public const MEDIUM_CANDY_APPLE_RED = 0xe2062c;
    public const MEDIUM_CARMINE = 0xaf4035;
    public const MEDIUM_CHAMPAGNE = 0xf3e5ab;
    public const MEDIUM_ELECTRIC_BLUE = 0x035096;
    public const MEDIUM_JUNGLE_GREEN = 0x1c352d;
    public const MEDIUM_LAVENDER_MAGENTA = 0xdda0dd;
    public const MEDIUM_ORCHID = 0xba55d3;
    public const MEDIUM_PERSIAN_BLUE = 0x0067a5;
    public const MEDIUM_PURPLE = 0x9370db;
    public const MEDIUM_RED_VIOLET = 0xbb3385;
    public const MEDIUM_RUBY = 0xaa4069;
    public const MEDIUM_SEA_GREEN = 0x3cb371;
    public const MEDIUM_SLATE_BLUE = 0x7b68ee;
    public const MEDIUM_SPRING_BUD = 0xc9dc87;
    public const MEDIUM_SPRING_GREEN = 0x00fa9a;
    public const MEDIUM_TAUPE = 0x674c47;
    public const MEDIUM_TURQUOISE = 0x48d1cc;
    public const MEDIUM_TUSCAN_RED = 0x79443b;
    public const MEDIUM_VERMILION = 0xd9603b;
    public const MEDIUM_VIOLET_RED = 0xc71585;
    public const MELLOW_APRICOT = 0xf8b878;
    public const MELLOW_YELLOW = 0xf8de7e;
    public const MELON = 0xfdbcb4;
    public const MIDNIGHT_BLUE = 0x191970;
    public const MIDNIGHT_GREEN_EAGLE_GREEN = 0x004953;
    public const MIKADO_YELLOW = 0xffc40c;
    public const MINT = 0x3eb489;
    public const MINT_CREAM = 0xf5fffa;
    public const MINT_GREEN = 0x98ff98;
    public const MISTY_ROSE = 0xffe4e1;
    public const MOCCASIN = 0xfaebd7;
    public const MODE_BEIGE = 0x967117;
    public const MOONSTONE_BLUE = 0x73a9c2;
    public const MORDANT_RED_19 = 0xae0c00;
    public const MOSS_GREEN = 0xaddfad;
    public const MOUNTAIN_MEADOW = 0x30ba8f;
    public const MOUNTBATTEN_PINK = 0x997a8d;
    public const MSU_GREEN = 0x18453b;
    public const MULBERRY = 0xc54b8c;
    public const MUSTARD = 0xffdb58;
    public const MYRTLE = 0x21421e;
    public const NADESHIKO_PINK = 0xf6adc6;
    public const NAPIER_GREEN = 0x2a8000;
    public const NAPLES_YELLOW = 0xfada5e;
    public const NAVAJO_WHITE = 0xffdead;
    public const NAVY_BLUE = 0x000080;
    public const NEON_CARROT = 0xffa343;
    public const NEON_FUCHSIA = 0xfe4164;
    public const NEON_GREEN = 0x39ff14;
    public const NEW_YORK_PINK = 0xd7837f;
    public const NON_PHOTO_BLUE = 0xa4dded;
    public const NORTH_TEXAS_GREEN = 0x059033;
    public const OCEAN_BOAT_BLUE = 0x0077be;
    public const OCHRE = 0xcc7722;
    public const OFFICE_GREEN = 0x008000;
    public const OLD_GOLD = 0xcfb53b;
    public const OLD_LACE = 0xfdf5e6;
    public const OLD_LAVENDER = 0x796878;
    public const OLD_MAUVE = 0x673147;
    public const OLD_ROSE = 0xc08081;
    public const OLIVE = 0x808000;
    public const OLIVE_DRAB_7 = 0x3c341f;
    public const OLIVE_DRAB_WEB_OLIVE_DRAB_3 = 0x6b8e23;
    public const OLIVINE = 0x9ab973;
    public const ONYX = 0x353839;
    public const OPERA_MAUVE = 0xb784a7;
    public const ORANGE_COLOR_WHEEL = 0xff7f00;
    public const ORANGE_PEEL = 0xff9f00;
    public const ORANGE_RED = 0xff4500;
    public const ORANGE_RYB = 0xfb9902;
    public const ORANGE_WEB_COLOR = 0xffa500;
    public const ORCHID = 0xda70d6;
    public const OTTER_BROWN = 0x654321;
    public const OU_CRIMSON_RED = 0x990000;
    public const OUTER_SPACE = 0x414a4c;
    public const OUTRAGEOUS_ORANGE = 0xff6e4a;
    public const OXFORD_BLUE = 0x002147;
    public const PAKISTAN_GREEN = 0x006600;
    public const PALATINATE_BLUE = 0x273be2;
    public const PALATINATE_PURPLE = 0x682860;
    public const PALE_AQUA = 0xbcd4e6;
    public const PALE_BLUE = 0xafeeee;
    public const PALE_BROWN = 0x987654;
    public const PALE_CARMINE = 0xaf4035;
    public const PALE_CERULEAN = 0x9bc4e2;
    public const PALE_CHESTNUT = 0xddadaf;
    public const PALE_COPPER = 0xda8a67;
    public const PALE_CORNFLOWER_BLUE = 0xabcdef;
    public const PALE_GOLD = 0xe6be8a;
    public const PALE_GOLDENROD = 0xeee8aa;
    public const PALE_GREEN = 0x98fb98;
    public const PALE_LAVENDER = 0xdcd0ff;
    public const PALE_MAGENTA = 0xf984e5;
    public const PALE_PINK = 0xfadadd;
    public const PALE_PLUM = 0xdda0dd;
    public const PALE_RED_VIOLET = 0xdb7093;
    public const PALE_ROBIN_EGG_BLUE = 0x96ded1;
    public const PALE_SILVER = 0xc9c0bb;
    public const PALE_SPRING_BUD = 0xecebbd;
    public const PALE_TAUPE = 0xbc987e;
    public const PALE_VIOLET_RED = 0xdb7093;
    public const PANSY_PURPLE = 0x78184a;
    public const PAPAYA_WHIP = 0xffefd5;
    public const PARIS_GREEN = 0x50c878;
    public const PASTEL_BLUE = 0xaec6cf;
    public const PASTEL_BROWN = 0x836953;
    public const PASTEL_GRAY = 0xcfcfc4;
    public const PASTEL_GREEN = 0x77dd77;
    public const PASTEL_MAGENTA = 0xf49ac2;
    public const PASTEL_ORANGE = 0xffb347;
    public const PASTEL_PINK = 0xdea5a4;
    public const PASTEL_PURPLE = 0xb39eb5;
    public const PASTEL_RED = 0xff6961;
    public const PASTEL_VIOLET = 0xcb99c9;
    public const PASTEL_YELLOW = 0xfdfd96;
    public const PATRIARCH = 0x800080;
    public const PAYNE_S_GREY = 0x536878;
    public const PEACH = 0xffe5b4;
    public const PEACH_CRAYOLA = 0xffcba4;
    public const PEACH_ORANGE = 0xffcc99;
    public const PEACH_PUFF = 0xffdab9;
    public const PEACH_YELLOW = 0xfadfad;
    public const PEAR = 0xd1e231;
    public const PEARL = 0xeae0c8;
    public const PEARL_AQUA = 0x88d8c0;
    public const PEARLY_PURPLE = 0xb768a2;
    public const PERIDOT = 0xe6e200;
    public const PERIWINKLE = 0xccccff;
    public const PERSIAN_BLUE = 0x1c39bb;
    public const PERSIAN_GREEN = 0x00a693;
    public const PERSIAN_INDIGO = 0x32127a;
    public const PERSIAN_ORANGE = 0xd99058;
    public const PERSIAN_PINK = 0xf77fbe;
    public const PERSIAN_PLUM = 0x701c1c;
    public const PERSIAN_RED = 0xcc3333;
    public const PERSIAN_ROSE = 0xfe28a2;
    public const PERSIMMON = 0xec5800;
    public const PERU = 0xcd853f;
    public const PHLOX = 0xdf00ff;
    public const PHTHALO_BLUE = 0x000f89;
    public const PHTHALO_GREEN = 0x123524;
    public const PIGGY_PINK = 0xfddde6;
    public const PINE_GREEN = 0x01796f;
    public const PINK = 0xffc0cb;
    public const PINK_LACE = 0xffddf4;
    public const PINK_ORANGE = 0xff9966;
    public const PINK_PEARL = 0xe7accf;
    public const PINK_SHERBET = 0xf78fa7;
    public const PISTACHIO = 0x93c572;
    public const PLATINUM = 0xe5e4e2;
    public const PLUM_TRADITIONAL = 0x8e4585;
    public const PLUM_WEB = 0xdda0dd;
    public const PORTLAND_ORANGE = 0xff5a36;
    public const POWDER_BLUE_WEB = 0xb0e0e6;
    public const PRINCETON_ORANGE = 0xff8f00;
    public const PRUNE = 0x701c1c;
    public const PRUSSIAN_BLUE = 0x003153;
    public const PSYCHEDELIC_PURPLE = 0xdf00ff;
    public const PUCE = 0xcc8899;
    public const PUMPKIN = 0xff7518;
    public const PURPLE_HEART = 0x69359c;
    public const PURPLE_HTML_CSS = 0x800080;
    public const PURPLE_MOUNTAIN_MAJESTY = 0x9678b6;
    public const PURPLE_MUNSELL = 0x9f00c5;
    public const PURPLE_PIZZAZZ = 0xfe4eda;
    public const PURPLE_TAUPE = 0x50404d;
    public const PURPLE_X11 = 0xa020f0;
    public const QUARTZ = 0x51484f;
    public const RACKLEY = 0x5d8aa8;
    public const RADICAL_RED = 0xff355e;
    public const RAJAH = 0xfbab60;
    public const RASPBERRY = 0xe30b5d;
    public const RASPBERRY_GLACE = 0x915f6d;
    public const RASPBERRY_PINK = 0xe25098;
    public const RASPBERRY_ROSE = 0xb3446c;
    public const RAW_UMBER = 0x826644;
    public const RAZZLE_DAZZLE_ROSE = 0xff33cc;
    public const RAZZMATAZZ = 0xe3256b;
    public const RED = 0xff0000;
    public const RED_BROWN = 0xa52a2a;
    public const RED_DEVIL = 0x860111;
    public const RED_MUNSELL = 0xf2003c;
    public const RED_NCS = 0xc40233;
    public const RED_ORANGE = 0xff5349;
    public const RED_PIGMENT = 0xed1c24;
    public const RED_RYB = 0xfe2712;
    public const RED_VIOLET = 0xc71585;
    public const REDWOOD = 0xab4e52;
    public const REGALIA = 0x522d80;
    public const RESOLUTION_BLUE = 0x002387;
    public const RICH_BLACK = 0x004040;
    public const RICH_BRILLIANT_LAVENDER = 0xf1a7fe;
    public const RICH_CARMINE = 0xd70040;
    public const RICH_ELECTRIC_BLUE = 0x0892d0;
    public const RICH_LAVENDER = 0xa76bcf;
    public const RICH_LILAC = 0xb666d2;
    public const RICH_MAROON = 0xb03060;
    public const RIFLE_GREEN = 0x414833;
    public const ROBIN_EGG_BLUE = 0x00cccc;
    public const ROSE = 0xff007f;
    public const ROSE_BONBON = 0xf9429e;
    public const ROSE_EBONY = 0x674846;
    public const ROSE_GOLD = 0xb76e79;
    public const ROSE_MADDER = 0xe32636;
    public const ROSE_PINK = 0xff66cc;
    public const ROSE_QUARTZ = 0xaa98a9;
    public const ROSE_TAUPE = 0x905d5d;
    public const ROSE_VALE = 0xab4e52;
    public const ROSEWOOD = 0x65000b;
    public const ROSSO_CORSA = 0xd40000;
    public const ROSY_BROWN = 0xbc8f8f;
    public const ROYAL_AZURE = 0x0038a8;
    public const ROYAL_BLUE_TRADITIONAL = 0x002366;
    public const ROYAL_BLUE_WEB = 0x4169e1;
    public const ROYAL_FUCHSIA = 0xca2c92;
    public const ROYAL_PURPLE = 0x7851a9;
    public const ROYAL_YELLOW = 0xfada5e;
    public const RUBINE_RED = 0xd10056;
    public const RUBY = 0xe0115f;
    public const RUBY_RED = 0x9b111e;
    public const RUDDY = 0xff0028;
    public const RUDDY_BROWN = 0xbb6528;
    public const RUDDY_PINK = 0xe18e96;
    public const RUFOUS = 0xa81c07;
    public const RUSSET = 0x80461b;
    public const RUST = 0xb7410e;
    public const RUSTY_RED = 0xda2c43;
    public const SACRAMENTO_STATE_GREEN = 0x00563f;
    public const SADDLE_BROWN = 0x8b4513;
    public const SAFETY_ORANGE_BLAZE_ORANGE = 0xff6700;
    public const SAFFRON = 0xf4c430;
    public const SALMON = 0xff8c69;
    public const SALMON_PINK = 0xff91a4;
    public const SAND = 0xc2b280;
    public const SAND_DUNE = 0x967117;
    public const SANDSTORM = 0xecd540;
    public const SANDY_BROWN = 0xf4a460;
    public const SANDY_TAUPE = 0x967117;
    public const SANGRIA = 0x92000a;
    public const SAP_GREEN = 0x507d2a;
    public const SAPPHIRE = 0x0f52ba;
    public const SAPPHIRE_BLUE = 0x0067a5;
    public const SATIN_SHEEN_GOLD = 0xcba135;
    public const SCARLET = 0xff2400;
    public const SCARLET_CRAYOLA = 0xfd0e35;
    public const SCHOOL_BUS_YELLOW = 0xffd800;
    public const SCREAMIN_GREEN = 0x76ff7a;
    public const SEA_BLUE = 0x006994;
    public const SEA_GREEN = 0x2e8b57;
    public const SEAL_BROWN = 0x321414;
    public const SEASHELL = 0xfff5ee;
    public const SELECTIVE_YELLOW = 0xffba00;
    public const SEPIA = 0x704214;
    public const SHADOW = 0x8a795d;
    public const SHAMROCK_GREEN = 0x009e60;
    public const SHOCKING_PINK = 0xfc0fc0;
    public const SHOCKING_PINK_CRAYOLA = 0xff6fff;
    public const SIENNA = 0x882d17;
    public const SILVER = 0xc0c0c0;
    public const SINOPIA = 0xcb410b;
    public const SKOBELOFF = 0x007474;
    public const SKY_BLUE = 0x87ceeb;
    public const SKY_MAGENTA = 0xcf71af;
    public const SLATE_BLUE = 0x6a5acd;
    public const SLATE_GRAY = 0x708090;
    public const SMALT_DARK_POWDER_BLUE = 0x003399;
    public const SMOKEY_TOPAZ = 0x933d41;
    public const SMOKY_BLACK = 0x100c08;
    public const SNOW = 0xfffafa;
    public const SPIRO_DISCO_BALL = 0x0fc0fc;
    public const SPRING_BUD = 0xa7fc00;
    public const SPRING_GREEN = 0x00ff7f;
    public const ST_PATRICK_S_BLUE = 0x23297a;
    public const STEEL_BLUE = 0x4682b4;
    public const STIL_DE_GRAIN_YELLOW = 0xfada5e;
    public const STIZZA = 0x990000;
    public const STORMCLOUD = 0x4f666a;
    public const STRAW = 0xe4d96f;
    public const SUNGLOW = 0xffcc33;
    public const SUNSET = 0xfad6a5;
    public const TAN = 0xd2b48c;
    public const TANGELO = 0xf94d00;
    public const TANGERINE = 0xf28500;
    public const TANGERINE_YELLOW = 0xffcc00;
    public const TANGO_PINK = 0xe4717a;
    public const TAUPE = 0x483c32;
    public const TAUPE_GRAY = 0x8b8589;
    public const TEA_GREEN = 0xd0f0c0;
    public const TEA_ROSE_ORANGE = 0xf88379;
    public const TEA_ROSE_ROSE = 0xf4c2c2;
    public const TEAL = 0x008080;
    public const TEAL_BLUE = 0x367588;
    public const TEAL_GREEN = 0x00827f;
    public const TELEMAGENTA = 0xcf3476;
    public const TENN_TAWNY = 0xcd5700;
    public const TERRA_COTTA = 0xe2725b;
    public const THISTLE = 0xd8bfd8;
    public const THULIAN_PINK = 0xde6fa1;
    public const TICKLE_ME_PINK = 0xfc89ac;
    public const TIFFANY_BLUE = 0x0abab5;
    public const TIGER_S_EYE = 0xe08d3c;
    public const TIMBERWOLF = 0xdbd7d2;
    public const TITANIUM_YELLOW = 0xeee600;
    public const TOMATO = 0xff6347;
    public const TOOLBOX = 0x746cc0;
    public const TOPAZ = 0xffc87c;
    public const TRACTOR_RED = 0xfd0e35;
    public const TROLLEY_GREY = 0x808080;
    public const TROPICAL_RAIN_FOREST = 0x00755e;
    public const TRUE_BLUE = 0x0073cf;
    public const TUFTS_BLUE = 0x417dc1;
    public const TUMBLEWEED = 0xdeaa88;
    public const TURKISH_ROSE = 0xb57281;
    public const TURQUOISE = 0x30d5c8;
    public const TURQUOISE_BLUE = 0x00ffef;
    public const TURQUOISE_GREEN = 0xa0d6b4;
    public const TUSCAN_RED = 0x7c4848;
    public const TWILIGHT_LAVENDER = 0x8a496b;
    public const TYRIAN_PURPLE = 0x66023c;
    public const UA_BLUE = 0x0033aa;
    public const UA_RED = 0xd9004c;
    public const UBE = 0x8878c3;
    public const UCLA_BLUE = 0x536895;
    public const UCLA_GOLD = 0xffb300;
    public const UFO_GREEN = 0x3cd070;
    public const ULTRA_PINK = 0xff6fff;
    public const ULTRAMARINE = 0x120a8f;
    public const ULTRAMARINE_BLUE = 0x4166f5;
    public const UMBER = 0x635147;
    public const UNBLEACHED_SILK = 0xffddca;
    public const UNITED_NATIONS_BLUE = 0x5b92e5;
    public const UNIVERSITY_OF_CALIFORNIA_GOLD = 0xb78727;
    public const UNMELLOW_YELLOW = 0xffff66;
    public const UP_FOREST_GREEN = 0x014421;
    public const UP_MAROON = 0x7b1113;
    public const UPSDELL_RED = 0xae2029;
    public const UROBILIN = 0xe1ad21;
    public const USAFA_BLUE = 0x004f98;
    public const USC_CARDINAL = 0x990000;
    public const USC_GOLD = 0xffcc00;
    public const UTAH_CRIMSON = 0xd3003f;
    public const VANILLA = 0xf3e5ab;
    public const VEGAS_GOLD = 0xc5b358;
    public const VENETIAN_RED = 0xc80815;
    public const VERDIGRIS = 0x43b3ae;
    public const VERMILION_CINNABAR = 0xe34234;
    public const VERMILION_PLOCHERE = 0xd9603b;
    public const VERONICA = 0xa020f0;
    public const VIOLET = 0x8f00ff;
    public const VIOLET_BLUE = 0x324ab2;
    public const VIOLET_COLOR_WHEEL = 0x7f00ff;
    public const VIOLET_RYB = 0x8601af;
    public const VIOLET_WEB = 0xee82ee;
    public const VIRIDIAN = 0x40826d;
    public const VIVID_AUBURN = 0x922724;
    public const VIVID_BURGUNDY = 0x9f1d35;
    public const VIVID_CERISE = 0xda1d81;
    public const VIVID_TANGERINE = 0xffa089;
    public const VIVID_VIOLET = 0x9f00ff;
    public const WARM_BLACK = 0x004242;
    public const WATERSPOUT = 0xa4f4f9;
    public const WENGE = 0x645452;
    public const WHEAT = 0xf5deb3;
    public const WHITE = 0xffffff;
    public const WHITE_SMOKE = 0xf5f5f5;
    public const WILD_BLUE_YONDER = 0xa2add0;
    public const WILD_STRAWBERRY = 0xff43a4;
    public const WILD_WATERMELON = 0xfc6c85;
    public const WINE = 0x722f37;
    public const WINE_DREGS = 0x673147;
    public const WISTERIA = 0xc9a0dc;
    public const WOOD_BROWN = 0xc19a6b;
    public const XANADU = 0x738678;
    public const YALE_BLUE = 0x0f4d92;
    public const YELLOW = 0xffff00;
    public const YELLOW_GREEN = 0x9acd32;
    public const YELLOW_MUNSELL = 0xefcc00;
    public const YELLOW_NCS = 0xffd300;
    public const YELLOW_ORANGE = 0xffae42;
    public const YELLOW_PROCESS = 0xffef00;
    public const YELLOW_RYB = 0xfefe33;
    public const ZAFFRE = 0x0014a8;
    public const ZINNWALDITE_BROWN = 0x2c1608;
    #endregion

    #region Color Names
    private static $names = [
        'air-force-blue-raf' => self::AIR_FORCE_BLUE_RAF,
        'air-force-blue-usaf' => self::AIR_FORCE_BLUE_USAF,
        'air-superiority-blue' => self::AIR_SUPERIORITY_BLUE,
        'alabama-crimson' => self::ALABAMA_CRIMSON,
        'alice-blue' => self::ALICE_BLUE,
        'alizarin-crimson' => self::ALIZARIN_CRIMSON,
        'alloy-orange' => self::ALLOY_ORANGE,
        'almond' => self::ALMOND,
        'amaranth' => self::AMARANTH,
        'amber' => self::AMBER,
        'amber-sae-ece' => self::AMBER_SAE_ECE,
        'american-rose' => self::AMERICAN_ROSE,
        'amethyst' => self::AMETHYST,
        'android-green' => self::ANDROID_GREEN,
        'anti-flash-white' => self::ANTI_FLASH_WHITE,
        'antique-brass' => self::ANTIQUE_BRASS,
        'antique-fuchsia' => self::ANTIQUE_FUCHSIA,
        'antique-ruby' => self::ANTIQUE_RUBY,
        'antique-white' => self::ANTIQUE_WHITE,
        'ao-english' => self::AO_ENGLISH,
        'apple-green' => self::APPLE_GREEN,
        'apricot' => self::APRICOT,
        'aqua' => self::AQUA,
        'aquamarine' => self::AQUAMARINE,
        'army-green' => self::ARMY_GREEN,
        'arsenic' => self::ARSENIC,
        'arylide-yellow' => self::ARYLIDE_YELLOW,
        'ash-grey' => self::ASH_GREY,
        'asparagus' => self::ASPARAGUS,
        'atomic-tangerine' => self::ATOMIC_TANGERINE,
        'auburn' => self::AUBURN,
        'aureolin' => self::AUREOLIN,
        'aurometalsaurus' => self::AUROMETALSAURUS,
        'avocado' => self::AVOCADO,
        'azure' => self::AZURE,
        'azure-mist-web' => self::AZURE_MIST_WEB,
        'baby-blue' => self::BABY_BLUE,
        'baby-blue-eyes' => self::BABY_BLUE_EYES,
        'baby-pink' => self::BABY_PINK,
        'ball-blue' => self::BALL_BLUE,
        'banana-mania' => self::BANANA_MANIA,
        'banana-yellow' => self::BANANA_YELLOW,
        'barn-red' => self::BARN_RED,
        'battleship-grey' => self::BATTLESHIP_GREY,
        'bazaar' => self::BAZAAR,
        'beau-blue' => self::BEAU_BLUE,
        'beaver' => self::BEAVER,
        'beige' => self::BEIGE,
        'big-dip-o-ruby' => self::BIG_DIP_O_RUBY,
        'bisque' => self::BISQUE,
        'bistre' => self::BISTRE,
        'bittersweet' => self::BITTERSWEET,
        'bittersweet-shimmer' => self::BITTERSWEET_SHIMMER,
        'black' => self::BLACK,
        'black-bean' => self::BLACK_BEAN,
        'black-leather-jacket' => self::BLACK_LEATHER_JACKET,
        'black-olive' => self::BLACK_OLIVE,
        'blanched-almond' => self::BLANCHED_ALMOND,
        'blast-off-bronze' => self::BLAST_OFF_BRONZE,
        'bleu-de-france' => self::BLEU_DE_FRANCE,
        'blizzard-blue' => self::BLIZZARD_BLUE,
        'blond' => self::BLOND,
        'blue' => self::BLUE,
        'blue-bell' => self::BLUE_BELL,
        'blue-crayola' => self::BLUE_CRAYOLA,
        'blue-gray' => self::BLUE_GRAY,
        'blue-green' => self::BLUE_GREEN,
        'blue-munsell' => self::BLUE_MUNSELL,
        'blue-ncs' => self::BLUE_NCS,
        'blue-pigment' => self::BLUE_PIGMENT,
        'blue-ryb' => self::BLUE_RYB,
        'blue-sapphire' => self::BLUE_SAPPHIRE,
        'blue-violet' => self::BLUE_VIOLET,
        'blush' => self::BLUSH,
        'bole' => self::BOLE,
        'bondi-blue' => self::BONDI_BLUE,
        'bone' => self::BONE,
        'boston-university-red' => self::BOSTON_UNIVERSITY_RED,
        'bottle-green' => self::BOTTLE_GREEN,
        'boysenberry' => self::BOYSENBERRY,
        'brandeis-blue' => self::BRANDEIS_BLUE,
        'brass' => self::BRASS,
        'brick-red' => self::BRICK_RED,
        'bright-cerulean' => self::BRIGHT_CERULEAN,
        'bright-green' => self::BRIGHT_GREEN,
        'bright-lavender' => self::BRIGHT_LAVENDER,
        'bright-maroon' => self::BRIGHT_MAROON,
        'bright-pink' => self::BRIGHT_PINK,
        'bright-turquoise' => self::BRIGHT_TURQUOISE,
        'bright-ube' => self::BRIGHT_UBE,
        'brilliant-lavender' => self::BRILLIANT_LAVENDER,
        'brilliant-rose' => self::BRILLIANT_ROSE,
        'brink-pink' => self::BRINK_PINK,
        'british-racing-green' => self::BRITISH_RACING_GREEN,
        'bronze' => self::BRONZE,
        'brown-traditional' => self::BROWN_TRADITIONAL,
        'brown-web' => self::BROWN_WEB,
        'bubble-gum' => self::BUBBLE_GUM,
        'bubbles' => self::BUBBLES,
        'buff' => self::BUFF,
        'bulgarian-rose' => self::BULGARIAN_ROSE,
        'burgundy' => self::BURGUNDY,
        'burlywood' => self::BURLYWOOD,
        'burnt-orange' => self::BURNT_ORANGE,
        'burnt-sienna' => self::BURNT_SIENNA,
        'burnt-umber' => self::BURNT_UMBER,
        'byzantine' => self::BYZANTINE,
        'byzantium' => self::BYZANTIUM,
        'cadet' => self::CADET,
        'cadet-blue' => self::CADET_BLUE,
        'cadet-grey' => self::CADET_GREY,
        'cadmium-green' => self::CADMIUM_GREEN,
        'cadmium-orange' => self::CADMIUM_ORANGE,
        'cadmium-red' => self::CADMIUM_RED,
        'cadmium-yellow' => self::CADMIUM_YELLOW,
        'caf-au-lait' => self::CAF_AU_LAIT,
        'caf-noir' => self::CAF_NOIR,
        'cal-poly-green' => self::CAL_POLY_GREEN,
        'cambridge-blue' => self::CAMBRIDGE_BLUE,
        'camel' => self::CAMEL,
        'cameo-pink' => self::CAMEO_PINK,
        'camouflage-green' => self::CAMOUFLAGE_GREEN,
        'canary-yellow' => self::CANARY_YELLOW,
        'candy-apple-red' => self::CANDY_APPLE_RED,
        'candy-pink' => self::CANDY_PINK,
        'capri' => self::CAPRI,
        'caput-mortuum' => self::CAPUT_MORTUUM,
        'cardinal' => self::CARDINAL,
        'caribbean-green' => self::CARIBBEAN_GREEN,
        'carmine' => self::CARMINE,
        'carmine-m-p' => self::CARMINE_M_P,
        'carmine-pink' => self::CARMINE_PINK,
        'carmine-red' => self::CARMINE_RED,
        'carnation-pink' => self::CARNATION_PINK,
        'carnelian' => self::CARNELIAN,
        'carolina-blue' => self::CAROLINA_BLUE,
        'carrot-orange' => self::CARROT_ORANGE,
        'catalina-blue' => self::CATALINA_BLUE,
        'ceil' => self::CEIL,
        'celadon' => self::CELADON,
        'celadon-blue' => self::CELADON_BLUE,
        'celadon-green' => self::CELADON_GREEN,
        'celeste-colour' => self::CELESTE_COLOUR,
        'celestial-blue' => self::CELESTIAL_BLUE,
        'cerise' => self::CERISE,
        'cerise-pink' => self::CERISE_PINK,
        'cerulean' => self::CERULEAN,
        'cerulean-blue' => self::CERULEAN_BLUE,
        'cerulean-frost' => self::CERULEAN_FROST,
        'cg-blue' => self::CG_BLUE,
        'cg-red' => self::CG_RED,
        'chamoisee' => self::CHAMOISEE,
        'champagne' => self::CHAMPAGNE,
        'charcoal' => self::CHARCOAL,
        'charm-pink' => self::CHARM_PINK,
        'chartreuse-traditional' => self::CHARTREUSE_TRADITIONAL,
        'chartreuse-web' => self::CHARTREUSE_WEB,
        'cherry' => self::CHERRY,
        'cherry-blossom-pink' => self::CHERRY_BLOSSOM_PINK,
        'chestnut' => self::CHESTNUT,
        'china-pink' => self::CHINA_PINK,
        'china-rose' => self::CHINA_ROSE,
        'chinese-red' => self::CHINESE_RED,
        'chocolate-traditional' => self::CHOCOLATE_TRADITIONAL,
        'chocolate-web' => self::CHOCOLATE_WEB,
        'chrome-yellow' => self::CHROME_YELLOW,
        'cinereous' => self::CINEREOUS,
        'cinnabar' => self::CINNABAR,
        'cinnamon' => self::CINNAMON,
        'citrine' => self::CITRINE,
        'classic-rose' => self::CLASSIC_ROSE,
        'cobalt' => self::COBALT,
        'cocoa-brown' => self::COCOA_BROWN,
        'coffee' => self::COFFEE,
        'columbia-blue' => self::COLUMBIA_BLUE,
        'congo-pink' => self::CONGO_PINK,
        'cool-black' => self::COOL_BLACK,
        'cool-grey' => self::COOL_GREY,
        'copper' => self::COPPER,
        'copper-crayola' => self::COPPER_CRAYOLA,
        'copper-penny' => self::COPPER_PENNY,
        'copper-red' => self::COPPER_RED,
        'copper-rose' => self::COPPER_ROSE,
        'coquelicot' => self::COQUELICOT,
        'coral' => self::CORAL,
        'coral-pink' => self::CORAL_PINK,
        'coral-red' => self::CORAL_RED,
        'cordovan' => self::CORDOVAN,
        'corn' => self::CORN,
        'cornell-red' => self::CORNELL_RED,
        'cornflower-blue' => self::CORNFLOWER_BLUE,
        'cornsilk' => self::CORNSILK,
        'cosmic-latte' => self::COSMIC_LATTE,
        'cotton-candy' => self::COTTON_CANDY,
        'cream' => self::CREAM,
        'crimson' => self::CRIMSON,
        'crimson-glory' => self::CRIMSON_GLORY,
        'cyan' => self::CYAN,
        'cyan-process' => self::CYAN_PROCESS,
        'daffodil' => self::DAFFODIL,
        'dandelion' => self::DANDELION,
        'dark-blue' => self::DARK_BLUE,
        'dark-brown' => self::DARK_BROWN,
        'dark-byzantium' => self::DARK_BYZANTIUM,
        'dark-candy-apple-red' => self::DARK_CANDY_APPLE_RED,
        'dark-cerulean' => self::DARK_CERULEAN,
        'dark-chestnut' => self::DARK_CHESTNUT,
        'dark-coral' => self::DARK_CORAL,
        'dark-cyan' => self::DARK_CYAN,
        'dark-electric-blue' => self::DARK_ELECTRIC_BLUE,
        'dark-goldenrod' => self::DARK_GOLDENROD,
        'dark-gray' => self::DARK_GRAY,
        'dark-green' => self::DARK_GREEN,
        'dark-imperial-blue' => self::DARK_IMPERIAL_BLUE,
        'dark-jungle-green' => self::DARK_JUNGLE_GREEN,
        'dark-khaki' => self::DARK_KHAKI,
        'dark-lava' => self::DARK_LAVA,
        'dark-lavender' => self::DARK_LAVENDER,
        'dark-magenta' => self::DARK_MAGENTA,
        'dark-midnight-blue' => self::DARK_MIDNIGHT_BLUE,
        'dark-olive-green' => self::DARK_OLIVE_GREEN,
        'dark-orange' => self::DARK_ORANGE,
        'dark-orchid' => self::DARK_ORCHID,
        'dark-pastel-blue' => self::DARK_PASTEL_BLUE,
        'dark-pastel-green' => self::DARK_PASTEL_GREEN,
        'dark-pastel-purple' => self::DARK_PASTEL_PURPLE,
        'dark-pastel-red' => self::DARK_PASTEL_RED,
        'dark-pink' => self::DARK_PINK,
        'dark-powder-blue' => self::DARK_POWDER_BLUE,
        'dark-raspberry' => self::DARK_RASPBERRY,
        'dark-red' => self::DARK_RED,
        'dark-salmon' => self::DARK_SALMON,
        'dark-scarlet' => self::DARK_SCARLET,
        'dark-sea-green' => self::DARK_SEA_GREEN,
        'dark-sienna' => self::DARK_SIENNA,
        'dark-slate-blue' => self::DARK_SLATE_BLUE,
        'dark-slate-gray' => self::DARK_SLATE_GRAY,
        'dark-spring-green' => self::DARK_SPRING_GREEN,
        'dark-tan' => self::DARK_TAN,
        'dark-tangerine' => self::DARK_TANGERINE,
        'dark-taupe' => self::DARK_TAUPE,
        'dark-terra-cotta' => self::DARK_TERRA_COTTA,
        'dark-turquoise' => self::DARK_TURQUOISE,
        'dark-violet' => self::DARK_VIOLET,
        'dark-yellow' => self::DARK_YELLOW,
        'dartmouth-green' => self::DARTMOUTH_GREEN,
        'davy-s-grey' => self::DAVY_S_GREY,
        'debian-red' => self::DEBIAN_RED,
        'deep-carmine' => self::DEEP_CARMINE,
        'deep-carmine-pink' => self::DEEP_CARMINE_PINK,
        'deep-carrot-orange' => self::DEEP_CARROT_ORANGE,
        'deep-cerise' => self::DEEP_CERISE,
        'deep-champagne' => self::DEEP_CHAMPAGNE,
        'deep-chestnut' => self::DEEP_CHESTNUT,
        'deep-coffee' => self::DEEP_COFFEE,
        'deep-fuchsia' => self::DEEP_FUCHSIA,
        'deep-jungle-green' => self::DEEP_JUNGLE_GREEN,
        'deep-lilac' => self::DEEP_LILAC,
        'deep-magenta' => self::DEEP_MAGENTA,
        'deep-peach' => self::DEEP_PEACH,
        'deep-pink' => self::DEEP_PINK,
        'deep-ruby' => self::DEEP_RUBY,
        'deep-saffron' => self::DEEP_SAFFRON,
        'deep-sky-blue' => self::DEEP_SKY_BLUE,
        'deep-tuscan-red' => self::DEEP_TUSCAN_RED,
        'denim' => self::DENIM,
        'desert' => self::DESERT,
        'desert-sand' => self::DESERT_SAND,
        'dim-gray' => self::DIM_GRAY,
        'dodger-blue' => self::DODGER_BLUE,
        'dogwood-rose' => self::DOGWOOD_ROSE,
        'dollar-bill' => self::DOLLAR_BILL,
        'drab' => self::DRAB,
        'duke-blue' => self::DUKE_BLUE,
        'earth-yellow' => self::EARTH_YELLOW,
        'ebony' => self::EBONY,
        'ecru' => self::ECRU,
        'eggplant' => self::EGGPLANT,
        'eggshell' => self::EGGSHELL,
        'egyptian-blue' => self::EGYPTIAN_BLUE,
        'electric-blue' => self::ELECTRIC_BLUE,
        'electric-crimson' => self::ELECTRIC_CRIMSON,
        'electric-cyan' => self::ELECTRIC_CYAN,
        'electric-green' => self::ELECTRIC_GREEN,
        'electric-indigo' => self::ELECTRIC_INDIGO,
        'electric-lavender' => self::ELECTRIC_LAVENDER,
        'electric-lime' => self::ELECTRIC_LIME,
        'electric-purple' => self::ELECTRIC_PURPLE,
        'electric-ultramarine' => self::ELECTRIC_ULTRAMARINE,
        'electric-violet' => self::ELECTRIC_VIOLET,
        'electric-yellow' => self::ELECTRIC_YELLOW,
        'emerald' => self::EMERALD,
        'english-lavender' => self::ENGLISH_LAVENDER,
        'eton-blue' => self::ETON_BLUE,
        'fallow' => self::FALLOW,
        'falu-red' => self::FALU_RED,
        'fandango' => self::FANDANGO,
        'fashion-fuchsia' => self::FASHION_FUCHSIA,
        'fawn' => self::FAWN,
        'feldgrau' => self::FELDGRAU,
        'fern-green' => self::FERN_GREEN,
        'ferrari-red' => self::FERRARI_RED,
        'field-drab' => self::FIELD_DRAB,
        'fire-engine-red' => self::FIRE_ENGINE_RED,
        'firebrick' => self::FIREBRICK,
        'flame' => self::FLAME,
        'flamingo-pink' => self::FLAMINGO_PINK,
        'flavescent' => self::FLAVESCENT,
        'flax' => self::FLAX,
        'floral-white' => self::FLORAL_WHITE,
        'fluorescent-orange' => self::FLUORESCENT_ORANGE,
        'fluorescent-pink' => self::FLUORESCENT_PINK,
        'fluorescent-yellow' => self::FLUORESCENT_YELLOW,
        'folly' => self::FOLLY,
        'forest-green-traditional' => self::FOREST_GREEN_TRADITIONAL,
        'forest-green-web' => self::FOREST_GREEN_WEB,
        'french-beige' => self::FRENCH_BEIGE,
        'french-blue' => self::FRENCH_BLUE,
        'french-lilac' => self::FRENCH_LILAC,
        'french-lime' => self::FRENCH_LIME,
        'french-raspberry' => self::FRENCH_RASPBERRY,
        'french-rose' => self::FRENCH_ROSE,
        'fuchsia' => self::FUCHSIA,
        'fuchsia-crayola' => self::FUCHSIA_CRAYOLA,
        'fuchsia-pink' => self::FUCHSIA_PINK,
        'fuchsia-rose' => self::FUCHSIA_ROSE,
        'fulvous' => self::FULVOUS,
        'fuzzy-wuzzy' => self::FUZZY_WUZZY,
        'gainsboro' => self::GAINSBORO,
        'gamboge' => self::GAMBOGE,
        'ghost-white' => self::GHOST_WHITE,
        'ginger' => self::GINGER,
        'glaucous' => self::GLAUCOUS,
        'glitter' => self::GLITTER,
        'gold-metallic' => self::GOLD_METALLIC,
        'gold-web-golden' => self::GOLD_WEB_GOLDEN,
        'golden-brown' => self::GOLDEN_BROWN,
        'golden-poppy' => self::GOLDEN_POPPY,
        'golden-yellow' => self::GOLDEN_YELLOW,
        'goldenrod' => self::GOLDENROD,
        'granny-smith-apple' => self::GRANNY_SMITH_APPLE,
        'gray' => self::GRAY,
        'gray-asparagus' => self::GRAY_ASPARAGUS,
        'gray-html-css-gray' => self::GRAY_HTML_CSS_GRAY,
        'gray-x11-gray' => self::GRAY_X11_GRAY,
        'green-color-wheel-x11-green' => self::GREEN_COLOR_WHEEL_X11_GREEN,
        'green-crayola' => self::GREEN_CRAYOLA,
        'green-html-css-green' => self::GREEN_HTML_CSS_GREEN,
        'green-munsell' => self::GREEN_MUNSELL,
        'green-ncs' => self::GREEN_NCS,
        'green-pigment' => self::GREEN_PIGMENT,
        'green-ryb' => self::GREEN_RYB,
        'green-yellow' => self::GREEN_YELLOW,
        'grullo' => self::GRULLO,
        'guppie-green' => self::GUPPIE_GREEN,
        'halay-be' => self::HALAY_BE,
        'han-blue' => self::HAN_BLUE,
        'han-purple' => self::HAN_PURPLE,
        'hansa-yellow' => self::HANSA_YELLOW,
        'harlequin' => self::HARLEQUIN,
        'harvard-crimson' => self::HARVARD_CRIMSON,
        'harvest-gold' => self::HARVEST_GOLD,
        'heart-gold' => self::HEART_GOLD,
        'heliotrope' => self::HELIOTROPE,
        'hollywood-cerise' => self::HOLLYWOOD_CERISE,
        'honeydew' => self::HONEYDEW,
        'honolulu-blue' => self::HONOLULU_BLUE,
        'hooker-s-green' => self::HOOKER_S_GREEN,
        'hot-magenta' => self::HOT_MAGENTA,
        'hot-pink' => self::HOT_PINK,
        'hunter-green' => self::HUNTER_GREEN,
        'iceberg' => self::ICEBERG,
        'icterine' => self::ICTERINE,
        'imperial-blue' => self::IMPERIAL_BLUE,
        'inchworm' => self::INCHWORM,
        'india-green' => self::INDIA_GREEN,
        'indian-red' => self::INDIAN_RED,
        'indian-yellow' => self::INDIAN_YELLOW,
        'indigo' => self::INDIGO,
        'indigo-dye' => self::INDIGO_DYE,
        'indigo-web' => self::INDIGO_WEB,
        'international-klein-blue' => self::INTERNATIONAL_KLEIN_BLUE,
        'international-orange-aerospace' => self::INTERNATIONAL_ORANGE_AEROSPACE,
        'international-orange-engineering' => self::INTERNATIONAL_ORANGE_ENGINEERING,
        'international-orange-golden-gate-bridge' => self::INTERNATIONAL_ORANGE_GOLDEN_GATE_BRIDGE,
        'iris' => self::IRIS,
        'isabelline' => self::ISABELLINE,
        'islamic-green' => self::ISLAMIC_GREEN,
        'ivory' => self::IVORY,
        'jade' => self::JADE,
        'jasmine' => self::JASMINE,
        'jasper' => self::JASPER,
        'jazzberry-jam' => self::JAZZBERRY_JAM,
        'jet' => self::JET,
        'jonquil' => self::JONQUIL,
        'june-bud' => self::JUNE_BUD,
        'jungle-green' => self::JUNGLE_GREEN,
        'kelly-green' => self::KELLY_GREEN,
        'kenyan-copper' => self::KENYAN_COPPER,
        'khaki-html-css-khaki' => self::KHAKI_HTML_CSS_KHAKI,
        'khaki-x11-light-khaki' => self::KHAKI_X11_LIGHT_KHAKI,
        'ku-crimson' => self::KU_CRIMSON,
        'la-salle-green' => self::LA_SALLE_GREEN,
        'languid-lavender' => self::LANGUID_LAVENDER,
        'lapis-lazuli' => self::LAPIS_LAZULI,
        'laser-lemon' => self::LASER_LEMON,
        'laurel-green' => self::LAUREL_GREEN,
        'lava' => self::LAVA,
        'lavender-blue' => self::LAVENDER_BLUE,
        'lavender-blush' => self::LAVENDER_BLUSH,
        'lavender-floral' => self::LAVENDER_FLORAL,
        'lavender-gray' => self::LAVENDER_GRAY,
        'lavender-indigo' => self::LAVENDER_INDIGO,
        'lavender-magenta' => self::LAVENDER_MAGENTA,
        'lavender-mist' => self::LAVENDER_MIST,
        'lavender-pink' => self::LAVENDER_PINK,
        'lavender-purple' => self::LAVENDER_PURPLE,
        'lavender-rose' => self::LAVENDER_ROSE,
        'lavender-web' => self::LAVENDER_WEB,
        'lawn-green' => self::LAWN_GREEN,
        'lemon' => self::LEMON,
        'lemon-chiffon' => self::LEMON_CHIFFON,
        'lemon-lime' => self::LEMON_LIME,
        'licorice' => self::LICORICE,
        'light-apricot' => self::LIGHT_APRICOT,
        'light-blue' => self::LIGHT_BLUE,
        'light-brown' => self::LIGHT_BROWN,
        'light-carmine-pink' => self::LIGHT_CARMINE_PINK,
        'light-coral' => self::LIGHT_CORAL,
        'light-cornflower-blue' => self::LIGHT_CORNFLOWER_BLUE,
        'light-crimson' => self::LIGHT_CRIMSON,
        'light-cyan' => self::LIGHT_CYAN,
        'light-fuchsia-pink' => self::LIGHT_FUCHSIA_PINK,
        'light-goldenrod-yellow' => self::LIGHT_GOLDENROD_YELLOW,
        'light-gray' => self::LIGHT_GRAY,
        'light-green' => self::LIGHT_GREEN,
        'light-khaki' => self::LIGHT_KHAKI,
        'light-pastel-purple' => self::LIGHT_PASTEL_PURPLE,
        'light-pink' => self::LIGHT_PINK,
        'light-red-ochre' => self::LIGHT_RED_OCHRE,
        'light-salmon' => self::LIGHT_SALMON,
        'light-salmon-pink' => self::LIGHT_SALMON_PINK,
        'light-sea-green' => self::LIGHT_SEA_GREEN,
        'light-sky-blue' => self::LIGHT_SKY_BLUE,
        'light-slate-gray' => self::LIGHT_SLATE_GRAY,
        'light-taupe' => self::LIGHT_TAUPE,
        'light-thulian-pink' => self::LIGHT_THULIAN_PINK,
        'light-yellow' => self::LIGHT_YELLOW,
        'lilac' => self::LILAC,
        'lime-color-wheel' => self::LIME_COLOR_WHEEL,
        'lime-green' => self::LIME_GREEN,
        'lime-web-x11-green' => self::LIME_WEB_X11_GREEN,
        'limerick' => self::LIMERICK,
        'lincoln-green' => self::LINCOLN_GREEN,
        'linen' => self::LINEN,
        'lion' => self::LION,
        'little-boy-blue' => self::LITTLE_BOY_BLUE,
        'liver' => self::LIVER,
        'lust' => self::LUST,
        'magenta' => self::MAGENTA,
        'magenta-dye' => self::MAGENTA_DYE,
        'magenta-process' => self::MAGENTA_PROCESS,
        'magic-mint' => self::MAGIC_MINT,
        'magnolia' => self::MAGNOLIA,
        'mahogany' => self::MAHOGANY,
        'maize' => self::MAIZE,
        'majorelle-blue' => self::MAJORELLE_BLUE,
        'malachite' => self::MALACHITE,
        'manatee' => self::MANATEE,
        'mango-tango' => self::MANGO_TANGO,
        'mantis' => self::MANTIS,
        'mardi-gras' => self::MARDI_GRAS,
        'maroon-crayola' => self::MAROON_CRAYOLA,
        'maroon-html-css' => self::MAROON_HTML_CSS,
        'maroon-x11' => self::MAROON_X11,
        'mauve' => self::MAUVE,
        'mauve-taupe' => self::MAUVE_TAUPE,
        'mauvelous' => self::MAUVELOUS,
        'maya-blue' => self::MAYA_BLUE,
        'meat-brown' => self::MEAT_BROWN,
        'medium-aquamarine' => self::MEDIUM_AQUAMARINE,
        'medium-blue' => self::MEDIUM_BLUE,
        'medium-candy-apple-red' => self::MEDIUM_CANDY_APPLE_RED,
        'medium-carmine' => self::MEDIUM_CARMINE,
        'medium-champagne' => self::MEDIUM_CHAMPAGNE,
        'medium-electric-blue' => self::MEDIUM_ELECTRIC_BLUE,
        'medium-jungle-green' => self::MEDIUM_JUNGLE_GREEN,
        'medium-lavender-magenta' => self::MEDIUM_LAVENDER_MAGENTA,
        'medium-orchid' => self::MEDIUM_ORCHID,
        'medium-persian-blue' => self::MEDIUM_PERSIAN_BLUE,
        'medium-purple' => self::MEDIUM_PURPLE,
        'medium-red-violet' => self::MEDIUM_RED_VIOLET,
        'medium-ruby' => self::MEDIUM_RUBY,
        'medium-sea-green' => self::MEDIUM_SEA_GREEN,
        'medium-slate-blue' => self::MEDIUM_SLATE_BLUE,
        'medium-spring-bud' => self::MEDIUM_SPRING_BUD,
        'medium-spring-green' => self::MEDIUM_SPRING_GREEN,
        'medium-taupe' => self::MEDIUM_TAUPE,
        'medium-turquoise' => self::MEDIUM_TURQUOISE,
        'medium-tuscan-red' => self::MEDIUM_TUSCAN_RED,
        'medium-vermilion' => self::MEDIUM_VERMILION,
        'medium-violet-red' => self::MEDIUM_VIOLET_RED,
        'mellow-apricot' => self::MELLOW_APRICOT,
        'mellow-yellow' => self::MELLOW_YELLOW,
        'melon' => self::MELON,
        'midnight-blue' => self::MIDNIGHT_BLUE,
        'midnight-green-eagle-green' => self::MIDNIGHT_GREEN_EAGLE_GREEN,
        'mikado-yellow' => self::MIKADO_YELLOW,
        'mint' => self::MINT,
        'mint-cream' => self::MINT_CREAM,
        'mint-green' => self::MINT_GREEN,
        'misty-rose' => self::MISTY_ROSE,
        'moccasin' => self::MOCCASIN,
        'mode-beige' => self::MODE_BEIGE,
        'moonstone-blue' => self::MOONSTONE_BLUE,
        'mordant-red-19' => self::MORDANT_RED_19,
        'moss-green' => self::MOSS_GREEN,
        'mountain-meadow' => self::MOUNTAIN_MEADOW,
        'mountbatten-pink' => self::MOUNTBATTEN_PINK,
        'msu-green' => self::MSU_GREEN,
        'mulberry' => self::MULBERRY,
        'mustard' => self::MUSTARD,
        'myrtle' => self::MYRTLE,
        'nadeshiko-pink' => self::NADESHIKO_PINK,
        'napier-green' => self::NAPIER_GREEN,
        'naples-yellow' => self::NAPLES_YELLOW,
        'navajo-white' => self::NAVAJO_WHITE,
        'navy-blue' => self::NAVY_BLUE,
        'neon-carrot' => self::NEON_CARROT,
        'neon-fuchsia' => self::NEON_FUCHSIA,
        'neon-green' => self::NEON_GREEN,
        'new-york-pink' => self::NEW_YORK_PINK,
        'non-photo-blue' => self::NON_PHOTO_BLUE,
        'north-texas-green' => self::NORTH_TEXAS_GREEN,
        'ocean-boat-blue' => self::OCEAN_BOAT_BLUE,
        'ochre' => self::OCHRE,
        'office-green' => self::OFFICE_GREEN,
        'old-gold' => self::OLD_GOLD,
        'old-lace' => self::OLD_LACE,
        'old-lavender' => self::OLD_LAVENDER,
        'old-mauve' => self::OLD_MAUVE,
        'old-rose' => self::OLD_ROSE,
        'olive' => self::OLIVE,
        'olive-drab-7' => self::OLIVE_DRAB_7,
        'olive-drab-web-olive-drab-3' => self::OLIVE_DRAB_WEB_OLIVE_DRAB_3,
        'olivine' => self::OLIVINE,
        'onyx' => self::ONYX,
        'opera-mauve' => self::OPERA_MAUVE,
        'orange-color-wheel' => self::ORANGE_COLOR_WHEEL,
        'orange-peel' => self::ORANGE_PEEL,
        'orange-red' => self::ORANGE_RED,
        'orange-ryb' => self::ORANGE_RYB,
        'orange-web-color' => self::ORANGE_WEB_COLOR,
        'orchid' => self::ORCHID,
        'otter-brown' => self::OTTER_BROWN,
        'ou-crimson-red' => self::OU_CRIMSON_RED,
        'outer-space' => self::OUTER_SPACE,
        'outrageous-orange' => self::OUTRAGEOUS_ORANGE,
        'oxford-blue' => self::OXFORD_BLUE,
        'pakistan-green' => self::PAKISTAN_GREEN,
        'palatinate-blue' => self::PALATINATE_BLUE,
        'palatinate-purple' => self::PALATINATE_PURPLE,
        'pale-aqua' => self::PALE_AQUA,
        'pale-blue' => self::PALE_BLUE,
        'pale-brown' => self::PALE_BROWN,
        'pale-carmine' => self::PALE_CARMINE,
        'pale-cerulean' => self::PALE_CERULEAN,
        'pale-chestnut' => self::PALE_CHESTNUT,
        'pale-copper' => self::PALE_COPPER,
        'pale-cornflower-blue' => self::PALE_CORNFLOWER_BLUE,
        'pale-gold' => self::PALE_GOLD,
        'pale-goldenrod' => self::PALE_GOLDENROD,
        'pale-green' => self::PALE_GREEN,
        'pale-lavender' => self::PALE_LAVENDER,
        'pale-magenta' => self::PALE_MAGENTA,
        'pale-pink' => self::PALE_PINK,
        'pale-plum' => self::PALE_PLUM,
        'pale-red-violet' => self::PALE_RED_VIOLET,
        'pale-robin-egg-blue' => self::PALE_ROBIN_EGG_BLUE,
        'pale-silver' => self::PALE_SILVER,
        'pale-spring-bud' => self::PALE_SPRING_BUD,
        'pale-taupe' => self::PALE_TAUPE,
        'pale-violet-red' => self::PALE_VIOLET_RED,
        'pansy-purple' => self::PANSY_PURPLE,
        'papaya-whip' => self::PAPAYA_WHIP,
        'paris-green' => self::PARIS_GREEN,
        'pastel-blue' => self::PASTEL_BLUE,
        'pastel-brown' => self::PASTEL_BROWN,
        'pastel-gray' => self::PASTEL_GRAY,
        'pastel-green' => self::PASTEL_GREEN,
        'pastel-magenta' => self::PASTEL_MAGENTA,
        'pastel-orange' => self::PASTEL_ORANGE,
        'pastel-pink' => self::PASTEL_PINK,
        'pastel-purple' => self::PASTEL_PURPLE,
        'pastel-red' => self::PASTEL_RED,
        'pastel-violet' => self::PASTEL_VIOLET,
        'pastel-yellow' => self::PASTEL_YELLOW,
        'patriarch' => self::PATRIARCH,
        'payne-s-grey' => self::PAYNE_S_GREY,
        'peach' => self::PEACH,
        'peach-crayola' => self::PEACH_CRAYOLA,
        'peach-orange' => self::PEACH_ORANGE,
        'peach-puff' => self::PEACH_PUFF,
        'peach-yellow' => self::PEACH_YELLOW,
        'pear' => self::PEAR,
        'pearl' => self::PEARL,
        'pearl-aqua' => self::PEARL_AQUA,
        'pearly-purple' => self::PEARLY_PURPLE,
        'peridot' => self::PERIDOT,
        'periwinkle' => self::PERIWINKLE,
        'persian-blue' => self::PERSIAN_BLUE,
        'persian-green' => self::PERSIAN_GREEN,
        'persian-indigo' => self::PERSIAN_INDIGO,
        'persian-orange' => self::PERSIAN_ORANGE,
        'persian-pink' => self::PERSIAN_PINK,
        'persian-plum' => self::PERSIAN_PLUM,
        'persian-red' => self::PERSIAN_RED,
        'persian-rose' => self::PERSIAN_ROSE,
        'persimmon' => self::PERSIMMON,
        'peru' => self::PERU,
        'phlox' => self::PHLOX,
        'phthalo-blue' => self::PHTHALO_BLUE,
        'phthalo-green' => self::PHTHALO_GREEN,
        'piggy-pink' => self::PIGGY_PINK,
        'pine-green' => self::PINE_GREEN,
        'pink' => self::PINK,
        'pink-lace' => self::PINK_LACE,
        'pink-orange' => self::PINK_ORANGE,
        'pink-pearl' => self::PINK_PEARL,
        'pink-sherbet' => self::PINK_SHERBET,
        'pistachio' => self::PISTACHIO,
        'platinum' => self::PLATINUM,
        'plum-traditional' => self::PLUM_TRADITIONAL,
        'plum-web' => self::PLUM_WEB,
        'portland-orange' => self::PORTLAND_ORANGE,
        'powder-blue-web' => self::POWDER_BLUE_WEB,
        'princeton-orange' => self::PRINCETON_ORANGE,
        'prune' => self::PRUNE,
        'prussian-blue' => self::PRUSSIAN_BLUE,
        'psychedelic-purple' => self::PSYCHEDELIC_PURPLE,
        'puce' => self::PUCE,
        'pumpkin' => self::PUMPKIN,
        'purple-heart' => self::PURPLE_HEART,
        'purple-html-css' => self::PURPLE_HTML_CSS,
        'purple-mountain-majesty' => self::PURPLE_MOUNTAIN_MAJESTY,
        'purple-munsell' => self::PURPLE_MUNSELL,
        'purple-pizzazz' => self::PURPLE_PIZZAZZ,
        'purple-taupe' => self::PURPLE_TAUPE,
        'purple-x11' => self::PURPLE_X11,
        'quartz' => self::QUARTZ,
        'rackley' => self::RACKLEY,
        'radical-red' => self::RADICAL_RED,
        'rajah' => self::RAJAH,
        'raspberry' => self::RASPBERRY,
        'raspberry-glace' => self::RASPBERRY_GLACE,
        'raspberry-pink' => self::RASPBERRY_PINK,
        'raspberry-rose' => self::RASPBERRY_ROSE,
        'raw-umber' => self::RAW_UMBER,
        'razzle-dazzle-rose' => self::RAZZLE_DAZZLE_ROSE,
        'razzmatazz' => self::RAZZMATAZZ,
        'red' => self::RED,
        'red-brown' => self::RED_BROWN,
        'red-devil' => self::RED_DEVIL,
        'red-munsell' => self::RED_MUNSELL,
        'red-ncs' => self::RED_NCS,
        'red-orange' => self::RED_ORANGE,
        'red-pigment' => self::RED_PIGMENT,
        'red-ryb' => self::RED_RYB,
        'red-violet' => self::RED_VIOLET,
        'redwood' => self::REDWOOD,
        'regalia' => self::REGALIA,
        'resolution-blue' => self::RESOLUTION_BLUE,
        'rich-black' => self::RICH_BLACK,
        'rich-brilliant-lavender' => self::RICH_BRILLIANT_LAVENDER,
        'rich-carmine' => self::RICH_CARMINE,
        'rich-electric-blue' => self::RICH_ELECTRIC_BLUE,
        'rich-lavender' => self::RICH_LAVENDER,
        'rich-lilac' => self::RICH_LILAC,
        'rich-maroon' => self::RICH_MAROON,
        'rifle-green' => self::RIFLE_GREEN,
        'robin-egg-blue' => self::ROBIN_EGG_BLUE,
        'rose' => self::ROSE,
        'rose-bonbon' => self::ROSE_BONBON,
        'rose-ebony' => self::ROSE_EBONY,
        'rose-gold' => self::ROSE_GOLD,
        'rose-madder' => self::ROSE_MADDER,
        'rose-pink' => self::ROSE_PINK,
        'rose-quartz' => self::ROSE_QUARTZ,
        'rose-taupe' => self::ROSE_TAUPE,
        'rose-vale' => self::ROSE_VALE,
        'rosewood' => self::ROSEWOOD,
        'rosso-corsa' => self::ROSSO_CORSA,
        'rosy-brown' => self::ROSY_BROWN,
        'royal-azure' => self::ROYAL_AZURE,
        'royal-blue-traditional' => self::ROYAL_BLUE_TRADITIONAL,
        'royal-blue-web' => self::ROYAL_BLUE_WEB,
        'royal-fuchsia' => self::ROYAL_FUCHSIA,
        'royal-purple' => self::ROYAL_PURPLE,
        'royal-yellow' => self::ROYAL_YELLOW,
        'rubine-red' => self::RUBINE_RED,
        'ruby' => self::RUBY,
        'ruby-red' => self::RUBY_RED,
        'ruddy' => self::RUDDY,
        'ruddy-brown' => self::RUDDY_BROWN,
        'ruddy-pink' => self::RUDDY_PINK,
        'rufous' => self::RUFOUS,
        'russet' => self::RUSSET,
        'rust' => self::RUST,
        'rusty-red' => self::RUSTY_RED,
        'sacramento-state-green' => self::SACRAMENTO_STATE_GREEN,
        'saddle-brown' => self::SADDLE_BROWN,
        'safety-orange-blaze-orange' => self::SAFETY_ORANGE_BLAZE_ORANGE,
        'saffron' => self::SAFFRON,
        'salmon' => self::SALMON,
        'salmon-pink' => self::SALMON_PINK,
        'sand' => self::SAND,
        'sand-dune' => self::SAND_DUNE,
        'sandstorm' => self::SANDSTORM,
        'sandy-brown' => self::SANDY_BROWN,
        'sandy-taupe' => self::SANDY_TAUPE,
        'sangria' => self::SANGRIA,
        'sap-green' => self::SAP_GREEN,
        'sapphire' => self::SAPPHIRE,
        'sapphire-blue' => self::SAPPHIRE_BLUE,
        'satin-sheen-gold' => self::SATIN_SHEEN_GOLD,
        'scarlet' => self::SCARLET,
        'scarlet-crayola' => self::SCARLET_CRAYOLA,
        'school-bus-yellow' => self::SCHOOL_BUS_YELLOW,
        'screamin-green' => self::SCREAMIN_GREEN,
        'sea-blue' => self::SEA_BLUE,
        'sea-green' => self::SEA_GREEN,
        'seal-brown' => self::SEAL_BROWN,
        'seashell' => self::SEASHELL,
        'selective-yellow' => self::SELECTIVE_YELLOW,
        'sepia' => self::SEPIA,
        'shadow' => self::SHADOW,
        'shamrock-green' => self::SHAMROCK_GREEN,
        'shocking-pink' => self::SHOCKING_PINK,
        'shocking-pink-crayola' => self::SHOCKING_PINK_CRAYOLA,
        'sienna' => self::SIENNA,
        'silver' => self::SILVER,
        'sinopia' => self::SINOPIA,
        'skobeloff' => self::SKOBELOFF,
        'sky-blue' => self::SKY_BLUE,
        'sky-magenta' => self::SKY_MAGENTA,
        'slate-blue' => self::SLATE_BLUE,
        'slate-gray' => self::SLATE_GRAY,
        'smalt-dark-powder-blue' => self::SMALT_DARK_POWDER_BLUE,
        'smokey-topaz' => self::SMOKEY_TOPAZ,
        'smoky-black' => self::SMOKY_BLACK,
        'snow' => self::SNOW,
        'spiro-disco-ball' => self::SPIRO_DISCO_BALL,
        'spring-bud' => self::SPRING_BUD,
        'spring-green' => self::SPRING_GREEN,
        'st-patrick-s-blue' => self::ST_PATRICK_S_BLUE,
        'steel-blue' => self::STEEL_BLUE,
        'stil-de-grain-yellow' => self::STIL_DE_GRAIN_YELLOW,
        'stizza' => self::STIZZA,
        'stormcloud' => self::STORMCLOUD,
        'straw' => self::STRAW,
        'sunglow' => self::SUNGLOW,
        'sunset' => self::SUNSET,
        'tan' => self::TAN,
        'tangelo' => self::TANGELO,
        'tangerine' => self::TANGERINE,
        'tangerine-yellow' => self::TANGERINE_YELLOW,
        'tango-pink' => self::TANGO_PINK,
        'taupe' => self::TAUPE,
        'taupe-gray' => self::TAUPE_GRAY,
        'tea-green' => self::TEA_GREEN,
        'tea-rose-orange' => self::TEA_ROSE_ORANGE,
        'tea-rose-rose' => self::TEA_ROSE_ROSE,
        'teal' => self::TEAL,
        'teal-blue' => self::TEAL_BLUE,
        'teal-green' => self::TEAL_GREEN,
        'telemagenta' => self::TELEMAGENTA,
        'tenn-tawny' => self::TENN_TAWNY,
        'terra-cotta' => self::TERRA_COTTA,
        'thistle' => self::THISTLE,
        'thulian-pink' => self::THULIAN_PINK,
        'tickle-me-pink' => self::TICKLE_ME_PINK,
        'tiffany-blue' => self::TIFFANY_BLUE,
        'tiger-s-eye' => self::TIGER_S_EYE,
        'timberwolf' => self::TIMBERWOLF,
        'titanium-yellow' => self::TITANIUM_YELLOW,
        'tomato' => self::TOMATO,
        'toolbox' => self::TOOLBOX,
        'topaz' => self::TOPAZ,
        'tractor-red' => self::TRACTOR_RED,
        'trolley-grey' => self::TROLLEY_GREY,
        'tropical-rain-forest' => self::TROPICAL_RAIN_FOREST,
        'true-blue' => self::TRUE_BLUE,
        'tufts-blue' => self::TUFTS_BLUE,
        'tumbleweed' => self::TUMBLEWEED,
        'turkish-rose' => self::TURKISH_ROSE,
        'turquoise' => self::TURQUOISE,
        'turquoise-blue' => self::TURQUOISE_BLUE,
        'turquoise-green' => self::TURQUOISE_GREEN,
        'tuscan-red' => self::TUSCAN_RED,
        'twilight-lavender' => self::TWILIGHT_LAVENDER,
        'tyrian-purple' => self::TYRIAN_PURPLE,
        'ua-blue' => self::UA_BLUE,
        'ua-red' => self::UA_RED,
        'ube' => self::UBE,
        'ucla-blue' => self::UCLA_BLUE,
        'ucla-gold' => self::UCLA_GOLD,
        'ufo-green' => self::UFO_GREEN,
        'ultra-pink' => self::ULTRA_PINK,
        'ultramarine' => self::ULTRAMARINE,
        'ultramarine-blue' => self::ULTRAMARINE_BLUE,
        'umber' => self::UMBER,
        'unbleached-silk' => self::UNBLEACHED_SILK,
        'united-nations-blue' => self::UNITED_NATIONS_BLUE,
        'university-of-california-gold' => self::UNIVERSITY_OF_CALIFORNIA_GOLD,
        'unmellow-yellow' => self::UNMELLOW_YELLOW,
        'up-forest-green' => self::UP_FOREST_GREEN,
        'up-maroon' => self::UP_MAROON,
        'upsdell-red' => self::UPSDELL_RED,
        'urobilin' => self::UROBILIN,
        'usafa-blue' => self::USAFA_BLUE,
        'usc-cardinal' => self::USC_CARDINAL,
        'usc-gold' => self::USC_GOLD,
        'utah-crimson' => self::UTAH_CRIMSON,
        'vanilla' => self::VANILLA,
        'vegas-gold' => self::VEGAS_GOLD,
        'venetian-red' => self::VENETIAN_RED,
        'verdigris' => self::VERDIGRIS,
        'vermilion-cinnabar' => self::VERMILION_CINNABAR,
        'vermilion-plochere' => self::VERMILION_PLOCHERE,
        'veronica' => self::VERONICA,
        'violet' => self::VIOLET,
        'violet-blue' => self::VIOLET_BLUE,
        'violet-color-wheel' => self::VIOLET_COLOR_WHEEL,
        'violet-ryb' => self::VIOLET_RYB,
        'violet-web' => self::VIOLET_WEB,
        'viridian' => self::VIRIDIAN,
        'vivid-auburn' => self::VIVID_AUBURN,
        'vivid-burgundy' => self::VIVID_BURGUNDY,
        'vivid-cerise' => self::VIVID_CERISE,
        'vivid-tangerine' => self::VIVID_TANGERINE,
        'vivid-violet' => self::VIVID_VIOLET,
        'warm-black' => self::WARM_BLACK,
        'waterspout' => self::WATERSPOUT,
        'wenge' => self::WENGE,
        'wheat' => self::WHEAT,
        'white' => self::WHITE,
        'white-smoke' => self::WHITE_SMOKE,
        'wild-blue-yonder' => self::WILD_BLUE_YONDER,
        'wild-strawberry' => self::WILD_STRAWBERRY,
        'wild-watermelon' => self::WILD_WATERMELON,
        'wine' => self::WINE,
        'wine-dregs' => self::WINE_DREGS,
        'wisteria' => self::WISTERIA,
        'wood-brown' => self::WOOD_BROWN,
        'xanadu' => self::XANADU,
        'yale-blue' => self::YALE_BLUE,
        'yellow' => self::YELLOW,
        'yellow-green' => self::YELLOW_GREEN,
        'yellow-munsell' => self::YELLOW_MUNSELL,
        'yellow-ncs' => self::YELLOW_NCS,
        'yellow-orange' => self::YELLOW_ORANGE,
        'yellow-process' => self::YELLOW_PROCESS,
        'yellow-ryb' => self::YELLOW_RYB,
        'zaffre' => self::ZAFFRE,
        'zinnwaldite-brown' => self::ZINNWALDITE_BROWN
    ];
    #endregion

    #region Color Functions
    private static $functions = [
        'rgb' => ['className' => RgbColor::class, 'args' => [
            ['type' => 'int', 'base' => 255.0],
            ['type' => 'int', 'base' => 255.0],
            ['type' => 'int', 'base' => 255.0]
        ]],
        'rgba' => ['className' => RgbaColor::class, 'args' => [
            ['type' => 'int', 'base' => 255.0],
            ['type' => 'int', 'base' => 255.0],
            ['type' => 'int', 'base' => 255.0],
            ['type' => 'float', 'base' => 1.0]
        ]],
        'hsl' => ['className' => HslColor::class, 'args' => [
            ['type' => 'float', 'base' => 360.0, 'rotate' => true],
            ['type' => 'float', 'base' => 1.0],
            ['type' => 'float', 'base' => 1.0]
        ]],
        'hsla' => ['className' => HslaColor::class, 'args' => [
            ['type' => 'float', 'base' => 360.0, 'rotate' => true],
            ['type' => 'float', 'base' => 1.0],
            ['type' => 'float', 'base' => 1.0],
            ['type' => 'float', 'base' => 1.0]
        ]],
        'hsv' => ['className' => HsvColor::class, 'args' => [
            ['type' => 'float', 'base' => 360, 'rotate' => true],
            ['type' => 'float', 'base' => 1],
            ['type' => 'float', 'base' => 1]
        ]],
        'hsva' => ['className' => HsvaColor::class, 'args' => [
            ['type' => 'float', 'base' => 360.0, 'rotate' => true],
            ['type' => 'float', 'base' => 1.0],
            ['type' => 'float', 'base' => 1.0],
            ['type' => 'float', 'base' => 1.0]
        ]],
        'xyz' => ['className' => XyzColor::class, 'args' => [
            ['type' => 'float', 'base' => XyzColorInterface::REF_X],
            ['type' => 'float', 'base' => XyzColorInterface::REF_Y],
            ['type' => 'float', 'base' => XyzColorInterface::REF_Z]
        ]],
        'lab' => ['className' => LabColor::class, 'args' => [
            ['type' => 'float', 'base' => 100.0],
            ['type' => 'float', 'base' => 1.0],
            ['type' => 'float', 'base' => 1.0]
        ]]
    ];
    #endregion

    private function __construct() {}

    public static function getNames(): array
    {
        return self::$names;
    }

    public static function toName(ColorInterface $color): string
    {
        $int = self::toInt($color->toRgb());
        $name = array_search($int, self::$names, true);
        return $name !== false ? $name : '0x'.dechex($int);
    }

    public static function fromName(string $name): ?RgbColorInterface
    {
        $lowerName = strtolower($name);
        if (!isset(self::$names[$lowerName])) {
            return null;
        }
        return self::fromInt(self::$names[$lowerName]);
    }

    public static function registerName(string $name, ColorInterface $color): void
    {
        self::$names[$name] = self::toInt($color->toRgb());
    }

    public static function toHexString(
        ColorInterface $color,
        bool $expand = false,
        bool $alpha = false
    ): string
    {
        $rgb = $alpha && $color instanceof AlphaColorInterface ? $color->toRgba() : $color->toRgb();

        $hex = '#';
        $hex .= str_pad(dechex($rgb->getRed()), 2, '0', STR_PAD_LEFT);
        $hex .= str_pad(dechex($rgb->getGreen()), 2, '0', STR_PAD_LEFT);
        $hex .= str_pad(dechex($rgb->getBlue()), 2, '0', STR_PAD_LEFT);

        if ($rgb instanceof AlphaColorInterface) {
            $hex .= str_pad(dechex($rgb->getAlpha() * 255), 2, '0', STR_PAD_LEFT);
        }

        if (!$expand && $rgb instanceof AlphaColorInterface
            && $hex[1] === $hex[2] && $hex[3] === $hex[4] && $hex[5] === $hex[6] && $hex[7] === $hex[8]) {
            $hex = '#' . $hex[1] . $hex[3] . $hex[5] . $hex[7];
        } elseif (!$expand && $hex[1] === $hex[2] && $hex[3] === $hex[4] && $hex[5] === $hex[6]) {
            $hex = '#' . $hex[1] . $hex[3] . $hex[5];
        }

        return $hex;
    }

    public static function fromHexString(
        string $hexString,
        int $endian = self::ENDIAN_BIG,
        bool $intAlpha = false
    ): ?RgbColorInterface
    {
        if (empty($hexString) || $hexString[0] !== '#' || \strlen($hexString) > 9) { //never accept more than 8 nibbles (4-channel max)
            return null;
        }

        $hex = ltrim($hexString, '#');
        $len = \strlen($hex);
        //The below switch allows alpha channel for all platforms
        //It contains 3-channel non-expanded, 3-channel expanded (6), 4-channel non-expanded and 4-channel expanded (8)
        switch ($len) {
            case 3:
                return $endian === self::ENDIAN_BIG
                    ? new RgbColor(
                        hexdec($hex[0].$hex[0]),
                        hexdec($hex[1].$hex[1]),
                        hexdec($hex[2].$hex[2])
                    )
                    : new RgbColor(
                        hexdec($hex[2].$hex[2]),
                        hexdec($hex[1].$hex[1]),
                        hexdec($hex[0].$hex[0])
                    );
            case 4:
                return $endian === self::ENDIAN_BIG
                    ? new RgbaColor(
                        hexdec($hex[0].$hex[0]),
                        hexdec($hex[1].$hex[1]),
                        hexdec($hex[2].$hex[2]),
                        hexdec($hex[3].$hex[3]) / 255
                    )
                    : new RgbaColor(
                        hexdec($hex[3].$hex[3]),
                        hexdec($hex[2].$hex[2]),
                        hexdec($hex[1].$hex[1]),
                        hexdec($hex[0].$hex[0]) / 255
                    );
            case 6:
                return $endian === self::ENDIAN_BIG
                    ? new RgbColor(
                        hexdec($hex[0].$hex[1]),
                        hexdec($hex[2].$hex[3]),
                        hexdec($hex[4].$hex[5])
                    )
                    : new RgbColor(
                        hexdec($hex[5].$hex[4]),
                        hexdec($hex[3].$hex[2]),
                        hexdec($hex[1].$hex[0])
                    );
            case 8:
                return $endian === self::ENDIAN_BIG
                    ? new RgbaColor(
                        hexdec($hex[0].$hex[1]),
                        hexdec($hex[2].$hex[3]),
                        hexdec($hex[4].$hex[5]),
                        hexdec($hex[6].$hex[7]) / 255
                    )
                    : new RgbaColor(
                        hexdec($hex[7].$hex[6]),
                        hexdec($hex[5].$hex[4]),
                        hexdec($hex[3].$hex[2]),
                        hexdec($hex[1].$hex[0]) / 255
                    );
        }

        //Try parsing from int (alpha channel only on 64bit) if no channel-pattern above matches
        return self::fromInt(hexdec($hex), $intAlpha, $endian);
    }

    public static function toInt(ColorInterface $color, bool $alpha = false, int $endian = self::ENDIAN_BIG): int
    {
        if ($alpha) {
            if (PHP_INT_SIZE < 5) {
                throw new InvalidPlatformException('4-channel color integers are only supported in 64-bit PHP');
            }

            $color = $color->toRgba();
            return unpack(self::getLongIntType($endian), pack('C*',
                $color->getRed(),
                $color->getGreen(),
                $color->getBlue(),
                (int)($color->getAlpha() * 255)
            ))[1];
        }

        $color = $color->toRgb();
        return unpack(self::getIntType($endian), pack('C*',
            0,
            $color->getRed(),
            $color->getGreen(),
            $color->getBlue()
        ))[1];
    }

    public static function fromInt(int $intValue, bool $alpha = false, int $endian = self::ENDIAN_BIG): RgbColorInterface
    {
        if ($alpha) {
            if (PHP_INT_SIZE < 5) {
                throw new InvalidPlatformException('4-channel color integers are only supported in 64-bit PHP');
            }

            [, $r, $g, $b, $a] = unpack('C*', pack(self::getLongIntType($endian), $intValue));
            return new RgbaColor($r, $g, $b, $a / 255);
        }

        [,, $r, $g, $b] = unpack('C*', pack(self::getIntType($endian), $intValue));
        return new RgbColor($r, $g, $b);
    }

    /**
     * @return array
     */
    public static function getFunctions(): array
    {
        return self::$functions;
    }

    public static function fromFunctionString(string $functionString): ?ColorInterface
    {
        if (!preg_match(self::FUNCTION_REGEX, $functionString, $matches)) {
            return null;
        }

        $function = $matches[1];
        $args = array_map('trim', explode(',', $matches[2]));

        if (!isset(self::$functions[$function])) {
            throw new InvalidFunctionNameException("Color function $function is not registered");
        }

        $className = self::$functions[$function]['className'];
        $argDefs = self::$functions[$function]['args'];

        if (\count($args) !== \count($argDefs)) {
            throw new BadFunctionArgumentsException(sprintf(
                "Invalid argument count for $function: Expected %d values, got %d values",
                \count($argDefs),
                \count($args)
            ));
        }

        $args = array_map(function($value, $arg) {
            return self::convertValue($value, $arg['type'], $arg['base'], $arg['rotate'] ?? false);
        }, $args, $argDefs);

        return new $className(...$args);
    }

    /**
     * @param ColorInterface|string|int $value
     *
     * @return ColorInterface|null
     */
    public static function get($value): ?ColorInterface
    {
        if ($value instanceof ColorInterface) {
            return $value;
        }

        if (\is_int($value)) {
            return self::fromInt($value);
        }

        return self::fromName($value) ?? (self::fromHexString($value) ?? self::fromFunctionString($value));
    }

    public static function getMax(ColorInterface $color): int
    {
        $rgb = $color->toRgb();
        return (int)max($rgb->getRed(), $rgb->getGreen(), $rgb->getBlue());
    }

    public static function getMin(ColorInterface $color): int
    {
        $rgb = $color->toRgb();
        return (int)min($rgb->getRed(), $rgb->getGreen(), $rgb->getBlue());
    }

    public static function getAverage(ColorInterface $color): float
    {
        $rgb = $color->toRgb();
        return (float)($rgb->getRed() + $rgb->getGreen() + $rgb->getBlue()) / 3;
    }

    public static function getHueRange(float $hue): string
    {
        if ($hue >= 30 && $hue < 90) {
            return self::HUE_RANGE_YELLOW;
        }

        if ($hue >= 90 && $hue < 150) {
            return self::HUE_RANGE_GREEN;
        }

        if ($hue >= 150 && $hue < 210) {
            return self::HUE_RANGE_CYAN;
        }

        if ($hue >= 210 && $hue < 270) {
            return self::HUE_RANGE_BLUE;
        }

        if ($hue >= 270 && $hue < 330) {
            return self::HUE_RANGE_MAGENTA;
        }

        return self::HUE_RANGE_RED;
    }

    public static function isHueRange(float $hue, string $range): bool
    {
        return self::getHueRange($hue) === $range;
    }

    public static function getColorHueRange(ColorInterface $color): string
    {
        return self::getHueRange($color->toHsl()->getHue());
    }

    public static function isColorHueRange(ColorInterface $color, string $range): bool
    {
        return self::isHueRange($color->toHsl()->getHue(), $range);
    }

    public static function mix(ColorInterface $color, ColorInterface $mixColor): RgbColorInterface
    {
        if ($color instanceof AlphaColorInterface || $mixColor instanceof AlphaColorInterface) {

            $color = $color->toRgba();
            $mixColor = $mixColor->toRgba();

            return new RgbaColor(
                (int)round(($color->getRed() + $mixColor->getRed()) / 2, 0, PHP_ROUND_HALF_DOWN),
                (int)round(($color->getGreen() + $mixColor->getGreen()) / 2, 0, PHP_ROUND_HALF_DOWN),
                (int)round(($color->getBlue() + $mixColor->getBlue()) / 2, 0, PHP_ROUND_HALF_DOWN),
                (($color instanceof AlphaColorInterface ? $color->getAlpha() : 0)
                    + ($mixColor instanceof AlphaColorInterface ? $mixColor->getAlpha() : 0)) / 2
            );
        }

        $color = $color->toRgb();
        $mixColor = $mixColor->toRgb();
        return new RgbColor(
            (int)round(($color->getRed() + $mixColor->getRed()) / 2, 0, PHP_ROUND_HALF_DOWN),
            (int)round(($color->getGreen() + $mixColor->getGreen()) / 2, 0, PHP_ROUND_HALF_DOWN),
            (int)round(($color->getBlue() + $mixColor->getBlue()) / 2, 0, PHP_ROUND_HALF_DOWN)
        );
    }

    public static function inverse(ColorInterface $color): RgbColorInterface
    {
        if ($color instanceof AlphaColorInterface) {
            $color = $color->toRgba();
            return new RgbaColor(
                255 - $color->getRed(),
                255 - $color->getGreen(),
                255 - $color->getBlue(),
                $color->getAlpha()
            );
        }

        $color = $color->toRgb();
        return new RgbColor(
            255 - $color->getRed(),
            255 - $color->getGreen(),
            255 - $color->getBlue()
        );
    }

    public static function lighten(ColorInterface $color, float $ratio): HslColorInterface
    {
        $hsl = $color instanceof AlphaColorInterface ? $color->toHsla() : $color->toHsl();
        return $hsl->setLightness($hsl->getLightness() + $ratio);
    }

    public static function darken(ColorInterface $color, float $ratio): HslColorInterface
    {
        $hsl = $color instanceof AlphaColorInterface ? $color->toHsla() : $color->toHsl();
        return $hsl->setLightness($hsl->getLightness() - $ratio);
    }

    public static function saturate(ColorInterface $color, float $ratio): HslColorInterface
    {
        $hsl = $color instanceof AlphaColorInterface ? $color->toHsla() : $color->toHsl();
        return $hsl->setSaturation($hsl->getSaturation() + $ratio);
    }

    public static function desaturate(ColorInterface $color, float $ratio): HslColorInterface
    {
        $hsl = $color instanceof AlphaColorInterface ? $color->toHsla() : $color->toHsl();
        return $hsl->setSaturation($hsl->getSaturation() - $ratio);
    }

    public static function greyscale(ColorInterface $color): HslColorInterface
    {
        $hsl = $color instanceof AlphaColorInterface ? $color->toHsla() : $color->toHsl();
        return $hsl->setSaturation(0);
    }

    public static function complement(ColorInterface $color, int $degrees = 180): HslColorInterface
    {
        $hsl = $color instanceof AlphaColorInterface ? $color->toHsla() : $color->toHsl();
        return $hsl->setHue($hsl->getHue() + $degrees);
    }

    public static function fade(ColorInterface $color, float $ratio): AlphaColorInterface
    {
        $alpha = $color->toAlpha();
        return $alpha->setAlpha($alpha->getAlpha() - $ratio);
    }

    //http://www.easyrgb.com/index.php?X=DELT&H=05#text5
    public static function getDifference(ColorInterface $color, ColorInterface $compareColor): float
    {
        $color = $color->toLab();
        $compareColor = $compareColor->toLab();

        $kl = $kc = $kh = 1.0;

        $l1 = $color->getL();
        $a1 = $color->getA();
        $b1 = $color->getB();
        $l2 = $compareColor->getL();
        $a2 = $compareColor->getA();
        $b2 = $compareColor->getB();

        $c1 = sqrt($a1 * $a1 + $b1 * $b1);
        $c2 = sqrt($a2 * $a2 + $b2 * $b2);
        $cx = ($c1 + $c2) / 2;
        $gx = 0.5 * (1 - sqrt(($cx ** 7) / (($cx ** 7) + (25 ** 7))));
        $nn = (1 + $gx) * $a1;
        $c1 = sqrt($nn * $nn + $b1 * $b1);
        $h1 = self::cieLabToHue($nn, $b1);
        $nn = (1 + $gx) * $a2;
        $c2 = sqrt($nn * $nn + $b2 * $b2);
        $h2 = self::cieLabToHue($nn, $b2);
        $dl = $l2 - $l1;
        $dc = $c2 - $c1;

        $dh = 0;
        if (($c1 * $c2) !== 0) {
            $nn = round($h1 - $h2, 12);
            if (abs($nn) <= 180) {
                $dh = $h2 - $h1;
            } else if ($nn > 180) {
                $dh = $h2 - $h1 - 360;
            } else {
                $dh = $h2 - $h1 + 360;
            }
        }

        $dh = 2 * sqrt($c1 * $c2) * sin(deg2rad($dh / 2));
        $lx = ($l1 + $l2) / 2;
        $cy = ($c1 + $c2) / 2;

        $hx = $h1 + $h2;
        if (($c1 * $c2) !== 0) {
            $nn = abs(round($h1 - $h2, 12));
            if ($nn > 180) {
                if (($h2 + $h1) < 360) {
                    $hx = $h1 + $h2 + 360;
                } else {
                    $hx = $h1 + $h2 - 360;
                }
            } else {
                $hx = $h1 + $h2;
            }
            $hx /= 2;
        }

        $tx = 1 - 0.17 * cos(deg2rad($hx - 30)) + 0.24 * cos(deg2rad(2 * $hx)) + 0.32
            * cos(deg2rad(3 * $hx + 6)) - 0.20 * cos(deg2rad(4 * $hx - 63));
        $ph = 30 * exp(-(($hx - 275) / 25) * (($hx - 275) / 25));
        $rc = 2 * sqrt(($cy ** 7) / (($cy ** 7) + (25 ** 7)));
        $sl = 1 + ((0.015 * (($lx - 50) * ($lx - 50))) / sqrt(20 + (($lx - 50) * ($lx - 50))));
        $sc = 1 + 0.045 * $cy;
        $sh = 1 + 0.015 * $cy * $tx;
        $rt = -sin(deg2rad(2 * $ph)) * $rc;
        $dl /= ($kl * $sl);
        $dc /= ($kc * $sc);
        $dh /= ($kh * $sh);
        return sqrt(($dl ** 2) + ($dc ** 2) + ($dh ** 2) + $rt * $dc * $dh);
    }

    /**
     * @param float $a
     * @param float $b
     * @return float
     */
    private static function cieLabToHue(float $a, float $b): float
    {
        $bias = 0;
        if ($a >= 0 && $b === 0) {
            return 0;
        }

        if ($a < 0 && $b === 0) {
            return 180;
        }

        if ($a === 0 && $b >= 0) {
            return 90;
        }

        if ($a === 0 && $b < 0) {
            return 270;
        }

        if ($a > 0 && $b > 0) {
            $bias = 0;
        }

        if ($a < 0) {
            $bias = 180;
        }

        if ($a > 0 && $b < 0) {
            $bias = 360;
        }
        return rad2deg(atan($b / $a)) + $bias;
    }

    public static function equals(ColorInterface $color, ColorInterface $compareColor, ?float $tolerance = 0.0): bool
    {
        $deltaE = self::getDifference($color, $compareColor);
        return $deltaE <= $tolerance;
    }

    public static function toHtml(ColorInterface $color, int $width = 120, int $height = 120): string
    {
        $color = $color->toRgba();
        $inversed = self::inverse($color)->toRgba();
        $name = self::toName($color);
        $hue = $color->toHsl()->getHue();
        return sprintf(
            '<div style="display: inline-block; vertical-align: middle; width: %dpx; height: %dpx; '.
            'background: %s; color: %s; font-size: 12px; font-family: Arial, sans-serif; '.
            'text-align: center; line-height: %dpx;">%s<br>%s<br>%s%s</div>',
            $width,
            $height,
            $color,
            $inversed,
            (int)($height / 4),
            $color->toLab()->toRgb(),
            self::toHexString($color->toRgb()),
            self::getHueRange($hue).'->'.round($hue, 2),
            $name ? "<br>$name" : ''
        );
    }

    public static function validateDivisor(float $divisor): void
    {
        if ($divisor === 0.0) {
            throw new ZeroDivisionException(
                "Failed to divide: You can't divide by zero"
            );
        }
    }

    public static function capValue(float $value, float $min, float $max): float
    {
        return max($min, min($value, $max));
    }

    public static function rotateValue(float $value, float $base): float
    {
        while ($value > $base) {
            $value -= $base;
        }

        while ($value < 0) {
            $value += $base;
        }

        return $value;
    }

    public static function formatValue(float $value, int $decimals = 0): string
    {
        $formatted = number_format($value, $decimals, '.', null);
        return preg_replace(['/\.0+$/', '/(\.[^0]+)0+$/'], ['', '$1'], $formatted);
    }

    private static function convertValueWithUnit(string $value, float $base): float
    {
        //sorted by probable occurence
        $len = mb_strlen($value);
        foreach (self::UNITS as $currentUnit) {
            $unitLen = mb_strlen($currentUnit);
            if ($len < $unitLen || mb_substr($value, -$unitLen) !== $currentUnit) {
                continue;
            }

            $value = mb_substr($value, 0, -$unitLen);
            if (!is_numeric($value)) {
                throw new \InvalidArgumentException(
                    "Tried to convert value $value, but it's not any kind of ".
                    'numeric value and/or using an invalid unit'
                );
            }

            $floatValue = (float)$value;
            switch ($currentUnit) {
                case self::UNIT_RADIANS:
                    $floatValue = round($value * 180 / M_PI, 3, PHP_ROUND_HALF_UP);
                    break;
                case self::UNIT_PERCENT:
                    $floatValue = $base / 100 * $value;
                    break;
                case self::UNIT_PERMILLE:
                    $floatValue = $base / 1000 * $value;
                    break;
                case self::UNIT_DEGREES:
                    //These are just semantic units, they get passed through 1:1
                    break;
            }
            return $floatValue;
        }
        return (float)$value;
    }

    /**
     * @param string $value
     * @param string $type
     * @param float $base
     * @param bool $rotate
     * @return float|int
     */
    private static function convertValue(string $value, string $type, float $base, bool $rotate = false)
    {
        $floatValue = null;
        if (!preg_match('/^[\d.]+$/', $value)) {
            $floatValue = self::convertValueWithUnit($value, $base);
        } else {
            $floatValue = (float)$value;
        }

        if ($rotate) {
            $floatValue = self::rotateValue($floatValue, $base);
        }

        switch ($type) {
            case 'int': return (int)round($floatValue, 0, PHP_ROUND_HALF_UP);
            case 'float': break;
            //This is ignored in coverage, as it's basically just a developer hint. It's driven by constants.
            // @codeCoverageIgnoreStart
            default:
                throw new \InvalidArgumentException(
                    "Passed value type $type is not valid. Use 'float' or 'int'."
                );
            // @codeCoverageIgnoreEnd
        }

        return $floatValue;
    }

    private static function getIntType(int $endian): string
    {
        $type = 'N';
        switch ($endian) {
            case self::ENDIAN_MACHINE:
                $type = 'L';
                break;
            case self::ENDIAN_LITTLE:
                $type = 'V';
        }
        return $type;
    }

    private static function getLongIntType(int $endian): string
    {
        $type = 'J';
        switch ($endian) {
            case self::ENDIAN_MACHINE:
                $type = 'Q';
                break;
            case self::ENDIAN_LITTLE:
                $type = 'P';
        }
        return $type;
    }
}

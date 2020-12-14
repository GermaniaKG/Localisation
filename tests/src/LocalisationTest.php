<?php
namespace tests;

use Germania\Localisation\Localisation;
use Germania\Localisation\LocalisationInterface;

use Prophecy\PhpUnit\ProphecyTrait;


class LocalisationTest extends \PHPUnit\Framework\TestCase
{
    use ProphecyTrait;



    public function testInstantiation()
    {
        $sut = new Localisation("en_GB");

        $this->assertInstanceOf(LocalisationInterface::class, $sut);

        return $sut;
    }


    /**
     * @depends testInstantiation
     * @dataProvider provideVariousLocales
     */
    public function testLocales($locale, $expected_locale, $expected_language, $expected_region, $sut)
    {
        $sut->setLocale( $locale );

        $this->assertInstanceOf(LocalisationInterface::class, $sut);
        $this->assertEquals($sut->__toString(), $expected_locale);
        $this->assertEquals($sut->getLocale(),  $expected_locale);
        $this->assertEquals($sut->getLanguage(), $expected_language);
        $this->assertEquals($sut->getRegion(), $expected_region);

        return $sut;
    }

    public function provideVariousLocales()
    {
        return array(
            [ "en_GB", "en_GB", "en", "GB"],
            [ "de-ch", "de_ch", "de", "CH"],
            [ "fr-FR", "fr_FR", "fr", "FR"],
            [ "dk",    "dk",     "dk", null],
        );
    }
}

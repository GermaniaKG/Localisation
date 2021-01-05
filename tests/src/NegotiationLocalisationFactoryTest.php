<?php
namespace tests;

use Germania\Localisation\NegotiationLocalisationFactory;
use Germania\Localisation\LocalisationFactoryInterface;
use Germania\Localisation\LocalisationInterface;
use Germania\Localisation\FactoryException;
use Germania\Localisation\ExceptionInterface;
use Negotiation\LanguageNegotiator;
use Psr\Http\Message\ServerRequestInterface;

use Prophecy\PhpUnit\ProphecyTrait;


class NegotiationLocalisationFactoryTest extends \PHPUnit\Framework\TestCase
{
    use ProphecyTrait;


    /**
     * @var Negotiation\LanguageNegotiator
     */
    public $negotiator;


    public function setUp() : void
    {
        parent::setUp();
        $this->negotiator = new LanguageNegotiator();
    }

    public function testInstantiation()
    {
        $available = array();
        $sut = new NegotiationLocalisationFactory($this->negotiator, $available);

        $this->assertInstanceOf(LocalisationFactoryInterface::class, $sut);

        return $sut;
    }


    /**
     * @depends testInstantiation
     */
    public function testLocales( $sut )
    {
        $available = array(
          "de" => "de_DE",
          "de-de" => "de_DE",
          "de_DE" => "de_DE"
        );

        $fluent = $sut->setAvailableLocales($available);
        $this->assertInstanceOf(LocalisationFactoryInterface::class, $fluent);

        $language_codes = $sut->getLanguageCodes();
        $this->assertIsArray( $language_codes );
        $this->assertEquals( array_keys($available), $language_codes );

        $locale_strings = $sut->getLocaleStrings();
        $this->assertIsArray( $locale_strings );
        $this->assertEquals( array_values($available), $locale_strings );

        $default_locale = $sut->getDefaultLocale();
        $this->assertEquals( "de_DE", $default_locale );

        return $sut;
    }


    /**
     * @dataProvider provideDefaultLocales
     * @depends testInstantiation
     */
    public function testLocalisationCreation( $available, $set_default, $expected_default, $sut )
    {

        $sut->setAvailableLocales($available);
        $sut->setDefaultLocale($set_default);

        $default_locale = $sut->getDefaultLocale();
        $this->assertEquals( $expected_default, $default_locale );

        $request_mock = $this->prophesize(ServerRequestInterface::class);
        $request_mock->getHeaderLine('Accept-Language')->willReturn(null);
        $request = $request_mock->reveal();

        if (!$default_locale) {
            $this->expectException(ExceptionInterface::class);
            $this->expectException(FactoryException::class);
        }

        $localisation = $sut->createFromRequest( $request );
        $this->assertInstanceOf(LocalisationInterface::class, $localisation);
        $this->assertEquals($localisation->getLocale(), $default_locale);

        return $sut;
    }

    public function provideDefaultLocales()
    {
        $available = array(
          "de" => "de_DE",
          "de-de" => "de_DE",
          "de_DE" => "de_DE"
        );

        return array(
            [ $available,   null,     "de_DE" ],
            [ $available,   "en_US",  "en_US" ],
            [ array(),      null,     null    ],
            [ array(),      "en_GB",  "en_GB" ],
        );
    }



    public function provideHeadersAndExpectedValues()
    {
        return array(
            [ null, "de_DE"]
        );
    }


    /**
     * @depends testInstantiation
     */
    public function testNegotiatorInterceptors( $sut )
    {
        $fluent = $sut->setNegotiator($this->negotiator);

        $this->assertInstanceOf(LocalisationFactoryInterface::class, $fluent);

        return $sut;
    }


}

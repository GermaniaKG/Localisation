<?php
namespace tests;

use Germania\Localisation\NegotiationLocalisationFactory;
use Germania\Localisation\LocalisationFactoryInterface;
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


}

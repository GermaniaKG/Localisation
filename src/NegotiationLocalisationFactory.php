<?php
namespace Germania\Localisation;

use Negotiation\LanguageNegotiator;
use Negotiation\Exception\Exception as NegotiationException;
use Psr\Http\Message\ServerRequestInterface;


/**
 * Setup:
 *
 *     <?php
 *     use NegotiationLocalisationFactory;
 *     use Negotiation\LanguageNegotiator;
 *
 *     // Will Durand's Language negotiator
 *     $negotiator = new LanguageNegotiator();
 *
 *     // Keys:   Language codes
 *     // Values: Locale strings
 *     $availabe_locales = array(
 *         "en"    => "en_GB"
 *         "de"    => "de_DE"
 *         "de-de" => "de_DE"
 *         "de-ch" => "de_CH"
 *         "fr"    => "fr_CH"
 *         "fr-ch" => "fr_CH"
 *     );
 *
 *     // Setup factory
 *     $factory = new NegotiationLocalisationFactory( $negotiator, $availabe_locales );
 *
 *
 * Configuration:
 *
 *     $factory->setAvailableLocales( $locales );
 *     $factory->setNegotiator( $negotiator );
 *
 *
 * Usage:
 *
 *     // Have PSR-7 ServerRequest at hand
 *     $request = ...
 *     $localisation = $factory->createFromRequest( $request );
 *
 *     echo $localisation->getLocale();     // en_GB
 *     echo $localisation->getLanguage();   // en
 *     echo $localisation->getRegion();     // en-GB
 */
class NegotiationLocalisationFactory implements LocalisationFactoryInterface
{

    /**
     * @var string
     */
    protected $php_locale_class;

    /**
     * @var array
     */
    protected $locales;

    /**
     * @var \Negotiation\LanguageNegotiator
     */
    protected $negotiator;



    /**
     * @param LanguageNegotiator $negotiator        Will Durand's LanguageNegotiator
     * @param array              $locales           Available locales with keys as language codes and Locale string values
     * @param string             $php_locale_class  Optional: Custom Localisation class, default is `\Germania\Localisation\Localisation`
     */
    public function __construct( LanguageNegotiator $negotiator, array $available_locales, string $php_locale_class = null )
    {
        $this->setNegotiator( $negotiator );
        $this->setAvailableLocales( $available_locales );
        $this->php_locale_class = $php_locale_class ?: Localisation::class;
    }


    /**
     * @inheritDoc
     */
    public function createFromRequest( ServerRequestInterface $request ) : LocalisationInterface
    {
        $acceptLangageHeader = $request->getHeaderLine('Accept-Language');
        $priorities = $this->getLanguageCodes();
        $locale_strings = $this->getLocaleStrings();

        try {
            $bestLanguage = $this->negotiator->getBest($acceptLangageHeader, $priorities);
            if ($bestLanguage) {
                $type = $bestLanguage->getType();
                $locale = $this->available_locales[$type] ?? null;
            }
            else {
                $locale = $locale_strings[0];
            }
        }
        catch (NegotiationException $e) {
            $locale = $locale_strings[0];
        }

        if (empty($locale)) {
            $msg = sprintf("Locale not found for key '%s'", $type);
            throw new \RuntimeException($msg);
        }

        $localisation = new $this->php_locale_class($locale);

        return $localisation;
    }



    /**
     * @param array $available_locales Available locales
     */
    public function setAvailableLocales( array $available_locales ) : self
    {
        $this->available_locales = $available_locales;
        return $this;
    }


    /**
     * @param LanguageNegotiator $negotiator Will Durand's LanguageNegotiator
     */
    public function setNegotiator( LanguageNegotiator $negotiator ) : self
    {
        $this->negotiator = $negotiator;
        return $this;
    }


    /**
     * Returns the available locales.
     *
     * @return array
     */
    public function getLanguageCodes() : array
    {
        return array_keys($this->available_locales);
    }

    /**
     * Returns the available locale strings.
     *
     * @return array
     */
    public function getLocaleStrings() : array
    {
        return array_values($this->available_locales);
    }



}

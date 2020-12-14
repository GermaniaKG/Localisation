<?php
namespace Germania\Localisation;

interface LocalisationInterface
{

    /**
     * Returns a fully-qualified Locale string such as `en_GB`.
     *
     * @return string
     */
    public function __toString();


    /**
     * Sets the fully-qualified Locale string such as `en_GB`.
     *
     * @param string $locale Locale string, e.g. `en_GB`
     */
    public function setLocale( string $locale ) : LocalisationInterface;


    /**
     * Returns a fully-qualified Locale string such as `en_GB`.
     *
     * @return string
     */
    public function getLocale() : string;


    /**
     * Returns ISO 639-1 language code such as `en`.
     *
     * @return string
     */
    public function getLanguage() : string;


    /**
     * Returns an ISO 3166-1 alpha-2 country/region code such as `GB`, if possible.
     *
     * @return null|string
     */
    public function getRegion() : ?string;


}

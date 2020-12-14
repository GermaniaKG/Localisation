<?php
namespace Germania\Localisation;


class Localisation implements LocalisationInterface
{

    /**
     * @var string
     */
    protected $locale;



    /**
     * @param string $locale Locale string, such as `en_GB`
     */
    public function __construct( string $locale )
    {
        $this->setLocale( $locale );
    }


    /**
     * @inheritDoc
     */
    public function setLocale( string $locale ) : LocalisationInterface
    {
        $this->locale = str_replace("-", "_", $locale);
        return $this;
    }


    /**
     * @inheritDoc
     */
    public function getLocale( ) : string
    {
        return $this->locale;
    }



    /**
     * @inheritDoc
     */
    public function __toString() {
        return $this->getLocale();
    }


    /**
     * @inheritDoc
     */
    public function getLanguage() : string
    {
        return $this->getLocaleArray()[0];
    }


    /**
     * @inheritDoc
     */
    public function getRegion() : ?string
    {
        $locale = $this->getLocaleArray();
        $region = $locale[1] ?? null;

        return $region ? strtoupper($region) : null;
    }




    protected function getLocaleArray() : array
    {
        $locale = $this->getLocale();
        return explode("_", $locale);
    }


}

<img src="https://static.germania-kg.com/logos/ga-logo-2016-web.svgz" width="250px">

------



# Germania KG · Localisation



## Installation

```bash
$ composer require germania-kg/localisation
```





---



## Interfaces

### LocalisationInterface

```php
<?php
namespace Germania\Localisation;

interface LocalisationInterface 
{
    // Sets the fully-qualified Locale string such as `en_GB`.
    public function setLocale( string $locale ) : LocalisationInterface;

    // Returns a fully-qualified Locale string such as `en_GB`.
    public function __toString();

    // Returns a fully-qualified Locale string such as `en_GB`.
    public function getLocale() : string;

    // Returns ISO 639-1 language code such as `en`.
    public function getLanguage() : string;

  	// Returns an ISO 3166-1 alpha-2 country/region code such as `GB`, if possible.
    public function getRegion() : ?string;
}

```



### LocalisationFactoryInterface

```php
<?php
namespace Germania\Localisation;

use Germania\Localisation\LocalisationInterface as Localisation;
use Psr\Http\Message\ServerRequestInterface as Request;

interface LocalisationFactoryInterface
{
    public function createFromRequest( Request $request ) : Localisation;
}

```



## Factories

### NegotiationLocalisationFactory

The constructor requires an instance of Will Durand´s [LanguageNegotiator](https://github.com/willdurand/Negotiation) and an array with available locale strings.

```php
<?php
use Germania\Localisation\NegotiationLocalisationFactory;
use Negotiation\LanguageNegotiator;
use Psr\Http\Message\ServerRequestInterface;

$negotiator = new LanguageNegotiator;

$available = array(
	"de" => "de_DE",
  "de-de" => "de_DE",
  "de_DE" => "de_DE"
);
$factory = new NegotiationLocalisationFactory( $negotiator, $available);

// Have PSR-7 ServerReuqest at hand
$localisation = $factory->createFromRequest( $server_request );
```





------



## Development

```bash
$ git clone git@github.com:GermaniaKG/Localisation.git
$ cd Localisation
$ composer install
```


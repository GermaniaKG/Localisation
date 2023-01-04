<img src="https://static.germania-kg.com/logos/ga-logo-2016-web.svgz" width="250px">

------



# Germania KG · Localisation



[![Packagist](https://img.shields.io/packagist/v/germania-kg/localisation.svg?style=flat)](https://packagist.org/packages/germania-kg/localisation)
[![PHP version](https://img.shields.io/packagist/php-v/germania-kg/localisation.svg)](https://packagist.org/packages/germania-kg/localisation)
[![Tests](https://github.com/GermaniaKG/Localisation/actions/workflows/tests.yml/badge.svg)](https://github.com/GermaniaKG/Localisation/actions/workflows/tests.yml)

## Installation

```bash
$ composer require germania-kg/localisation
```



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
    /**
     * @param  ServerRequestInterface $request PSR-7 Server Request
     * @return \Germania\Localisation\LocalisationInterface
     * @throws \Germania\Localisation\FactoryException
     */  
    public function createFromRequest( Request $request ) : Localisation;
}

```



## Factories

### NegotiationLocalisationFactory

Class *NegotiationLocalisationFactory* implements **LocalisationFactoryInterface**. The constructor requires an instance of Will Durand´s [**LanguageNegotiator**](https://github.com/willdurand/Negotiation) and an array with available *language codes* and *locale strings*.

#### Setup

```php
<?php
use Germania\Localisation\NegotiationLocalisationFactory;
use Negotiation\LanguageNegotiator;

$negotiator = new LanguageNegotiator;
$available = array(
	"de" => "de_DE",
  "de-de" => "de_DE",
  "de_DE" => "de_DE"
);

$factory = new NegotiationLocalisationFactory( $negotiator, $available);

// Optional, as factory would use the first available locale from above, 
// e.g. "de_DE"
$factory->setDefaultLocale("en_US");
```

#### Usage

```php
<?php
use Germania\Localisation\ExceptionInterface;  
use Psr\Http\Message\ServerRequestInterface;

try {
  $server_request = ...; //
	$localisation = $factory->createFromRequest( $server_request );  
}
catch (\Germania\Localisation\ExceptionInterface $e) {
  echo get_class($e);
  // Germania\Localisation\FactoryException  
}
```





------



## Development

```bash
$ git clone git@github.com:GermaniaKG/Localisation.git
$ cd Localisation
$ composer install
```


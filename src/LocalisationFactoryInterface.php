<?php
namespace Germania\Localisation;

use Psr\Http\Message\ServerRequestInterface;

interface LocalisationFactoryInterface
{

    /**
     * @param  ServerRequestInterface $request PSR-7 Server Request
     *
     * @return \Germania\Localisation\LocalisationInterface
     *
     * @throws \Germania\Localisation\FactoryException
     */
    public function createFromRequest( ServerRequestInterface $request ) : LocalisationInterface;

}

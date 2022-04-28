<?php

namespace App\Entity;

use App\Model\Interfaces\Interfaces\CanContainCharacters;
use App\Model\Interfaces\Interfaces\Key;

class SpecialCharactersKey extends Key implements CanContainCharacters
{
    private $symbols;

    public function __construct(string $keyIdentifier,$symbols)
    {
        parent::__construct($keyIdentifier);
        $this->symbols=$symbols;
    }

    /**
     * @return mixed
     */
    public function getSymbols()
    {
        return $this->symbols;
    }

    /**
     * @param mixed $symbols
     */
    public function setSymbols($symbols): void
    {
        $this->symbols = $symbols;
    }

    public function contains(string $char):bool{
        return in_array($char,$this->getSymbols());
    }
}
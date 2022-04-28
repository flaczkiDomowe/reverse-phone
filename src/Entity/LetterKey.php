<?php

namespace App\Entity;

use App\Model\Interfaces\Interfaces\CanContainCharacters;

use App\Model\Key;
use Symfony\Component\String\Exception\InvalidArgumentException;

class LetterKey extends Key implements CanContainCharacters
{
    private $letters;

    public function __construct(string $keyIdentifier, array $letters)
    {
        parent::__construct($keyIdentifier);
       $this->setLetters($letters);
    }

    /**
     * @return array
     */
    public function getLetters(): array
    {
        return $this->letters;
    }

    /**
     * @param array $letters
     */
    public function setLetters(array $letters): void
    {
        foreach($letters as $symbol) {
            //validation
            if(!ctype_alpha($symbol))
            {
                throw new InvalidArgumentException("Standard phone key accept only alphabet letters");
            }
        }
        $this->letters=$letters;
    }

    public function setUpperCase(){
        foreach ($this->letters as &$letter){
            $letter=strtoupper($letter);
        }
    }

    public function setLowerCase(){
        foreach ($this->letters as &$letter){
            $letter=strtolower($letter);
        }
    }

    public function contains(string $char):bool{
        return in_array($char,$this->getLetters());
    }
}
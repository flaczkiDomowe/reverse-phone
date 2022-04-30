<?php

namespace App\Entity;






use App\Model\Interfaces\CanManipulateKeys;
use App\Model\InverseKeyboard;
use App\Model\Key;
use App\Model\StandardKeyboard;
use Exception;

class RulingKey extends Key implements CanManipulateKeys
{
    private $functions;
    public function __construct(string $keyIdentifier,$functions)
    {
        parent::__construct($keyIdentifier);
        $this->functions=$functions;
    }

    public function press($char,$program){
        switch($program) {
            case InverseKeyboard::class:
                $this->manipulateKeys();
                return $this->getKeyIdentifier();
                break;
            case StandardKeyboard::class:
                $this->manipulateKeys();
                break;
            default:
                throw new Exception ("Nieznany program $program");
        }
    }

    public function manipulateKeys(){
        foreach($this->functions as $function){
            $function();
        }
    }

}
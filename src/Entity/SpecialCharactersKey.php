<?php

namespace App\Entity;




use App\Model\Interfaces\CanContainCharacters;
use App\Model\InverseKeyboard;
use App\Model\Key;
use App\Model\StandardKeyboard;
use Exception;
use InvalidArgumentException;

class SpecialCharactersKey extends Key implements CanContainCharacters
{
    private $symbols;
    private $actualSymbolIterator;

    public function __construct(string $keyIdentifier,$symbols)
    {
        parent::__construct($keyIdentifier);
        $this->symbols=$symbols;
        $this->actualSymbolIterator=Key::KEY_ARRAY_OFFSET;
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

    private function getCode($char){
        $code="";
        $key=array_search($char,$this->symbols);
        if($key===false){
            throw new InvalidArgumentException("$char nie istnieje w przycisku");
        }
        for($i=-1;$i<$key;$i++){
            $code.=$this->getKeyIdentifier();
        };
        return $code;
    }

    public function press($arg,$program)
    {
        switch($program){
            case InverseKeyboard::class:
                return $this->getCode($arg);
                break;
            case StandardKeyboard::class:
                return $this->getSpecialCharacter();
                break;
            default:
                throw new Exception ("Nieznany program $program");
        }
    }
    public function resetIterator(){
        $this->actualSymbolIterator=Key::KEY_ARRAY_OFFSET;
    }
    private function getSpecialCharacter(){
        $this->actualSymbolIterator=++$this->actualSymbolIterator%sizeof($this->symbols);
        return $this->symbols[$this->actualSymbolIterator];
    }

}
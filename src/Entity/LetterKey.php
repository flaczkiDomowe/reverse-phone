<?php

namespace App\Entity;



use App\Model\Interfaces\CanContainCharacters;
use App\Model\InverseKeyboard;
use App\Model\Key;
use App\Model\Phone;
use App\Model\StandardKeyboard;
use Exception;
use Symfony\Component\String\Exception\InvalidArgumentException;

class LetterKey extends Key implements CanContainCharacters
{
    private $letters;
    private $caseState=Phone::UCASE;
    private $actualLetterIterator;

    public function __construct(string $keyIdentifier, array $letters)
    {
        parent::__construct($keyIdentifier);
       $this->setLetters($letters);
       $this->actualLetterIterator=Key::KEY_ARRAY_OFFSET;
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

    public function getCaseState(){
        return $this->caseState;
    }

    public function checkIfLetterIsTheSameCaseState(string $letter):bool{
        if(ctype_upper($letter)){
            return $this->caseState===Phone::UCASE;
        } else {
            return $this->caseState===Phone::LCASE;
        }
    }

    public function setUpperCase(){
        foreach ($this->letters as &$letter){
            $letter=strtoupper($letter);
        }
        $this->caseState=Phone::UCASE;
    }

    public function setLowerCase(){
        foreach ($this->letters as &$letter){
            $letter=strtolower($letter);
        }
        $this->caseState=Phone::LCASE;
    }

    public function contains(string $char):bool{
        if(ctype_alpha($char)) {
            return in_array(strtoupper($char), $this->getLetters())||in_array(strtolower($char),$this->getLetters());
        }
        return false;
    }

    private function getCode($char){
        $code="";
        $key=array_search($char,$this->letters);
        if($key===false){
            throw new InvalidArgumentException("$char nie istnieje w przycisku");
        }
        for($i=-1;$i<$key;$i++){
            $code.=$this->getKeyIdentifier();
        };
        return $code;}

    public function resetIterator(){
        $this->actualLetterIterator=Key::KEY_ARRAY_OFFSET;
    }

    private function getLetter(){
        $this->actualLetterIterator=++$this->actualLetterIterator%sizeof($this->letters);
        return $this->letters[$this->actualLetterIterator];
    }

    public function press($arg,$program)
    {
        switch($program){
            case InverseKeyboard::class:
                return $this->getCode($arg);
            break;
            case StandardKeyboard::class:
                return $this->getLetter();
                break;
            default:
                throw new Exception ("Nieznany program $program");
        }
    }
}
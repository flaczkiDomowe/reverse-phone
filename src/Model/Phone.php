<?php

namespace App\Model;



use App\Entity\LetterKey;
use App\Entity\RulingKey;
use App\Entity\SpecialCharactersKey;

class Phone extends Device
{
    /**
     * @var array
     */
    private $phoneLetterKeys;
    /**
     * @var array
     */
    private $phoneSpecialCharKeys;
    /**
     * @var array
     */
    private $rulingKeys;

    public function __construct(){
        $this->phoneLetterKeys[]=new LetterKey('2',['A','B','C']);
        $this->phoneLetterKeys[]=new LetterKey('3',['D','E','F']);
        $this->phoneLetterKeys[]=new LetterKey('4',['G','H','I']);
        $this->phoneLetterKeys[]=new LetterKey('5',['J','K','L']);
        $this->phoneLetterKeys[]=new LetterKey('6',['M','N','O']);
        $this->phoneLetterKeys[]=new LetterKey('7',['P','Q','R','S']);
        $this->phoneLetterKeys[]=new LetterKey('8',['T','U','V']);
        $this->phoneLetterKeys[]=new LetterKey('9',['W','X','Y','Z']);
        $this->phoneSpecialCharKeys[]=new SpecialCharactersKey('*',['.',',','!','?']);
        $this->phoneSpecialCharKeys[]=new SpecialCharactersKey('0',[' ']);
        $this->rulingKeys[]=new RulingKey('#',[function (array $keys,$toUpper=true){
        if($toUpper){
            $function="setUpperCase";
        }else{
            $function="setLowerCase";
        }
        foreach($keys as $letterKey){
            $letterKey->$function();
        }
        }]);
    }

    /**
     * @return array
     */
    public function getPhoneLetterKeys(): array
    {
        return $this->phoneLetterKeys;
    }

    /**
     * @return array
     */
    public function getPhoneSpecialCharKeys(): array
    {
        return $this->phoneSpecialCharKeys;
    }

    /**
     * @return array
     */
    public function getRulingKey(): array
    {
        return $this->rulingKeys;
    }

    /**
     * @param array $rulingKey
     */
    public function setRulingKey(array $rulingKey): void
    {
        $this->rulingKeys = $rulingKey;
    }

}
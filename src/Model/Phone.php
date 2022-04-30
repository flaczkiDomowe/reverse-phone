<?php

namespace App\Model;



use App\Entity\LetterKey;
use App\Entity\RulingKey;
use App\Entity\SpecialCharactersKey;

class Phone
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

    /**
     * @var array
     */
    private $keys;

    private $caseState=self::UCASE;
    public const LCASE=0;
    public const UCASE=1;

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
        $letterKeys=&$this->phoneLetterKeys;
        $caseState=&$this->caseState;
        $this->rulingKeys['caseChange']=new RulingKey('#',[function () use (&$letterKeys,&$caseState){
            /** @var LetterKey $letterKey */
            foreach($letterKeys as $letterKey){
            if($caseState===self::UCASE){
            $letterKey->setLowerCase();
            } else {
            $letterKey->setUpperCase();
            }
            $caseState=($caseState===self::UCASE)?self::UCASE:self::LCASE;
            }

        }
        ]
        );
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
    public function getRulingKeys(): array
    {
        return $this->rulingKeys;
    }

    /**
     * @param array $rulingKey
     */
    public function setRulingKeys(array $rulingKey): void
    {
        $this->rulingKeys = $rulingKey;
    }

    public function getKeysWhichContainsChars():array{
        return array_merge($this->getPhoneLetterKeys(),$this->getPhoneSpecialCharKeys());
    }

    public function getKeys():array{
        $arr= array_merge($this->getPhoneSpecialCharKeys(),$this->getPhoneLetterKeys(),$this->getRulingKeys());
        /** @var Key $key */
        foreach($arr as $value) {
            $arr[$value->getKeyIdentifier()] = $value;
        }
        return $arr;
    }

    public function setLowerCase(){
        $this->caseState=self::LCASE;
        /** @var LetterKey $letter */
        foreach ($this->phoneLetterKeys as $letter){
            $letter->setLowerCase();
        }
    }

    public function setUpperCase(){
        $this->caseState=self::UCASE;
        /** @var LetterKey $letter */
        foreach ($this->phoneLetterKeys as $letter){
            $letter->setUpperCase();
        }
    }

}
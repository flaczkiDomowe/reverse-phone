<?php

namespace App\Model;

use App\Entity\LetterKey;
use App\Entity\RulingKey;

use App\Model\Interfaces\CanContainCharacters;
use InvalidArgumentException;

class InverseKeyboard extends Program
{
    private $phone;
    private $inputSentence;
    private $outputCode;


    public function __construct(Phone $phone)
    {
        $this->phone = $phone;
    }

    public function execute()
    {

    }

    public function makeCodeFromString(string $string)
    {
        $charArray = str_split($string);
        $iter = 0;
        foreach ($charArray as $key => $char) {
            if ($iter == 0) {
                $this->phone->setUpperCase();
                $this->outputCode = $this->getCode($char);
            } else if($iter==1) {
                $this->concatCharCode($this->getCode($char));
            } else {
                $keyBefore=--$key;
                $keyBeforeBefore=--$keyBefore;
                if($charArray[$keyBefore]==' '&&$charArray[$keyBeforeBefore]==='.'){
                    $this->phone->setUpperCase();
                }
                $this->concatCharCode($this->getCode($char));
            }
            $iter++;
            $this->phone->setLowerCase();
        }
        return $this->outputCode;
    }

    private function getCode(string $char)
    {
        $code = "";
        $key = $this->findKey($char);
        if ($key instanceof LetterKey) {
            if ($key->checkIfLetterIsTheSameCaseState($char)) {
                $code = $key->press($char,self::class);
            } else {
                /** @var RulingKey $rulingKey */
                $rulingKey = $this->phone->getRulingKeys()['caseChange'];
                var_dump($key);
                $code = $rulingKey->press($char,self::class);
                var_dump($key);
                $code.=$key->press($char,self::class);
            }
        } else {
            $code = $key->press($char,self::class);
        }
        return $code;
    }


    private function concatCharCode($code)
    {
        $this->outputCode .= " " . $code;
    }

    private function findKey(string $char): CanContainCharacters
    {
        foreach ($this->phone->getKeysWhichContainsChars() as $key) {
            if ($key->contains($char)) {
                return $key;
            }
        }
        throw new InvalidArgumentException("Wprowadzone wyrażenie posiada niedozwolony znak: $char", 123);
    }
}
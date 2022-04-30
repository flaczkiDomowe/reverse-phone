<?php

namespace App\Model;

use App\Model\Interfaces\CanContainCharacters;

class StandardKeyboard extends Program
{
    private $phone;
    private $inputCode;
    private $outputSentence;
    private $phoneKeys;


    public function execute()
    {
        // TODO: Implement execute() method.
    }

    public function __construct(Phone $phone)
    {
        $this->phone=$phone;
        $this->phoneKeys=$phone->getKeys();
    }

    public function makeSentenceFromCode(string $code)
    {
        if(empty($code)){
            return;
        }
        $codeArr = explode(" ",$code);
        $iter=0;
        foreach ($codeArr as $key => $code) {
                if ($iter == 0) {
                    $this->phone->setUpperCase();
                    $this->outputSentence = $this->decode($code);
                } else if($iter==1) {
                    $this->concatOutput($this->decode($code));
                } else {
                    $keyBefore=--$key;
                    $keyBeforeBefore=--$keyBefore;
                    if($this->outputSentence[$keyBefore]==' '&&$this->outputSentence[$keyBeforeBefore]==='.'){
                        $this->phone->setUpperCase();
                    }
                    $this->concatOutput($this->decode($code));
                }
                $iter++;
                $this->phone->setLowerCase();
            }
        return $this->outputSentence;
    }

    private function decode(string $code)
    {
        $chars=str_split($code);
        $outputSymbol="";
        foreach($chars as $char){
            /** @var Key $key */
            $key=$this->phoneKeys[$char];
            $outputSymbol=$key->press($char,self::class);
        }
        if($key instanceof CanContainCharacters){
            $key->resetIterator();
        }
        return $outputSymbol;
    }

    private function concatOutput($getCode)
    {
        $this->outputSentence.=$getCode;
    }

}
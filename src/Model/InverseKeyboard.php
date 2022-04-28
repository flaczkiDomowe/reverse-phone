<?php

namespace App\Model;

class InverseKeyboard extends Program
{
    private $phone;
    public function __construct(Phone $phone)
    {
        $this->phone=$phone;
    }

    public function execute()
    {
    }

    public function makeCodeFromString(string $string){

    }
    private function findKey(string $key){
        if(ctype_alpha($key)){
            foreach($this->phone->getPhoneLetterKeys() as $key){
                if()
            }
        }
    }



}
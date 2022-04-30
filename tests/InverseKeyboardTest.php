<?php

namespace App\Tests;

use App\Model\InverseKeyboard;
use App\Model\Phone;
use PHPUnit\Framework\TestCase;


class InverseKeyboardTest extends TestCase
{
    private $expectedResults=[
        "Bury Kot."=>"22 88 777 999 0 #55 666 8 *",
        "Ala ma kota."=>"2 555 2 0 6 2 0 55 666 8 2 *",
        "Pragmatyczny Programista!"=>"7 777 2 4 6 2 8 999 222 9999 66 999 0 #7 777 666 4 777 2 6 444 7777 8 2 ***",
        "Trans.eu Road Transport Platform"=>"8 777 2 66 7777 * 33 88 0 #777 666 2 3 0 #8 777 2 66 7777 7 666 777 8 0 #7 555 2 8 333 666 777 6"
    ];

    public function testMakeCodeFromString()
    {   $phone=new Phone();
        $keyboard=new InverseKeyboard($phone);
        foreach($this->expectedResults as $key=>$val){
            self::assertEquals($keyboard->makeCodeFromString($key),$val);
        }
    }
}

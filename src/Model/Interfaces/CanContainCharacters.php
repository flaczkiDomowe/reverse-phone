<?php

namespace App\Model\Interfaces\Interfaces;

interface CanContainCharacters
{
    public function contains(string $str):bool;

}
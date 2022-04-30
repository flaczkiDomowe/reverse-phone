<?php

namespace App\Model\Interfaces;

interface CanContainCharacters
{
    public function contains(string $str):bool;
    public function resetIterator();

}
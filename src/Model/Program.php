<?php

namespace App\Model;



use App\Model\Interfaces\Executable;

abstract class Program implements Executable
{

    abstract public function execute();
}
<?php

namespace App\Model\Interfaces;

use App\Model\Program;

interface Pressable
{
    public function press($arg,string $program);
}
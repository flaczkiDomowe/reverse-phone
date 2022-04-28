<?php

namespace App\Model;

class PhoneSystem extends System
{
    public function __construct(Phone $device, array $programs)
    {
        parent::__construct($device, $programs);

    }
}
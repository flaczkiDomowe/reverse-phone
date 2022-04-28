<?php

namespace App\Entity;

use App\Model\Interfaces\Interfaces\Key;

class RulingKey extends Key implements CanManipulateKeys
{
    public function __construct(string $keyIdentifier,$functions)
    {
        parent::__construct($keyIdentifier);
        $this->functions=$functions;
    }
}
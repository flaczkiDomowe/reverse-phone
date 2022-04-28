<?php

namespace App\Model;

abstract class Key
{
    private $keyIdentifier;
    public function __construct(string $keyIdentifier)
    {
        $this->keyIdentifier=$keyIdentifier;
    }

    /**
     * @return string
     */
    public function getKeyIdentifier(): string
    {
        return $this->keyIdentifier;
    }

    /**
     * @param string $keyIdentifier
     */
    public function setKeyIdentifier(string $keyIdentifier): void
    {
        $this->keyIdentifier = $keyIdentifier;
    }


}
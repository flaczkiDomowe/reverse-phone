<?php

namespace App\Model;

use App\Model\Interfaces\Pressable;

abstract class Key implements Pressable
{
    public const KEY_ARRAY_OFFSET=-1;
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
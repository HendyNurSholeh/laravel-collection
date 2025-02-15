<?php

namespace App\Data;

class Person
{
    private string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }
}
<?php

namespace App\DataValueObjects;

abstract class DataValueObject
{
    public function toArray(): array
    {
        return json_decode(json_encode($this), true);
    }
}

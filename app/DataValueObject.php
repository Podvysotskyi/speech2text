<?php

namespace App;

abstract readonly class DataValueObject
{
    public function toArray(): array
    {
        return json_decode(json_encode($this), true);
    }
}

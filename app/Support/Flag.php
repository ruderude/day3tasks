<?php

namespace App\Support;

class Flag
{
    public const on = 1;
    public const off = 0;

    public static function is($data): bool
    {
        return $data === "on" || $data === true || $data === "true" || $data === 1 || $data === "1";
    }
}

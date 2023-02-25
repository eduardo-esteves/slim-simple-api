<?php

namespace App\helpers;

class Helper
{
    public static function jsonToObject(string $json)
    {
        $contents = json_decode($json);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception('Parametros informado estão incorreto');
        }
        return $contents;
    }
}

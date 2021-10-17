<?php

namespace App\Helper;

class UtilsHelper
{
    public function generateNumber(int $qtde): string
    {
        $n = "";
        for($i = 0; $i < $qtde; $i++) {
            $n .= (string)mt_rand(0,9);
        }
        return $n;
    }
}
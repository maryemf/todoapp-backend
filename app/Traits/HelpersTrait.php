<?php

namespace App\Traits;

trait HelpersTrait
{
    public function filterInputFields($fields, $input){
        return array_filter($input, function ($v, $k) use ($fields) {
            return in_array($k, $fields);
        }, ARRAY_FILTER_USE_BOTH);
    }
}

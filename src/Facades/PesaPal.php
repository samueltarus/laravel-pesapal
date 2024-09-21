<?php

namespace samueltarus\LaravelPesaPal\Facades;

use Illuminate\Support\Facades\Facade;

class PesaPal extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'pesapal';
    }
}
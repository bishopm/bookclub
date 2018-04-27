<?php namespace Bishopm\Bookclub\Models\Facades;

use Illuminate\Support\Facades\Facade;

class Setting extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'setting';
    }
}

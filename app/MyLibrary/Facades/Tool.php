<?php

namespace App\MyLibrary\Facades;

use App\MyLibrary\ToolFactory;
use Illuminate\Support\Facades\Facade;

class Tool extends Facade
{
    protected static function getFacadeAccessor()
    {
        return ToolFactory::class;
    }
}

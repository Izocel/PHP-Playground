<?php

namespace App;

use App\EzmaxPlayground\EzmaxPlayground;
use App\ImagickPlaygroud\ImagickPlaygroud;

class App
{
    public function __construct()
    {
        new ImagickPlaygroud;
    }
}

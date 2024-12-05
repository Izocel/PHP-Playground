<?php

namespace App;

use App\EzmaxPlayground\EzmaxPlayground;
use App\ImagickPlayground\ImagickPlayground;
use App\CSVPlayground\CSVPlayground;

class App
{
    public function __construct()
    {
        new CSVPlayground;
    }
}

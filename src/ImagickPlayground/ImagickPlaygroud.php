<?php

namespace App\ImagickPlaygroud;

class ImagickPlaygroud
{
    public function __construct()
    {
        $imageHelper = new ImagickHelper(__DIR__ . "../../assets/TestCoupons/1a2d.jpg");
        $imageHelper->convertTo('png');
        echo $imageHelper->autoRotateImage();
        echo $imageHelper->display();
    }
}

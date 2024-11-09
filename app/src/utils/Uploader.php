<?php

namespace Softexpert\Mercado\utils;

use CoffeeCode\Uploader\Image;
use Exception;

class Uploader
{
    public function image($file, $name)
    {
        try {
            $up = new Image("files", "images");
            $up = $up->upload($file, $name);
 
            return $up;
        } catch (Exception $e) {
            echo $e->getMessage();
            return false;
        }
    }
}
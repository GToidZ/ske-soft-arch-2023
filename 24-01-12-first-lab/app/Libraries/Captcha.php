<?php
namespace App\Libraries;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;

class Captcha {
    public function make() {
        $string = Str::random(6);
        Session::put('answer', $string);

        $width = 100;
        $height = 25;
        $image = imagecreatetruecolor($width, $height);
        $fg = imagecolorallocate($image, 254, 0, 0);
        $bg = imagecolorallocate($image, 255, 255, 255);

        imagefilledrectangle($image, 0, 0, $width, $height, $bg);
        imagestring($image, 5, 16, 4, $string, $fg);

        ob_start();
        imagejpeg($image);
        $jpg = ob_get_clean();
        return "data:image/jpeg;base64," . base64_encode($jpg);
    }
}
?>
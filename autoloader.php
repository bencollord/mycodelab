<?php

class Autoloader {
    public static function load ($class){
        $filename = strtolower($class) . '.class.php';
        $file = 'classes/' . $filename;
        if (!file_exists($file)) {
            return false;
        }
        else {
            include $file;
        }
    }
}

?>
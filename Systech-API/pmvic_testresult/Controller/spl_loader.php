<?php 
    //include "../../Model/DbModel.php";

    spl_autoload_register('autoLoader');

    function autoLoader($className) {
        $path = "../../Model/";
        $extension = ".php";
        $filename = $path . $className . $extension;

        if (!file_exists($filename)
        ) {
            return false;
        }

        include($path . $className . $extension);
    }
?>
<?php

spl_autoload_register
(
    function( $class_name )
    {
        $class_path = str_replace( "\\", DIRECTORY_SEPARATOR, $class_name );
        include_once $class_path . '.php';
    }
);
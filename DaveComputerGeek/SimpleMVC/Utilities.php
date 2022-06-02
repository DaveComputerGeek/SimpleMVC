<?php

namespace DaveComputerGeek\SimpleMVC;

class Utilities
{
    /**
     * Forces provided string by reference to have a leading forward slash.
     * 
     * @param String $string The string to force a leading forward slash on.
     * @return null Nothing returned.
     */
    public static function forceLeadingSlash( String &$string )
    {
        if( substr( $string, 0, 1 ) != "/" )
            $string = "/" . $string;
    }
}
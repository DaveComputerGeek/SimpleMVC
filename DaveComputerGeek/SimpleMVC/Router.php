<?php

namespace DaveComputerGeek\SimpleMVC;

use DaveComputerGeek\SimpleMVC\Utilities;

class Router
{
    private $methods = array( "GET", "POST", "404" );
    private $maps = array();

    /**
     * Creates a map with route information to a part of the application.
     * 
     * @param String $path The path. (e.g. /something)
     * @param callable $callback The callable callback code.
     * @param String $method (Optional) The request method. (Defaults to GET, POST also supported)
     * @param String $host (Optional) The hostname/domain. (Defaults to empty)
     * @return null Nothing returned.
     */
    public function map( String $path, callable $callback, String $method = "GET", String $host = "" )
    {
        $this->housekeeping( $path, $method );

        $this->maps[] = array
        (
            "path" => $path,
            "callback" => $callback,
            "method" => $method,
            "host" => $host,
        );
    }

    /**
     * Creates a map as a fallback for requests without a defined map.
     * 
     * @param callable $callback The callable callback code.
     * @return null Nothing returned.
     */
    public function _404( callable $callback )
    {
        $this->map( "", $callback, "404" );
    }

    /**
     * Resolves given info to a map previously created with Router->map() based on provided info.
     * 
     * @param String $path The path. (e.g. /something)
     * @param String $method (Optional) The request method. (Defaults to GET, POST also supported)
     * @param String $host (Optional) The hostname/domain. (Defaults to empty)
     * @return array|null Array containing resolved map info (if resolved), otherwise null.
     */
    public function resolve( String $path, String $method = "GET", String $host = "" )
    {
        $this->housekeeping( $path, $method );

        foreach( $this->maps as $map )
        {
            if( $map['path'] != $path || $map['method'] != $method || $map['host'] != $host )
                continue;
            return $map;
        }
    }

    /**
     * Resolves and executes the callback for a map previously created with Router->map() based on provided info.
     * 
     * Outputs "Route Not Found" upon resolution failure.
     * 
     * @param String $path The path. (e.g. /something)
     * @param String $method (Optional) The request method. (Defaults to GET, POST also supported)
     * @param String $host (Optional) The hostname/domain. (Defaults to empty)
     * @return null Nothing returned.
     */
    public function route( String $path, String $method = "GET", String $host = "" )
    {
        $this->housekeeping( $path, $method );

        $resolved_route = $this->resolve( $path, $method, $host );

        if( ! $resolved_route )
        {
            $route404 = $this->resolve( '', '404' );

            header( "HTTP/1.0 404 Not Found" );
            
            if( ! $route404 )
                return;
            
            $resolved_route = $route404;
        }

        call_user_func( $resolved_route['callback'] );
    }

    /**
     * Performs some basic housekeeping tasks.
     * 
     * - Forces path to have a leading slash.
     * - Forces method to be uppercase.
     * - Forces GET method if invalid provided.
     * 
     * @param String $path The path passed by reference.
     * @param String $method (Optional) The request method passed by reference. (Defaults to GET, POST also supported)
     * @return null Nothing returned.
     */
    private function housekeeping( String &$path, String &$method = "GET" )
    {
        Utilities::forceLeadingSlash( $path );

        $method = strtoupper( $method );

        if( ! in_array( $method, $this->methods ) )
            $method = "GET";
    }
}
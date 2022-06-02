<?php

namespace DaveComputerGeek\SimpleMVC;

class Controller
{
    private $views_dir_path;

    public function __construct( $views_dir_path )
    {
        if( is_dir( $views_dir_path ) )
            $this->views_dir_path = $views_dir_path;
    }

    public function view( $filename, $data = array() )
    {
        $view_file_ext = ".view.php";
        $view_file_path = $this->views_dir_path . DIRECTORY_SEPARATOR . $filename . $view_file_ext;

        if( ! is_array( $data ) )
            return;

        if( ! is_file( $view_file_path ) )
        {
            http_response_code( 404 );
            echo "SimpleMVC Controller Error: View file \"" . $filename . "\" does not exist or is not a file.";
            return;
        }

        include_once $view_file_path;
    }

    public function getViewsDirPath()
    {
        return $this->views_dir_path;
    }
}
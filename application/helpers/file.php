<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

if (!function_exists('get_type_of_file'))
{

    function get_extension_of_file($user_id)
    {
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        
        return $ext;
        //$path_info = pathinfo('/foo/bar/baz.bill');

        //echo $path_info['extension']; // "bill"
    }


}

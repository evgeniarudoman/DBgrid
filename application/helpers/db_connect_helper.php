<?php

if (!defined ('BASEPATH'))
    exit ('No direct script access allowed');

if (!function_exists ('db_connect'))
{

    function db_connect ($db)
    {
        $db['hostname'] = 'localhost';
        $db['database'] = '';
        $db['dbdriver'] = 'mysql';
        $db['dbprefix'] = '';
        $db['pconnect'] = TRUE;
        $db['db_debug'] = TRUE;
        $db['cache_on'] = FALSE;
        $db['cachedir'] = '';
        $db['char_set'] = 'utf8';
        $db['dbcollat'] = 'utf8_general_ci';
        $db['swap_pre'] = '';
        $db['autoinit'] = TRUE;
        $db['stricton'] = FALSE;
        
        $grid = &get_instance();
        $grid->load->database ($db);
        
        //return $db;
    }

}
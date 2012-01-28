<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

interface I_Data_Row {

    public function select($db,$where);

    public function insert($db);
    
    public function show_tables($db);

    public function update();
    
    public function update_id($id);
    
    public function delete($where);

    public static function table_name();

    public static function load_collection($where = NULL, $order_by = NULL);
}

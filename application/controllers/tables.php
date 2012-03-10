<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Tables extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form', 'url', 'html'));
        $this->load->library('session');

        $this->load->model('database');
        $this->load->model('table');
        $this->load->model('field');
        $this->load->model('type');
    }


    public function add()
    {
        $user_id = $this->session->userdata('user_id');

        $this->load->model('query');

        try
        {
            var_dump($_POST);
            //$this->query->create_table($_POST['table_name']);

            $this->database->db_name = "dbgrid";
            $this->database->select(array('name' => $_POST['database'], 'user_id' => $user_id));
            $this->database->setNumberOfTables($this->database->getNumberOfTables() + 1);
            $this->database->update();

            $this->table->db_name = "dbgrid";
            $this->table->setName($_POST['table_name']);
            $this->table->setUserId($user_id);
            $this->table->setDbId($this->database->getId());
            $this->table->setNumberOfFields($_POST['count']);
            $this->table->insert();
        }
        catch (Exception $e)
        {
            
        }
    }


    public function get_type()
    {
        $types = $this->type->load_collection("dbgrid");

        foreach ($types as $type)
        {
            $list_type[] = array('key' => $type->getType());
        }
        
        echo json_encode($list_type);
    }


}
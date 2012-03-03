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
    }

    public function header($title)
    {
        $this->template = array('title' => $title,
            'scripts' => array(
                '1' => "/js/jquery-1.6.2.min.js",
                '2' => "/js/jquery-ui-1.8.16.custom.min.js",
                '3' => "/js/validation.js"),
            'styles' => array(
                '1' => "/css/jquery-ui-1.8.16.custom.css",
                '2' => "/css/style.css")
        );

        $this->load->view('templates/head', $this->template);
    }

    public function add()
    {
        $session_hash = $this->session->userdata('session_hash');
        $user_id = $this->session->userdata('user_id');

        if (isset($session_hash) && $session_hash != TRUE)
        {
            redirect(site_url('grid/login'));
        }
        else
        {
            $this->header('table add');

            if (isset($_POST['submit']))
            {
                $this->load->model('query');

                try
                {
                    die(var_dump($_POST));
                    $this->query->create_table($_POST['table_name']);

                    $this->database->select(array('name' => $_POST['list_database'], 'user_id' => $user_id));
                    $this->database->setNumberOfTables($this->database->setNumberOfTables + 1);
                    $this->database->update();

                    $this->table->db_name = "dbgrid";
                    $this->table->setName($_POST['table_name']);
                    $this->table->setUserId($user_id);
                    $this->table->setDbId($this->database->getId());
                    $this->table->setNumberOfFiedls($_POST['count_fields']);
                    $this->table->insert();

                    redirect(site_url('grid'));
                }
                catch (Exception $e)
                {
                    
                }
            }

            $databases = $this->database->load_collection("dbgrid", array('user_id' => $user_id));

            foreach ($databases as $database)
            {
                $list_database[$database->getId()] = $database->getName();
            }

            $this->load->view('table', array(
                'list_database' => $list_database,
            ));
        }
    }

}
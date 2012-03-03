<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Databases extends CI_Controller
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
            $this->header('database add');

            $this->load->view('database');

            if (isset($_POST['submit']))
            {
                $this->load->model('query');

                try
                {
                    $this->query->create_database($_POST['db_name']);

                    $this->database->db_name = "dbgrid";
                    $this->database->setName($_POST['db_name']);
                    $this->database->setUserId($user_id);
                    $this->database->insert();
                    

                    redirect(site_url('grid'));
                }
                catch (Exception $e)
                {
                    
                }
            }
        }
    }

}
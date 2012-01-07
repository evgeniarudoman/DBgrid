<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Grid extends CI_Controller
{

    public $template;

    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form', 'url', 'html'));
    }

    public function templates($title)
    {
        $this->template = array('title' => $title,
            'scripts' => array(
                '1' => "/js/jquery-1.6.2.min.js",
                '2' => "/js/jquery-ui-1.8.16.custom.min.js",
                '3' => "/js/validation.js"),
            'styles' => array(
                '1' => "/css/jquery-ui-1.8.16.custom.css",
                '2' => "/css/style.css"));

        $this->load->view('head', $this->template);
    }

    public function register()
    {
        //$this->CI->session->set_userdata('account', $account);
        $account = $this->session->userdata('account');

        if (isset($account))
        {
            redirect(site_url('grid/login'));
        }
        else
        {
            if (isset($_POST) && !empty($_POST))
            {
                $this->load->model('query');
                $query = $this->query->create_db('all_users', 'users', $_POST);

                if ($query == TRUE)
                    redirect(site_url('grid/success'));
                else
                    redirect(site_url('grid/error'));
            }
            else
            {
                $this->templates('REGISTRATION');
                $this->load->view('auth');
            }
        }
    }

    public function login()
    {
        $this->templates('AUTHORIZATION');
        $this->load->view('signin');
    }

    public function success()
    {
        $this->templates('SUCCESS');
    }

    public function error()
    {
        $this->templates('ERROR');
        $this->load->view('error');
    }

}
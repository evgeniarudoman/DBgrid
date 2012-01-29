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
        $this->load->library('session');

        $this->load->model('query');
        $this->query->create_default_db();
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

    public function register()
    {
        $account = $this->session->userdata('account');

        if (isset($account) && $account == TRUE)
        {
            redirect(site_url('grid/login'));
        }
        else
        {
            if (isset($_POST) && !empty($_POST))
            {
                $this->load->model('user');
                $this->user->setUsername(trim(str_replace(' ', '_', $_POST['username'])));
                $this->user->setEmail(trim($_POST['email']));
                $this->user->setPassword(trim(md5($_POST['password'])));
                $this->user->setSessionHash('');
                $this->user->setThemeId(1);
                $this->user->setNumberOfDb(0);
                $this->user->insert('dbgrid');
            }
            else
            {
                $this->header('REGISTRATION');
                $this->load->view('auth');
            }
        }
    }

    public function login()
    {
        $this->header('AUTHORIZATION');
        $this->load->view('signin');
    }

    public function success()
    {
        $this->header('SUCCESS');
    }

    public function error()
    {
        $this->header('ERROR');
        $this->load->view('error');
    }

    public function tables()
    {
        $this->header('table');
        
        $this->load->model('query');
        $tables = $this->query->show_tables($_GET['database']);
        //  $databases = mysql_query('SHOW DATABASES');

        if (isset($_GET['table']) && !empty($_GET['table']))
            $result = mysql_query("SELECT * FROM " . $_GET['database'] . '.' . $_GET['table']);
        else
            $result = NULL;

        $this->load->view('tables', array('all_tables' => $tables->result_id, 'result' => $result));
    }

    /*
      public function tables()
      {

      $this->load->model('query');
      $tables = $this->query->show_tables($_GET['database']);
      $databases = mysql_query('SHOW DATABASES');

      if (isset($_GET['table']) && $_GET['table'])
      $result = mysql_query("SELECT * FROM " . $_GET['database'] . '.' . $_GET['table']);
      else
      $result = NULL;

      //$tables = $this->query->show_tables($_GET['database']);
      $this->header('table111');

      $left_menu = $this->load->view('templates/left_menu', array('all_tables' => $tables->result_id));
      $content = $this->load->view('content', array('result' => $result));
      $this->load->view('tables', array('left_menu' => $left_menu, 'content' => $content));
      // $this->load->view('tables', array('all_tables' => $tables->result_id,'result'=>$result,'databases'=>$databases));
      }
     */
}
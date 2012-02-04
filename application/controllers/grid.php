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
        $session_hash = $this->session->userdata('session_hash');
        $this->session->set_userdata('error', '');

        if (isset($session_hash) && $session_hash == TRUE)
        {
            redirect(site_url('grid/login'));
        }
        else
        {
            if (isset($_POST) && !empty($_POST))
            {
                $this->load->model('user');
                $this->user->db_name = "dbgrid";

                try
                {
                    $this->user->get_unique(array('email' => $_POST['email']), array('username' => $_POST['username']));
                }
                catch (Exception $e)
                {
                    $this->user->setUsername(trim(str_replace(' ', '_', $_POST['username'])));
                    $this->user->setEmail(trim($_POST['email']));
                    $this->user->setPassword(trim(md5($_POST['password'])));
                    $this->user->setSessionHash('');
                    $this->user->setThemeId(1);
                    $this->user->setNumberOfDb(0);
                    $this->user->insert('dbgrid');

                    redirect(site_url('grid/login'));
                }

                $this->session->set_userdata('error', 'Username or email is already exist.');
            }

            $this->header('REGISTRATION');
            $this->load->view('auth');
        }
    }

    public function login()
    {
        $session_hash = $this->session->userdata('session_hash');
        $this->session->set_userdata('error', '');

        if (isset($session_hash) && $session_hash == TRUE)
        {
            redirect(site_url('grid/tables'));
        }
        else
        {
            if (isset($_POST) && !empty($_POST))
            {
                $this->load->model('user');
                $this->user->db_name = "dbgrid";

                try
                {
                    $this->user->select(array('username' => $_POST['username'], 'password' => md5($_POST['password'])));
                    $session_hash = md5($_POST['username'] . md5($_POST['password']));
                    $this->user->setSessionHash($session_hash);
                    $this->user->update();

                    $this->session->set_userdata('user_id', $this->user->getId());
                    $this->session->set_userdata('username', $this->user->getUsername());
                    $this->session->set_userdata('session_hash', $session_hash);

                    redirect(site_url('grid/tables'));
                }
                catch (Exception $e)
                {
                    $this->session->set_userdata('error', 'Username or password is not correct.');
                }
            }

            $this->header('AUTHORIZATION');
            $this->load->view('signin');
        }
    }

    public function tables()
    {
        $session_hash = $this->session->userdata('session_hash');

        if (isset($session_hash) && !empty($session_hash))
        {
            $username = $this->session->userdata('username');
            $this->header($username);

            try
            {
                $this->load->model('database');
                $databases = $this->database->load_collection("dbgrid", array('user_id' => $this->session->userdata('user_id')));

                foreach ($databases as $database)
                { 
                    $database_name[$database->getId()] = $database->getName();
                }
                
            }
            catch (Exception $e)
            {
                
            }

            if (isset($_GET) && !empty($_GET))
            {
                $this->load->model('query');
                $this->query->db_name = $_GET['database'];
                $tables = $this->query->show_tables();

                if (isset($_GET['table']) && !empty($_GET['table']))
                    $result = mysql_query("SELECT * FROM " . $_GET['database'] . '.' . $_GET['table']);
                else
                    $result = NULL;
            }

            $this->load->view('tables', array(
                'databases' => $database_name,
                'all_tables' => $tables->result_id,
                'result' => $result,
            ));
        }
        else
        {
            redirect(site_url('grid/login'));
        }
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
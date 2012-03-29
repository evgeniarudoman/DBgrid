<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Grid extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form', 'url', 'html', 'database_tree'));
        $this->load->library('session');

        $this->load->model('query');
        $this->query->create_default_db();
        
        //delete this later !!!
        //$this->session->set_userdata('session_hash', 'djkfkdsjflk5673rgyh');
    }


    public function header($title)
    {
        $this->template = array('title' => $title,
            'scripts' => array(
                '1' => "/bootstrap/js/bootstrap.js",
                '2' => "/bootstrap/js/bootstrap.min.js",
                '3' => "/bootstrap/js/bootstrap.modal.js",
                '4' => "/js/jquery-1.6.2.min.js",
                '5' => "/js/jquery-ui-1.8.16.custom.min.js",
                '6' => "/js/validation.js",
                ),
            'styles' => array(
                '1' => "/css/jquery-ui-1.8.18.custom.css",
                '2' => "/css/style.css",
                '3' => "/bootstrap/css/bootstrap.css",
                '4' => "/bootstrap/css/bootstrap.min.css",
                '5' => "/bootstrap/css/bootstrap-responsive.css",
                '6' => "/bootstrap/css/bootstrap-responsive.min.css",
                '7' => "/bootstrap/css/docs.css",
                '8' => "/css/dialog.css"
                ),
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
           // if (!mysql_select_db($db, $this->conn_id))
           // throw new SQLException("Could not select the database.", 2); 
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
            redirect(site_url('grid/index'));
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

                    redirect(site_url('grid/index'));
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


    public function logout()
    {
        $session_hash = $this->session->userdata('session_hash');
        $user_id = $this->session->userdata('user_id');

        if (isset($session_hash) && $session_hash == TRUE)
        {
            $this->load->model('user');
            $this->user->db_name = "dbgrid";

            try
            {
                $this->user->select(array('session_hash' => $session_hash, 'id' => $user_id));
                $this->user->setSessionHash('');
                $this->user->update();

                $this->session->set_userdata('user_id', '');
                $this->session->set_userdata('username', '');
                $this->session->set_userdata('session_hash', '');

                redirect(site_url('grid/index'));
            }
            catch (Exception $e)
            {
                
            }
        }
        else
        {
            redirect(site_url('grid/index'));
        }
    }


    public function index()
    {
        $session_hash = $this->session->userdata('session_hash');
        $user_id = $this->session->userdata('user_id');

        if (isset($session_hash) && $session_hash != TRUE)
        {
            redirect(site_url('grid/login'));
        }
        else
        {
            $username = $this->session->userdata('username');
            $this->header($username);

            $result = get_database_tree($user_id);

            try
            {
                if (isset($_GET['database']) && !empty($_GET['database']) && isset($_GET['table']) && !empty($_GET['table']))
                {
                    $err = db_table_exists($user_id, $_GET['database'], $_GET['table']);

                    if (isset($err) && $err == 1)
                    {
                        $result['result'] = mysql_query("SELECT * FROM " . $_GET['database'] . '.' . $_GET['table']);
                    }
                    elseif (isset($err) && $err == 2)
                    {
                        redirect(site_url('grid/index?database=' . $_GET['database']));
                    }
                    else
                    {
                        redirect(site_url('grid'));
                    }
                }
            }
            catch (Exception $e)
            {
                redirect(site_url('grid'));
            }

            $databases = $this->database->load_collection("dbgrid", array('user_id' => $user_id));

            foreach ($databases as $database)
            {
                $list_database[] = $database->getName();
            }
            if (!isset($list_database))
                $list_database = NULL;

            $this->load->view('templates/scripts');
            $this->load->view('templates/jquery_form', array(
                'list_database' => $list_database
            ));
            $this->load->view('content', array(
                'result' => $result,
            ));
            $this->load->view('templates/menu_button');
        }
    }


}

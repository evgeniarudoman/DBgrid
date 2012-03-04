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
    }

    public function header($title)
    {
        $this->template = array('title' => $title,
            'scripts' => array(
                '1' => "/js/jquery-1.6.2.min.js",
                '2' => "/js/jquery-ui-1.8.16.custom.min.js",
                '3' => "/js/validation.js"),
            'styles' => array(
                '1' => "/css/jquery-ui-1.8.18.custom.css",
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
                    $result['result'] = mysql_query("SELECT * FROM " . $_GET['database'] . '.' . $_GET['table']);
                }
                else
                {
                    $err = 0;
                }
            }
            catch (Exception $e)
            {
                
            }

            $this->load->view('templates/scripts');
            $this->load->view('templates/jquery_form');
            $this->load->view('content', array(
                'result' => $result,
                'err' => $err,
            ));
            $this->load->view('templates/menu_button');
        }
    }

}
<?php

if (!defined ('BASEPATH'))
    exit ('No direct script access allowed');

class Grid extends CI_Controller
{

    private $confg = array ();

    public function __construct ()
    {
        parent::__construct ();

        /*
          $this->confg['hostname'] = "localhost";
          $this->confg['username'] = "root";
          $this->confg['password'] = "root";
          $this->confg['database'] = "";
          $this->confg['dbdriver'] = "mysql";
          $this->confg['dbprefix'] = "";
          $this->confg['pconnect'] = FALSE;
          $this->confg['db_debug'] = TRUE;
          $this->confg['cache_on'] = FALSE;
          $this->confg['cachedir'] = "";
          $this->confg['char_set'] = "utf8";
          $this->confg['dbcollat'] = "utf8_general_ci";

          $this->load->database ($this->confg);
         */
        $this->load->helper (array ('form', 'url', 'html', 'database_tree'));
        $this->load->library ('session');

        $this->load->model ('query');
        $this->load->model ('user');
        $this->user->db_name = "dbgrid";
        $this->load->model ('theme');
        $this->load->model ('type');
        $this->theme->db_name = "dbgrid";

        $this->query->create_default_db ();
        $this->query->insert_default ();
    }

    public function header ($title, $theme = NULL)
    {
        switch ($theme)
        {
            case 'серая':
                $theme_css = "/bootstrap/css/bootstrap.gray.css";
                break;
            case 'голубая':
                $theme_css = "/bootstrap/css/bootstrap.css";
                break;
            case NULL:
                $theme_css = "/bootstrap/css/bootstrap.css";
                break;
        }

        $this->template = array ('title' => 'DBGrid - ' . $title,
            'scripts' => array (
                //'1' => "/bootstrap/js/bootstrap.js",
                '2' => "/bootstrap/js/bootstrap.min.js",
                '3' => "/bootstrap/js/bootstrap.modal.js",
                '4' => "/js/jquery-1.6.2.min.js",
                '5' => "/js/jquery-ui-1.8.16.custom.min.js",
                '6' => "/js/tablesorter.js",
                '7' => "/js/validation.js",
                '8' => "/js/jquery.countdown.js",
                '9' => "/js/script.js",
                '10' => "/uploadify/swfobject.js",
                '11' => "/uploadify/jquery.uploadify.v2.1.4.min.js",
                '12' => "/uploadify/uploadify-script.js",
            ),
            'styles' => array (
                '1' => "/css/jquery-ui-1.8.18.custom.css",
                '2' => "/css/style.css",
                '3' => $theme_css,
                //'4' => "/bootstrap/css/bootstrap.min.css",
                //'5' => "/bootstrap/css/bootstrap-responsive.css",
                '6' => "/bootstrap/css/bootstrap-responsive.min.css",
                '7' => "/bootstrap/css/docs.css",
                '8' => "/css/jquery.countdown.css",
                '9' => "/uploadify/uploadify.css",
            //'9' => "/css/styles.css",
            //'8' => "/css/dialog.css"
            ),
        );

        $this->load->view ('templates/head', $this->template);
    }

    public function register ()
    {
        $session_hash = $this->session->userdata ('session_hash');
        $this->session->set_userdata ('error', '');

        if (isset ($session_hash) && $session_hash == TRUE)
        {
            redirect (site_url ('grid/index'));
        }
        else
        {
            if (isset ($_POST) && !empty ($_POST))
            {
                try
                {
                    $this->user->get_unique (array ('username' => $_POST['username']));
                }
                catch (Exception $e)
                {
                    $this->user->setUsername (trim (str_replace (' ', '_', $_POST['username'])));
                    $this->user->setPassword (trim (md5 ($_POST['password'])));
                    $session_hash = md5 ($_POST['username'] . md5 ($_POST['password']));
                    $this->user->setSessionHash ($session_hash);
                    $this->user->setThemeId (1);
                    $this->user->setNumberOfDb (0);
                    $user_id = $this->user->insert ('dbgrid');

                    $this->session->set_userdata ('user_id', $user_id);
                    $this->session->set_userdata ('username', $this->user->getUsername ());
                    $this->session->set_userdata ('session_hash', $session_hash);

                    redirect (site_url ('grid/index'));
                }

                $this->session->set_userdata ('error', 'Username is already exist.');
            }

            $this->header ('Signup');
            $this->load->view ('auth');
        }
    }

    public function login ()
    {
        $session_hash = $this->session->userdata ('session_hash');
        $this->session->set_userdata ('error', '');

        if (isset ($session_hash) && $session_hash == TRUE)
        {
            redirect (site_url ('grid/index'));
        }
        else
        {
            if (isset ($_POST) && !empty ($_POST))
            {
                try
                {
                    $this->user->select (array ('username' => $_POST['username'], 'password' => md5 ($_POST['password'])));
                    $session_hash = md5 ($_POST['username'] . md5 ($_POST['password']));
                    $this->user->setSessionHash ($session_hash);
                    $this->user->update ();

                    $this->session->set_userdata ('user_id', $this->user->getId ());
                    $this->session->set_userdata ('username', $this->user->getUsername ());
                    $this->session->set_userdata ('session_hash', $session_hash);

                    redirect (site_url ('grid/index'));
                }
                catch (Exception $e)
                {
                    $this->session->set_userdata ('error', 'Username or password is not correct.');
                }
            }

            $this->header ('Login');
            $this->load->view ('signin');
        }
    }

    public function logout ()
    {
        $session_hash = $this->session->userdata ('session_hash');
        $user_id      = $this->session->userdata ('user_id');

        if (isset ($session_hash) && $session_hash == TRUE)
        {
            try
            {
                $this->user->select (array ('session_hash' => $session_hash, 'id' => $user_id));
                $this->user->setSessionHash ('');
                $this->user->update ();

                $this->session->set_userdata ('user_id', '');
                $this->session->set_userdata ('username', '');
                $this->session->set_userdata ('session_hash', '');

                redirect (site_url ('grid/index'));
            }
            catch (Exception $e)
            {
                
            }
        }
        else
        {
            redirect (site_url ('grid/index'));
        }
    }

    public function index ()
    {
        $session_hash = $this->session->userdata ('session_hash');
        $user_id      = $this->session->userdata ('user_id');

        if (isset ($session_hash) && $session_hash != TRUE)
        {
            redirect (site_url ('grid/login'));
        }
        else
        {
            try
            {
                $this->user->select (
                        array (
                            'session_hash' => $session_hash,
                            'id' => $user_id
                        )
                );

                $this->theme->select ($this->user->getThemeId ());
            }
            catch (Exception $e)
            {
                $this->session->set_userdata ('session_hash', '');
                redirect (site_url ('grid/login'));
            }

            $username = $this->session->userdata ('username');
            $this->header ($username, $this->theme->getName ());

            $result = get_database_tree ($user_id);

            try
            {
                if (isset ($_GET['database']) && !empty ($_GET['database']) && isset ($_GET['table']) && !empty ($_GET['table']))
                {
                    $err = db_table_exists ($user_id, $_GET['database'], $_GET['table']);

                    if (isset ($err) && $err == 1)
                    {
                        $result['result']   = mysql_query ("SELECT * FROM " . $_GET['database'] . '.' . $_GET['table'] . ' LIMIT 5');
                        $result['num_rows'] = mysql_num_rows (mysql_query ("SELECT * FROM " . $_GET['database'] . '.' . $_GET['table']));
                    }
                    elseif (isset ($err) && $err == 2)
                    {
                        redirect (site_url ('grid/index?database=' . $_GET['database']));
                    }
                    else
                    {
                        redirect (site_url ('grid'));
                    }
                }
            }
            catch (Exception $e)
            {
                redirect (site_url ('grid'));
            }

            $databases = $this->database->load_collection ("dbgrid", array ('user_id' => $user_id));

            foreach ($databases as $database)
            {
                $list_database[] = $database->getName ();
            }
            if (!isset ($list_database))
                $list_database   = NULL;

            $types = $this->type->load_collection ("dbgrid");

            foreach ($types as $type)
            {
                $list_type[] = $type->getName ();
            }

            $this->load->model ('theme');
            $themes = $this->theme->load_collection ("dbgrid");
            foreach ($themes as $theme)
            {
                $list_theme[] = $theme->getName ();
            }

            $this->load->view ('templates/scripts');
            $this->load->view ('templates/jquery_scripts');
            $this->load->view ('jquery_form', array (
                'list_database' => $list_database,
                'list_type' => $list_type,
                'result' => $result
            ));
            $this->load->view ('content', array (
                'list_database' => $list_database,
                'list_type' => $list_type,
                'result' => $result,
                'list_theme' => $list_theme,
            ));
            $this->load->view ('templates/menu_button');
        }
    }

    public function save_theme ()
    {
        $session_hash = $this->session->userdata ('session_hash');
        $user_id      = $this->session->userdata ('user_id');

        $this->load->model ('theme');
        $this->theme->db_name = "dbgrid";
        try
        {
            $this->theme->select (array ('name' => $_POST['theme']));

            $this->user->select (array ('session_hash' => $session_hash, 'id' => $user_id));
            $this->user->setThemeId ($this->theme->getId ());
            $this->user->update ();
            $success       = TRUE;
        }
        catch (Exception $e)
        {
            $success = '* Message - ' . $e->getMessage () . "\r\n" . "* Line # - " . $e->getLine () . "\r\n" . "* File - " . $e->getFile ();
        }
        echo json_encode ($success);
    }

    public function jquery_row ()
    {
        header ("Content-Type: text/html;charset=utf-8");
        $user_id = $this->session->userdata ('user_id');

        $bool = db_table_exists ($user_id, $_POST['database_name'], $_POST['table_name']);

        if (isset ($bool) && $bool == 1)
        {
            $result           = get_database_tree ($user_id);
            $result['result'] = mysql_query ("SELECT * FROM " . $_POST['database_name'] . '.' . $_POST['table_name'] . ' LIMIT 5');

            json_encode ($this->load->view (
                            'templates/row-form', array (
                        'result' => $result,
                        'database' => $_POST['database_name'],
                        'table' => $_POST['table_name'],
                    ))
            );
        }
    }

}

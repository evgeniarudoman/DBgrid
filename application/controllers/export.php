<?php

if (!defined ('BASEPATH'))
    exit ('No direct script access allowed');

class Export extends CI_Controller
{

    public function __construct ()
    {
        parent::__construct ();

        $this->load->helper (array ('form', 'url', 'html', 'database_tree'));
        $this->load->library ('session');

        $this->load->model ('database');
    }

    public function xls ()
    {
        $header = '';
        $data   = '';

        $select = "SELECT * FROM `" . $_GET['database'] . "`.`" . $_GET['table'] . "`";
        $export = mysql_query ($select) or die ("Sql error : " . mysql_error ());
        $fields = mysql_num_fields ($export);

        for ($i = 0; $i < $fields; $i++)
        {
            $header .= "<td>" . mysql_field_name ($export, $i) . "</td>";
        }
        while ($row = mysql_fetch_row ($export))
        {
            $line = '<tr>';
            foreach ($row as $value)
            {
                if ((!isset ($value) ) || ( $value == "" ))
                {
                    $value = "<td></td>";
                }
                else
                {
                    $value = "<td>" . $value . "</td>";
                }
                $line .= $value;
            }
            $data .= $line . "</tr>";
        }

        header ("Content-Type: application/force-download");
        header ("Content-Type: application/octet-stream");
        header ("Content-Type: application/download");

        header ('Content-Type: text/x-csv; charset=utf-8');
        header ("Content-Disposition: attachment;filename=" . date ("d-m-Y") . "-export.xls");
        header ("Content-Transfer-Encoding: binary ");

        $csv_output = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                            <html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
                                <head>
                                    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
                                </head>
                                <body>';

        $csv_output .='<table><tr>' . $header . '</tr><tr>' . $data . '</tr></table>';
        $csv_output .='</body></html>';

        echo $csv_output;
    }

}

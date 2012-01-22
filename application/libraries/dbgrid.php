<?php

class DBgrid
{

    var $result;
    var $tabla;
    var $titulo;
    var $linea;

    function DBgrid($all_tables, $result = NULL)
    {
        $this->all = $all_tables;
        $this->result = $result;


        if ($_GET)
        {
            if ($_GET['database'] && !$_GET['table'])
            {
                ?>
                <table class='table'><tr><td class='tab width' bgcolor='#002F32'><div class='base'>
                                <table class='linked'><tr>
                                        <?php
                                        echo "<td class='data' colspan=2>" . $_GET['database'] . "_database</td></tr>";

                                        //  echo "";

                                        while ($row = mysql_fetch_array($all_tables))
                                        {
                                            echo "<tr><td><div class='tabl'><img src='table.png'></td>";
                                            for ($i = 0; $i < mysql_num_fields($all_tables); $i++)
                                            {
                                                echo "<td class ='href'><a href='/grid/dbgrid.php?database=" . $_GET['database'] . "&table=" . $row[mysql_field_name($all_tables, $i)] . "'>" . $row[mysql_field_name($all_tables, $i)] . "</a></div></td>";
                                            }
                                            echo "";
                                        }
                                        if ($all_tables)
                                        {
                                            if (mysql_num_rows($all_tables) == 1)
                                            {
                                                // echo "111";
                                            }
                                            else
                                            {
                                                echo "<tr><td colspan=2 class='no_table'>No tables found in database.</td></tr>";
                                                echo "<tr><td colspan=2 class='label_table'>You can create new table</td></tr>";
                                                echo "<tr><td colspan=2 class='new_table'><input type='text' name='new_table' value='table name'/></td></tr>";
                                                echo "<tr><td colspan=2 class='new_table'><input type='text' name='num_table' value='number of fields'/></td></tr>";
                                                echo "<tr><td colspan=2 class='create_button'><input type='button' name='create_button' value='create'/></td></tr>";
                                            }
                                        }
                                        ?>
                                    </tr></table></div></td>
                        <td class="buttons">
                            <table>
                                <tr>
                                    <td>
                                        <a href=""><button type="button" name="button" class="menu" ><img src='image/4.png'/><br/>reload</button></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href=""><button type="button" name="button" class="menu"><img src='image/7.png'/><br/>help</button></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="/grid/logout.php"><button type="button" name="button" class="menu" ><img src='image/3.png'/><br/>exit</button></a>
                                    </td>
                                </tr>

                            </table>

                        </td>
                        <td class="buttonsH">
                            <table>
                                <tr>
                                    <td>
                                        <button type="button" name="button" class="menu" onclick="add_field();"><img src='image/1.png'/><br/>add</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <button type="submit" class="menu"><img src='image/4.png'/><br/>edit</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <button type="button" class="menu" id="cancel"><img src='image/3.png'/><br/>delete</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <button type="submit" class="menu"><img src='image/6.png'/><br/>save</button>
                                    </td>
                                </tr>
                            </table>

                        </td>
                        <td id="nav">
                            <input type="button" name="nav" onclick="display_menu();"/>
                            <div id="hidden">
                                <input type="hidden" class="hide"/>
                            </div>
                        </td>

                                                <?php
                                            }
//**************************************************************************************************************
                                            if ($_GET['table'])
                                            {

                                                $this->insert($result);
                                                ?>
                    <form action='' method='post'><table class='table'><tr><td class='tab width' bgcolor='#002F32'><div class='base'>

                                        <table class='linked'><tr><td></td>
                                                <?php
                                                for ($i = 0; $i < mysql_num_fields($all_tables); $i++)
                                                {
                                                    echo "<td>" . mysql_field_name($all_tables, $i) . "</td></tr>";
                                                }
                                                echo "";

                                                while ($row = mysql_fetch_array($all_tables))
                                                {
                                                    echo "<tr><td><div class='tabl'><img src='table.png'></td>";
                                                    for ($i = 0; $i < mysql_num_fields($all_tables); $i++)
                                                    {
                                                        echo "<td class ='href'><a href='/grid/dbgrid.php?database=" . $_GET['database'] . "&table=" . $row[mysql_field_name($all_tables, $i)] . "'>" . $row[mysql_field_name($all_tables, $i)] . "</a></div></td>";
                                                    }
                                                    echo "";
                                                }
                                                ?>
                                            </tr></table></div></td>
                                <td class='tub'><table class='tables fff'>
                                        <tr><td class ='disp'></td><td bgcolor='#002F32'>#</td>
                <?php
                for ($i = 0; $i < mysql_num_fields($result); $i++)
                {
                    echo "<td bgcolor='#002F32' name='" . $i . "'><div class='resDiv'>" . mysql_field_name($result, $i) . "</div></td>";
                }
                echo "</tr>";
                $j = 1;
                while ($row = mysql_fetch_array($result))
                {
                    echo "<tr><td ><input type='checkbox'></td><td class='id'>" . $j . "</td>";
                    for ($i = 0; $i < mysql_num_fields($result); $i++)
                    {
                        echo "<td ><div class ='href inp'>" . $row[mysql_field_name($result, $i)] . "</div></td>";
                    }
                    echo "</tr>";
                    $j++;
                }
                ?>
                                    </table></td>


                                <td class="buttons">
                                    <table>
                                        <tr>
                                            <td>
                                                <a href=""><button type="button" name="button" class="menu" ><img src='image/4.png'/><br/>reload</button></a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <a href=""><button type="button" name="button" class="menu"><img src='image/7.png'/><br/>help</button></a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <a href="/grid/logout.php"><button type="button" name="button" class="menu" ><img src='image/3.png'/><br/>exit</button></a>
                                            </td>
                                        </tr>

                                    </table>

                                </td>

                                <td class="buttonsH">
                                    <table>
                                        <tr>
                                            <td>
                                                <button type="button" name="button" class="menu" onclick="add_field();"><img src='image/1.png'/><br/>add</button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <button type="submit" class="menu"><img src='image/4.png'/><br/>edit</button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <button type="button" class="menu" id="cancel"><img src='image/3.png'/><br/>delete</button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <button type="submit" class="menu"><img src='image/6.png'/><br/>save</button>
                                            </td>
                                        </tr>
                                    </table>

                                </td>
                                <td id="nav">
                                    <input type="button" name="nav" onclick="display_menu();"/>
                                </td>

                            </tr></table></form>
                    <div id="hidden">
                        <input type="hidden" class="hide"/>
                    </div>
                    <?php
                }
//**************************************************************************************************************
            }
        }

        function insert($result)
        {
            $this->result = $result;
            for ($i = 0; $i < mysql_num_fields($result); $i++)
            {
                $adding[] = mysql_field_name($result, $i);
            }
            foreach ($_POST as $post)
            {
                $a[] = implode("','", $post);
                print_r($a);
                $arr = implode("'), ('", $a);
            }
            $b = implode("`,`", $adding);
            if (isset($_POST) && isset($arr))
            {
                mysql_query("INSERT INTO  `" . $_GET['database'] . "`.`" . $_GET['table'] . "` (`" . $b . "`) VALUES ('" . $arr . "')");
            }
        }

    }

    
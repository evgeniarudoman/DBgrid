<!doctype html public "-//W3C//DTD HTML 4.0 //EN">
<html>
    <head>
        <script language="javascript">
            $(document).ready(function() {
                $(".resDiv").resizable({ 
                    handles: 'e'
                });
            });
            
            $(document).ready(function(){
                $("input[type='checkbox']").change(function(){
                    $("input[type='checkbox']:checked").parent('td').parent('tr').addClass('check')
                    if ($("input[type='checkbox']:not(:checked)"))
                    {
                        $("input[type='checkbox']:not(:checked)").parent('td').parent('tr').attr({class: ''});
                    }
                })
            });
            
            $(document).ready(function(){
                $($('.new_table input')[0]).click(function(){
                    $($('.new_table input')[0]).val('');
                    $($('.new_table')[0]).attr({class: 'new_table new'});;
                })
                $($('.new_table input')[1]).click(function(){
                    $($('.new_table input')[1]).val('');
                    $($('.new_table')[1]).attr({class: 'new_table new'});;
                })
            });
            
            function add_field(){
                var inp;
                var id;
                var num;
                var a;
                num=$('.tables tr:last .id').text();
                a=Number(num);
                id = Number(a+1);
                inp+='<td ><input type="checkbox"></td><td class="id">'+id+'</td>';
                for (i=0;i<=$('.tables tr:first td').length-3;i++)
                {
                    inp+= '<td><div class="href inp in"><input type="text" align="center" style="border: 1px solid yellow;" class="input" name="'+id+'['+i+']" ></div></td>';
                }
                $(".tables").find('tbody')
                .append($('<tr>')
                .append($(inp)  
            ) 
            );
            }
            
            $(function() {
                $( "#cancel" ).click(function() {
                    
                    $( "#dialog-cancel" ).dialog({
                        modal: true,
                        height: 200,
                        buttons: {
                            "YES": function(){
                                $(".tables .check").slideUp('fast');
                                
                                $( this ).dialog( "close" );
                            },
                            "NO": function(){
                                $( this ).dialog( "close" );
                            }
                                       
                        }
                    });	
                });
            });
            
            function display_menu() 
            {
                if ($('#hidden .hide').val()==1){
                    $('.table .tab').attr({style: ''});
                    $('.table .newbuttons').attr({class: 'buttons'});
                    $('.table .newbuttonsH').attr({class: 'buttonsH'});
                    $('#newnav').attr({id: 'nav'});
                    $('#hidden .hide').val(0);
                }
                else 
                {
                    $('.table .tab').attr({style: 'display:none'});
                    $('.table .buttons').attr({class: 'newbuttons'});
                    $('.table .buttonsH').attr({class: 'newbuttonsH'});
                    $('#nav').attr({id: 'newnav'});
                    $('#hidden .hide').val(1);
                }
            }
        </script>
    </head>
    <body>
        <div id="dialog-cancel"  style="display: none">
            Are you sure want delete rows?
        </div>
        <?php if ($_GET):
            if ($_GET['database'] && !isset($_GET['table'])):
                ?>
                <table class='table'>
                    <tr>
                        <td class='tab width' bgcolor='#002F32'>
                            <div class='base'>
                                <table class='linked'>
                                            <tr>
                                                <td class='data' colspan=2>database "<?php echo $_GET['database'] ?>"</td>
                                            </tr>
                                        <?php while ($row = mysql_fetch_array($all_tables)):?>
                                           <tr>
                                               <td><div class='tabl'><img src='/image/table.png'></td>
                                        <?php for ($i = 0; $i < mysql_num_fields($all_tables); $i++):?>
                                           <td class ='href'><a href='/grid/tables?database=<?php echo $_GET['database'] ?>&table=<?php echo $row[mysql_field_name($all_tables, $i)] ?>'><?php echo $row[mysql_field_name($all_tables, $i)] ?></a></div></td>
                                        <?php endfor;
                                            endwhile;
                                        if ($all_tables):
                                            if (mysql_num_rows($all_tables) < 1):?>
                                                <tr><td colspan=2 class='no_table'>No tables found in database.</td></tr>
                                            <?php endif;?>
                                            <tr><td colspan=2 class='label_table'>You can create new table</td></tr>
                                            <tr><td colspan=2 class='new_table'><input type='text' name='new_table' value='table name'/></td></tr>
                                            <tr><td colspan=2 class='new_table'><input type='text' name='num_table' value='number of fields'/></td></tr>
                                            <tr><td colspan=2 class='create_button'><input type='button' name='create_button' value='create'/></td></tr>
                                        <?php endif; ?>
                                    </tr>
                                </table>
                            </div>
                        </td>
                        <td class="buttons">
                            <table>
                                <tr>
                                    <td>
                                        <a href=""><button type="button" name="button" class="menu" ><img src='/image/4.png'/><br/>reload</button></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href=""><button type="button" name="button" class="menu"><img src='/image/7.png'/><br/>help</button></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="/grid/logout.php"><button type="button" name="button" class="menu" ><img src='/image/3.png'/><br/>exit</button></a>
                                    </td>
                                </tr>

                            </table>
                        </td>
                        <td class="buttonsH">
                            <table>
                                <tr>
                                    <td>
                                        <button type="button" name="button" class="menu" onclick="add_field();"><img src='/image/1.png'/><br/>add</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <button type="submit" class="menu"><img src='/image/4.png'/><br/>edit</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <button type="button" class="menu" id="cancel"><img src='/image/3.png'/><br/>delete</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <button type="submit" class="menu"><img src='/image/6.png'/><br/>save</button>
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
                        <?php endif;
                            if (isset($_GET['table']) && $_GET['table']):
                        ?>
                    <form action='' method='post'>
                        <table class='table'>
                            <tr>
                                <td class='tab width' bgcolor='#002F32'>
                                    <div class='base'>
                                        <table class='linked'>
                                            <tr>
                                                <td class='data' colspan=2>database "<?php echo $_GET['database'] ?>"</td>
                                            </tr>
                                              <?php while ($row = mysql_fetch_array($all_tables)):?>
                                            <tr>
                                                <td><div class='tabl'><img src='/image/table.png'></td>
                                                <?php for ($i = 0; $i < mysql_num_fields($all_tables); $i++):?>
                                                <td class ='href'><a href='/grid/tables?database=<?php echo $_GET['database'] ?>&table=<?php echo $row[mysql_field_name($all_tables, $i)] ?>'><?php echo $row[mysql_field_name($all_tables, $i)]; echo ' ('.mysql_num_fields($result).')';?></a></div></td>
                                                <?php endfor;?>
                                              <?php endwhile;?>
                                            </tr>
                                        </table>
                                    </div>
                                </td>
                                <td class='tub'>
                                    <table class='tables fff'>
                                        <tr>
                                            <td class ='disp'></td><td bgcolor='#002F32'>#</td>
                                                <?php for ($i = 0; $i < mysql_num_fields($result); $i++):?>
                                            <td bgcolor='#002F32' name='<?php echo $i ?>'><div class='resDiv'><?php echo mysql_field_name($result, $i); ?></div></td>
                                                <?php endfor;?>
                                        </tr>
                                        <?php  $j = 1;
                                        while ($row = mysql_fetch_array($result)):?>
                                        <tr>
                                            <td><input type='checkbox'></td>
                                            <td class='id'><?php echo $j ?></td>
                                        <?php for ($i = 0; $i < mysql_num_fields($result); $i++):?>
                                            <td><div class ='href inp'><?php echo $row[mysql_field_name($result, $i)] ?></div></td>
                                        <?php endfor;?>
                                        </tr>
                                        <?php $j++;?>
                                        <?php endwhile;?>
                                    </table>
                                </td>
                                <td class="buttons">
                                    <table>
                                        <tr>
                                            <td>
                                                <a href=""><button type="button" name="button" class="menu" ><img src='/image/4.png'/><br/>reload</button></a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <a href=""><button type="button" name="button" class="menu"><img src='/image/7.png'/><br/>help</button></a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <a href="/grid/logout.php"><button type="button" name="button" class="menu" ><img src='/image/3.png'/><br/>exit</button></a>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                                <td class="buttonsH">
                                    <table>
                                        <tr>
                                            <td>
                                                <button type="button" name="button" class="menu" onclick="add_field();"><img src='/image/1.png'/><br/>add</button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <button type="submit" class="menu"><img src='/image/4.png'/><br/>edit</button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <button type="button" class="menu" id="cancel"><img src='/image/3.png'/><br/>delete</button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <button type="submit" class="menu"><img src='/image/6.png'/><br/>save</button>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                                <td id="nav">
                                    <input type="button" name="nav" onclick="display_menu();"/>
                                </td>
                            </tr>
                        </table>
                    </form>
                    <div id="hidden">
                        <input type="hidden" class="hide"/>
                    </div>
                    <?php
                endif;
            endif;
            ?>
<?php
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
            ?>
    </body>
</html>

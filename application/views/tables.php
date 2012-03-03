<body>
    <script language="javascript">
        $(document).ready(function() {
            $(".resize").resizable({ 
                handles: 'e'
            });
        //--------------------------------------
            $("#content div.checkbox input[type='checkbox']").change(function(){
                $("#content div.checkbox input[type='checkbox']:checked").parent('div').addClass('checked').parent('td').parent('tr').addClass('check');
                $("#content div.checkbox input[type='checkbox']:not(:checked)").parent('div').removeClass('checked').parent('td').parent('tr').removeClass('check');
            }) 
        //--------------------------------------
            $("#content div.checkbox_all input[type='checkbox']").change(function(){
                $("#content div.checkbox_all input[type='checkbox']:checked").val(1);
                $("#content div.checkbox_all input[type='checkbox']:not(:checked)").val(0);
                
                if ($("#content div.checkbox_all input[type='checkbox']").val()==1)
                    {
                        $("#content tr").addClass('check');
                        $("#content tr:first-child").removeClass('check');
                        $("#content tr td div").addClass('checked');
                    }
                if($("#content div.checkbox_all input[type='checkbox']").val()==0)
                    {
                        $("#content tr").removeClass('check');
                        $("#content tr td div").removeClass('checked');
                    }
                   
               }) 
        });
        
          /*  
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
         */   
        $(function() {
            $( "#remove" ).click(function() {
                $( "#dialog-remove" ).dialog({
                    modal: true,
                    height: 200,
                    buttons: {
                        "YES": function(){
                            $("#content .check").slideUp('fast');
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
            if ($('#hidden input[name=hide]').val()==1)
            {
                $('.left_menu').attr({style: ''});
                $('.menu_button.first.left').removeClass('left');
                $('.menu_button.second.left').removeClass('left');
                $('#nav.nav_left').attr({id: 'nav',class: 'nav_right'});
                $('#hidden input[name=hide]').val(0);
            }
            else 
            {
                $('.left_menu').attr({style: 'display:none'});
                $('.menu_button.first').addClass('left');
                $('.menu_button.second').addClass('left');
                $('#nav.nav_right').attr({id: 'nav',class: 'nav_left'});
                $('#hidden input[name=hide]').val(1);
            }
        }
    </script>
    <div id="dialog-remove" style="display: none">
        Are you sure want delete rows?
    </div>
    <?php if (isset($_GET) && !empty($_GET)): ?>
        <?php if (isset($_GET['database']) && !empty($_GET['database'])): ?>
            <table id='table'>
                <tr>
                    <td class='left_menu' bgcolor='#002F32'>   
                            <table>
                                <tr>
                                    <td class='database_title' colspan=2>database "<?php echo $_GET['database'] ?>"</td>
                                </tr>
                                <?php while ($row = mysql_fetch_array($all_tables)): ?>
                                    <tr>
                                        <td><div class="icon table"></div></td>
                                        <?php for ($i = 0; $i < mysql_num_fields($all_tables); $i++): ?>
                                            <?php $count_field = mysql_query("SELECT * FROM " . $_GET['database'] . '.' . $row[mysql_field_name($all_tables, $i)]); ?>
                                            <td><a href='/grid/tables?database=<?php echo $_GET['database'] ?>&table=<?php echo $row[mysql_field_name($all_tables, $i)] ?>'>
                                                <?php echo $row[mysql_field_name($all_tables, $i)].' (<i>' . mysql_num_fields($count_field) . '</i>)'; ?></a></div></td>
                                        <?php endfor; ?>
                                <?php endwhile; ?>
                                </tr>
                            </table>
                    </td>
                    <?php if (isset($_GET['table']) && !empty($_GET['table'])): ?>
                        <td id='content'>
                            <table>
                                <tr>
                                    <td bgcolor='#002F32'><div class="icon checkbox_all"><input type='checkbox'></div></td><td bgcolor='#002F32'>#</td>
                                    <?php for ($i = 0; $i < mysql_num_fields($result); $i++): ?>
                                        <td bgcolor='#002F32' name='<?php echo $i ?>'><div class='resize'><?php echo mysql_field_name($result, $i); ?></div></td>
                                    <?php endfor; ?>
                                </tr>
                                <?php $j = 1;?>
                                <?php while ($row = mysql_fetch_array($result)):?>
                                    <tr>
                                        <td><div class="icon checkbox"><input type='checkbox' value=""></div></td>
                                        <td class='id'><?php echo $j ?></td>
                                        <?php for ($i = 0; $i < mysql_num_fields($result); $i++): ?>
                                            <td><?php echo $row[mysql_field_name($result, $i)] ?></td>
                                        <?php endfor; ?>
                                    </tr>
                                <?php $j++; ?>
                                <?php endwhile; ?>
                            </table>
                        </td>
                    <?php endif; ?>
                    <td class="menu_button first">
                        <table>
                            <tr>
                                <td>
                                    <a href="">
                                        <div class="icon home"></div>
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <a href="">
                                        <div class="icon reload"></div>
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <a href="">
                                        <div class="icon help"></div>
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <a href="">
                                        <div class="icon exit"></div>
                                    </a>
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td class="menu_button second">
                        <table>
                            <tr>
                                <td>
                                    <a href="">
                                        <div class="icon add"></div>
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <a href="">
                                        <div class="icon edit"></div>
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <a href="" id="remove" onclick="return false;">
                                        <div class="icon delete"></div>
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <a href="">
                                        <div class="icon save"></div>
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <a href="">
                                        <div class="icon search"></div>
                                    </a>
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td id="nav" class="nav_right">
                        <input type="button" name="nav" onclick="display_menu();"/>
                    </td>
    <?php endif; ?>
            </tr>
        </table>
        <div id="hidden">
            <input type="hidden" name="hide"/>
        </div>
    <?php endif; ?>
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

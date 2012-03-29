<body>
    <script language="javascript">
        $(document).ready(function() {
            $(".resize").resizable({ 
                handles: 'e'
            });
            //--------------------------------------
            $("td.checkbox_one input[type='checkbox']").change(function(){
                $("#content div.checkbox input[type='checkbox']:checked").parent('div').addClass('checked').parent('td').parent('tr').addClass('check');
                $("#content div.checkbox input[type='checkbox']:not(:checked)").parent('div').removeClass('checked').parent('td').parent('tr').removeClass('check');
            }) 
            //--------------------------------------
            $("td.checkbox_all input[type='checkbox']").change(function(){
                $("#content div.checkbox_all input[type='checkbox']:checked").val(1);
                $("#content div.checkbox_all input[type='checkbox']:not(:checked)").val(0);
                
                if ($("td.checkbox_all input[type='checkbox']").val()==1)
                {
                    $("#content tr").addClass('check');
                    $("#content tr:first-child").removeClass('check');
                    $("#content tr td div").addClass('checked');
                }
                if($("td.checkbox_all input[type='checkbox']").val()==0)
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
    <script>        
        function delete_db(db_name){
            $.ajax({
                type: "POST",
                dataType: "json",
                url: '<?php echo site_url('db/delete') ?>',
                data: "database_name="+db_name,
                success: function(response){
                    //change on something
                    alert(response);
                    $('.db_'+db_name).empty();
                }
            });
        }
    </script>
    <script>        
        function delete_table(db_name, table_name){
            $.ajax({
                type: "POST",
                dataType: "json",
                url: '<?php echo site_url('tables/delete') ?>',
                data: "database_name="+db_name+
                    "&table_name="+table_name,
                success: function(response){
                    //change on something
                    alert(response);
                    $('.db_'+table_name).empty();
                }
            });
        }
    </script>
    <script>    
        //I need to do THAT !!!
        function edit_db(db_name){
            //$('#database-form').attr("title","Edit Database");
            $('input[type=hidden].db').val(db_name);
            $( "#database-form" ).dialog( "open" );
        }
    </script>
    <script>    
        //I need to do THAT !!!
        function edit_table(db_name, table_name){
            $('input[type=hidden].db').val(db_name);
            $('input[type=hidden].tables').val(table_name);
            $('#db').hide();
            $('label[for=db]').hide();
            $('#count').hide();
            $('label[for=count]').hide();
            $( "#table-form" ).dialog( "open" );
        }
    </script>
    <script>
        jQuery(document).ready(function(){
            $('#accordion .head').click(function() {
                $(this).next().toggle();
                return false;
            }).next().hide();
        });
    </script>
    <div id="dialog-remove" style="display: none">
        Are you sure want delete rows?
    </div>
    <div class="navbar navbar-fixed-top">
        <div class="navbar-inner">
            <div class="container">
                
                <a class="brand" href="<?php echo site_url('grid')?>">
                     <i class="icon-leaf icon-white"></i>
                     <!--<img src="/image/heart.png"/>
                     &nbsp;-->
                     DBGrid
                </a>
                
                <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                
                <div class="nav-collapse">
                    <ul class="nav">
                        <li class="">
                            <a href="<?php echo site_url('grid')?>">
                                <i class="icon-home icon-white"></i>
                                &nbsp;Home
                            </a>
                        </li>
                        <li class="">
                            <a href="<?php echo site_url('grid')?>">
                                <i class="icon-repeat icon-white"></i>
                                &nbsp;Reload
                            </a>
                        </li>
                        <li class="">
                            <a href="<?php echo site_url('help')?>">
                                <i class="icon-flag icon-white"></i>
                                &nbsp;Help
                            </a>
                        </li>
                        <li class="">
                            <a href="<?php echo site_url('grid/logout')?>">
                                <i class="icon-off icon-white"></i>
                                &nbsp;LogOut
                            </a>
                        </li>
                    </ul>
                </div>
                
            </div>
        </div>
    </div>
    <div class="container">
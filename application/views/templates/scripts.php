<body>
    <script language="javascript">
        $(document).ready(function() {
            $(".resize").resizable({ 
                handles: 'e'
            });
            //-----------------------------
        });
    </script>
    <script>
    function get_theme(theme){
        $.ajax({
                type: "POST",
                dataType: "json",
                url: '<?php echo site_url('grid/save_theme') ?>',
                data: "theme="+theme,
                success: function(response){
                    //change on something
                    alert(response);
                    location.reload();
                }
            });
    }
    </script>
    <script>
      
        function add_row(db_name, table_name, count){
        
            var td;
            for (i=1;i<=count;i++)
            {
                td += "<td></td>";
            }
            $('table.table-striped').append(
            '<tr><td class="check_one"><input type="checkbox"></td>'+td+'</tr>'
        );
                            
            $.ajax({
                type: "POST",
                dataType: "json",
                url: '<?php echo site_url('rows/add') ?>',
                data: "database_name="+db_name+
                    "&table_name="+table_name+
                    // "&count="+count+
                fields,
                success: function(response){
                    //change on something
                    alert(response);
                    $('.db_'+db_name).empty();
                }
            });
        };
           
    </script>
    <script>
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
    <script>
        function open_dropdown(class_name){
            $('.btn-group').removeClass('open');
            $('.btn-group .'+class_name).parent('a').parent('div').addClass('open');
            return false;
        }
    </script>
    <div class="navbar navbar-fixed-top">
        <div class="navbar-inner">
            <div class="container">

                <a class="brand" href="<?php echo site_url('grid') ?>">
                    <i class="icon-leaf icon-white"></i>
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
                            <a href="<?php echo site_url('grid') ?>">
                                <i class="icon-home icon-white"></i>
                                &nbsp;Home
                            </a>
                        </li>
                        <li class="">
                            <a href="<?php echo site_url('grid') ?>">
                                <i class="icon-repeat icon-white"></i>
                                &nbsp;Reload
                            </a>
                        </li>
                        <li class="">
                            <a href="<?php echo site_url('help') ?>">
                                <i class="icon-flag icon-white"></i>
                                &nbsp;Help
                            </a>
                        </li>
                        <li class="">
                            <a href="<?php echo site_url('grid/logout') ?>">
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
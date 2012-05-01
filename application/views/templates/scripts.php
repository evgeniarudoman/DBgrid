<body>
    <div id="ajax-loading-left" style="display:none;">
        <img src="/image/ajax-loader.gif"/>
    </div>
<body>
    <div id="ajax-loading-right" style="display:none;">
        <img src="/image/ajax-loader.gif"/>
    </div>
    <script language="javascript">
        $(document).ready(function() {
            //-----------------------------
            $("div.resize").resizable({ 
                handles: "e, w",
                stop: function() {
                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: '<?php echo site_url ('fields/save_width') ?>',
                        data: "database_name="+'<?php
if (isset ($_GET['database']))
    echo $_GET['database']
    ?>'+
                            "&table_name="+'<?php
if (isset ($_GET['table']))
    echo $_GET['table']
    ?>'+
                            "&field_name="+$(this).children('input[type=hidden]').val()+
                            "&field_size="+$(this).width(),
                        success: function(response){
                            //change on something
                            //alert(response);
                            $('th.header')
                        }
                    });
                }
            });
            //-----------------------------
        });
    </script>
    <script>
        function get_theme(theme){
            $.ajax({
                type: "POST",
                dataType: "json",
                url: '<?php echo site_url ('grid/save_theme') ?>',
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
                url: '<?php echo site_url ('rows/add') ?>',
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
            $('input[type=hidden].db').val(db_name);
            $( "#database-remove" ).dialog( "open" );
        }
    </script>
    <script>        
        function delete_table(db_name, table_name){
            $('input[type=hidden].db').val(db_name);
            $('input[type=hidden].tables').val(table_name);
            $( "#table-remove" ).dialog( "open" );
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
            $('input#table-e').val(table_name);
            $( "#table-edit-form" ).dialog( "open" );
        }
    </script>
    <script>
        jQuery(document).ready(function(){
            $('#accordion .head').click(function() {
                $(this).next().toggle();
                return false;
            }).next().hide();
            
<?php if (isset ($_GET['database']) && !empty ($_GET['database'])): ?>
            $('table#tables[name=<?php echo $_GET['database'] ?>]').show();
    <?php if (isset ($_GET['table']) && !empty ($_GET['table'])): ?>
                    $('table#tables[name=<?php echo $_GET['database'] ?>] tr[name=<?php echo $_GET['table'] ?>]').attr('style','background-color:#EFF1F1;');
    <?php endif; ?>
<?php endif; ?>
    });
    </script>

    <script>
        $(document).ready(function() {
            $('.wells input.input-small').change(function(){
                alert(this.name+' = '+$(this).val());
               
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: '<?php echo site_url ('rows/add') ?>',
                    data: "database_name="+db_name+
                        "&table_name="+table_name,
                    success: function(response){
                        //change on something
                        alert(response);
                        $('.db_'+table_name).empty();
                    }
                });
            
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('i.icon-pencil').click(function(){
                if ($("td.check_one input:checked").val() == 'on')
                {                    
                    if($("td.check_one input:checked").length == 1)
                    {
                        var $inputs = $("td.check_one input:checked").parent('td');
                        var $name = $("th div.resize");
                        var row = '';
                        var hidden = '';
                    
                        $inputs.each(function() {
                            var $rows = $(this).siblings();
                            $rows.each(function(j) {
                                row = $(this).text();
                                $name.each(function(z) {
                                    if (z == j)
                                    {
                                        if($('div#row-form input[type=text][name='+$(this).attr("name")+']').length == 1)
                                        {
                                            $('div#row-form input[type=text][name='+$(this).attr("name")+']').val(row);
                                            hidden += "&old_input_"+$(this).attr("number")+'='+row;
                                        }
                                    
                                        if($('div#row-form textarea[name='+$(this).attr("name")+']').length == 1)
                                        {
                                            $('div#row-form textarea[name='+$(this).attr("name")+']').val(row);
                                            hidden += "&old_textarea_"+$(this).attr("number")+'='+row;
                                        }
                                        
                                        if($('div#row-form select[name='+$(this).attr("name")+']').length == 1)
                                        {
                                            $('div#row-form select[name='+$(this).attr("name")+']').val(row);
                                            hidden += "&old_select_"+$(this).attr("number")+'='+row;
                                        }
                                    
                                        if($('#row-form input[type=hidden][file='+$(this).attr("name")+']').length == 1)
                                        {
                                            $('#row-form input[type=hidden][file='+$(this).attr("name")+']').val(row);
                                            hidden += "&old_file_"+$(this).attr("number")+'='+row;
                                        }
                    
                                        if($('div#row-form input[type=checkbox][name='+$(this).attr("name")+']').length >= 1)
                                        {
                                            if (row == 1)
                                                $('div#row-form input[type=checkbox][name='+$(this).attr("name")+']').attr('checked','checked');
                                            else
                                                $('div#row-form input[type=checkbox][name='+$(this).attr("name")+']').removeAttr('checked');
                                            hidden += "&old_checkbox_"+$(this).attr("number")+'='+row;    
                                        }
                                    
                                        var img = $("td.check_one input:checked").parent('td').parent('tr').children('td').children('img').attr('src');
                                        if (img != '')
                                        {
                                            $('input.photo100').val(img);
                                            $('div#row-form img').show().parent('td').prev().hide();
                                            $('div#row-form img.img').attr('src', img);
                                        }
                                    
                                        $('input[type=hidden].rows').val(hidden);    
                                    }   
                                });
                            });
                        });
                    
                        $('input[type=hidden].db').val('<?php
if (isset ($_GET['database']))
    echo $_GET['database']
    ?>');
                                            
                        $( "#row-form" ).dialog( "open" );                    
                    }
                    else
                    {
                        alert('Выбрана больше чем 1 запись на редактирование.');
                    }
                }
            })
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#tabs-2 i.icon-trash').click(function(){
                if ($("#tabs-2 td.check_one input:checked").val() == 'on')
                { 
                    $( "#dialog-remove" ).dialog( "open" );
                }
            });
            
            //----------------------
            
            $('#tabs-1 i.icon-trash').click(function(){
                if ($("td.check_one input:checked").val() == 'on')
                { 
                    $( "#remove-field" ).dialog( "open" );
                }
            });
            
            //----------------------
            
            $('html').click(function(){
                if ($('div.open').length == 1)
                    $('div.open').removeClass('open');
            });
            
            //----------------------
            
            $('a.dropdown-toggle').click(function(){
                if ($('div.open').length == 1)
                {
                    $('div.open').removeClass('open');
                }
                else
                {
                    $('.btn-group').removeClass('open');
                    $(this).parent('div').addClass('open');
                }
                return false;
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            //-----------------------------------------------
            $('div#pages input').change(function(){
                var limit = $('div#pages select option:selected').text();
                var offset = ($('div#pages input').val()*limit)-limit;
                
                paging(offset, limit);
                
                return false;
            });
            //-----------------------------------------------
            $('div#pages select').change(function(){
                var limit = $('div#pages select option:selected').text();
                var offset = ($('div#pages input').val()*limit)-limit;
                
                paging(offset, limit);
                
                return false;
            });
            //-----------------------------------------------
            $('a.previous-page').click(function(){
                if ($('div#pages input').val() > 1)
                {
                    var limit = $('div#pages select option:selected').text();
                    var offset = (($('div#pages input').val()-1)*limit)-limit;
                                
                    $('div#pages input').val($('div#pages input').val()-1)
                                
                    paging(offset, limit);                      
                }      
                return false;
            });
            //-----------------------------------------------
            $('a.next-page').click(function(){
                if ($('a.next-page:disabled').length == 0)
                { 
                    alert($('a.next-page:disabled').length);
                    var limit = $('div#pages select option:selected').text();
                    var offset = ((Number($('div#pages input').val())+1)*limit)-limit;
                                
                    $('div#pages input').val(Number($('div#pages input').val())+1)
                                
                    paging(offset, limit);
                }
                return false;
            });
                
            //-----------------------------------------------
            function paging(offset, limit){
                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url ('rows/select') ?>",
                    dataType: "html",
                    data: "database_name="+'<?php
if (isset ($_GET['database']))
    echo $_GET['database']
    ?>'+
                        "&table_name="+'<?php
if (isset ($_GET['table']))
    echo $_GET['table']
    ?>'+
                        "&offset="+offset+
                        "&limit="+limit,
                    success: function(res) {
                        $('#ajax-page').html(res);
                    }
                });
            }
        });
    </script>
    <?php
    if (isset ($_GET['database']))
        $database = $_GET['database'];
    else
        $database = NULL;
    ?>
    <?php
    if (isset ($_GET['table']))
        $table    = $_GET['table'];
    else
        $table    = NULL;
    ?>
    <script>
        function search_by(){ 
            $.ajax({
                type: "POST",
                dataType: "html",
                url: '<?php echo site_url ('ajax/search?database_name=') . $database . '&table_name=' . $table . '&term=' ?>'+$('#prependedInput').val(),
                success: function(response){
                    $('#ajax-page').html(response);
                }
            });
        }
    </script>

    <script>
        $(document).ready(function(){
            $('input[type=checkbox]').click(function(){ 
                if ($(this).is(':checked'))
                {
                    $(this).parent('td').parent('tr').children('td').attr('style','background-color:#EFF1F1;text-shadow: 0 1px 0 #FFFFFF;  color: #005580;');
                }
                else
                {
                    $(this).parent('td').parent('tr').children('td').removeAttr('style');
                }
            });
            //---------------------------------------------------------------------
            $('#ajax-page td.edit_one i.icon-pencil').click(function(){
                var name = $(this).attr('name');
                $('tr.edit'+name).show();
                $('tr.real'+name).hide();
                $('div.save-changes').show();
            });
            //---------------------------------------------------------------------
            $('input[type=checkbox].check_all').click(function(){ 
                if ($(this).is(':checked'))
                {
                    $('input[type=checkbox]').attr('checked','checked').parent('td').parent('tr').children('td').attr('style','background-color:#EFF1F1;text-shadow: 0 1px 0 #FFFFFF;  color: #005580;');
                }
                else
                {
                    $('input[type=checkbox]').removeAttr('checked').parent('td').parent('tr').children('td').removeAttr('style');
                }
            });
        });
    </script>

    <script>
        $(document).ready(function() 
        { 
            $("#myTable").tablesorter(); 
        } 
    ); 
    </script>

    <script>
        function cancel_img(){
            $('input[name=attachment]').val('');
            $('input.photo100').val('');
            $('div#row-form img').hide().parent('td').prev().show();
        }
    </script>

    <style>
        table.tablesorter {
            margin:10px 0pt 15px;
            font-size: 8pt;
            text-align: left;
            background-color: #e6EEEE;
        }
        table.tablesorter thead tr th, table.tablesorter tfoot tr th {
            background-color: #e6EEEE;
            font-size: 8pt;
            padding: 4px;
        }

        table.tablesorter tr th{
            background-color: #e6EEEE;
            font-size: 8pt;
            padding: 4px;
        }
        table.tablesorter thead tr .header {
            background-image: url(/image/bg.gif);
            background-repeat: no-repeat;
            background-position: center right;
            cursor: pointer;
        }
        table.tablesorter tbody td {
            color: #3D3D3D;
            padding: 4px;
            background-color: #FFF;
            vertical-align: top;
        }
        table.tablesorter tbody tr.odd td {
            background-color:#F0F0F6;
        }
        table.tablesorter thead tr .headerSortUp {
            background-image: url(/image/asc.gif);
        }
        table.tablesorter thead tr .headerSortDown {
            background-image: url(/image/desc.gif);
        }
        table.tablesorter thead tr .headerSortDown, table.tablesorter thead tr .headerSortUp {
            background-color: #08c;
            color:white;
        }

    </style>

    <div class="navbar navbar-fixed-top">
        <div class="navbar-inner">
            <div class="container">
                <a class="brand" href="<?php echo site_url ('grid') ?>" title="DBGrid">
                    <i class="icon-leaf icon-white"></i>
                    DBGrid
                </a>

                <div class="nav-collapse">
                    <ul class="nav">
                        <li class="" title="Главная">
                            <a href="<?php echo site_url ('grid') ?>">
                                <i class="icon-home icon-white"></i>
                                &nbsp;Главная
                            </a>
                        </li>
                        <li class="" title="Обновить">
                            <a href="">
                                <i class="icon-repeat icon-white"></i>
                                &nbsp;Обновить
                            </a>
                        </li>
                        <li class="" title="Помощь">
                            <a href="<?php echo site_url ('help') ?>">
                                <i class="icon-flag icon-white"></i>
                                &nbsp;Помощь
                            </a>
                        </li>
                        <li class="" title="Выйти">
                            <a href="<?php echo site_url ('grid/logout') ?>">
                                <i class="icon-off icon-white"></i>
                                &nbsp;Выйти
                            </a>
                        </li>
                    </ul>
                </div>

            </div>
        </div>
    </div>
    <div class="container">
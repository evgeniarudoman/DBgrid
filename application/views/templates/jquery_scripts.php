<script>
    $(function() {  
        $( "#dialog:ui-dialog" ).dialog( "destroy" );
        
        $( "#create-database" ).click(function() {
            $( "#database-form" ).dialog( "open" );
        });
        
        $( "#remove" ).click(function() {
            $( "#dialog-remove" ).dialog( "open" );
        });
        
        $( "#create-table" ).click(function() {
            $.ajax({
                type: "POST",
                dataType: "json",
                url: '<?php echo site_url ('db/select'); ?>',
                success: function(types){
                    var options="";
                    
                    $.each( types, function(k, val){
                        options+=  "<option value='"+val.key+"'>"+val.key+"</option>";
                    });
                    
                    $( "div#table-form form.table-form select" ).html(
                    "<option value='' selected='selected'> -- выбрать базу данных -- </option>"+
                        options);
                }
            });
            
            $( "#table-form" ).dialog( "open" );
        });
        
        $( "#add-row" ).click(function() {
            $( "#row-form" ).dialog( "open" );
        });
        
        $( "#add-field" ).click(function() {
            $( "#field-form" ).dialog( "open" );
        });
		
        // announcement variables
        var table = $( "#table" )
        var count = $( "#count" )
        var db = $( "#db" )
        var database= $( "#database" ),
        allFields = $( [] ).add( db ).add( table ).add( count ).add( database ),
        tips = $( "p.validateTips" );
        
        // @function Highlight error
        // param t - field
        function updateTips( t ) {
            tips
            .html('<div class="ui-widget"><div class="ui-state-error ui-corner-all" style="padding: 0 .7em;"><p><span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span><strong></strong> '+t+'</p></div></div>')
            //.addClass('alert alert-error')#B94A48 #EED3D7 #F2DEDE
            setTimeout(function() {
                tips.removeClass( "ui-state-highlight", 1500 );
            }, 500 );
        }

        // @function Check length of field
        // @param o - field
        // @param n - name of field
        // @param min - min length
        // @param max - max length
        function checkLength( o, n, min, max ) {
            if ( o.val().length > max || o.val().length < min ) {
                //o.addClass( "ui-state-error" );
                updateTips( "Length of " + n + " must be between " +
                    min + " and " + max + "." );
                return false;
            } else {
                return true;
            }
        }

        // @function Check regular expressions
        // @param o - field
        // @param regexp - regular expression
        // @param n - name of field
        function checkRegexp( o, regexp, n ) {
            if ( !( regexp.test( o.val() ) ) ) {
                //o.addClass( "ui-state-error" );
                updateTips( n );
                return false;
            } else {
                return true;
            }
        }
        
        // @function Check on emptiness
        // @param o - field
        // @param n - name of field
        function checkEmpty( o, n ) {
            if ( o.val() == "" ) {
                //o.addClass( "ui-state-error" );
                updateTips( n );
                return false;
            } else {
                return true;
            }
        }
	
        // modal of creating new database
        $( "#database-form" ).dialog({
            autoOpen: false,
            height: 300,
            width: 400,
            modal: true,
            buttons: {
                "Create": function() {
                    var bValid = true;

                    bValid = bValid && checkEmpty( database, "Поле имени базы данных не должно быть пустым.");
                    bValid = bValid && checkRegexp( database, /^[a-zа-я]([a-zа-я_])+$/i, "Поле имени базы данных должно содержать буквы, нижнее подчерквание и начинаться с букв." );
                   
                    if ( bValid ) {
                        
                        if ( $('input[type=hidden].db').val() == 0) 
                        {
                            $( "ul.nav.nav-list" ).append( "<li class='active head'>" +
                                "<a href='#'>"+"<i class='icon-list-alt icon-white'></i>"+"&nbsp;"+
                                database.val()+
                                "<i onclick='delete_db(\""+database.val()+"\");' title='Удалить базу данных' class='icon-trash icon-white' style='float:right;'></i>"+
                                "</a></li>"+
                                "<table id='tables' name='"+database.val()+"' style='margin-left: 15px;height: 30px;width:100%;'>"+
                                "<tr>"+"<td style='width: 20px;'><i class='icon-th'></i></td>"+"<td><i>No tables.</i></td>"+"</tr>"
                        ); 
                                
                            // add new database by ajax
                            $.ajax({
                                type: "POST",
                                url: '<?php echo site_url ('db/add'); ?>',
                                data: "database_name="+database.val(),
                                success: function(response){
                                    //change on something
                                    alert(response);
                                }
                            })
                        }
                        else
                        {
                            $( "ul.nav.nav-list" ).append( "<li class='active head'>" +
                                "<a href='#'>"+"<i class='icon-list-alt icon-white'></i>"+
                                database.val()+
                                "<i onclick='delete_db('data');' class='icon-trash icon-white' style='float:right;'></i>"+
                                "<i onclick='edit_db('data');' class='icon-pencil icon-white' style='float:right;'></i>"+
                                "</a>");
                                
                            // add new database by ajax
                            $.ajax({
                                type: "POST",
                                url: '<?php echo site_url ('db/rename'); ?>',
                                data: "new_name="+database.val()+
                                    "&database_name="+$('input[type=hidden].db').val(),
                                success: function(response){
                                    //change on something
                                    alert(response);
                                }
                            });
                            
                            $('input[type=hidden].db').val(0);
                        }
                        
                        $( this ).dialog( "close" );
                    }
                },
                Cancel: function() {
                    $( this ).dialog( "close" );
                }
            },
            open: function() {
                $('#database-form div.ui-widget').empty();
                allFields.val("");
            }
        });
        // end of creating new database
          
        // modal of creating new field
        $( "#row-form" ).dialog({
            autoOpen: false,
            height: 380,
            width: 400,
            modal: true,
            buttons: {
                "Add": function() {
                    var bValid = true;

                    var $inputs = $('#row-form input');

                    var fields = '';
                    var values = '';
                    var td;
                    
                    $inputs.each(function(i) {
                        fields += '&field'+i+'='+this.name;
                        values += '&value'+i+'='+$(this).val();
                        td += '<td>'+$(this).val()+'</td>';
                    });
                    
                    if ( $('input[type=hidden].db').val() == 0) 
                    {
                        // add new database by ajax
                        $.ajax({
                            type: "POST",
                            dataType: "json",
                            url: '<?php echo site_url ('rows/add'); ?>',
                            data: "database_name="+"<?php if (isset ($_GET['database'])) echo $_GET['database'] ?>"+
                                "&table_name="+"<?php if (isset ($_GET['table'])) echo $_GET['table'] ?>"+
                                fields+values+
                                "&count="+$inputs.length,
                            success: function(response){
                                //change on something
                                alert(response);
                            
                                $('table.table-striped').append(
                                '<tr><td class="check_one"><input type="checkbox"></td>'+td+'</tr>'
                            );
                            }
                        });
                    }
                    else
                    {
                        $.ajax({
                            type: "POST",
                            dataType: "json",
                            url: '<?php echo site_url ('rows/edit'); ?>',
                            data: "database_name="+"<?php if (isset ($_GET['database'])) echo $_GET['database'] ?>"+
                                "&table_name="+"<?php if (isset ($_GET['table'])) echo $_GET['table'] ?>"+
                                fields+values+
                                "&count="+$inputs.length+
                                $('input[type=hidden].rows').val(),
                            success: function(response){
                                //change on something
                                alert(response);
                                
                                if ($("td.check_one input:checked").val() == 'on')
                                {
                                    $inputs.each(function() {
                                        $("td.check_one input:checked").parent('td').siblings().text($(this).val());
                                    });
                                }
                            }
                        });
                        
                        $('input[type=hidden].db').val(0)
                    }
                    $( this ).dialog( "close" );
                    
                },
                Cancel: function() {
                    $( this ).dialog( "close" );
                }
            },
            close: function() {
                allFields.val( "" ).removeClass( "ui-state-error" );
            }
        });
        // end of creating new field
        
        // modal of creating new field
        $( "#field-form" ).dialog({
            autoOpen: false,
            height: 380,
            width: 400,
            modal: true,
            buttons: {
                "Add": function() {
                    var bValid = true;
                    allFields.removeClass( "ui-state-error" );
                    var val = $('input[name=field_name]').val();
                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: '<?php echo site_url ('fields/add'); ?>',
                        data: "database_name="+"<?php if (isset ($_GET['database'])) echo $_GET['database'] ?>"+
                            "&table_name="+"<?php if (isset ($_GET['table'])) echo $_GET['table'] ?>"+
                            "&field_name="+val+
                            "&type="+$('select[name=type] option:selected').val()+
                            "&size="+$('input[name=size]').val(),
                        success: function(response){
                            //change on something
                            alert(response);
                            
                            $('table#myTable thead tr').append(
                            '<th class="header" style="width:60px;position:relative;" onclick="$(\'.caret#up\').hide();$(\'.caret#down\').show();return false;"><div class="resize" name="'+val+'">'+val+'<input type="hidden" value="'+val+'"><input type="hidden" name="sorting" value="0"></div></th>'
                        );
                            var select = $('select[name=type] option:selected').val();
                        
                            if(select == 'дата')
                                var data = '<input type="text" class="datepicker" style="width:65px;height:10px;" value="00/00/0000"/>';
                            else if(select == 'файл')
                                var data = 'FILE';
                            else if(select == 'чекбокс')
                                var data = '<input type="checkbox"/>';
                            else if(select == 'список')
                                var data = '<select name="select" class="text ui-widget-content ui-corner-all"><option value="" selected="selected"> -- choose database -- </option></select>';
                            else if(select == 'переключатель')
                                var data = '<input type="radio" name="'+val+'"/>';
                            
                            $('table#myTable tbody tr').append(
                            '<td onclick="$(this).datepicker();">'+data+'</td>'
                        );
                        }
                    });
                        
                    $( this ).dialog( "close" );
                    
                },
                Cancel: function() {
                    $( this ).dialog( "close" );
                }
            },
            close: function() {
                allFields.val( "" ).removeClass( "ui-state-error" );
            }
        });
        // end of creating new field
         
        // modal of creating new table
        $( "#table-form" ).dialog({
            autoOpen: false,
            height: 390,
            width: 400,
            modal: true,
            buttons: {
                "Create": function() {
                    var bValid = true;
                    var fValid = false;
                    
                    bValid = bValid && checkEmpty( table, "Поле имени таблицы не должно быть пустым.");
                    bValid = bValid && checkRegexp( table, /^[a-zа-я]([a-zа-я_])+$/i, "Поле имени таблицы должно содержать буквы, нижнее подчерквание и начинаться с букв." );
                        
                    if ( $('input[type=hidden].tables').val() == 0) 
                    {
                        bValid = bValid && checkEmpty( count, "Поле количество полей не должно быть пустым.");
                        bValid = bValid && checkRegexp( count, /^[0-9]+$/i, "Поле количество полей должно содержать только цифры." );
                        bValid = bValid && checkEmpty( db, "Поле имени базы данных не должно быть пустым.");                    

                    
                        if ( bValid ) 
                        {
                            if ( $('input[type=hidden].valid').val() == 'true') 
                            {
                                $( "div#table-form form.field-form table" ).append( 
                                "<tr><td><p>Ключ</p></td><td><p>Имя поля</p></td><td><p>Тип</p></td><td><p>Размер поля</p></td></tr>");
                            
                                var i;
                                for (i=1;i<=count.val();i++)
                                {
                                    $( "div#table-form form.field-form table" ).append(
                                    "<tr><td><input type='radio' name='check' id='check' value='"+i+"' class='field ui-widget-content ui-corner-all'></td>"+
                                        "<td><input type='text' name='field"+i+"' id='field"+i+"' style='width:100px;' class='field ui-widget-content ui-corner-all'></td>"+
                                        "<td><select name='type"+i+"' id='type"+i+"' style='width:150px;' class='text ui-widget-content ui-corner-all'>"+
                                        "<option value='' selected='selected'> -- выбрать тип -- </option>"+
                                        "</select></td>"+
                                        "<td><input type='text' name='size"+i+"' id='size"+i+"' class='field ui-widget-content ui-corner-all'></td></tr>");
                                
                                    $('input[type=hidden].valid').val('false');
                                }
                            
                                // get type from db
                                $.ajax({
                                    type: "POST",
                                    dataType: "json",
                                    url: '<?php echo site_url ('tables/get_type'); ?>',
                                    success: function(types){
                                        $.each( types, function(k, val){
                                            $( "div#table-form form.field-form select" ).append(
                                            "<option value='"+val.key+"'>"+val.key+"</option>"); 
                                        });
                                    }
                                })
                            }
                            if ($('div#table-form form.table-form fieldset').length == 0){
                                var fValid = true;
                                for (i=1;i<=count.val();i++)
                                {
                                    fValid = fValid && checkEmpty( $('input[name=field'+i+']'), "Имя поля #"+i+" не должно быть пустым.");
                                    fValid = fValid && checkEmpty( $('select[name=type'+i+']'), "Выберите тип для поля #"+i+".");
                                    fValid = fValid && checkEmpty( $('input[name=check]'), "Вы должны выбрать начальный ключ нажатием радиокнопки.");
                                    fValid = fValid && checkRegexp( $('input[name=size'+i+']'), /^[0-9]+$/i, "Размер поля должен содержать только числа." );
                                }
                            }
                            else
                            {
                                $('#table-form div.ui-widget').empty();
                            }
                            $('div#table-form form.table-form').empty();
                            $('div#table-form form.field-form').show();
                        }
                        if (fValid) 
                        {
                            var fields = '';
                            var types = '';
                            var sizes = '';
                        
                            for (i=1;i<=count.val();i++)
                            {
                                fields += "&field"+i+"="+$('input#field'+i).val();
                                types += "&type"+i+"="+$('#type'+i+' option:selected').text();
                                sizes += "&size"+i+"="+$('input#size'+i).val();
                            }
                        
                            // add table and fields by ajax
                            $.ajax({
                                type: "POST",
                                dataType: "json",
                                url: '<?php echo site_url ('tables/add'); ?>',
                                data: "table_name="+table.val()+
                                    "&count="+count.val()+
                                    "&database="+db.val()+
                                    "&radio="+$('input#check:checked').val()+
                                    fields+types+sizes,
                                success: function(response){
                                    //change on something
                                    alert(response);
                                    
                                    $( "li.head[name=<?php if (isset ($_GET['database'])) echo $_GET['database']; ?>]").next().append( "<tr>" +
                                    "<td style='width:20px;'>"+"<i class='icon-th'></i>"+"</td>"+
                                    "<td style='width:247px'>"+"<a href='/grid/index?database=<?php if (isset ($_GET['database'])) echo $_GET['database']; ?>"+"&table="+table.val()+"'>" + table.val() + "</td>" +
                                    '<td style="width:20px"><i class="icon-pencil" title="Переименовать таблицу" style="cursor: pointer;" onclick="edit_table(\"<?php if (isset ($_GET['database'])) echo $_GET['database']; ?>\", \"<?php if (isset ($_GET['table'])) echo $_GET['table']; ?>\");"></i></td><td><i class="icon-trash" title="Удалить таблицу" style="cursor: pointer;" onclick="delete_table(\"<?php if (isset ($_GET['database'])) echo $_GET['database']; ?>\", \"<?php if (isset ($_GET['table'])) echo $_GET['table']; ?>\");"></i></td>'+
                                    "</tr>" );
                                }
                            });
                            
                            $( this ).dialog( "close" );
                        }
                    }
                    else
                    {
                        $.ajax({
                            type: "POST",
                            url: '<?php echo site_url ('tables/rename'); ?>',
                            data: "new_name="+table.val()+
                                "&database_name="+$('input[type=hidden].db').val()+
                                "&table_name="+$('input[type=hidden].tables').val(),
                            success: function(response){
                                //change on something
                                alert(response);
                            }
                        });
                        
                        $('input[type=hidden].db').val(0);
                        $( this ).dialog( "close" );
                    }
                },
                Cancel: function() {
                    $( this ).dialog( "close" );
                }
            },
            open: function() {
                $('#table-form div.ui-widget').empty();
                allFields.val("");
            }
        });
    });
    // end of creating new table
    
    
    $(function() {
        $( "#dialog-remove" ).dialog({
            autoOpen: false,
            height: 300,
            width: 400,
            modal: true,
            buttons: {
                "YES": function(){
                    var checked = $("td.check_one input:checked");

                    if (checked.val() == 'on')
                    {
                        var $inputs = checked.parent('td');
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
                                        hidden += "&"+$(this).attr("name")+'='+row;
                                    }   
                                });
                            });
                        });
                        
                        $.ajax({
                            type: "POST",
                            url: '<?php echo site_url ('rows/remove'); ?>',
                            data: "database_name="+'<?php if (isset ($_GET['database'])) echo $_GET['database'] ?>'+
                                "&table_name="+'<?php if (isset ($_GET['table'])) echo $_GET['table'] ?>'+hidden+"&count="+$inputs.length,
                            success: function(response){
                                //change on something
                                checked.parent('td').parent('tr').slideUp();
                                alert(response);
                            }
                        });
                    }
                    
                    $( this ).dialog( "close" );
                },
                "NO": function(){
                    $( this ).dialog( "close" );
                }                  
            }
        });
    });
    
    $(function() {
        $( "#database-remove" ).dialog({
            autoOpen: false,
            height: 300,
            width: 400,
            modal: true,
            buttons: {
                "YES": function(){
                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: '<?php echo site_url ('db/delete') ?>',
                        data: "database_name="+$('input[type=hidden].db').val(),
                        success: function(response){
                            //change on something
                            alert(response);
                            $('table#tables[name='+$('input[type=hidden].db').val()+']').empty().prev().empty();
                        }
                    });
                    
                    $( this ).dialog( "close" );
                },
                "NO": function(){
                    $( this ).dialog( "close" );
                }                  
            }
        });
    });
    
</script>
<script>
    $(function(){
        $('.ui-dialog-buttonset > button:first-child').attr('class', 'btn btn-primary');
        $('.ui-dialog-buttonset > button:last-child').attr('class', 'btn');
        $('.ui-dialog-buttonpane.ui-widget-content.ui-helper-clearfix').appendTo('#dialog form fieldset');
        //--------------------
        $('.datepicker').datepicker({ 
            dateFormat: "dd/mm/yy",
            monthNames: ["Январь","Февраль","Март","Апрель","Май","Июнь","Июль","Август","Сентябрь","Октябрь","Ноябрь","Декабрь"],
            dayNamesMin: ["Пн", "Вт", "Ср", "Чт", "Пт", "Сб", "Вс"]
        });
    });
</script>
<style>
    .well input[type=text]{
        /*background: transparent;
        border: none;
        box-shadow: none;
        margin:0;
        padding: 0;*/
    }
    .well input[type=checkbox]{
        /*margin-top: -5px;*/
    }
    .ui-widget-header{
        background: #D9EDF7;
        border-color: #BCE8F1;
        color: #3A87AD;
        font-size: 14px;
        font-weight: normal;
        text-align: center;
    }
    .ui-widget-overlay{
        background: #333;
    }
    .btn-group .btn-mini.dropdown-toggle {
        padding-left: 5px;
        padding-right: 5px;
        padding-top: 3px;
    }
    .btn-toolbar {
        margin-top: -15px;
    }
    label, input { display:block; }
    input.text { margin-bottom:12px; width:95%; padding: .4em; }
    select.text { display: inline; margin-left: 5px;}
    input.field { display:inline;}
    input[id^=size] { display:inline; width: 30px;}
    fieldset { padding:0; border:0; /*margin-top:25px;*/ }
    h1 { font-size: 1.2em; margin: .6em 0; }
    div#databases-contain { width: 350px; margin: 20px 0; }
    div#databases-contain table { margin: 1em 0; border-collapse: collapse; width: 100%; }
    div#databases-contain table td, div#databases-contain table th { border: 1px solid #eee; padding: .6em 10px; text-align: left; }
    .validateTips { border: 1px solid transparent; padding: 0.3em; }
    .ui-dialog .ui-state-error { /*background: #B94A48 #EED3D7 #F2DEDE*/; }
</style>

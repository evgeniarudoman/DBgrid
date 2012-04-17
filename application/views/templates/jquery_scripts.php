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
            //$('div#table-form ').append('<form class="table-form"><fieldset class="control-group"><label for="table">Имя таблицы</label><input type="text" name="table" id="table" class="text ui-widget-content ui-corner-all"><label for="count">Количество полей</label><input type="text" name="count" id="count" class="text ui-widget-content ui-corner-all"><label for="db">Имя базы данных</label><select name="db" id="db" class="text ui-widget-content ui-corner-all"></select></fieldset></form>');
            /*$.ajax({
                type: "POST",
                dataType: "html",
                url: '<?php //echo site_url ('tables/form');              ?>',
                success: function(response){
                    //change on something
                    alert(response);
                                    
                    $('div#table-form').html(response);
                }
            });*/
            
            $.ajax({
                type: "POST",
                dataType: "json",
                url: '<?php echo site_url('db/select'); ?>',
                success: function(types){
                    var options="";
                    // $('div#table-form form.field-form').hide();
                    
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
        tips = $( "div.ui-state-highlight p" );
        
        // @function Highlight error
        // param t - field
        function updateTips( t ) {
            $("div.ui-state-highlight").attr('class', 'ui-state-error');
            tips
            .html('<span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>'+t)
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
                "Создать": function() {
                    $('div#ajax-loading-left').show();
                    
                    var bValid = true;

                    bValid = bValid && checkEmpty( database, "Поле имени базы данных не должно быть пустым.");
                    bValid = bValid && checkRegexp( database, /^[a-zа-я]([a-zа-я_])+$/i, "Поле имени базы данных должно содержать буквы, нижнее подчерквание и начинаться с букв." );
                   
                    if ( bValid ) {
                        $.ajax({
                            type: "POST",
                            dataType:"html",
                            url: '<?php echo site_url('db/add'); ?>',
                            data: "database_name="+database.val(),
                            success: function(response){
                                $('div#ajax-loading-left').hide();
                                $('div#accordion div.well').html(response);
                            }
                        });
                        
                        $( this ).dialog( "close" );
                    }
                },
                "Отмена": function() {
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
                "Добавить": function() {
                    var fields = '';
                    var values = '';

                    var $textareas = $('#row-form textarea');
                    $textareas.each(function(k) {
                        fields += '&field_textarea_'+$(this).attr("number")+'='+this.name;
                        values += '&value_textarea_'+$(this).attr("number")+'='+$(this).val();
                    });
                    
                    var $inputs = $('#row-form input[type=text]');
                    $inputs.each(function(k) {
                        fields += '&field_input_'+$(this).attr("number")+'='+this.name;
                        values += '&value_input_'+$(this).attr("number")+'='+$(this).val();
                    });
                    
                    var $checkboxs = $('#row-form input:checked');
                    $checkboxs.each(function(k) {
                        fields += '&field_checkbox_'+$(this).attr("number")+'='+this.name;
                        values += '&value_checkbox_'+$(this).attr("number")+'='+$(this).val();
                    });
                    
                    var $selects = $('#row-form select');
                    $selects.each(function(k) {
                        fields += '&field_select_'+$(this).attr("number")+'='+this.name;
                        values += '&value_select_'+$(this).attr("number")+'='+$(this).text();
                    });
                    
                    //alert(fields);
                    //alert(values);
                    if ( $('input[type=hidden].db').val() == 0) 
                    {
                        // add new database by ajax
                        $.ajax({
                            type: "POST",
                            dataType: "html",
                            url: '<?php echo site_url('rows/add'); ?>',
                            data: "database_name="+"<?php if (isset($_GET['database']))
                                    echo $_GET['database'] ?>"+
                                    "&table_name="+"<?php if (isset($_GET['table']))
                                    echo $_GET['table'] ?>"+
                                    fields+values+
                                    "&count_input="+$inputs.length+
                                    "&count_textarea="+$textareas.length+
                                    "&count_select="+$selects.length+
                                    "&count_checkbox="+$checkboxs.length,
                                success: function(response){
                                    //change on something
                                    //alert(response);
                            
                                    $('#ajax-page').html(response);
                                }
                            });
                        }
                        else
                        {
                            var $checkboxs = $('#row-form input');
                            $checkboxs.each(function(k) {
                                fields += '&field_checkbox_'+$(this).attr("number")+'='+this.name;
                                values += '&value_checkbox_'+$(this).attr("number")+'='+$(this).val();
                            });
                    
                            $.ajax({
                                type: "POST",
                                dataType: "html",
                                url: '<?php echo site_url('rows/edit'); ?>',
                                data: "database_name="+"<?php if (isset($_GET['database']))
                                    echo $_GET['database'] ?>"+
                                    "&table_name="+"<?php if (isset($_GET['table']))
                                    echo $_GET['table'] ?>"+
                                    fields+values+
                                    "&count_input="+$inputs.length+
                                    "&count_textarea="+$textareas.length+
                                    "&count_select="+$selects.length+
                                    "&count_checkbox="+$checkboxs.length+
                                    $('input[type=hidden].rows').val(),
                                success: function(response){
                                    //change on something
                                    //alert(response);
                                
                                    //alert(response);
                            
                                    $('#ajax-page').html(response);
                                
                                    /*if ($("td.check_one input:checked").val() == 'on')
                                    {
                                        $inputs.each(function() {
                                            $("td.check_one input:checked").parent('td').siblings().text($(this).val());
                                        });
                                    }*/
                                }
                            });
                        
                            $('input[type=hidden].db').val(0)
                        }
                        $( this ).dialog( "close" );
                    
                    },
                    "Отмена": function() {
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
                    "Добавить": function() {
                        var bValid = true;
                        allFields.removeClass( "ui-state-error" );
                        var val = $('input[name=field_name]').val();
                        $.ajax({
                            type: "POST",
                            dataType: "html",
                            url: '<?php echo site_url('fields/add'); ?>',
                            data: "database_name="+"<?php if (isset($_GET['database']))
                                echo $_GET['database'] ?>"+
                                "&table_name="+"<?php if (isset($_GET['table']))
                                echo $_GET['table'] ?>"+
                                "&field_name="+val+
                                "&type="+$('select[name=type] option:selected').val(),//+
                            //"&size="+$('input[name=size]').val(),
                            success: function(response){
                                //change on something
                                //alert(response);
                            
                                $('div#structure').html(response);
                            
                                $.ajax({
                                    type: "POST",
                                    dataType: "html",
                                    url: '<?php echo site_url('rows/get_table'); ?>',
                                    data: "database_name="+"<?php if (isset($_GET['database']))
                                        echo $_GET['database'] ?>"+
                                        "&table_name="+"<?php if (isset($_GET['table']))
                                        echo $_GET['table'] ?>",
                                    success: function(response){
                                        //alert(response);
                                        $('#ajax-page').html(response);
                                    }
                                });
                            }
                        
                        });
                        
                        $( this ).dialog( "close" );
                    
                    },
                    "Отмена": function() {
                        $( this ).dialog( "close" );
                    }
                },
                open: function() {
                    $('#field-form div.ui-widget').empty();
                    $('#field-form input').val('');
                    $('#field-form select').val('');
                    allFields.val("");
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
                    "Создать": function() {
                        var bValid = true;
                        var fValid = false;
                    
                        bValid = bValid && checkEmpty( table, "Поле имени таблицы не должно быть пустым.");
                        bValid = bValid && checkRegexp( table, /^[a-zа-я]([a-zа-я_])+$/i, "Поле имени таблицы должно содержать буквы, нижнее подчерквание и начинаться с букв." );
                      
                        bValid = bValid && checkEmpty( count, "Поле количество полей не должно быть пустым.");
                        bValid = bValid && checkRegexp( count, /^[0-9]+$/i, "Поле количество полей должно содержать только цифры." );
                        bValid = bValid && checkEmpty( db, "Поле имени базы данных не должно быть пустым.");                    

                    
                        if ( bValid ) 
                        {
                            if ( $('input[type=hidden].valid').val() == 'true') 
                            {
                                var i;
                                for (i=1;i<=count.val();i++)
                                {
                                    $( "div#field-form-tb form.field-form" ).append(
                                    '<fieldset style="border: 1px solid #DDD;padding-left: 5px;display: inline;margin-right: 10px;width: 190px;-moz-border-radius:5px 5px 5px 5px;-webkit-border-radius: 5px 5px 5px 5px;">'+
                                        '<legend style="font-size: 13px;border: none;">Поле'+i+'</legend>'+
                                        '<label for="field_name">Имя поля</label>'+
                                        '<input type="text" name="field'+i+'" class="text ui-widget-content ui-corner-all" style="width: 150px;margin-left: 5px;"/>'+
                                        '<label for="field_type">Тип</label>'+
                                        "<select name='type"+i+"' class='text ui-widget-content ui-corner-all' style='width: 162px;'>"+
                                        '<option value="" selected="selected"> -- выбрать тип -- </option>'+
                                        '</select>'+
                                        '</fieldset>');
            
                                    $.ajax({
                                        type: "POST",
                                        dataType: "json",
                                        url: '<?php echo site_url('tables/get_type'); ?>',
                                        success: function(types){
                                            var options='';
                                            $.each( types, function(k, val){
                                                options+=  "<option value='"+val.key+"'>"+val.key+"</option>";
                                            });
                    
                                            $( "div#field-form-tb form.field-form select" ).html(
                                            "<option value='' selected='selected'> -- выбрать тип -- </option>"+
                                                options);
                    
                                        }
                                    })
                                    $('input[type=hidden].valid').val('false');
                                }
                            
                                /* var i;
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
                                }*/
                            }
                            if ($('div#table-form form.table-form fieldset').length == 0){
                                var fValid = true;
                                for (i=1;i<=count.val();i++)
                                {
                                    fValid = fValid && checkEmpty( $('input[name=field'+i+']'), "Имя поля #"+i+" не должно быть пустым.");
                                    fValid = fValid && checkEmpty( $('select[name=type'+i+']'), "Выберите тип для поля #"+i+".");
                                    // fValid = fValid && checkEmpty( $('input[name=check]'), "Вы должны выбрать начальный ключ нажатием радиокнопки.");
                                    //fValid = fValid && checkRegexp( $('input[name=size'+i+']'), /^[0-9]+$/i, "Размер поля должен содержать только числа." );
                                }
                            }
                            else
                            {
                                $('#table-form div.ui-widget').empty();
                            }
                        
                            
                                
                                
                            $( "#field-form-tb" ).dialog("open");
                            $( this ).dialog( "close" );
                        }
                       /* if (fValid) 
                        {
                            $('div#ajax-loading-left').show();
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
                                dataType: "html",
                                url: '<?php //echo site_url('tables/add'); ?>',
                                data: "table_name="+table.val()+
                                    "&count="+count.val()+
                                    "&database="+db.val()+
                                    "&radio="+$('input#check:checked').val()+
                                    fields+types+sizes,
                                success: function(response){
                                
                                
                                
                                    $('div#ajax-loading-left').hide();
                                    $('div#accordion div.well').html(response);
                                }
                            });
                            
                            $( this ).dialog( "close" );
                        }*/
                    },
                    "Отмена": function() {
                        $( this ).dialog( "close" );
                    }
                },
                open: function() {
                    $('#table-form div.ui-widget').empty();
                    allFields.val("");
                }
            });
            // end of creating new table
    
            $( "#field-form-tb" ).dialog({
                autoOpen: false,
                height:464,
                width: 666,
                modal: true,
                buttons: {
                    "Добавить": function(){
                        var fValid = true;
                        var i;
                        for (i=1;i<=count.val();i++)
                        {
                            fValid = fValid && checkEmpty( $('input[name=field'+i+']'), "Имя поля #"+i+" не должно быть пустым.");
                            fValid = fValid && checkEmpty( $('select[name=type'+i+']'), "Выберите тип для поля #"+i+".");
                            // fValid = fValid && checkEmpty( $('input[name=check]'), "Вы должны выбрать начальный ключ нажатием радиокнопки.");
                            //fValid = fValid && checkRegexp( $('input[name=size'+i+']'), /^[0-9]+$/i, "Размер поля должен содержать только числа." );
                        }
                            
                        if (fValid)
                        {
                            $('div#ajax-loading-left').show();
                            
                            var fields = '';
                            var types = '';
                            //var sizes = '';
                        
                            for (i=1;i<=count.val();i++)
                            {
                                fields += "&field"+i+"="+$('#field-form-tb input[name=field'+i+']').val();
                                types += "&type"+i+"="+$('#field-form-tb select[name=type'+i+'] option:selected').text();
                                //sizes += "&size"+i+"="+$('input#size'+i).val();
                            }
                            //alert(fields);
                            //alert(types);
                            
                            $.ajax({
                                type: "POST",
                                dataType: "html",
                                url: '<?php echo site_url('tables/add'); ?>',
                                data: "table_name="+table.val()+
                                    "&count="+count.val()+
                                    "&database="+db.val()+
                                    "&radio="+$('input#check:checked').val()+
                                    fields+types,//+sizes,
                                success: function(response){
                                
                                
                                
                                    $('div#ajax-loading-left').hide();
                                    $('div#accordion div.well').html(response);
                                }
                            });
                        
                            $( this ).dialog( "close" );
                        }
                    },
                    "Отмена": function(){
                        $( this ).dialog( "close" );
                    }                  
                }
            });
        });
    
        $(function() {
            $( "#table-edit-form" ).dialog({
                autoOpen: false,
                height: 300,
                width: 400,
                modal: true,
                buttons: {
                    "Редактировать": function(){
                        $('div#ajax-loading-left').show();
                        //alert($('input#table-e').val()+', '+$('input[type=hidden].db').val()+', '+$('input[type=hidden].tables').val())
                        $.ajax({
                            type: "POST",
                            dataType: "html",
                            url: '<?php echo site_url('tables/rename'); ?>',
                            data: "new_name="+$('input#table-e').val()+
                                "&database_name="+$('input[type=hidden].db').val()+
                                "&table_name="+$('input[type=hidden].tables').val(),
                            success: function(response){
                                $('div#ajax-loading-left').hide();
                                $('div#accordion div.well').html(response);
                            }
                        });
                        
                        $('input[type=hidden].db').val(0);
                        $( this ).dialog( "close" );
                    },
                    "Отмена": function(){
                        $( this ).dialog( "close" );
                    }                  
                }
            });
        });
    
        $(function() {
            $( "#dialog-remove" ).dialog({
                autoOpen: false,
                height: 300,
                width: 400,
                modal: true,
                buttons: {
                    "Да": function(){
                        var checked = $("td.check_one input:checked");

                        if (checked.val() == 'on')
                        {
                            var $inputs = checked.parent('td');
                            var $name = $("th div.resize");
                            var row = '';
                            var fields = '';
                            var values = '';
                    
                            $inputs.each(function() {
                                var $rows = $(this).siblings();
                                $rows.each(function(j) {
                                    row = $(this).text();
                                    $name.each(function(z) {
                                        if (z == j)
                                        {
                                            fields += "&field"+z+'='+$(this).attr("name");
                                            values += "&value"+z+'='+row;
                                        }   
                                    });
                                });
                            });
                        
                            $.ajax({
                                type: "POST",
                                url: '<?php echo site_url('rows/remove'); ?>',
                                data: "database_name="+'<?php if (isset($_GET['database']))
                                    echo $_GET['database'] ?>'+
                                    "&table_name="+'<?php if (isset($_GET['table']))
                                    echo $_GET['table'] ?>'+fields+values+"&count="+$inputs.length,
                                success: function(response){
                                    //change on something
                                    checked.parent('td').parent('tr').slideUp();
                                    //alert(response);
                                }
                            });
                        }
                    
                        $( this ).dialog( "close" );
                    },
                    "Нет": function(){
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
                    "Да": function(){
                        $('div#ajax-loading-left').show();
                    
                        $.ajax({
                            type: "POST",
                            dataType: "html",
                            url: '<?php echo site_url('db/delete') ?>',
                            data: "database_name="+$('input[type=hidden].db').val(),
                            success: function(response){
                                $('div#ajax-loading-left').hide();
                                $('div#accordion div.well').html(response);
                            }
                        });
                    
                        $( this ).dialog( "close" );
                    },
                    "Нет": function(){
                        $( this ).dialog( "close" );
                    }                  
                }
            });
        });
    
    
        $(function() {
            $( "#table-remove" ).dialog({
                autoOpen: false,
                height: 300,
                width: 400,
                modal: true,
                buttons: {
                    "Да": function(){
                        $('div#ajax-loading-left').show();
                    
                        $.ajax({
                            type: "POST",
                            dataType: "html",
                            url: '<?php echo site_url('tables/delete') ?>',
                            data: "database_name="+$('input[type=hidden].db').val()+
                                "&table_name="+$('input[type=hidden].tables').val(),
                            success: function(response){
                                $('div#ajax-loading-left').hide();
                                $('div#accordion div.well').html(response);
                            }
                        });
                    
                        $( this ).dialog( "close" );
                    },
                    "Нет": function(){
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
<script>
    $(function() {
        $( "#tabs" ).tabs();
    });
</script>
<style>
    .wells input[type=text]{
        /*background: transparent;
        border: none;
        box-shadow: none;
        margin:0;
        padding: 0;*/
    }
    .wells input[type=checkbox]{
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
    div#tabs a{font-size: 13px;}
</style>

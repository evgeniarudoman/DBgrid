<script>
    $(function() {  
        $('select.select-type').change(function(){
            if ($('select.select-type option:selected').text() == 'список')
            {
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: '<?php echo site_url ('db/select'); ?>',
                    success: function(db){
                        var options='';
                        $.each( db, function(k, val){
                            options+=  "<option value='"+val.key+"'>"+val.key+"</option>";
                        });
                    
                        $( "select.select-db" ).show();
                        $( "select.select-db" ).html(
                        "<option value='' selected='selected'> -- выберите базу данных -- </option>"+
                            options);
                    
                    }
                }); 
            }
            else
            {
                $( "select.select-db" ).hide();
                $( "select.select-table" ).hide();
                $( "select.select-field" ).hide();
            }
        });
        
        $('select.select-db').change(function(){            
            $.ajax({
                type: "POST",
                dataType: "json",
                url: '<?php echo site_url ('tables/select'); ?>',
                data: "db_name="+$('select.select-db option:selected').text(),
                success: function(table){
                    var options='';
                    $.each( table, function(k, val){
                        options+=  "<option value='"+val.key+"'>"+val.key+"</option>";
                    });
                    
                    $( "select.select-table" ).show();
                    $( "select.select-table" ).html(
                    "<option value='' selected='selected'> -- выберите таблицу -- </option>"+
                        options);
                    
                }
            }); 
        });
        
        $('select.select-table').change(function(){            
            $.ajax({
                type: "POST",
                dataType: "json",
                url: '<?php echo site_url ('fields/select'); ?>',
                data: "db_name="+$('select.select-db option:selected').text()+"&table_name="+$('select.select-table option:selected').text(),
                success: function(field){
                    var options='';
                    $.each( field, function(k, val){
                        options+=  "<option value='"+val.key+"'>"+val.key+"</option>";
                    });
                    
                    $( "select.select-field" ).show();
                    $( "select.select-field" ).html(
                    "<option value='' selected='selected'> -- выберите поле -- </option>"+
                        options);
                    
                }
            }); 
        });
        
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
            $('div#row-form input[type=text]').val('');         
            $('div#row-form textarea').val('');
            $('#row-form input[type=hidden]').val('');
            $('div#row-form input[type=checkbox]').removeAttr('checked');
            $('input.photo100').val('');
            $('div#row-form img').hide().parent('td').prev().show();
            
            $('input[type=hidden].db').val(0);
                
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
            $('div#ajax-loading-left').hide();
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
                updateTips( n );
                return false;
            } else {
                return true;
            }
        }
        
        function jqueryForms () {
            $.ajax({
                type: "POST",
                dataType:"html",
                url: '<?php echo site_url ('grid/jquery_forms'); ?>',
                success: function(response){
                    $('div#jquery-forms').html(response);
                }
            });
        }
	
        // modal of creating new database
        $( "#database-form" ).dialog({
            autoOpen: false,
            height: 300,
            width: 360,
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
                            url: '<?php echo site_url ('db/add'); ?>',
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
                $("div.ui-state-error").attr('class', 'ui-state-highlight');
                allFields.val("");
            }
        });
        // end of creating new database
          
        // modal of creating new field
        $( "#row-form" ).dialog({
            autoOpen: false,
            height: 380,
            width: 360,
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
                        $(this).is(':selected')
                        {
                            fields += '&field_select_'+$(this).attr("number")+'='+this.name;
                            values += '&value_select_'+$(this).attr("number")+'='+$(this).find("option:selected").text();
                        }
                    });
                    
                    var $files = $('#row-form input[type=hidden]');
                    $files.each(function(k) {
                        fields += '&field_file_'+$(this).attr("number")+'='+$(this).attr("file");
                        values += '&value_file_'+$(this).attr("number")+'='+$(this).val();
                    });
                    alert(fields);
                    alert(values);
                    if ( $('input[type=hidden].db').val() == 0) 
                    {
                        // add new database by ajax
                        $.ajax({
                            type: "POST",
                            dataType: "html",
                            url: '<?php echo site_url ('rows/add'); ?>',
                            data: "database_name="+"<?php
if (isset ($_GET['database']))
    echo $_GET['database']
    ?>"+
                                    "&table_name="+"<?php
if (isset ($_GET['table']))
    echo $_GET['table']
    ?>"+
                                    fields+values+
                                    "&count_input="+$inputs.length+
                                    "&count_textarea="+$textareas.length+
                                    "&count_select="+$selects.length+
                                    "&count_checkbox="+$checkboxs.length+
                                    "&count_file="+$files.length,
                                success: function(response){
                                    $('#ajax-page').html(response);
                                }
                            });
                        }
                        else
                        {
                            var $checkboxs = $('#row-form input[type=checkbox]');
                            $checkboxs.each(function(k) {
                                fields += '&field_checkbox_'+$(this).attr("number")+'='+this.name;
                                if ($(this).is(":checked"))
                                    values += '&value_checkbox_'+$(this).attr("number")+'='+1;
                                else
                                    values += '&value_checkbox_'+$(this).attr("number")+'='+0;
                            });
                            //alert(fields);
                            //alert(values);
                            $.ajax({
                                type: "POST",
                                dataType: "html",
                                url: '<?php echo site_url ('rows/edit'); ?>',
                                data: "database_name="+"<?php
if (isset ($_GET['database']))
    echo $_GET['database']
    ?>"+
                                    "&table_name="+"<?php
if (isset ($_GET['table']))
    echo $_GET['table']
    ?>"+
                                    fields+values+
                                    "&count_input="+$inputs.length+
                                    "&count_textarea="+$textareas.length+
                                    "&count_select="+$selects.length+
                                    "&count_checkbox="+$checkboxs.length+
                                    "&count_file="+$files.length+
                                    $('input[type=hidden].rows').val(),
                                success: function(response){
                                    $('#ajax-page').html(response);
                                }
                            });
                        
                            $('input[type=hidden].db').val(0);
                        }
                        $( this ).dialog( "close" );
                    
                    },
                    "Отмена": function() {
                        $( this ).dialog( "close" );
                    }
                },
                open: function() {
                    $('div#row-form div#photo100Queue').hide();
                    
                    $("div.ui-state-error").attr('class', 'ui-state-highlight');
                    allFields.val("");
                },
                close: function(){
                    /*  $('div#row-form input[type=text]').val('');         
                    $('div#row-form textarea').val('');
                    $('div#row-form select').text('');
                    $('#row-form input[type=hidden]').val('');
                    $('div#row-form input[type=checkbox]').removeAttr('checked');
                    $('input.photo100').val('');
                    $('div#row-form img').hide().parent('td').prev().show();*/
                }
            });
            // end of creating new field
        
            // modal of creating new field
            $( "#field-form" ).dialog({
                autoOpen: false,
                height: 380,
                width: 360,
                modal: true,
                buttons: {
                    "Добавить": function() {
                        var bValid = true;
                        allFields.removeClass( "ui-state-error" );
                        var val = $('input[name=field_name]').val();
                
                        var db = "";
                        var table = "";
                        var field = "";
                        
                        if ($('select.select-type option:selected').text() == 'список')
                        {
                            db = "&db="+$('select.select-db option:selected').text();
                            table = "&table="+$('select.select-table option:selected').text();
                            field = "&field="+$('select.select-field option:selected').text();
                        }
                        
                        $.ajax({
                            type: "POST",
                            dataType: "html",
                            url: '<?php echo site_url ('fields/add'); ?>',
                            data: "database_name="+"<?php
if (isset ($_GET['database']))
    echo $_GET['database']
    ?>"+
                                "&table_name="+"<?php
if (isset ($_GET['table']))
    echo $_GET['table']
    ?>"+
                                "&field_name="+val+
                                "&type="+$('select[name=type] option:selected').val()+
                                db+table+field,
                            success: function(response){
                                $('div#structure').html(response);
                            
                                $.ajax({
                                    type: "POST",
                                    dataType: "html",
                                    url: '<?php echo site_url ('rows/get_table'); ?>',
                                    data: "database_name="+"<?php
if (isset ($_GET['database']))
    echo $_GET['database']
    ?>"+
                                        "&table_name="+"<?php
if (isset ($_GET['table']))
    echo $_GET['table']
    ?>",
                                    success: function(response){
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
                    $("div.ui-state-error").attr('class', 'ui-state-highlight');
                    allFields.val("");
                }
            });
            // end of creating new field
         
            // modal of creating new table
            $( "#table-form" ).dialog({
                autoOpen: false,
                height: 390,
                width: 360,
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
                            //if ( $('input[type=hidden].valid').val() == 'true') 
                            //{
                                var i;
                                var data = '';
                                for (i=1;i<=count.val();i++)
                                {
                                    
                                    data += '<fieldset style="border: 1px solid #DDD;padding: 5px;display: inline;margin-right: 10px;">'+
                                        '<legend style="font-size: 12px;border: none;">Поле'+i+'</legend>'+
                                        '<table>'+'<tr>'+
                                        '<td style="width:70px">'+'<label for="field_name">Имя поля</label>'+'</td>'+
                                        '<td>'+'<input type="text" name="field'+i+'" class="text ui-widget-content ui-corner-all" style="width: 130px;height: 10px;"/>'+'</td>'+
                                        '</tr>'+
                                        '<tr>'+
                                        '<td>'+'<label for="field_type">Тип</label>'+'</td>'+
                                        '<td>'+"<select name='type"+i+"' class='text ui-widget-content ui-corner-all' style='width: 140px;height: 25px;'>"+
                                        '<option value="" selected="selected"> -- выбрать тип -- </option>'+
                                        '</select>'+'</td>'+
                                        '</tr>'+'</table>'+
                                        '</fieldset>'
            
                                    $.ajax({
                                        type: "POST",
                                        dataType: "json",
                                        url: '<?php echo site_url ('tables/get_type'); ?>',
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
                                //alert(data);
                                $( "div#field-form-tb form.field-form" ).html(data);
                            //}
                            if ($('div#table-form form.table-form fieldset').length == 0){
                                var fValid = true;
                                for (i=1;i<=count.val();i++)
                                {
                                    fValid = fValid && checkEmpty( $('input[name=field'+i+']'), "Имя поля #"+i+" не должно быть пустым.");
                                    fValid = fValid && checkEmpty( $('select[name=type'+i+']'), "Выберите тип для поля #"+i+".");
                                }
                            }
                            else
                            {
                                $('#table-form div.ui-widget').empty();
                            }

                            $('input[type=hidden].db').val(db.val());
                            $('input[type=hidden].tables').val(table.val());
                            $('input[type=hidden].count').val(count.val());
                            
                            $( "#field-form-tb" ).dialog("open");
                            $( this ).dialog( "close" );
                        }
                    },
                    "Отмена": function() {
                        $( this ).dialog( "close" );
                    }
                },
                open: function() {
                    $('span.fill').text(' Все поля обязательны для заполнения.');
                    $("div.ui-state-error").attr('class', 'ui-state-highlight');
                    allFields.val("");
                }
            });
            // end of creating new table
    
            $( "#field-form-tb" ).dialog({
                autoOpen: false,
                height:464,
                width: 500,
                modal: true,
                buttons: {
                    "Добавить": function(){
                        var fValid = true;
                        var i;
                        for (i=1;i<=$('input[type=hidden].count').val();i++)
                        {
                            fValid = fValid && checkEmpty( $('input[name=field'+i+']'), "Имя поля #"+i+" не должно быть пустым.");
                            fValid = fValid && checkEmpty( $('select[name=type'+i+']'), "Выберите тип для поля #"+i+".");
                        }
                            
                        if (fValid)
                        {
                            $('div#ajax-loading-left').show();
                            
                            var fields = '';
                            var types = '';
                        
                            for (i=1;i<=$('input[type=hidden].count').val();i++)
                            {
                                fields += "&field"+i+"="+$('#field-form-tb input[name=field'+i+']').val();
                                types += "&type"+i+"="+$('#field-form-tb select[name=type'+i+'] option:selected').text();
                            }
                            
                            $.ajax({
                                type: "POST",
                                dataType: "html",
                                url: '<?php echo site_url ('tables/add'); ?>',
                                data: "table_name="+$('input[type=hidden].tables').val()+
                                    "&count="+$('input[type=hidden].count').val()+
                                    "&database="+$('input[type=hidden].db').val()+
                                    //"&radio="+$('input#check:checked').val()+
                                fields+types,
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
                },
                open: function() {
                    $("div.ui-state-error").attr('class', 'ui-state-highlight');
                    allFields.val("");
                }
            });
        });
    
        $(function() {
            $( "#table-edit-form" ).dialog({
                autoOpen: false,
                height: 300,
                width: 360,
                modal: true,
                buttons: {
                    "Редактировать": function(){
                        $('div#ajax-loading-left').show();
                        
                        $.ajax({
                            type: "POST",
                            dataType: "html",
                            url: '<?php echo site_url ('tables/rename'); ?>',
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
                },
                open: function() {
                    $("div.ui-state-error").attr('class', 'ui-state-highlight');
                    allFields.val("");
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
                                url: '<?php echo site_url ('rows/remove'); ?>',
                                data: "database_name="+'<?php
if (isset ($_GET['database']))
    echo $_GET['database']
    ?>'+
                                    "&table_name="+'<?php
if (isset ($_GET['table']))
    echo $_GET['table']
    ?>'+fields+values+"&count="+$inputs.length,
                                success: function(response){
                                    checked.parent('td').parent('tr').slideUp();
                                }
                            });
                        }
                    
                        $( this ).dialog( "close" );
                    },
                    "Нет": function(){
                        $( this ).dialog( "close" );
                    }                  
                },
                open: function() {
                    $("div.ui-state-error").attr('class', 'ui-state-highlight');
                    allFields.val("");
                }
            });
        });
        
        
        $(function() {
            $( "#remove-field" ).click(function(){
                alert('aaaaaaaaaa');
            });
            
            $( "#remove-field" ).dialog({
                autoOpen: false,
                height: 300,
                width: 400,
                modal: true,
                buttons: {
                    "Да": function(){
                        var checked = $("td.check_one input:checked");
                        
                        alert('aaa');
                        
                        if (checked.val() == 'on')
                        {
                            var $inputs = checked.parent('td');
                            var $name = $("th");
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
                            alert($inputs);
                            alert(values);
                        
                        }
                    
                        $( this ).dialog( "close" );
                    },
                    "Нет": function(){
                        $( this ).dialog( "close" );
                    }                  
                },
                open: function() {
                    $("div.ui-state-error").attr('class', 'ui-state-highlight');
                    allFields.val("");
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
                            url: '<?php echo site_url ('db/delete') ?>',
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
                },
                open: function() {
                    $("div.ui-state-error").attr('class', 'ui-state-highlight');
                    allFields.val("");
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
                            url: '<?php echo site_url ('tables/delete') ?>',
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
                },
                open: function() {
                    $("div.ui-state-error").attr('class', 'ui-state-highlight');
                    allFields.val("");
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
    label, input,textarea { display:inline; }
    input.text { width:95%; padding: .4em; }
    select.text { display: inline; /*margin-left: 5px;*/}
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

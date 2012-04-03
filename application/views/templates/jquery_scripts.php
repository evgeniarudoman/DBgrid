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
            $( "#table-form" ).dialog( "open" );
        });
        
        $( "#add-row" ).click(function() {
            $( "#row-form" ).dialog( "open" );
        });
		
        // announcement variables
        var table = $( "#table" )
        var count = $( "#count" )
        var db = $( "#db" )
        var database= $( "#database" ),
        allFields = $( [] ).add( db ).add( table ).add( count ),
        tips = $( ".validateTips" );
        
        // @function Highlight error
        // param t - field
        function updateTips( t ) {
            tips
            .text( t )
            .addClass( "ui-state-highlight" );
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
                o.addClass( "ui-state-error" );
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
                o.addClass( "ui-state-error" );
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
                o.addClass( "ui-state-error" );
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
                    allFields.removeClass( "ui-state-error" );

                    bValid = bValid && checkLength( database, "database", 3, 16 );
                    bValid = bValid && checkRegexp( database, /^[a-z]([0-9a-z_])+$/i, "Database name may consist of a-z, 0-9, underscores, begin with a letter." );
                   
                    if ( bValid ) {
                        
                        if ( $('input[type=hidden].db').val() == 0) 
                        {
                            $( "ul.nav.nav-list" ).append( "<li class='active head'>" +
                                "<a href='#'>"+"<i class='icon-list-alt icon-white'></i>"+
                                database.val()+
                                "<i onclick='delete_db(\""+database.val()+"\");' class='icon-trash icon-white' style='float:right;'></i>"+
                                "<i onclick='edit_db(\""+database.val()+"\");' class='icon-pencil icon-white' style='float:right;'></i>"+
                                "</a>"
                        ); 
                                
                            // add new database by ajax
                            $.ajax({
                                type: "POST",
                                url: '<?php echo site_url('db/add'); ?>',
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
                                url: '<?php echo site_url('db/rename'); ?>',
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
            close: function() {
                allFields.val( "" ).removeClass( "ui-state-error" );
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
                    allFields.removeClass( "ui-state-error" );

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
                            url: '<?php echo site_url('rows/add'); ?>',
                            data: "database_name="+"<?php echo $_GET['database'] ?>"+
                                "&table_name="+"<?php echo $_GET['table'] ?>"+
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
                            url: '<?php echo site_url('rows/edit'); ?>',
                            data: "database_name="+"<?php echo $_GET['database'] ?>"+
                                "&table_name="+"<?php echo $_GET['table'] ?>"+
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
         
        // modal of creating new table
        $( "#table-form" ).dialog({
            autoOpen: false,
            height: 390,
            width: 400,
            modal: true,
            buttons: {
                "Create": function() {
                    var bValid = true;
                    var fValid = true;
                    allFields.removeClass( "ui-state-error" );
                    
                    bValid = bValid && checkEmpty( table, "Table name must be not empty");
                    bValid = bValid && checkLength( table, "table", 3, 16 );
                    bValid = bValid && checkRegexp( table, /^[a-z]([0-9a-z_])+$/i, "Table name may consist of a-z, 0-9, underscores, begin with a letter." );
                        
                    if ( $('input[type=hidden].tables').val() == 0) 
                    {
                        bValid = bValid && checkEmpty( count, "Count of fields must be not empty");
                        bValid = bValid && checkRegexp( count, /^[0-9]+$/i, "Count of fields may consist only numbers." );
                        bValid = bValid && checkEmpty( db, "Choose the database name");                    

                    
                        if ( bValid ) 
                        {                        
                            allFields.removeClass( "ui-state-error" );
                       
                            if ( $('input[type=hidden].valid').val() == 'true') 
                            {                            
                                $( "#tables tbody" ).append( "<tr>" +
                                    "<td>"+"<div class='icon table'></div>"+"</td>"+
                                    "<td>"+"<a href='/grid/index?database="+table.val()+"'>" + table.val() + "</td>" +
                                    "</tr>" );
                                $( "div#table-form form.field-form table" ).append( 
                                "<tr><td><p>key</p></td><td><p>field name</p></td><td><p>type</p></td><td><p>size of field</p></td></tr>");
                            
                                var i;
                                for (i=1;i<=count.val();i++)
                                {
                                    $( "div#table-form form.field-form table" ).append(
                                    "<tr><td><input type='radio' name='check' id='check' value='"+i+"' class='field ui-widget-content ui-corner-all'></td>"+
                                        "<td><input type='text' name='field"+i+"' id='field"+i+"' class='field ui-widget-content ui-corner-all'></td>"+
                                        "<td><select name='type"+i+"' id='type"+i+"' class='text ui-widget-content ui-corner-all'>"+
                                        "<option value='' selected='selected'> -- choose type -- </option>"+
                                        "</select></td>"+
                                        "<td><input type='text' name='size"+i+"' id='size"+i+"' class='field ui-widget-content ui-corner-all'></td></tr>");
                                
                                    $('input[type=hidden].valid').val('false');
                                }
                            
                                //http://vk.com/id11456991
                                // get type from db
                                $.ajax({
                                    type: "POST",
                                    dataType: "json",
                                    url: '<?php echo site_url('tables/get_type'); ?>',
                                    success: function(types){
                                        $.each( types, function(k, val){
                                            $( "div#table-form form.field-form select" ).append(
                                            "<option value='"+val.key+"'>"+val.key+"</option>"); 
                                        });
                                    }
                                })
                            }
                        
                            for (i=1;i<=count.val();i++)
                            {                    
                                fValid = fValid && checkEmpty( $('input[name=field'+i+']'), "Field name #"+i+" must be not empty");
                                fValid = fValid && checkEmpty( $('select[name=type'+i+']'), "Choose the type #"+i);
                                fValid = fValid && checkEmpty( $('input[name=check]'), "You need to choose primary key by click radio button");
                                fValid = fValid && checkRegexp( $('input[name=size'+i+']'), /^[0-9]+$/i, "Size of fields may consist only numbers." );
                            }
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
                                url: '<?php echo site_url('tables/add'); ?>',
                                data: "table_name="+table.val()+
                                    "&count="+count.val()+
                                    "&database="+db.val()+
                                    "&radio="+$('input#check:checked').val()+
                                    fields+types+sizes,
                                success: function(response){
                                    //change on something
                                    alert(response);
                                }
                            });
                            
                            $( this ).dialog( "close" );
                        }
                        
                        $('div#table-form form.table-form').empty();
                        $('div#table-form form.field-form').show();
                    }
                    else
                    {
                        $.ajax({
                            type: "POST",
                            url: '<?php echo site_url('tables/rename'); ?>',
                            data: "new_name="+table.val()+
                                "&database_name="+$('input[type=hidden].db').val()+
                                "&table_name="+$('input[type=hidden].tables').val(),
                            success: function(response){
                                //change on something
                                alert(response);
                            }
                        });
                        
                        $('input[type=hidden].db').val(0);
                    }
                },
                Cancel: function() {
                    $( this ).dialog( "close" );
                }
            },
            close: function() {
                allFields.val( "" ).removeClass( "ui-state-error" );
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
                        checked.parent('td').parent('tr').slideUp();
                    }
                    
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
    });
</script>
<style>
    .well input[type=text]{
        background: transparent;
        /*border: none;
        box-shadow: none;*/
        margin:0;
        padding: 0;
    }
    .well input[type=checkbox]{
        margin-top: -5px;
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
    fieldset { padding:0; border:0; margin-top:25px; }
    h1 { font-size: 1.2em; margin: .6em 0; }
    div#databases-contain { width: 350px; margin: 20px 0; }
    div#databases-contain table { margin: 1em 0; border-collapse: collapse; width: 100%; }
    div#databases-contain table td, div#databases-contain table th { border: 1px solid #eee; padding: .6em 10px; text-align: left; }
    .ui-dialog .ui-state-error { background: none; color: #363636; border: 1px solid #FF3853; }
    .validateTips { border: 1px solid transparent; padding: 0.3em; }
</style>

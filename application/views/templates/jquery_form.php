<script>
    $(function() {
        $( "#dialog:ui-dialog" ).dialog( "destroy" );
		
        var table = $( "#table" )
        var count = $( "#count" )
        var db = $( "#db" )
        var database = $( "#database" ),
        allFields = $( [] ).add( database ),
        tips = $( ".validateTips" );

        function updateTips( t ) {
            tips
            .text( t )
            .addClass( "ui-state-highlight" );
            setTimeout(function() {
                tips.removeClass( "ui-state-highlight", 1500 );
            }, 500 );
        }

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

        function checkRegexp( o, regexp, n ) {
            if ( !( regexp.test( o.val() ) ) ) {
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
            width: 350,
            modal: true,
            buttons: {
                "Create": function() {
                    var bValid = true;
                    allFields.removeClass( "ui-state-error" );

                    bValid = bValid && checkLength( database, "database", 3, 16 );

                    bValid = bValid && checkRegexp( database, /^[a-z]([0-9a-z_])+$/i, "Database name may consist of a-z, 0-9, underscores, begin with a letter." );

                    if ( bValid ) {
                        $( "#databases tbody" ).append( "<tr>" +
                            "<td>"+"<div class='icon table'></div>"+"</td>"+
                            "<td>"+"<a href='/grid/index?database="+database.val()+"'>" + database.val() + "</td>" +
                            "</tr>" ); 
                                
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

        $( "#create-database" )
        .click(function() {
            $( "#database-form" ).dialog( "open" );
        });
        // end of creating new database

        // modal of creating new table
        $( "#table-form" ).dialog({
            autoOpen: false,
            height: 300,
            width: 350,
            modal: true,
            buttons: {
                "Create": function() {
                    var bValid = true;
                    var fValid = true;
                    allFields.removeClass( "ui-state-error" );

                    bValid = bValid && checkLength( table, "table", 3, 16 );
                    bValid = bValid && count.val();
                    bValid = bValid && db.val();

                    bValid = bValid && checkRegexp( table, /^[a-z]([0-9a-z_])+$/i, "Table name may consist of a-z, 0-9, underscores, begin with a letter." );
                    bValid = bValid && checkRegexp( count, /^[0-9]+$/i, "Count of fields may consist 0-9, underscores, begin with a letter." );

                    if ( bValid ) {                        
                        $( "#tables tbody" ).append( "<tr>" +
                            "<td>"+"<div class='icon table'></div>"+"</td>"+
                            "<td>"+"<a href='/grid/index?database="+table.val()+"'>" + table.val() + "</td>" +
                            "</tr>" ); 
                        
                        if ( $('input[type=hidden].valid').val() == 'true') {
                            var i;
                            for (i=1;i<=count.val();i++)
                            {
                                $( "div#table-form form.field-form p" ).append(
                                "<input type='text' name='field"+i+"' id='field"+i+"' class='field ui-widget-content ui-corner-all'>"+
                                    "<select name='type"+i+"' id='type"+i+"' class='text ui-widget-content ui-corner-all'>"+
                                    "<option value='' selected='selected'> -- choose type -- </option>"+
                                    "</select>");

                               
                                
                                $('input[type=hidden].valid').val('false');
                            }
                        
                            for (i=1;i<=count.val();i++)
                            {
                                fValid = fValid && $('input[name=field'+i+']').val();
                                fValid = fValid && $('select[name=type'+i+']').val();
                            }
                            // show fields form
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
                        
                            // add table by ajax
                            $.ajax({
                                type: "POST",
                                url: '<?php echo site_url('tables/add'); ?>',
                                data: "table_name="+table.val()+"&count="+count.val()+"&database="+$('#db option:selected').text()
                            })
                        }  
                        $('div#table-form form.table-form').empty();
                        $('div#table-form form.field-form').show();
                        
                        if (fValid) {
                            $( this ).dialog( "close" );
                        }
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

        $( "#create-table" )
        .click(function() {
            $( "#table-form" ).dialog( "open" );
        });
    });
    // end of creating new table
</script>
<style>
    body { font-size: 62.5%; }
    label, input { display:block; }
    input.text { margin-bottom:12px; width:95%; padding: .4em; }
    select.text { display: inline; margin-left: 5px;}
    input.field { margin-bottom:12px; padding: .4em; display:inline;}
    fieldset { padding:0; border:0; margin-top:25px; }
    h1 { font-size: 1.2em; margin: .6em 0; }
    div#databases-contain { width: 350px; margin: 20px 0; }
    div#databases-contain table { margin: 1em 0; border-collapse: collapse; width: 100%; }
    div#databases-contain table td, div#databases-contain table th { border: 1px solid #eee; padding: .6em 10px; text-align: left; }
    .ui-dialog .ui-state-error { padding: .3em; }
    .validateTips { border: 1px solid transparent; padding: 0.3em; }
</style>


<div style="outline-width: 0px; outline-style: initial; outline-color: initial; height: auto; width: 350px; position: absolute; top: 186px; left: 462px; z-index: 1002; display: none; " class="ui-dialog ui-widget ui-widget-content ui-corner-all ui-draggable ui-resizable" tabindex="-1" role="dialog" aria-labelledby="ui-dialog-title-dialog-form">
    <div class="ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix">
        <span class="ui-dialog-title" id="ui-dialog-title-dialog-form">Create</span>
        <a href="#" class="ui-dialog-titlebar-close ui-corner-all" role="button">
            <span class="ui-icon ui-icon-closethick">close</span>
        </a>
    </div>

    <!-- create new database form -->    
    <div id="database-form" class="ui-dialog-content ui-widget-content" style="width: auto; min-height: 0px; height: 216px; " scrolltop="0" scrollleft="0">
        <p class="validateTips">All form fields are required.</p>
        <form>
            <fieldset>
                <label for="database">Database name</label>
                <input type="text" name="database" id="database" class="text ui-widget-content ui-corner-all">
            </fieldset>
        </form>
    </div>
    <!-- end database form -->

    <!-- create new table form -->    
    <div id="table-form" class="ui-dialog-content ui-widget-content" style="width: auto; min-height: 0px; height: 216px; " scrolltop="0" scrollleft="0">
        <p class="validateTips">All form fields are required.</p>
        <form class="table-form">
            <fieldset>
                <label for="table">Table name</label>
                <input type="text" name="table" id="table" class="text ui-widget-content ui-corner-all">
                <label for="count">Count of fields</label>
                <input type="text" name="count" id="count" class="text ui-widget-content ui-corner-all">
                <label for="db">Database name</label>
                <select name="db" id="db" class="text ui-widget-content ui-corner-all">
                    <option value="" selected="selected"> -- choose database -- </option>
                    <?php if (isset($list_database) && !empty($list_database)): ?>
                        <?php foreach ($list_database as $key => $database): ?>
                            <option value="<?php echo $key ?>"><?php echo $database ?></option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </fieldset>
        </form>
        <form class="field-form" style="display: none;">
            <fieldset>
                <p></p>
            </fieldset>
            <input type="hidden" class="valid" value="true"/>
        </form>
    </div>
    <!-- end table form -->

    <div class="ui-resizable-handle ui-resizable-n"></div>
    <div class="ui-resizable-handle ui-resizable-e"></div>
    <div class="ui-resizable-handle ui-resizable-s"></div>
    <div class="ui-resizable-handle ui-resizable-w"></div>
    <div class="ui-resizable-handle ui-resizable-se ui-icon ui-icon-gripsmall-diagonal-se ui-icon-grip-diagonal-se" style="z-index: 1001; "></div>
    <div class="ui-resizable-handle ui-resizable-sw" style="z-index: 1002; "></div>
    <div class="ui-resizable-handle ui-resizable-ne" style="z-index: 1003; "></div>
    <div class="ui-resizable-handle ui-resizable-nw" style="z-index: 1004; "></div>
    <div class="ui-dialog-buttonpane ui-widget-content ui-helper-clearfix">
        <div class="ui-dialog-buttonset">
            <button type="button" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" role="button" aria-disabled="false">
                <span class="ui-button-text">Create</span>
            </button>
            <button type="button" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" role="button" aria-disabled="false">
                <span class="ui-button-text">Cancel</span>
            </button>
        </div>
    </div>
</div>
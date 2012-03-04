<!doctype html public "-//W3C//DTD HTML 4.0 //EN">
<html>
    <head>
        <title><?php echo $title; ?></title>

        <?php foreach ($scripts as $script): ?>
            <script src="<?php echo $script; ?>"></script>
        <?php endforeach; ?>

        <?php foreach ($styles as $style): ?>
            <link rel="stylesheet" type="text/css" href="<?php echo $style; ?>"/>
        <?php endforeach; ?>
        <script>
            $(function() {
                // a workaround for a flaw in the demo system (http://dev.jqueryui.com/ticket/4375), ignore!
                $( "#dialog:ui-dialog" ).dialog( "destroy" );
		
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
		
                $( "#dialog-form" ).dialog({
                    autoOpen: false,
                    height: 300,
                    width: 350,
                    modal: true,
                    buttons: {
                        "Create an account": function() {
                            var bValid = true;
                            allFields.removeClass( "ui-state-error" );

                            bValid = bValid && checkLength( database, "database", 3, 16 );

                            bValid = bValid && checkRegexp( database, /^[a-z]([0-9a-z_])+$/i, "Database name may consist of a-z, 0-9, underscores, begin with a letter." );

                            if ( bValid ) {
                                $( "#databases tbody" ).append( "<tr>" +
                                    "<td>"+"<div class='icon table'></div>"+"</td>"+
                                    "<td>"+"<a href='/grid/index?database="+database.val()+"'>" + database.val() + "</td>" +
                                    "</tr>" ); 
                                
                                // add to database by ajax
                                alert(database.val());
                                
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

                $( "#create-user" )
                
                .click(function() {
                    $( "#dialog-form" ).dialog( "open" );
                });
            });
        </script>
        <style>
            body { font-size: 62.5%; }
            label, input { display:block; }
            input.text { margin-bottom:12px; width:95%; padding: .4em; }
            fieldset { padding:0; border:0; margin-top:25px; }
            h1 { font-size: 1.2em; margin: .6em 0; }
            div#databases-contain { width: 350px; margin: 20px 0; }
            div#databases-contain table { margin: 1em 0; border-collapse: collapse; width: 100%; }
            div#databases-contain table td, div#databases-contain table th { border: 1px solid #eee; padding: .6em 10px; text-align: left; }
            .ui-dialog .ui-state-error { padding: .3em; }
            .validateTips { border: 1px solid transparent; padding: 0.3em; }
        </style>
    </head>
            
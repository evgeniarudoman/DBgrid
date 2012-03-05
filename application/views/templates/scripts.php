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
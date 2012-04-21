
$(function() {            
    $("input[id^=photo]").uploadify({
        'uploader' : '/uploadify/uploadify.swf', 
        'script' : '/uploadify/uploadify.php', 
        'cancelImg': '/uploadify/cancel.png',
        'folder': '/upload',
        'buttonImg'   : '/image/white.png',
        //'hideButton'   : true,
        //'wmode'      : 'transparent',
        'width' : 82,
        //'height' : 20,
        'multi': false,
        'auto' : true,
        'removeCompleted' : false,
        'scriptAccess'         : 'always',
        'checkScript': '/uploadify/check.php',
        'fileDesc'   : 'jpg;png;gif;jpeg;xls;xlsx;doc;docx;pdf;txt',
        'fileExt'   : '*.jpg;*.png;*.gif;*.jpeg;*.xls;*.xlsx;*.doc;*.docx;*.pdf;*.txt',
        'onError'  : function (event,ID,fileObj,errorObj) {                                                                                   
            alert('<p>'+errorObj.type + ' Error: ' + errorObj.info+'</p>');
        },
        'onSelect': function(){
        //$(".save").prop("disabled", true); 
        },
        'onComplete': function(event, ID, fileObj, response, data) {
            //alert (response);
            
            if (response== 1)
            {
                alert("The file is bigger than this PHP installation allows");
                $("input[id^=photo]").uploadifyCancel(ID);
            }
            else if (response==2)
            {
                alert("The file is bigger than this form allows");
                $("input[id^=photo]").uploadifyCancel(ID);
            }
            else if (response==3)
            {
                alert("Only part of the file was uploaded");
                $("input[id^=photo]").uploadifyCancel(ID);
            }
            else if (response== 4)
            {
                alert("No file was uploaded");
                $("input[id^=photo]").uploadifyCancel(ID);
            }
            else if (response== 6)
            {
                alert("Missing a temporary folder");
                $("input[id^=photo]").uploadifyCancel(ID);
            }
            else if (response== 7)
            {
                alert("Failed to write file to disk");
                $("input[id^=photo]").uploadifyCancel(ID);
            }
            else if (response== 8)
            {
                alert("File upload stopped by extension");
                $("input[id^=photo]").uploadifyCancel(ID);
            }
            else
            {
                //alert(event.currentTarget.id);
                $('input[type=hidden][name=attachment][class='+event.currentTarget.id+']').val(response);
            }
            
            
        /*
            if (response==1)
            {
                $("input[id^=photo]").uploadifyCancel(ID);
                alert('Превышен максимальный размер загрузки файла.');           
            }
            else
            {
                $('input[type=hidden][name=attachment][class='+event.currentTarget.id+']').val(response); 
            // $('.thumbnail img').attr('src', "/resize/timthumb.php?src="+response+"&h=200&w=200&zc=1")
           
            }
            */
        },
        'onCancel':function(event, ID, fileObj, data, remove, clearFast){
            $('input[name=attachment]').val('');
        }
    });
});


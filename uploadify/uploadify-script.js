$(function() {            
    $("input[id^=photo]").uploadify({
        'uploader' : '/uploadify/uploadify.swf', 
        'script' : '/uploadify/uploadify.php', 
        'cancelImg': '/uploadify/cancel.png',
        'folder': '/upload',
        //'buttonImg' : '/image/upload.png',
        //'width' : 65,
        //'height' : 20,
        'multi': false,
        'auto' : true,
        'removeCompleted' : false,
        'scriptAccess'         : 'always',
        'checkScript': '/uploadify/check.php',
        'fileDesc'   : 'jpg;png;gif;jpeg',
        'fileExt'   : '*.jpg;*.png;*.gif;*.jpeg',
        'onError'  : function (event,ID,fileObj,errorObj) {                                                                                   
            alert('<p>'+errorObj.type + ' Error: ' + errorObj.info+'</p>');
        },
        'onSelect': function(){
        //$(".save").prop("disabled", true); 
        },
        'onComplete': function(event, ID, fileObj, response, data) {
            if (response==1)
            {
                $("input[id^=photo]").uploadifyCancel(ID);
                alert('Превишен максимальный размер загрузки файла!');           
            }
            else
            {
                $('#attachment').val(response); 
                $('.thumbnail img').attr('src', "/resize/timthumb.php?src="+response+"&h=200&w=200&zc=1")
           
            }
        },
        'onCancel':function(event, ID, fileObj, data, remove, clearFast){
            $('input[name=attachments]').val('');
        }
    });
});
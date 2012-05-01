<table>
    <?php $i = 0; ?>
    <?php if (isset ($database) && !empty ($database) && isset ($table) && !empty ($table)): ?>
        <?php foreach ($result[$database . '_' . $table . '_field'] as $key => $field): ?>
            <tr>
                <td name='<?php echo $key; ?>' style="width: 120px;font-weight: normal;"><?php echo $field['name']; ?></td>
                <?php if ($field['type_name'] == 'чекбокс'): ?>
                    <td><input type="checkbox" name="<?php echo $field['name'] ?>" number="<?php echo $i; ?>"/><br/></td>
                <?php elseif ($field['type_name'] == 'переключатель'): ?>
                    <td><input type="radio" name="<?php echo $field['name'] ?>" number="<?php echo $i; ?>"/><br/></td>
                <?php elseif ($field['type_name'] == 'файл'): ?>
                    <td><input id="photo100" style="display:inline;" number="<?php echo $i; ?>" class="input-file btn btn-primary" type="file" name="<?php echo $field['name'] ?>"/><br/></td>
                    <td><img src="" style="height:45px; display:none;"/><button type="button" class="cancel"/><br/></td>
                <input class="photo100" number="<?php echo $i; ?>" file="<?php echo $field['name'] ?>" type="hidden" name="attachment"/>
            <?php elseif ($field['type_name'] == 'список'): ?>
                <td>
                    <?php $query = get_select ($field['id']); //var_dump($query);?>
                    <select style="width:210px;" number="<?php echo $i; ?>" name="<?php echo $field['name'] ?>" class="text ui-widget-content ui-corner-all">
                        <option value="" selected="selected"> -- выбрать -- </option>
                        <?php if (isset ($query['mysql']) && !empty ($query['mysql'])): ?>
                            <?php $k   = 0; ?>
                            <?php while ($row = mysql_fetch_array ($query['mysql'])): ?>
                                <?php //var_dump($field)?>
                                <?php if (!empty ($row[$query['name']])): ?>
                                    <option value=""><?php echo $row[$query['name']]; ?></option>
                                    <?php $k++; ?>
                                <?php endif; ?>
                            <?php endwhile; ?>
                        <?php endif; ?>
                    </select>
                    <br/>
                </td>
            <?php elseif ($field['type_name'] == 'дата'): ?>
                <td><input type="text" number="<?php echo $i; ?>" style="height: 10px;width:200px;display: inline;font-weight: normal;" class="text ui-widget-content ui-corner-all datepicker" value="--/--/----" name="<?php echo $field['name'] ?>"/><br/></td>
            <?php elseif ($field['type_name'] == 'число'): ?>
                <td><input type="text" style="height: 10px;width:200px;display: inline;font-weight: normal;" number="<?php echo $i; ?>" class="text ui-widget-content ui-corner-all" value="0" name="<?php echo $field['name'] ?>"/><br/></td>
            <?php else: ?>
                <td><textarea number="<?php echo $i; ?>" class="text ui-widget-content ui-corner-all" type="text" style="display:inline;width:200px;" value="" name="<?php echo $field['name'] ?>"></textarea><br/></td>
                <?php endif; ?>
        </th>
        <?php $i++; ?>
        </tr>
    <?php endforeach; ?>
<?php endif; ?>
</table>
<script>
    $(function() {            
        $("input[id^=photo]").uploadify({
            'uploader' : '/uploadify/uploadify.swf', 
            'script' : '/uploadify/uploadify.php', 
            'cancelImg': '/uploadify/cancel.png',
            'folder': '/upload',
            'buttonImg'   : '/image/white.png',
            'width' : 82,
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
                    $('input[type=hidden][name=attachment][class='+event.currentTarget.id+']').val(response);
                }
            },
            'onCancel':function(event, ID, fileObj, data, remove, clearFast){
                $('input[name=attachment]').val('');
            }
        });
    });
</script>
<script>
    $(function(){
        $('.datepicker').datepicker({ 
            dateFormat: "dd/mm/yy",
            monthNames: ["Январь","Февраль","Март","Апрель","Май","Июнь","Июль","Август","Сентябрь","Октябрь","Ноябрь","Декабрь"],
            dayNamesMin: ["Пн", "Вт", "Ср", "Чт", "Пт", "Сб", "Вс"]
        });
    });
</script>
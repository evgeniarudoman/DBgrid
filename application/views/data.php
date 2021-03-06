<script>
    $(document).ready(function() 
    { 
        $("#myTable").tablesorter(); 
    } 
); 
</script>
<script language="javascript">
    $(document).ready(function() {
        //-----------------------------
        $("div.resize").resizable({ 
            handles: "e, w",
            stop: function() {
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: '<?php echo site_url ('fields/save_width') ?>',
                    data: "database_name="+'<?php
if (isset ($database))
    echo $database
    ?>'+
                            "&table_name="+'<?php
if (isset ($table))
    echo $table
    ?>'+
                            "&field_name="+$(this).children('input[type=hidden]').val()+
                            "&field_size="+$(this).width(),
                        success: function(response){
                            //change on something
                            //alert(response);
                        }
                    });
                }
            });
            //-----------------------------
        });
</script>
<script>
    $(document).ready(function(){
        $('input[type=checkbox]').click(function(){ 
            if ($(this).is(':checked'))
            { 
                $(this).parent('td').parent('tr').children('td').attr('style','background-color:#EFF1F1;text-shadow: 0 1px 0 #FFFFFF;  color: #005580;');
            }
            else
            {
                $(this).parent('td').parent('tr').children('td').removeAttr('style');
            }
        });
        //---------------------------------------------------------------------
        $('input[type=checkbox].check_all').click(function(){ 
            if ($(this).is(':checked'))
            {
                $('input[type=checkbox]').attr('checked','checked').parent('td').parent('tr').children('td').attr('style','background-color:#EFF1F1;text-shadow: 0 1px 0 #FFFFFF;  color: #005580;');
            }
            else
            {
                $('input[type=checkbox]').removeAttr('checked').parent('td').parent('tr').children('td').removeAttr('style');
            }
        });
        //---------------------------------------------------------------------
        $('span.total').text("<?php echo $result['num_rows'] ?>");
    });
</script>
<table id="myTable" class="tablesorter table-striped table-bordered table-condensed" style="margin-left: 20px;">
    <thead>
        <tr>
            <td title="Выбрать все строки">
                <input type="checkbox" class="check_all"/>
            </td>
            <?php $n = 0; ?>
            <?php foreach ($result[$database . '_' . $table . '_field'] as $key => $field): ?>
                <th class="header">
        <div class='resize' number="<?php echo $n; ?>" name="<?php echo $field['name']; ?>" style="width:<?php echo $field['width'] . 'px'; ?>;">
            <?php echo $field['name']; ?>
            <input type="hidden" value="<?php echo $field['name']; ?>" />
            <input type="hidden" name="sorting" value="0" />
        </div>
    </th>
    <?php $n++; ?>
<?php endforeach; ?>
<!--<td></td>-->
</tr>
</thead>
<tbody> 
    <?php $j   = 1; ?>
    <?php while ($row = mysql_fetch_array ($result['result'])): ?>
        <tr class="real<?php echo $j; ?>">
            <td class="check_one" title="Выбрать строку">
                <input type="checkbox" name="<?php echo $j; ?>" />
            </td>
            <?php $i = 0; ?>
            <?php foreach ($result[$database . '_' . $table . '_field'] as $key => $field): ?>
                <?php if ($field['type_name'] == 'файл'): ?>
                    <?php $ext = pathinfo ($row[mysql_field_name ($result['result'], $i)]); ?>
                    <?php if (isset ($ext["extension"]) && $ext["extension"] == 'docx'): ?>
                        <td><img src="/image/icons/docx.jpg" style="width: 25px;display: inline;" class="photo<?php echo $i ?>"/>&nbsp;<?php echo $ext["basename"]; ?></td>
                    <?php elseif (isset ($ext["extension"]) && $ext["extension"] == 'doc'): ?>
                        <td><img src="/image/icons/doc.jpg" style="width: 25px;display: inline;" class="photo<?php echo $i ?>"/>&nbsp;<?php echo $ext["basename"]; ?></td>
                    <?php elseif (isset ($ext["extension"]) && $ext["extension"] == 'txt'): ?>
                        <td><img src="/image/icons/txt.png" style="width: 25px;display: inline;" class="photo<?php echo $i ?>"/>&nbsp;<?php echo $ext["basename"]; ?></td>
                    <?php elseif (isset ($ext["extension"]) && $ext["extension"] == 'pdf'): ?>
                        <td><img src="/image/icons/pdf.png" style="width: 25px;display: inline;" class="photo<?php echo $i ?>"/>&nbsp;<?php echo $ext["basename"]; ?></td>
                    <?php elseif (isset ($ext["extension"]) && $ext["extension"] == 'xls'): ?>
                        <td><img src="/image/icons/xls.png" style="width: 25px;display: inline;" class="photo<?php echo $i ?>"/>&nbsp;<?php echo $ext["basename"]; ?></td>
                    <?php else: ?>
                        <td><img style="height: 45px;display: inline;" src="<?php echo $row[mysql_field_name ($result['result'], $i)] ?>"/></td>
                    <?php endif; ?> 
                <?php else: ?>
                    <td><?php echo $row[mysql_field_name ($result['result'], $i)] ?></td>
                <?php endif; ?>
                <?php $i++; ?>
            <?php endforeach; ?>
    <!-- <td class="edit_one" >
    <i class="icon-pencil" title="Редактировать строку" style="cursor:pointer" name="<?php echo $j; ?>"></i>
    </td>-->
        </tr>
        <tr style="display:none;" class="edit<?php echo $j; ?>">
            <td class="check_one" >
                <input type="checkbox" name="<?php echo $j; ?>" />
            </td>
            <?php $i = 0; ?>
            <?php foreach ($result[$database . '_' . $table . '_field'] as $key => $field): ?>
                <?php if ($field['type_name'] == 'чекбокс'): ?>
                    <td><input type="checkbox"/></td>
                <?php elseif ($field['type_name'] == 'переключатель'): ?>
                    <td><input type="radio" name="<?php echo $field['name'] ?>"/></td>
                <?php elseif ($field['type_name'] == 'файл'): ?>
                    <td>
                        <input id="photo<?php echo $j ?>"class="input-file btn btn-primary" type="file"/>
                        <input class="photo<?php echo $j ?>" number="<?php echo $j; ?>" type="hidden" name="attachment"/>
                    </td>
                <?php elseif ($field['type_name'] == 'список'): ?>
                    <td>
                        <select name="select" class="text ui-widget-content ui-corner-all">
                            <option value="" selected="selected"> -- choose database -- </option>
                        </select>
                    </td>
                <?php elseif ($field['type_name'] == 'дата'): ?>
                    <td><input type="text" class="datepicker" style="width:65px;height:10px;" value="<?php echo $row[mysql_field_name ($result['result'], $i)] ?>"/></td>
                <?php else: ?>
                    <td><input type="text" style="width:65px;height:10px;" value="<?php echo $row[mysql_field_name ($result['result'], $i)] ?>"/></td>
                <?php endif; ?>
                <?php $i++; ?>
            <?php endforeach; ?>
            <td class="edit_one" >
                <i class="icon-ok" title="Сохранить изменения" style="cursor:pointer" name="<?php echo $j; ?>"></i>
            </td>
        </tr>
        <?php $j++; ?>
    <?php endwhile; ?>
</tbody> 
</table>
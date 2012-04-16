<script>
    $(document).ready(function() 
    { 
        $("#myTable").tablesorter(); 
    } 
); 
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
    });
</script>
<table id="myTable" class="tablesorter table-striped table-bordered table-condensed" style="margin-left: 20px;">
    <thead>
        <tr>
            <td >
                <input type="checkbox" class="check_all"/>
            </td>
            <?php $n=0;?>
            <?php foreach ($result[$database . '_' . $table . '_field'] as $key => $field): ?>
                <th class="header" style="width:<?php echo $field['width'] . 'px'; ?>;position:relative;" onclick="$('.caret#up').hide();$('.caret#down').show();return false;">
        <div class='resize' number="<?php echo $n;?>" name="<?php echo $field['name']; ?>" >
            <?php echo $field['name']; ?>
            <input type="hidden" value="<?php echo $field['name']; ?>" />
            <input type="hidden" name="sorting" value="0" />
        </div>
    </th>        
    <?php $n++;?>
<?php endforeach; ?>
<td></td>
</tr>
</thead>
<tbody> 
    <?php $j = 1; ?>
    <?php while ($row = mysql_fetch_array($result['result'])): ?>
        <tr class="real<?php echo $j; ?>">
            <td class="check_one" >
                <input type="checkbox" name="<?php echo $j; ?>" />
            </td>
            <?php $i = 0; ?>
            <?php foreach ($result[$database . '_' . $table . '_field'] as $key => $field): ?>
                <?php if ($field['type_name'] == 'файл'): ?>
                    <td><i>No file.</i></td>
                <?php elseif ($field['type_name'] == 'дата'): ?>
                    <?php if (isset($row[mysql_field_name($result['result'], $i)]) && !empty($row[mysql_field_name($result['result'], $i)])): ?>
                        <td><?php echo $row[mysql_field_name($result['result'], $i)] ?></td>
                    <?php else: ?>
                        <td>--/--/----</td>
                    <?php endif; ?> 
                <?php else: ?>
                    <td><?php echo $row[mysql_field_name($result['result'], $i)] ?></td>
                <?php endif; ?>
                <?php $i++; ?>
            <?php endforeach; ?>
            <td class="edit_one" >
                <i class="icon-pencil" name="<?php echo $j; ?>"></i>
            </td>
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
                    <td><input id="photo<?php echo $j ?>"class="input-file btn btn-primary" type="file"/></td>
                <?php elseif ($field['type_name'] == 'список'): ?>
                    <td>
                        <select name="select" class="text ui-widget-content ui-corner-all">
                            <option value="" selected="selected"> -- choose database -- </option>
                        </select>
                    </td>
                <?php elseif ($field['type_name'] == 'дата'): ?>
                    <?php if (isset($row[mysql_field_name($result['result'], $i)]) && !empty($row[mysql_field_name($result['result'], $i)])): ?>
                        <td><input type="text" class="datepicker" style="width:65px;height:10px;" value="<?php echo $row[mysql_field_name($result['result'], $i)] ?>"/></td>
                    <?php else: ?>
                        <td><input type="text" class="datepicker" style="width:65px;height:10px;" value="--/--/----"/></td>
                    <?php endif; ?> 
                <?php else: ?>
                    <td><input type="text" style="width:65px;height:10px;" value="<?php echo $row[mysql_field_name($result['result'], $i)] ?>"/></td>
                <?php endif; ?>
                <?php $i++; ?>
            <?php endforeach; ?>
            <td class="edit_one" >
                <i class="icon-ok" name="<?php echo $j; ?>"></i>
            </td>
        </tr>
        <?php $j++; ?>
    <?php endwhile; ?>
</tbody> 
</table>
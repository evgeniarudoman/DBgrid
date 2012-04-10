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
            <td>
                <input type="checkbox" class="check_all"/>
            </td>
            <?php foreach ($result[$database . '_' . $table . '_field'] as $key => $field): ?>
                <th class="header" style="width:<?php echo $field['width'] . 'px'; ?>;position:relative;" onclick="$('.caret#up').hide();$('.caret#down').show();return false;">
        <div class='resize' name="<?php echo $field['name']; ?>" >
            <?php echo $field['name']; ?>
            <input type="hidden" value="<?php echo $field['name']; ?>" />
            <input type="hidden" name="sorting" value="0" />
        </div>
    </th>   
<?php endforeach; ?>
</tr>
</thead>
<tbody>
    <?php $j = 1; ?>
    <?php while ($row = mysql_fetch_array($result['result'])): ?>
        <tr>
            <td class="check_one" >
                <input type="checkbox" name="<?php echo $j; ?>" />
            </td>
            <?php $i = 0; ?>
            <?php foreach ($result[$database . '_' . $table . '_field'] as $key => $field): ?>
                <td><?php echo $row[mysql_field_name($result['result'], $i)] ?></td>
                <?php $i++; ?>
            <?php endforeach; ?>
        </tr>
        <?php $j++; ?>
    <?php endwhile; ?>
</tbody> 
</table>
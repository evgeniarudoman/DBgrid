<table class="table-striped table-bordered table-condensed" style="margin-left: 20px;">
    <tr>
        <td class="check_all">
            <input type="checkbox" />
        </td>
        <?php foreach ($result[$database . '_' . $table . '_field'] as $key => $field): ?>
            <th style="width:<?php echo $field['width'] . 'px'; ?>">
        <div class='resize' name="<?php echo $field['name']; ?>">
            <?php echo $field['name']; ?>
            <input type="hidden" value="<?php echo $field['name']; ?>"/>
        </div>
    </th>
<?php endforeach; ?>
</tr>
<?php $j = 1; ?>
<?php while ($row = mysql_fetch_array ($result['result'])): ?>
    <tr>
        <td class="check_one" >
            <input type="checkbox" name="<?php echo $j; ?>" onclick="$(this).parent('td').parent('tr').children('td').attr('style','background-color:#EFF1F1;text-shadow: 0 1px 0 #FFFFFF;  color: #005580;')"/>
        </td>
        <?php $i = 0; ?>
        <?php foreach ($result[$database . '_' . $table . '_field'] as $key => $field): ?>
            <td>
                <?php echo $row[mysql_field_name ($result['result'], $i)] ?>
            </td>
            <?php $i++; ?>
        <?php endforeach; ?>
    </tr>
    <?php $j++; ?>
<?php endwhile; ?>
</table>
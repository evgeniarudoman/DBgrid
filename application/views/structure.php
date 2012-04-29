<table id="myTables" class="tablesorter table-striped table-bordered table-condensed" style="margin-left: 20px;">
    <tr>
        <td title="Выбрать все строки" style="background-color: #E6EEEE">
            <input type="checkbox" class="check_all"/>
        </td>
        <th style="position:relative;background-color: #E6EEEE">
            Имя поля
        </th>
        <th style="position:relative;background-color: #E6EEEE">
            Тип
        </th>
    </tr>
    <tbody> 
        <?php $s = 1; ?>
        <?php foreach ($result[$database . '_' . $table . '_field'] as $key => $field): ?>
            <tr>
                <td class="check_one" title="Выбрать строку">
                    <input type="checkbox" name="<?php echo $s; ?>" />
                </td>
                <td><?php echo $field['name']; ?></td>
                <td><?php echo $field['type_name']; ?></td>
            </tr>
            <?php $s++; ?>
        <?php endforeach; ?>
    </tbody> 
</table>
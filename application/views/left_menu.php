<script>
    jQuery(document).ready(function(){
        $('#accordion .head').click(function() {
            $(this).next().toggle();
            return false;
        }).next().hide();
            
<?php if (isset ($data) && !empty ($data)): ?>
            $('table#tables[name=<?php echo $data ?>]').show();
<?php endif; ?>
    });
</script>
<?php echo $success; ?>
<ul class="nav nav-list">
    <?php if (isset ($result['databases'])): ?>
        <?php foreach ($result['databases'] as $database): ?>
            <li class="active head" name="<?php echo $database; ?>">
                <a href="#">
                    <i class="icon-list-alt icon-white"></i><?php echo $database; ?><i style="float:right;" title="Удалить базу данных" class="icon-trash icon-white" onclick="delete_db('<?php echo $database; ?>');"></i>
                </a>
            </li>
            <table id="tables" name="<?php echo $database; ?>" style="margin-left: 15px;height: 30px;width:100%;">
                <?php if (isset ($result[$database . '_table'])): ?>
                    <?php foreach ($result[$database . '_table'] as $table): ?>
                        <tr name="<?php echo $table; ?>">
                            <td style="width: 20px;"><i class="icon-th"></i></td>
                            <td style="width:247px">
                                <a href='/grid/index?database=<?php echo $database ?>&table=<?php echo $table; ?>'>
                                    <?php echo $table . ' (<i>' . count ($result[$database . '_' . $table . '_field']) . '</i>)'; ?>
                                </a>
                            </td>
                            <td style="width:20px">
                                <i class="icon-pencil" title="Переименовать таблицу" style="cursor: pointer;" onclick="edit_table('<?php echo $database; ?>', '<?php echo $table; ?>');"></i>
                            </td>
                            <td>
                                <i class="icon-trash" title="Удалить таблицу" style="cursor: pointer;" onclick="delete_table('<?php echo $database; ?>', '<?php echo $table; ?>');"></i>
                            </td>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <td style="width: 20px;" class='no_table'><i class="icon-th"></i></td>
                        <td><i>No tables.</i></td>
                    <?php endif; ?>
                </tr>
            </table>
        <?php endforeach; ?>
    <?php else: ?>
        <i class="no_db">No databases.</i>
    <?php endif; ?>
</ul>
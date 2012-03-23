<table id='table'>
    <tr>
        <?php if (isset($_GET) && empty($_GET)): ?>
            <td class='left_menu' bgcolor='#002F32'>   
                <table id="databases">
                    <tr>
                        <td class='database_title ui-state-error' colspan=2>all database</td>
                    </tr>
                    <?php if (isset($result['databases'])): ?>
                        <?php foreach ($result['databases'] as $database): ?>
                            <tr>
                                <td><div class="icon table"></div></td>
                                <td><a href='/grid/index?database=<?php echo $database; ?>'>
                                        <?php echo $database; ?></a></div></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </table>
            </td>
        <?php elseif (isset($_GET['database']) && !empty($_GET['database'])): ?>
            <td class='left_menu' bgcolor='#002F32'>   
                <table id="tables">
                    <tr>
                        <td class='database_title ui-state-error' colspan=2>database "<?php echo $_GET['database'] ?>"</td>
                    </tr>
                    <?php if (isset($result[$_GET['database'] . '_table'])): ?>
                        <?php foreach ($result[$_GET['database'] . '_table'] as $table): ?>
                            <tr>
                                <td><div class="icon table"></div></td>
                                <td><a href='/grid/index?database=<?php echo $_GET['database'] ?>&table=<?php echo $table; ?>'>
                                        <?php echo $table . ' (<i>' . count($result[$_GET['database'] . '_field']) . '</i>)'; ?></a></div></td>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tr>
                </table>
            </td>
            <?php if (isset($_GET['table']) && !empty($_GET['table'])): ?>
                <td id='content'>
                    <table>
                        <tr>
                            <td bgcolor='#002F32' class="ui-widget-header"><div class="icon checkbox_all"><input type='checkbox'></div></td><td bgcolor='#002F32' class="ui-widget-header">#</td>
                            <?php foreach ($result[$_GET['database'] . '_field'] as $key => $field): ?>
                                <td bgcolor='#002F32'  class="ui-widget-header" name='<?php echo $key; ?>'><div class='resize'><?php echo $field['name']; ?></div></td>
                            <?php endforeach; ?>
                        </tr>
                        <?php $j = 1; ?>
                        <?php while ($row = mysql_fetch_array($result['result'])): ?>
                            <tr>
                                <td><div class="icon checkbox"><input type='checkbox' value=""></div></td>
                                <td class='id'><?php echo $j ?></td>
                                <?php for ($i = 0; $i < mysql_num_fields($result['result']); $i++): ?>
                                    <td><?php echo $row[mysql_field_name($result['result'], $i)] ?></td>
                                <?php endfor; ?>
                            </tr>
                            <?php $j++; ?>
                        <?php endwhile; ?>
                    </table>
                    <table>
                        <tr>
                            <td  class="ui-state-error">
                                <a href="">
                                    <div class="icon add"></div>
                                </a>
                            </td>
                            <td  class="ui-state-error">
                                <a href="">
                                    <div class="icon edit"></div>
                                </a>
                            </td>
                            <td  class="ui-state-error">
                                <a href="" id="remove" onclick="return false;">
                                    <div class="icon delete"></div>
                                </a>
                            </td>
                        </tr>
                    </table>
                </td>
            <?php endif; ?>
        <?php endif; ?>

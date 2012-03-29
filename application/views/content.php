<div class="container-fluid">
    <div class="row-fluid">
        <div class="span4">
            <div class="alert alert-info" style="text-align: center;">
                all databases
            </div>
            <div id="accordion">
                <div class="well" style="padding: 8px 0;height: 300px;">
                    <ul class="nav nav-list">
                        <?php if (isset($result['databases'])): ?>
                            <?php foreach ($result['databases'] as $database): ?>
                                <li class="active head">
                                    <a href="#">
                                        <i class="icon-list-alt icon-white"></i>
                                        <?php echo $database; ?>
                                    </a>
                                </li>
                                <table id="tables">
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
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>

        <div class="span8">
            <div class="well" style="padding: 8px 0;height: 353px;">
                <?php if (isset($_GET['table']) && !empty($_GET['table'])): ?>
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
                <?php endif; ?>

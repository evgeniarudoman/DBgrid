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
                                        <i style="float:right;" class="icon-trash icon-white"></i>
                                        <i style="float:right;" class="icon-pencil icon-white"></i>
                                    </a>
                                </li>
                                <table id="tables" style="margin-left: 15px;height: 30px;">
                                    <?php if (isset($result[$database . '_table'])): ?>
                                        <?php foreach ($result[$database . '_table'] as $table): ?>
                                            <tr>
                                                <td style="width: 20px;"><i class="icon-list-alt"></i></td>
                                                <td>
                                                    <a href='/grid/index?database=<?php echo $database ?>&table=<?php echo $table; ?>'>
                                                        <?php echo $table . ' (<i>' . count($result[$database . '_field']) . '</i>)'; ?></a>
                                                </td>
                                                <td> <i class="icon-pencil"></i></td>
                                                <td><i class="icon-trash"></i></td>
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
                    <table class="table-striped table-bordered table-condensed">
                        <tr>
                            <td ><div class="icon checkbox_all"><input type='checkbox'></div></td><td >#</td>
                            <?php foreach ($result[$_GET['database'] . '_field'] as $key => $field): ?>
                                <td  name='<?php echo $key; ?>'><div class='resize'><?php echo $field['name']; ?></div></td>
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
                  <!--  <table>
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
                    </table>-->
                <?php endif; ?>

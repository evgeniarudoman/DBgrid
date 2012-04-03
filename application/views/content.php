<div class="container-fluid">
    <div class="row-fluid">
        <div class="span4"> 
            <div class="alert alert-info" style="">
                <ul class="breadcrumb" style="background:none; border:none;box-shadow: none;color:#333;padding: 0;margin: 0;">
                    <?php if (isset($_GET['database'])): ?>
                        <li>
                            <a href="<?php echo site_url('grid') ?>">Home</a>
                            <span class="divider">/</span>
                        </li>
                        <?php if (isset($_GET['table'])): ?>
                            <li>
                                <a href="<?php echo site_url('grid/index?database=' . $_GET['database']) ?>">
                                    <?php echo $_GET['database']; ?>
                                </a> 
                                <span class="divider">/</span>
                            </li>
                            <li class="active">
                                <?php echo $_GET['table']; ?>
                            </li>
                        <?php else: ?>
                            <li class="active">
                                <?php echo $_GET['database']; ?>
                            </li>
                        <?php endif; ?>
                    <?php else: ?>
                        <div style="text-align:center;color:#3A87AD;">
                            Home
                        </div>
                    <?php endif; ?>
                </ul>
            </div>
            <div id="accordion">
                <div class="well" style="padding: 8px 0;height: 320px;">
                    <ul class="nav nav-list">
                        <?php if (isset($result['databases'])): ?>
                            <?php foreach ($result['databases'] as $database): ?>
                                <li class="active head">
                                    <a href="#">
                                        <i class="icon-list-alt icon-white"></i>
                                        <?php echo $database; ?>
                                        <i style="float:right;" class="icon-trash icon-white" onclick="delete_db('<?php echo $database; ?>');"></i>
                                        &nbsp;
                                        <i style="float:right;" class="icon-pencil icon-white" onclick="edit_db('<?php echo $database; ?>');"></i>
                                    </a>
                                </li>
                                <table id="tables" style="margin-left: 15px;height: 30px;">
                                    <?php if (isset($result[$database . '_table'])): ?>
                                        <?php foreach ($result[$database . '_table'] as $table): ?>
                                            <tr>
                                                <td style="width: 20px;"><i class="icon-th"></i></td>
                                                <td>
                                                    <a href='/grid/index?database=<?php echo $database ?>&table=<?php echo $table; ?>'>
                                                        <?php echo $table . ' (<i>' . count($result[$database . '_' . $table . '_field']) . '</i>)'; ?>
                                                    </a>
                                                </td>
                                                <td>
                                                    <i class="icon-pencil" style="cursor: pointer;" onclick="edit_table('<?php echo $database; ?>', '<?php echo $table; ?>');"></i>
                                                </td>
                                                <td>
                                                    <i class="icon-trash" style="cursor: pointer;" onclick="delete_table('<?php echo $database; ?>', '<?php echo $table; ?>');"></i>
                                                </td>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <td style="width: 20px;"><i class="icon-th"></i></td>
                                            <td><i>No tables.</i></td>
                                        <?php endif; ?>
                                    </tr>
                                </table>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <i>No databases.</i>
                        <?php endif; ?>
                    </ul>
                </div>
                <div class="btn-toolbar" style="margin-bottom: 9px">
                    <div class="btn-group">
                        <a class="btn btn-primary btn-mini" href="#"><i class="icon-plus icon-white"></i> Create</a>
                        <a onclick="open_dropdown('icon-plus');" class="btn btn-primary dropdown-toggle btn-mini" data-toggle="dropdown" href="#"><span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li style="background-color: #08C;"><a href="#" style="color:#fff;"><i class="icon-plus"></i> Create</a></li>
                            <li class="divider"></li>
                            <li><a href="#" id="create-database"><i class="icon-list-alt"></i> Database</a></li>
                            <li><a href="#" id="create-table"><i class="icon-th"></i> Table</a></li>
                        </ul>
                    </div>
                    <div class="btn-group">
                        <a class="btn btn-primary btn-mini" href="#"><i class="icon-random icon-white"></i></a>
                        <a onclick="open_dropdown('icon-random');" class="btn btn-primary dropdown-toggle btn-mini" data-toggle="dropdown" href="#"><span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li style="background-color: #08C;"><a href="#" style="color:#fff;"><i class="icon-random"></i> Relations</a></li>
                            <li class="divider"></li>
                            <li><a href="#"><i class="icon-plus"></i> Create</a></li>
                            <li><a href="#"><i class="icon-trash"></i> Remove</a></li>
                        </ul>
                    </div>
                    <div class="btn-group dropup" style="float:right;">
                        <a class="btn btn-primary btn-mini" href="#"><i class="icon-th-large icon-white"></i></a>
                        <a onclick="open_dropdown('icon-th-large');" class="btn btn-primary dropdown-toggle btn-mini" data-toggle="dropdown" href="#"><span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li style="background-color: #08C;"><a href="#" style="color:#fff;"><i class="icon-th-large"></i> Choose theme</a></li>
                            <li class="divider"></li>
                            <li><a href="" onclick="get_theme('blue');return false;"><i class="icon-tint"></i> Blue</a></li>
                            <li><a href="" onclick="get_theme('gray');return false;"><i class="icon-tint"></i> Gray</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="span8">
            <div class="well" style="padding: 8px 0;height: 400px;position: relative;">
                <?php if (isset($_GET['table']) && !empty($_GET['table'])): ?>
                    <table class="table-striped table-bordered table-condensed" style="margin-left: 20px;">
                        <tr>
                            <td class="check_all">
                               <!-- <i class="icon-check"></i>-->
                                <input type="checkbox" />
                            </td>
                            <?php foreach ($result[$_GET['database'] . '_' . $_GET['table'] . '_field'] as $key => $field): ?>
                                <th style="width:<?php echo $field['width'] . 'px'; ?>">
                            <div class='resize' name="<?php echo $field['name']; ?>">
                                <?php echo $field['name']; ?>
                                <input type="hidden" value="<?php echo $field['name']; ?>"/>
                            </div>
                            </th>
                        <?php endforeach; ?>
                        </tr>
                        <?php $j = 1; ?>
                        <?php while ($row = mysql_fetch_array($result['result'])): ?>
                            <tr>
                                <td class="check_one" >
                                  <!--  <i class="icon-check"></i>-->
                                    <input type="checkbox" name="<?php echo $j; ?>" onclick="$(this).parent('td').parent('tr').children('td').attr('style','background-color:#EFF1F1;text-shadow: 0 1px 0 #FFFFFF;  color: #005580;')"/>
                                </td>

                                <?php $i = 0; ?>
                                <?php foreach ($result[$_GET['database'] . '_' . $_GET['table'] . '_field'] as $key => $field): ?>
                                    <td><?php echo $row[mysql_field_name($result['result'], $i)] ?></td>
                                       <!-- <input type="text" name="<?php //echo $field['name'].'_'.$j;   ?>" style="width:<?php //echo 10 * $field['size'] . 'px';   ?>" class="input-small" value="<?php //echo $row[mysql_field_name ($result['result'], $i)]   ?>"/>--> 
                                    <?php $i++; ?>
                                <?php endforeach; ?>

                                <!--
                                <?php //for ($i = 0; $i < mysql_num_fields ($result['result']); $i++): ?>
                                <td onclick="/*$(this).append('<input type=\'text\'/>');*/">
                                    <input type="text" class="input-small" value="<?php //echo $row[mysql_field_name ($result['result'], $i)]    ?>"/>                                        
                                </td>
                                <?php //endfor; ?>
                                -->
                            </tr>
                            <?php $j++; ?>
                        <?php endwhile; ?>
                    </table>
                    <i class="icon-plus" style="cursor: pointer;position: absolute;bottom: 10px;left: 20px;" id="add-row"></i>
                    <i class="icon-pencil" style="cursor: pointer;position: absolute;bottom: 10px;left: 40px;"></i>
                    <i class="icon-trash" style="cursor: pointer;position: absolute;bottom: 10px;left: 60px;"></i>
                <?php endif; ?>
<!--onclick="add_row('<?php //echo $_GET['database'];   ?>', '<?php //echo $_GET['table'];   ?>', '<?php //echo mysql_num_fields ($result['result']);   ?>');"-->
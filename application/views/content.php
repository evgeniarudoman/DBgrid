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
                                        <i style="float:right;width:20px" class="icon-pencil icon-white" onclick="edit_db('<?php echo $database; ?>');"></i>
                                    </a>
                                </li>
                                <table id="tables" name="<?php echo $database; ?>" style="margin-left: 15px;height: 30px;width:100%;">
                                    <?php if (isset($result[$database . '_table'])): ?>
                                        <?php foreach ($result[$database . '_table'] as $table): ?>
                                            <tr name="<?php echo $table; ?>">
                                                <td style="width: 20px;"><i class="icon-th"></i></td>
                                                <td style="width:247px">
                                                    <a href='/grid/index?database=<?php echo $database ?>&table=<?php echo $table; ?>'>
                                                        <?php echo $table . ' (<i>' . count($result[$database . '_' . $table . '_field']) . '</i>)'; ?>
                                                    </a>
                                                </td>
                                                <td style="width:20px">
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
                    <form class="form-horizontal">
                        <fieldset>
                            <div class="control-group">
                                <div class="controls">
                                    <div class="input-append">
                                        <input type="text" size="16" id="appendedInput" class="span2" onkeypress="if ( event.keyCode == 13 ) { search_by(); return false; }" onchange="search_by();">
                                        <span class="add-on btn" onclick="search_by();"><i class="icon-search"></i></span>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                    <i class="icon-plus" style="cursor: pointer;bottom: 10px;margin-left: 20px;" id="add-field"></i>
                    <div id="ajax-page">
                        <table id="myTable" class="tablesorter table-striped table-bordered table-condensed" style="margin-left: 20px;">
                            <thead>
                                <tr>
                                    <td >
                                        <input type="checkbox" class="check_all"/>
                                    </td>
                                    <?php foreach ($result[$_GET['database'] . '_' . $_GET['table'] . '_field'] as $key => $field): ?>
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
                                        <?php foreach ($result[$_GET['database'] . '_' . $_GET['table'] . '_field'] as $key => $field): ?>
                                            <?php if ($field['type_name'] == 'чекбокс'): ?>
                                                <td><input type="checkbox"/></td>
                                            <?php elseif ($field['type_name'] == 'переключатель'): ?>
                                                <td><input type="radio" name="<?php echo $field['name']?>"/></td>
                                            <?php elseif ($field['type_name'] == 'файл'): ?>
                                                <td>FILE</td>
                                            <?php elseif ($field['type_name'] == 'список'): ?>
                                                <td>
                                                    <select name="select" class="text ui-widget-content ui-corner-all">
                                                        <option value="" selected="selected"> -- choose database -- </option>
                                                    </select>
                                                </td>
                                            <?php elseif ($field['type_name'] == 'дата'): ?>
                                                <td><input type="text" class="datepicker" style="width:65px;height:10px;" value="<?php echo $row[mysql_field_name($result['result'], $i)] ?>"/></td>
                                            <?php else: ?>
                                                <td><?php echo $row[mysql_field_name($result['result'], $i)] ?></td>
                                            <?php endif; ?>
                                            <?php $i++; ?>
                                        <?php endforeach; ?>
                                    </tr>
                                    <?php $j++; ?>
                                <?php endwhile; ?>
                            </tbody> 
                        </table>
                    </div>
                    <i class="icon-plus" style="cursor: pointer;position: absolute;bottom: 10px;left: 20px;" id="add-row"></i>
                    <i class="icon-pencil" style="cursor: pointer;position: absolute;bottom: 10px;left: 40px;"></i>
                    <i class="icon-trash" style="cursor: pointer;position: absolute;bottom: 10px;left: 60px;"></i>
                    <a href="<?php echo site_url('export/xls') . '?' . $_SERVER["QUERY_STRING"]; ?>">
                        <i class="icon-file" style="cursor: pointer;position: absolute;bottom: 10px;left: 100px;"></i>
                    </a>
                    <div class="pagination">
                        <ul style="position: absolute;left:20px;">
                            <li class="active"><a href="#">1</a></li>
                            <?php for ($k = 2; $k <= ceil($result['num_rows'] / 8); $k++): ?>
                                <li><a href="#"><?php echo $k ?></a></li>
                            <?php endfor; ?>
                        </ul>
                    </div>
                <?php endif; ?>
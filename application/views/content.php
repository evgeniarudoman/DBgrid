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
                <div class="well" style="padding: 8px 0;height: 360px;">
                    <ul class="nav nav-list">
                        <?php if (isset($result['databases'])): ?>
                            <?php foreach ($result['databases'] as $database): ?>
                                <li class="active head" name="<?php echo $database; ?>">
                                    <a href="#">
                                        <i class="icon-list-alt icon-white"></i><?php echo $database; ?><i style="float:right;" title="Удалить базу данных" class="icon-trash icon-white" onclick="delete_db('<?php echo $database; ?>');"></i>
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
                </div>
                <div class="btn-toolbar" style="margin-bottom: 9px">
                    <div class="btn-group">
                        <a class="btn btn-primary btn-mini" href="#"><i class="icon-plus icon-white"></i> Создать</a>
                        <a onclick="" class="btn btn-primary dropdown-toggle btn-mini" title="Создать базу/таблицу" data-toggle="dropdown" href="#"><span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li style="background-color: #08C;"><a href="#" style="color:#fff;"><i class="icon-plus"></i> Создать</a></li>
                            <li class="divider"></li>
                            <li><a href="#" id="create-database"><i class="icon-list-alt"></i> База данных</a></li>
                            <li><a href="#" id="create-table"><i class="icon-th"></i> Таблица</a></li>
                        </ul>
                    </div>
                    <div class="btn-group">
                        <a class="btn btn-primary btn-mini" href="#"><i class="icon-random icon-white"></i></a>
                        <a onclick="open_dropdown('icon-random');" title="Связи создать/удалить" class="btn btn-primary dropdown-toggle btn-mini" data-toggle="dropdown" href="#"><span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li style="background-color: #08C;"><a href="#" style="color:#fff;"><i class="icon-random"></i> Связи</a></li>
                            <li class="divider"></li>
                            <li><a href="#"><i class="icon-plus"></i> Создать</a></li>
                            <li><a href="#"><i class="icon-trash"></i> Удалить</a></li>
                        </ul>
                    </div>
                    <div class="btn-group dropup" style="float:right;">
                        <a class="btn btn-primary btn-mini" href="#"><i class="icon-th-large icon-white"></i></a>
                        <a onclick="open_dropdown('icon-th-large');" title="Выбрать тему" class="btn btn-primary dropdown-toggle btn-mini" data-toggle="dropdown" href="#"><span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li style="background-color: #08C;"><a href="#" style="color:#fff;"><i class="icon-th-large"></i> Выбрать тему</a></li>
                            <li class="divider"></li>
                            <?php foreach ($list_theme as $theme): ?>
                                <li><a href="" onclick="get_theme('<?php echo $theme ?>');return false;"><i class="icon-tint"></i> <?php echo $theme ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="span8">
            <div id="tabs" style="width: 100%;" class="ui-tabs ui-widget ui-widget-content ui-corner-all">
                <ul class="ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all">
                    <li class="ui-state-default ui-corner-top "><a href="#tabs-1" onclick="return false;">Структура</a></li>
                    <li class="ui-state-default ui-corner-top ui-tabs-selected ui-state-active"><a href="#tabs-2" onclick="return false;">Обзор</a></li>
                </ul>
                <div class="wells" style="padding: 8px 0;min-height: 400px;height: 100%;position: relative;">
                    <?php if (isset($_GET['table']) && !empty($_GET['table'])): ?>
                        <div id="tabs-1" class="ui-tabs-panel ui-widget-content ui-corner-bottom">
                            <div id="structure">
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
                                        <?php foreach ($result[$_GET['database'] . '_' . $_GET['table'] . '_field'] as $key => $field): ?>
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
                            </div>
                            <i class="icon-plus" title="Добавить столбец" style="cursor: pointer;position: absolute;bottom: 10px;left: 20px;" id="add-field"></i>
                            <i class="icon-trash" title="Удалить столбец" style="cursor: pointer;position: absolute;bottom: 10px;left: 40px;"></i>
                        </div>
                        <div id="tabs-2" class="ui-tabs-panel ui-widget-content ui-corner-bottom ui-tabs-hide">
                            <form class="form-horizontal">
                                <fieldset>
                                    <div class="control-group">
                                        <div class="controls">
                                            <div class="input-prepend" title="Поиск">
                                                <span class="add-on btn" style="margin-right: -5px;" onclick="search_by();"><i class="icon-search"></i></span>
                                                <input type="text" size="16" id="prependedInput" placeholder="Search..." style="" class="span2" onkeypress="if ( event.keyCode == 13 ) { search_by(); return false; }" onchange="search_by();">
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                            </form>
                            <!--
                            <div class="save-changes ui-state-highlight" style="padding-left: 10px;padding-top: 5px;margin-bottom: 15px;width: 275px;margin-left: 25px;height:20px;display:inline;display:none;">
                                <p>
                                    <span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>
                                    <strong></strong> Вы должны сохранить все изменения.
                                </p>
                            </div>
                            -->
                            <div id="ajax-page" style="margin-bottom: 40px;">
                                <table id="myTable" class="tablesorter table-striped table-bordered table-condensed" style="margin-left: 20px;">
                                    <thead>
                                        <tr>
                                            <td title="Выбрать все строки">
                                                <input type="checkbox" class="check_all"/>
                                            </td>
                                            <?php $n = 0; ?>
                                            <?php foreach ($result[$_GET['database'] . '_' . $_GET['table'] . '_field'] as $key => $field): ?>
                                                    <th class="header" >
                                        <div class='resize' number="<?php echo $n; ?>" name="<?php echo $field['name']; ?>" style="width:<?php echo $field['width'] . 'px'; ?>;" >
                                            <?php echo $field['name']; ?>
                                            <input type="hidden" value="<?php echo $field['name']; ?>" />
                                            <input type="hidden" name="sorting" value="0" />
                                        </div>
                                        </th>
                                        <?php $n++; ?>
                                    <?php endforeach; ?>
                                    <!--<td></td>-->
                                    </tr>
                                    </thead>
                                    <tbody> 
                                        <?php $j = 1; ?>
                                        <?php while ($row = mysql_fetch_array($result['result'])): ?>
                                            <tr class="real<?php echo $j; ?>">
                                                <td class="check_one" title="Выбрать строку">
                                                    <input type="checkbox" name="<?php echo $j; ?>" />
                                                </td>
                                                <?php $i = 0; ?>
                                                <?php foreach ($result[$_GET['database'] . '_' . $_GET['table'] . '_field'] as $key => $field): ?>
                                                    <?php if ($field['type_name'] == 'файл'): ?>
                                                        <?php $ext = pathinfo($row[mysql_field_name($result['result'], $i)]); ?>
                                                        <?php if (isset($ext["extension"]) && $ext["extension"] == 'docx'): ?>
                                                            <td><img src="/image/icons/docx.jpg" style="width: 25px;display: inline;" class="photo<?php echo $i ?>"/>&nbsp;<?php echo $ext["basename"]; ?></td>
                                                        <?php elseif (isset($ext["extension"]) && $ext["extension"] == 'doc'): ?>
                                                            <td><img src="/image/icons/doc.jpg" style="width: 25px;display: inline;" class="photo<?php echo $i ?>"/>&nbsp;<?php echo $ext["basename"]; ?></td>
                                                        <?php elseif (isset($ext["extension"]) && $ext["extension"] == 'xls'): ?>
                                                            <td><img src="/image/icons/xls.png" style="width: 25px;display: inline;" class="photo<?php echo $i ?>"/>&nbsp;<?php echo $ext["basename"]; ?></td>
                                                        <?php elseif (isset($ext["extension"]) && $ext["extension"] == 'pdf'): ?>
                                                            <td><img src="/image/icons/pdf.png" style="width: 25px;display: inline;" class="photo<?php echo $i ?>"/>&nbsp;<?php echo $ext["basename"]; ?></td>
                                                        <?php elseif (isset($ext["extension"]) && $ext["extension"] == 'txt'): ?>
                                                            <td><img src="/image/icons/txt.png" style="width: 25px;display: inline;" class="photo<?php echo $i ?>"/>&nbsp;<?php echo $ext["basename"]; ?></td>
                                                        <?php else: ?>
                                                            <td><img style="height: 45px;display: inline;" src="<?php echo $row[mysql_field_name($result['result'], $i)] ?>"/></td>
                                                        <?php endif; ?> 
                                                    <?php else: ?>
                                                        <td><?php echo $row[mysql_field_name($result['result'], $i)] ?></td>
                                                    <?php endif; ?>
                                                    <?php $i++; ?>
                                                <?php endforeach; ?>
                                                        <!--
                                                <td class="edit_one" >
                                                    <i class="icon-pencil" title="Редактировать строку" style="cursor:pointer" name="<?php echo $j; ?>"></i>
                                                </td>
                                                        -->
                                            </tr>
                                            <tr style="display:none;" class="edit<?php echo $j; ?>">
                                                <td class="check_one" >
                                                    <input type="checkbox" name="<?php echo $j; ?>" />
                                                </td>
                                                <?php $i = 0; ?>
                                                <?php foreach ($result[$_GET['database'] . '_' . $_GET['table'] . '_field'] as $key => $field): ?>
                                                    <?php if ($field['type_name'] == 'чекбокс'): ?>
                                                        <td><input type="checkbox"/></td>
                                                    <?php elseif ($field['type_name'] == 'переключатель'): ?>
                                                        <td><input type="radio" name="<?php echo $field['name'] ?>"/></td>
                                                    <?php elseif ($field['type_name'] == 'файл'): ?>
                                                        <td>
                                                            <input id="photo<?php echo $j ?>"class="input-file btn btn-primary" type="file"/>
                                                            <input class="photo<?php echo $j ?>" number="<?php echo $j; ?>" type="hidden" name="attachment"/>
                                                        </td>
                                                    <?php elseif ($field['type_name'] == 'список'): ?>
                                                        <td>
                                                            <select name="select" class="text ui-widget-content ui-corner-all">
                                                                <option value="" selected="selected"> -- choose database -- </option>
                                                            </select>
                                                        </td>
                                                    <?php elseif ($field['type_name'] == 'дата'): ?>
                                                        <td><input type="text" class="datepicker" style="width:65px;height:10px;" value="<?php echo $row[mysql_field_name($result['result'], $i)] ?>"/></td>
                                                    <?php else: ?>
                                                        <td><input type="text" style="width:65px;height:10px;" value="<?php echo $row[mysql_field_name($result['result'], $i)] ?>"/></td>
                                                    <?php endif; ?>
                                                    <?php $i++; ?>
                                                <?php endforeach; ?>
                                                <td class="edit_one" >
                                                    <i class="icon-ok" title="Сохранить изменения" style="cursor:pointer" name="<?php echo $j; ?>"></i>
                                                </td>
                                            </tr>
                                            <?php $j++; ?>
                                        <?php endwhile; ?>
                                    </tbody> 
                                </table>
                            </div>
                            <!--
                            <div class="pagination">
                                <ul style="position: absolute;left:20px;">
                                    <li class="active"><a href="#">1</a></li>
                            <?php //for ($k = 2; $k <= ceil ($result['num_rows'] / 5); $k++): ?>
                                        <li><a href="#"><?php //echo $k    ?></a></li>
                            <?php //endfor; ?>
                                </ul>
                            </div>
                            -->
                            <div style="display:inline;position:absolute;width: 100%;bottom: 20px;" id="pages">
                                <i class="icon-plus" title="Добавить строку" style="cursor: pointer;bottom: 10px;margin-left: 20px;" id="add-row"></i>
                                <i class="icon-pencil" title="Редактировать строку" style="cursor: pointer;bottom: 10px;margin-left: 5px;"></i>
                                <i class="icon-trash" title="Удалить строку" style="cursor: pointer;bottom: 10px;margin-left: 5px;"></i>
                                <a href="<?php echo site_url('export/xls') . '?' . $_SERVER["QUERY_STRING"]; ?>">
                                    <i class="icon-file" title="Экспорт в XLS" style="cursor: pointer;bottom: 10px;margin-left: 20px;"></i>
                                </a>

                                <span style="margin-left: 20%;">
                                    <a href="#" class="previous-page" >
                                        «
                                    </a>
                                </span>
                                <span> | Page </span>
                                <input type="text" value="1" style="height:14px;width:22px;"/>
                                <span>of <span class="total"><?php echo ceil($result['num_rows'] / 5); ?></span> | </span>
                                <span>
                                    <a href="#" class="next-page" >
                                        »
                                    </a>
                                </span>
                                <select style="width:42px;height:24px;">
                                    <option value="" >1</option>
                                    <option value="" >2</option>
                                    <option value="" >3</option>
                                    <option value="" selected="selected">5</option>
                                </select>
                            </div>

                        <?php endif; ?>
                    </div>
<div class="container-fluid">
    <div class="row-fluid">
        <div class="span4"> 
            <div class="alert alert-info" style="text-align: center;">
                DBGrid
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
                                        &nbsp;
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
                <div class="btn-toolbar" style="margin-bottom: 9px">
                    <div class="btn-group">
                        <a class="btn btn-primary btn-mini" href="#"><i class="icon-list-alt icon-white"></i></a>
                        <a onclick="open_dropdown('icon-list-alt');" class="btn btn-primary dropdown-toggle btn-mini" data-toggle="dropdown" href="#"><span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="#"><i class="icon-list-alt"></i> Databases</a></li>
                            <li class="divider"></li>
                            <li id="create-database"><a href="#"><i class="icon-plus"></i> Create</a></li>
                            <li><a href="#"><i class="icon-pencil"></i> Rename</a></li>
                            <li><a href="#"><i class="icon-trash"></i> Remove</a></li>
                        </ul>
                    </div>
                    <div class="btn-group">
                        <a class="btn btn-primary btn-mini" href="#"><i class="icon-th icon-white"></i></a>
                        <a onclick="open_dropdown('icon-th');" class="btn btn-primary dropdown-toggle btn-mini" data-toggle="dropdown" href="#"><span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="#"><i class="icon-th"></i> Tables</a></li>
                            <li class="divider"></li>
                            <li id="create-table"><a href="#"><i class="icon-plus"></i> Create</a></li>
                            <li><a href="#"><i class="icon-pencil"></i> Rename</a></li>
                            <li><a href="#"><i class="icon-trash"></i> Remove</a></li>
                        </ul>
                    </div>
                    <div class="btn-group">
                        <a class="btn btn-primary btn-mini" href="#"><i class="icon-random icon-white"></i></a>
                        <a onclick="open_dropdown('icon-random');" class="btn btn-primary dropdown-toggle btn-mini" data-toggle="dropdown" href="#"><span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="#"><i class="icon-random"></i> Relations</a></li>
                            <li class="divider"></li>
                            <li><a href="#"><i class="icon-plus"></i> Create</a></li>
                            <li><a href="#"><i class="icon-trash"></i> Remove</a></li>
                        </ul>
                    </div>
                    <div class="btn-group">
                        <a class="btn btn-primary btn-mini" href="#"><i class="icon-th-list icon-white"></i></a>
                        <a onclick="open_dropdown('icon-th-list');" class="btn btn-primary dropdown-toggle btn-mini" data-toggle="dropdown" href="#"><span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="#"><i class="icon-th-list"></i> Fields</a></li>
                            <li class="divider"></li>
                            <li><a href="#"><i class="icon-plus"></i> Add</a></li>
                            <li><a href="#"><i class="icon-pencil"></i> Edit</a></li>
                            <li><a href="#"><i class="icon-trash"></i> Remove</a></li>
                        </ul>
                    </div>
                    <div class="btn-group" style="float:right;">
                        <a class="btn btn-primary btn-mini" href="#"><i class="icon-th-large icon-white"></i></a>
                        <a onclick="open_dropdown('icon-th-large');" class="btn btn-primary dropdown-toggle btn-mini" data-toggle="dropdown" href="#"><span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="#"><i class="icon-th-large"></i> Choose theme</a></li>
                            <li class="divider"></li>
                            <li><a href="#"><i class="icon-tint"></i> Blue</a></li>
                            <li><a href="#"><i class="icon-tint"></i> Gray</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="span8">
            <div class="well" style="padding: 8px 0;height: 379px;">
                <?php if (isset($_GET['table']) && !empty($_GET['table'])): ?>
                    <table class="table-striped table-bordered table-condensed" style="margin-left: 20px;">
                        <tr>
                            <td class="check_all">
                               <!-- <i class="icon-check"></i>-->
                                <input type="checkbox" />
                            </td>
                            <?php foreach ($result[$_GET['database'] . '_field'] as $key => $field): ?>
                                <th  name='<?php echo $key; ?>'><div class='resize'><?php echo $field['name']; ?></div></th>
                        <?php endforeach; ?>
                        </tr>
                        <?php $j = 1; ?>
                        <?php while ($row = mysql_fetch_array($result['result'])): ?>
                            <tr>
                                <td class="check_one" >
                                  <!--  <i class="icon-check"></i>-->
                                    <input type="checkbox" />
                                </td>
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



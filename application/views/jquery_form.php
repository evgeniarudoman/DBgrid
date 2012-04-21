<!-- delete rows-->
<div id="dialog-remove" title="Удаление строки" style="display: none;">
    Вы уверенны, что хотите удалить эту строку?
</div>
<!-- end delete rows-->

<!-- delete rows-->
<div id="remove-field" title="Удаление столбца" style="display: none;">
    Вы уверенны, что хотите удалить этот столбец?
</div>
<!-- end delete rows-->

<!-- delete rows-->
<div id="database-remove" title="Удаление базы данных" style="display: none;">
    Вы уверенны, что хотите удалить эту базу данных?
</div>
<!-- end delete rows-->

<!-- delete rows-->
<div id="table-remove" title="Удаление таблицы" style="display: none;">
    Вы уверенны, что хотите удалить эту таблицу?
</div>
<!-- end delete rows-->

<!-- create new database form -->    
<div id="database-form" title="Добавление базы данных" class="ui-dialog-content ui-widget-content" style="width: auto; min-height: 0px; height: 216px;display: none; " scrolltop="0" scrollleft="0">
    <div class="ui-state-highlight" style="padding: 0 .7em;padding-top: 5px;margin-bottom: 15px;">
        <p>
            <span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>
            <strong></strong> Все поля обязательны для заполнения.
        </p>
    </div>
    <form>
        <fieldset>
            <table>
                <tr>
                    <td style="width:120px">
                        <label for="database">Имя базы данных <span class="star">*</span></label>
                    </td>
                    <td>
                        <input type="text" style="height: 10px;width:200px;display: inline;font-weight: normal;" name="database" id="database" class="text ui-widget-content ui-corner-all">
                    </td>
                </tr>
            </table>
        </fieldset>
    </form>
</div>
<!-- end database form -->

<!-- create new row form  -->
<div id="row-form" title="Добавление строки" class="ui-dialog-content ui-widget-content" style="width: auto; min-height: 0px; height: 216px;display: none; " scrolltop="0" scrollleft="0">
    <p class="validateTips"></p>
    <form>
        <fieldset>
            <table>
                <?php $i = 0; ?>
                <?php if (isset ($_GET['database']) && !empty ($_GET['database']) && isset ($_GET['table']) && !empty ($_GET['table'])): ?>
                    <?php foreach ($result[$_GET['database'] . '_' . $_GET['table'] . '_field'] as $key => $field): ?>
                        <tr>
                            <td name='<?php echo $key; ?>' style="width: 120px;font-weight: normal;"><?php echo $field['name']; ?></td>
                            <?php if ($field['type_name'] == 'чекбокс'): ?>
                                <td><input type="checkbox" name="<?php echo $field['name'] ?>" number="<?php echo $i; ?>"/><br/></td>
                            <?php elseif ($field['type_name'] == 'переключатель'): ?>
                                <td><input type="radio" name="<?php echo $field['name'] ?>" number="<?php echo $i; ?>"/><br/></td>
                            <?php elseif ($field['type_name'] == 'файл'): ?>
                                <td><input id="photo100" style="display:inline;" number="<?php echo $i; ?>" class="input-file btn btn-primary" type="file" name="<?php echo $field['name'] ?>"/><br/></td>
                            <input class="photo100" number="<?php echo $i; ?>" file="<?php echo $field['name'] ?>" type="hidden" name="attachment"/>
                        <?php elseif ($field['type_name'] == 'список'): ?>
                            <td>
                                <select number="<?php echo $i; ?>" name="<?php echo $field['name'] ?>" class="text ui-widget-content ui-corner-all">
                                    <option value="" selected="selected"> -- choose -- </option>
                                </select><br/>
                            </td>
                        <?php elseif ($field['type_name'] == 'дата'): ?>
                            <td><input type="text" number="<?php echo $i; ?>" style="height: 10px;width:200px;display: inline;font-weight: normal;" class="text ui-widget-content ui-corner-all datepicker" value="--/--/----" name="<?php echo $field['name'] ?>"/><br/></td>
                        <?php elseif ($field['type_name'] == 'число'): ?>
                            <td><input type="text" style="height: 10px;width:200px;display: inline;font-weight: normal;" number="<?php echo $i; ?>" class="text ui-widget-content ui-corner-all" value="0" name="<?php echo $field['name'] ?>"/><br/></td>
                        <?php else: ?>
                            <td><textarea number="<?php echo $i; ?>" class="text ui-widget-content ui-corner-all" type="text" style="display:inline;width:200px;" value="" name="<?php echo $field['name'] ?>"></textarea><br/></td>
                        <?php endif; ?>
                        </th>
                        <?php $i++; ?>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </table>
        </fieldset>
    </form>
</div>
<!-- end row form -->

<!-- create new row form  -->
<div id="field-form" title="Добавление столбца" class="ui-dialog-content ui-widget-content" style="width: auto; min-height: 0px; height: 216px;display: none; " scrolltop="0" scrollleft="0">
    <div class="ui-state-highlight" style="padding: 0 .7em;padding-top: 5px;margin-bottom: 15px;">
        <p>
            <span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>
            <strong></strong> Все поля обязательны для заполнения.
        </p>
    </div>
    <form>
        <fieldset>
            <?php if (isset ($_GET['database']) && !empty ($_GET['database']) && isset ($_GET['table']) && !empty ($_GET['table'])): ?>
                <table>  
                    <tr>  
                        <td style="width:120px"> 
                            <label for="field_name">Имя столбца</label>
                        </td>
                        <td>
                            <input style="width: 200px;height: 10px;" type="text" name="field_name" class="text ui-widget-content ui-corner-all" />
                        </td>
                    </tr>
                    <tr>  
                        <td>
                            <label for="field_type">Тип</label>
                        </td>
                        <td>
                            <select name='type' style='width: 210px;height: 25px;' class='text ui-widget-content ui-corner-all'>
                                <option value="" selected="selected"> -- выбрать тип -- </option>
                                <?php if (isset ($list_type) && !empty ($list_type)): ?>
                                    <?php foreach ($list_type as $key => $type): ?>
                                        <option value="<?php echo $type ?>"><?php echo $type ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </td>
                    </tr>
                </table>
            <?php endif; ?>
        </fieldset>
    </form>
</div>
<!-- end row form -->

<!-- create new table form -->    
<div id="table-form" title="Добавление таблицы" class="ui-dialog-content ui-widget-content" style="width: auto; min-height: 0px; height: 216px;display: none; " scrolltop="0" scrollleft="0">
    <div class="ui-state-highlight" style="padding: 0 .7em;padding-top: 5px;margin-bottom: 15px;">
        <p>
            <span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>
            <strong></strong> Все поля обязательны для заполнения.
        </p>
    </div>
    <form class="table-form">
        <fieldset class="control-group">
            <table>
                <tr>
                    <td style="width:120px">
                        <label for="table">Имя таблицы <span class="star">*</span></label></td>
                    <td>
                        <input style="height: 10px;width:200px;display: inline;font-weight: normal;" type="text" name="table" id="table" style="width: 250px;" class="text ui-widget-content ui-corner-all">
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="count">Количество полей <span class="star">*</span></label>
                    </td>
                    <td>
                        <input style="height: 10px;width:200px;display: inline;font-weight: normal;" type="text" name="count" id="count" style="width: 100px;" class="text ui-widget-content ui-corner-all">
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="db">Имя базы данных <span class="star">*</span></label>
                    </td>
                    <td>
                        <select name="db" id="db" style="width: 210px;height: 25px;" class="text ui-widget-content ui-corner-all"></select>
                    </td>
                </tr>
            </table>
        </fieldset>
    </form>
    <!-- <form class="field-form" style="display: none;">
         <fieldset>
             <table class="table-striped table-condensed"></table>
         </fieldset>
         <input type="hidden" class="valid" value="true"/>
         <input type="hidden" class="db" value="0"/>
         <input type="hidden" class="tables" value="0"/>
         <input type="hidden" class="rows" value="0"/>
     </form>-->
</div>
<!-- end table form -->

<!-- create new row form  -->
<div id="field-form-tb" title="Добавление столбцов" class="ui-dialog-content ui-widget-content" style="width: auto; min-height: 0px; height: 216px;display: none; " scrolltop="0" scrollleft="0">
    <div class="ui-state-highlight" style="padding: 0 .7em;padding-top: 5px;margin-bottom: 15px;">
        <p>
            <span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>
            <strong></strong> Все поля обязательны для заполнения.
        </p>
    </div>
    <form class="field-form">
        <input type="hidden" class="valid" value="true"/>
        <input type="hidden" class="db" value="0"/>
        <input type="hidden" class="tables" value="0"/>
        <input type="hidden" class="rows" value="0"/>
        <input type="hidden" class="count" value="0"/>
    </form>
</div>
<!-- end row form -->

<!-- create new table form -->    
<div id="table-edit-form" title="Переименовывание таблицы" class="ui-dialog-content ui-widget-content" style="width: auto; min-height: 0px; height: 216px;display: none; " scrolltop="0" scrollleft="0">
    <div class="ui-state-highlight" style="padding: 0 .7em;padding-top: 5px;margin-bottom: 15px;">
        <p>
            <span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>
            <strong></strong> Все поля обязательны для заполнения.
        </p>
    </div>
    <form class="table-form">
        <fieldset class="control-group">
            <table>
                <tr>
                    <td style="width:120px;">
                        <label for="table">Имя таблицы</label>
                    </td>
                    <td>
                        <input type="text" name="table" id="table-e" style="width:200px;height:10px;" class="text ui-widget-content ui-corner-all">
                    </td>
                </tr>
            </table>
        </fieldset>
    </form>
</div>
<!-- end table form -->
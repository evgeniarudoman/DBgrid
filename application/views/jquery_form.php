<!-- delete rows-->
<div id="dialog-remove" title="Удаление строки" style="display: none;">
    Вы уверенны, что хотите удалить эту строку?
</div>
<!-- end delete rows-->

<!-- delete rows-->
<div id="database-remove" title="Удаление базы данных" style="display: none;">
    Вы уверенны, что хотите удалить эту базу данных?
</div>
<!-- end delete rows-->

<!-- create new database form -->    
<div id="database-form" title="Добавление базы данных" class="ui-dialog-content ui-widget-content" style="width: auto; min-height: 0px; height: 216px;display: none; " scrolltop="0" scrollleft="0">
    <p class="validateTips">Все поля обязательны для заполнения.</p>
    <form>
        <fieldset>
            <label for="database">Имя базы данных</label>
            <input type="text" name="database" id="database" class="text ui-widget-content ui-corner-all">
        </fieldset>
    </form>
</div>
<!-- end database form -->

<!-- create new row form  -->
<div id="row-form" title="Добавление строки" class="ui-dialog-content ui-widget-content" style="width: auto; min-height: 0px; height: 216px;display: none; " scrolltop="0" scrollleft="0">
    <p class="validateTips"></p>
    <form>
        <fieldset>
            <!--
            <pre>
            <?php //var_dump($result) ?>
            </pre>
            -->
            <?php $i = 0; ?>
            <?php if (isset($_GET['database']) && !empty($_GET['database']) && isset($_GET['table']) && !empty($_GET['table'])): ?>
                <?php foreach ($result[$_GET['database'] . '_' . $_GET['table'] . '_field'] as $key => $field): ?>
                    <th name='<?php echo $key; ?>'><?php echo $field['name']; ?></th>
                    <th name='<?php echo $key; ?>'>
                        <?php
                        if (isset($field['width']) && !empty($field['width']))
                            $width = $field['width'] . 'px';
                        else
                            $width = 100 . 'px';
                        ?>
                        <?php if ($field['type_name'] == 'чекбокс'): ?>
                        <td><input type="checkbox"/></td>
                    <?php elseif ($field['type_name'] == 'переключатель'): ?>
                        <td><input type="radio" name="<?php echo $field['name'] ?>"/></td>
                    <?php elseif ($field['type_name'] == 'файл'): ?>
                        <td><input id="photo<?php echo $i ?>" class="input-file btn btn-primary" type="file"/></td>
                    <?php elseif ($field['type_name'] == 'список'): ?>
                        <td>
                            <select name="select" class="text ui-widget-content ui-corner-all">
                                <option value="" selected="selected"> -- choose database -- </option>
                            </select>
                        </td>
                    <?php elseif ($field['type_name'] == 'дата'): ?>
                        <td><input type="text" class="text ui-widget-content ui-corner-all datepicker" style="width:65px;height:10px;" value="--/--/----"/></td>
                    <?php else: ?>
                        <td><input class="text ui-widget-content ui-corner-all" type="text" style="width:<?php echo $width ?>;height:10px;" value=""/></td>
                    <?php endif; ?>
                    </th>
                    <?php $i++; ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </fieldset>
    </form>
</div>
<!-- end row form -->

<!-- create new row form  -->
<div id="field-form" title="Добавление столбца" class="ui-dialog-content ui-widget-content" style="width: auto; min-height: 0px; height: 216px;display: none; " scrolltop="0" scrollleft="0">
    <p class="validateTips"></p>
    <form>
        <fieldset>
            <!--
            <pre>
            <?php //var_dump($result)  ?>
            </pre>
            --><?php if (isset($_GET['database']) && !empty($_GET['database']) && isset($_GET['table']) && !empty($_GET['table'])): ?>
                <label for="field_name">Имя столбца</label>
                <input type="text" name="field_name" class="text ui-widget-content ui-corner-all" />
                <label for="field_type">Тип</label>
                <select name='type' class='text ui-widget-content ui-corner-all'>
                    <option value="" selected="selected"> -- выбрать тип -- </option>
                    <?php if (isset($list_type) && !empty($list_type)): ?>
                        <?php foreach ($list_type as $key => $type): ?>
                            <option value="<?php echo $type ?>"><?php echo $type ?></option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
                <label for="size">Размер</label>
                <input type="text" name="size" class="text ui-widget-content ui-corner-all" />
            <?php endif; ?>
        </fieldset>
    </form>
</div>
<!-- end row form -->

<!-- create new table form -->    
<div id="table-form" title="Добавление таблицы" class="ui-dialog-content ui-widget-content" style="width: auto; min-height: 0px; height: 216px;display: none; " scrolltop="0" scrollleft="0">
    <p class="validateTips">Все поля обязательны для заполнения.</p>
    <form class="table-form">
        <fieldset class="control-group">
            <label for="table">Имя таблицы</label>
            <input type="text" name="table" id="table" class="text ui-widget-content ui-corner-all">
            <label for="count">Количество полей</label>
            <input type="text" name="count" id="count" class="text ui-widget-content ui-corner-all">
            <label for="db">Имя базы данных</label>
            <select name="db" id="db" class="text ui-widget-content ui-corner-all"></select>
        </fieldset>
    </form>
    <form class="field-form" style="display: none;">
        <fieldset>
            <table class="table-striped table-condensed"></table>
        </fieldset>
        <input type="hidden" class="valid" value="true"/>
        <input type="hidden" class="db" value="0"/>
        <input type="hidden" class="tables" value="0"/>
        <input type="hidden" class="rows" value="0"/>
    </form>
</div>
<!-- end table form -->
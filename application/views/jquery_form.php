<!-- delete rows-->
<div id="dialog-remove" title="Delete rows">
    Are you sure you want to delete the rows?
</div>
<!-- end delete rows-->

<!-- create new database form -->    
<div id="database-form" title="Add Database" class="ui-dialog-content ui-widget-content" style="width: auto; min-height: 0px; height: 216px; " scrolltop="0" scrollleft="0">
    <p class="validateTips">All form fields are required.</p>
    <form>
        <fieldset>
            <label for="database">Database name</label>
            <input type="text" name="database" id="database" class="text ui-widget-content ui-corner-all">
        </fieldset>
    </form>
</div>
<!-- end database form -->

<!-- create new row form  -->
<div id="row-form" title="Add row" class="ui-dialog-content ui-widget-content" style="width: auto; min-height: 0px; height: 216px; " scrolltop="0" scrollleft="0">
    <p class="validateTips">All form fields are required.</p>
    <form>
        <fieldset>
            <!--
            <pre>
                <?php //var_dump($result) ?>
            </pre>
            -->
            <?php foreach ($result[$_GET['database'] .'_'.$_GET['table']. '_field'] as $key => $field): ?>
                <th name='<?php echo $key; ?>'><?php echo $field['name']; ?></th>
                <th name='<?php echo $key; ?>'>
                    <input type="text" name="<?php echo $field['name']; ?>" id="database" class="text ui-widget-content ui-corner-all" style="width:<?php echo 10 * $field['size'] . 'px'; ?>"/>
                </th>
            <?php endforeach; ?>
        </fieldset>
    </form>
</div>
<!-- end row form -->

<!-- create new table form -->    
<div id="table-form" title="Add Table" class="ui-dialog-content ui-widget-content" style="width: auto; min-height: 0px; height: 216px; " scrolltop="0" scrollleft="0">
    <p class="validateTips">All form fields are required.</p>
    <form class="table-form">
        <fieldset class="control-group">
            <label for="table">Table name</label>
            <input type="text" name="table" id="table" class="text ui-widget-content ui-corner-all">
            <label for="count">Count of fields</label>
            <input type="text" name="count" id="count" class="text ui-widget-content ui-corner-all">
            <label for="db">Database name</label>
            <select name="db" id="db" class="text ui-widget-content ui-corner-all">
                <option value="" selected="selected"> -- choose database -- </option>
                <?php if (isset($list_database) && !empty($list_database)): ?>
                    <?php foreach ($list_database as $key => $database): ?>
                        <option value="<?php echo $database ?>"><?php echo $database ?></option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
        </fieldset>
    </form>
    <form class="field-form" style="display: none;">
        <fieldset>
            <table class="table-striped table-condensed"></table>
        </fieldset>
        <input type="hidden" class="valid" value="true"/>
        <input type="hidden" class="db" value="0"/>
        <input type="hidden" class="tables" value="0"/>
    </form>
</div>
<!-- end table form -->
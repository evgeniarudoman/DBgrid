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
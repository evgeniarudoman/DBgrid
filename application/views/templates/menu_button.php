<td class="menu_button first">
    <table>
        <tr>
            <td>
                <a href="<?php echo site_url('grid');?>">
                    <div class="icon home"></div>
                </a>
            </td>
        </tr>
        <tr>
            <td>
                <a href="">
                    <div class="icon reload"></div>
                </a>
            </td>
        </tr>
        <tr>
            <td>
                <a href="<?php echo site_url('help');?>">
                    <div class="icon help"></div>
                </a>
            </td>
        </tr>
        <tr>
            <td>
                <a href="<?php echo site_url('grid/logout');?>">
                    <div class="icon exit"></div>
                </a>
            </td>
        </tr>
    </table>
</td>
<td class="menu_button second">
    <table>
        <tr id="create-database">
            <td>
                <div class="icon save_j"></div>
            </td>
            <td>
                <div class="icon add_j"></div>
            </td>
        </tr>
        <tr id="create-table">
            <td>
                <div class="icon table_j"></div>
            </td>
            <td>
                <div class="icon add_j"></div>
            </td>
        </tr>
    </table>
</td>
<td id="nav" class="nav_right">
    <input type="button" name="nav" onclick="display_menu();"/>
</td>
</tr>
</table>
<div id="hidden">
    <input type="hidden" name="hide"/>
</div>
</body>
</html>
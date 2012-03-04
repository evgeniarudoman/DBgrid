<td class="menu_button first">
    <table>
        <tr>
            <td>
                <a href="">
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
                <a href="">
                    <div class="icon help"></div>
                </a>
            </td>
        </tr>
        <tr>
            <td>
                <a href="">
                    <div class="icon exit"></div>
                </a>
            </td>
        </tr>
    </table>
</td>
<td class="menu_button second">
    <table>
        <tr>
            <td>
                <a href="">
                    <div class="icon add"></div>
                </a>
            </td>
        </tr>
        <tr>
            <td>
                <a href="">
                    <div class="icon edit"></div>
                </a>
            </td>
        </tr>
        <tr>
            <td>
                <a href="" id="remove" onclick="return false;">
                    <div class="icon delete"></div>
                </a>
            </td>
        </tr>
        <tr>
            <td>
                <a href="">
                    <div class="icon save"></div>
                </a>
            </td>
        </tr>
        <tr>
            <td>
                <a href="">
                    <div class="icon search"></div>
                </a>
            </td>
        </tr>
        <tr>
            <td>
                <div class="icon add" id="create-database"></div>
            </td>
        </tr>
        <tr>
            <td>
                <a href="<?php echo site_url('tables/add'); ?>">
                    <div class="icon add"></div>
                </a>
            </td>
        </tr>
        <tr>
            <td>
                <a href="<?php echo site_url('fields/add'); ?>">
                    <div class="icon add"></div>
                </a>
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
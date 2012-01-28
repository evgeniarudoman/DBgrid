
        <table class='linked'>
            <tr>
                <td class='data' colspan=2>database "<?php echo $_GET['database'] ?>"</td>
            </tr>
            <?php while ($row = mysql_fetch_array($all_tables)): ?>
                <tr>
                    <td><div class="icon table"></div></td>
                    <?php for ($i = 0; $i < mysql_num_fields($all_tables); $i++): ?>
                        <?php $count_field = mysql_query("SELECT * FROM " . $_GET['database'] . '.' . $row[mysql_field_name($all_tables, $i)]); ?>
                        <td class ='href'><a href='/grid/tables?database=<?php echo $_GET['database'] ?>&table=<?php echo $row[mysql_field_name($all_tables, $i)] ?>'><?php echo $row[mysql_field_name($all_tables, $i)];
                echo ' (<i>' . mysql_num_fields($count_field) . '</i>)'; ?></a></div></td>
                    <?php endfor;
                endwhile;
                ?>
            </tr>
        </table>
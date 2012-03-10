<!doctype html public "-//W3C//DTD HTML 4.0 //EN">
<html>
    <head>
        <?php foreach ($scripts as $script): ?>
            <script src="<?php echo $script; ?>"></script>
        <?php endforeach; ?>

        <?php foreach ($styles as $style): ?>
            <link rel="stylesheet" type="text/css" href="<?php echo $style; ?>"/>
        <?php endforeach; ?>
    </head>
    <body>
        <script language="javascript">
            $(document).ready(function() {
            
            });
        </script>
        <form action="" method="post"> 
            <table border="1">
                <tr>
                    <td>
                        <input type="text" name="table_name"/>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="text" name="count_fields"/>
                    </td>
                </tr>
                <tr>
                    <td>
                        <select name="list_database">
                            <option selected="selected">--select--</option>
                            <?php foreach ($list_database as $id=>$database):?>
                                <option name="<?php echo $id;?>"><?php echo $database;?></option>
                            <?php endforeach;?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="submit" name="submit"/>
                    </td>
                </tr>
            </table>
        </form>
    </body>
</html>
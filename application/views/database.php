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
                        <input type="text" name="db_name"/>
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
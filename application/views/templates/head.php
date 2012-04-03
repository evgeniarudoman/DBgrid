<!doctype html public "-//W3C//DTD HTML 4.0 //EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf8" />
        <title><?php echo $title; ?></title>

        <?php foreach ($scripts as $script): ?>
            <script src="<?php echo $script; ?>"></script>
        <?php endforeach; ?>

        <?php foreach ($styles as $style): ?>
            <link rel="stylesheet" type="text/css" href="<?php echo $style; ?>"/>
        <?php endforeach; ?>
    </head>
            
<!DOCTYPE html>
<html data-ng-app='testApp'>
        <head>
            <meta charset="utf-8">
                <title><?php echo $title;?></title>
                <?php foreach($css as $file):?>
                <link type='text/css' rel='stylesheet' href="/<?php echo $file;?>">
                <?php endforeach;?>
                <?php foreach($js as $file):?>
                    <script src="/<?php echo $file;?>"></script>
                <?php endforeach;?>
        </head>
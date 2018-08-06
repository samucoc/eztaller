<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = 'Cotizacion Repuestos';
?>
<!DOCTYPE html>
<html>
<head>
    <script src="http://192.168.1.102/backup/sgrepuestos/js/jquery.min.js"></script>
    <script src="http://192.168.1.102/backup/sgrepuestos/js/jquery-ui.js"></script>
    <script src="http://192.168.1.102/backup/sgrepuestos/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="http://192.168.1.102/backup/sgrepuestos/css/jquery.dataTables.min.css"/>
    <link rel="stylesheet" href="http://192.168.1.102/backup/sgrepuestos/css/jquery-ui.css" />
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $cakeDescription ?>:
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>

    <?= $this->Html->css('base.css') ?>
    <?= $this->Html->css('cake.css') ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body link='white'>
    <nav id="menu_gral" style="margin-top: 10px !important;">
        
    </nav>
    <div id="container">
        <div id="content">
            <?=$this->Flash->render()?>
            <div class="row">
                <?= $this->fetch('content') ?>
            </div>
        </div>
    </div>
</body>
</html>
<script>
// $(document).ready(function(){
//     $.ajax({
//         url: "/sgrepuestos/menues/generar_menu",
//     }).done(function(data) {
//                 $("#menu_gral").html(data);//menu con usuario
//             });
// });
</script>
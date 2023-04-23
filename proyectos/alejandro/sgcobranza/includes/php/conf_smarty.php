<?php
require("cls_smarty/libs/Smarty.class.php");

$miSmarty = new Smarty();
$miSmarty->template_dir = '../smarty/tpl';
$miSmarty->config_dir = '../smarty/config';
$miSmarty->cache_dir = '../smarty/cache';
$miSmarty->compile_dir = '../smarty/tpl_c';

?>
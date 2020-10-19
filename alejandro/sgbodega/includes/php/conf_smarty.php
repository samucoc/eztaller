<?php
ini_set('display_errors', 1); 
error_reporting(E_ALL);

require("cls_smarty/libs/Smarty.class.php");

$miSmarty = new Smarty();
$miSmarty->template_dir = '../smarty/tpl';
$miSmarty->config_dir = '../smarty/config';
$miSmarty->cache_dir = '../smarty/cache';
$miSmarty->compile_dir = '../smarty/tpl_c';

?>
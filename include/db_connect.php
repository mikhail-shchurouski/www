<?php
defined('mystorefirst') or die('Страница не найдена!');
$db_host        ='localhost';
$db_user        ='admin';
$db_pass        ='123321';
$db_database    ='db_shop';

$link = mysql_connect($db_host,$db_user,$db_pass);

mysql_select_db($db_database,$link) or die("Нет соединения с БД" .mysql_error());
mysql_query("Set names utf-8");//utf-8 для публикации в интернет
?>
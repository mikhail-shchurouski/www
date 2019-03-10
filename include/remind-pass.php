<?php

if($_SERVER["REQUEST_METHOD"] == "POST")          // здесь выполняется восстановление пароля обработчик ajax
{
define('mystorefirst', true);   
include("db_connect.php");
include("../functions/functions.php");
$email = clear_string($_POST["email"]);
if ($email != "")                           // если переменная емайл не пустая делаем код дальше
{
    
   $result = mysql_query("SELECT email FROM reg_user WHERE email='$email'",$link);
If (mysql_num_rows($result) > 0)
{
    
//генерация пароля
    $newpass = fungenpass();
    
// шифрование пароля
    $pass   = md5($newpass);
    $pass   = strrev($pass);
    $pass   = strtolower("9nm2rv8q".$pass."2yo6z");    
 
// обновление пароля в бд
$update = mysql_query ("UPDATE reg_user SET pass='$pass' WHERE email='$email'",$link);
    
// Отправка нового пароля
   
	         send_mail( 'noreply@shop.ru',
			             $email,
						'Новый пароль для сайта EntertainmentStore.by',
						'Ваш пароль: '.$newpass);   
   
   echo 'yes';
    
}else
{
    echo 'Данный e-mail не найден!';
}
}
else
{
    echo 'Введите другой E-mail';
}
}


?>
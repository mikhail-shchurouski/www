<?php
  define('mystorefirst',true);                                                                    // обработчик формы если все поля заполнены верно пользователь регистрируется в БД. если нет отображаются ошибки
 if($_SERVER["REQUEST_METHOD"] == "POST")
{ 
 session_start();
 include("../include/db_connect.php");
 include("../functions/functions.php");
 
     $error = array();                               // массив который будет отображать все ошибки в форме
         
        $login = iconv("UTF-8", "cp1251",strtolower(clear_string($_POST['reg_login']))); // iconv("UTF-8", "cp1251", - эта кодировка для локального хостинка делает корректное отоброжение русских символов в БД после переноса сайта в интернет нужно удалить эти кодировки'
        $pass = iconv("UTF-8", "cp1251",strtolower(clear_string($_POST['reg_pass']))); 
        $surname = iconv("UTF-8", "cp1251",clear_string($_POST['reg_surname'])); 
        
        $name = iconv("UTF-8", "cp1251",clear_string($_POST['reg_name'])); 
        $patronymic = iconv("UTF-8", "cp1251",clear_string($_POST['reg_patronymic'])); 
        $email = iconv("UTF-8", "cp1251",clear_string($_POST['reg_email'])); 
        
        $phone = iconv("UTF-8", "cp1251",clear_string($_POST['reg_phone'])); 
        $address = iconv("UTF-8", "cp1251",clear_string($_POST['reg_address'])); 
 
 
    if (strlen($login) < 5 or strlen($login) > 15)
    {
       $error[] = "Логин должен быть от 5 до 15 символов!"; 
    }
    else
    {   
     $result = mysql_query("SELECT login FROM reg_user WHERE login = '$login'",$link);// проверка логина
    If (mysql_num_rows($result) > 0)
    {
       $error[] = "Логин занят!";
    }
            
    }
     
    if (strlen($pass) < 7 or strlen($pass) > 15) $error[] = "Укажите пароль от 7 до 15 символов!";
    if (strlen($surname) < 3 or strlen($surname) > 20) $error[] = "Укажите фамилию от 3 до 20 символов!";
    if (strlen($name) < 3 or strlen($name) > 15) $error[] = "Укажите имя от 3 до 15 символов!";
    if (strlen($patronymic) < 3 or strlen($patronymic) > 25) $error[] = "Укажите отчество от 3 до 25 символов!";
    if (!preg_match("/^(?:[a-z0-9]+(?:[-_.]?[a-z0-9]+)?@[a-z0-9_.-]+(?:\.?[a-z0-9]+)?\.[a-z]{2,5})$/i",trim($email))) $error[] = "Укажите корректный email!";
    if (!$phone) $error[] = "Укажите номер телефона!";
    if (!$address) $error[] = "Необходимо указать адрес доставки!";
    
    if($_SESSION['img_captcha'] != strtolower($_POST['reg_captcha'])) $error[] = "Неверный код с картинки!";
    unset($_SESSION['img_captcha']);                                                                        // меняем каптчу после регистрации(сессии))
    
   if (count($error))
   {
    
 echo implode('<br />',$error);
     
   }else
   {   
        $pass   = md5($pass); // старый метод шифрования пароля мд5 смертный не расшифрует а адекватный спец да
        $pass   = strrev($pass);
        $pass   = "9nm2rv8q".$pass."2yo6z"; // к паролю добавляется доп начало и конец. 
        
        $ip = $_SERVER['REMOTE_ADDR'];// добавление ip адреса пользователя в переменну для последующей отправки в БД
		                                                                                                  // и привет регистрация в базе данных в том случае если вверху все сработало в тру
		mysql_query("	INSERT INTO reg_user(login,pass,surname,name,patronymic,email,phone,address,datetime,ip)   
						VALUES(
						                                                                                         
							'".$login."',
							'".$pass."',
							'".$surname."',
							'".$name."',                     
							'".$patronymic."',
                            '".$email."',
                            '".$phone."',
                            '".$address."',
                            NOW(),
                            '".$ip."'							
						)",$link);
 echo 'true';
 }        
}
// все переменные из столбика летят в БД
?>
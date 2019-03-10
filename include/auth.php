<?php
define('mystorefirst',true);
if($_SERVER["REQUEST_METHOD"] == "POST")              // обрабодчик кнопки вход этот код отправляет введенные пользователем логин и пароль в базу данных и обробатывает все ли хорошо]
{
	include('db_connect.php');
    include('../functions/functions.php');
    
    $login = clear_string($_POST["login"]);
    
    $pass   = md5(clear_string($_POST["pass"]));       // шифрование пароля
    $pass   = strrev($pass);
    $pass   = strtolower("9nm2rv8q".$pass."2yo6z");
    
    
    if ($_POST["rememberme"] == "yes")                // проверяем чек бокс
    {
            setcookie('rememberme',$login.'+'.$pass,time()+3600*24*31, "/");  // если чек бокс выбран создаем куки файл и сохраняем в него логин и пароль и сдесбь же определяем срок жизни куки файла
    }
    
       
   $result = mysql_query("SELECT * FROM reg_user WHERE (login = '$login' OR email = '$login') AND pass = '$pass'",$link);   // здесь устанавливаем правила регистрации если логин и пароль верные все ок регистрируем если нет то нет так же здесь мы разрешаем входить и по логину и по адресу электронной почты
If (mysql_num_rows($result) > 0)
{
    $row = mysql_fetch_array($result);                // запускаем сессию если введенный логин и пароль верны
    session_start();
    $_SESSION['auth'] = 'yes_auth'; 
    $_SESSION['auth_pass'] = $row["pass"];
    $_SESSION['auth_login'] = $row["login"];
    $_SESSION['auth_surname'] = $row["surname"];
    $_SESSION['auth_name'] = $row["name"];
    $_SESSION['auth_patronymic'] = $row["patronymic"];
    $_SESSION['auth_address'] = $row["address"];
    $_SESSION['auth_phone'] = $row["phone"];
    $_SESSION['auth_email'] = $row["email"];
    echo 'yes_auth';                                   // отправляем ответ ajaxy о том что автаризация успешна страница перезагрузится аякс слушает в файле блок хедер
}else
{
    echo 'no_auth';     
}  
} 


?>
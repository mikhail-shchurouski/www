<?php
 defined('mystorefirst') or die('—траница не найдена!');                                                                 
 if ($_SESSION['auth'] != 'yes_auth' && $_COOKIE["rememberme"])  // авторизаци€ пользовател€ будет происходить если файл куки существует и сесси€ запущена
  {   
  $str = $_COOKIE["rememberme"];
  
  // ¬с€ длина строки - функци€ читает длину строки
  $all_len = strlen($str);
  // ƒлина логина считает количество символов логина
  $login_len = strpos($str,'+'); 
  // обрезаем строку до плюса и и получаем логин
  $login = clear_string(substr($str,0,$login_len));
  
  // получаем пороль
  $pass = clear_string(substr($str,$login_len+1,$all_len));
  
     $result = mysql_query("SELECT * FROM reg_user WHERE (login = '$login' or email = '$login') AND pass = '$pass'",$link);
If (mysql_num_rows($result) > 0)
{
    $row = mysql_fetch_array($result);
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
}
  
  
  
  }

?>
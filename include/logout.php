<?php

if($_SERVER["REQUEST_METHOD"] == "POST")  // кнопка выход из профиля
{
      session_start();
      unset($_SESSION['auth']);
      setcookie('rememberme','',0,'/');
      echo 'logout'; 
} 


?>
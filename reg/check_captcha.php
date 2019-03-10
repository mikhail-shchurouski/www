<?php
define('mystorefirst',true);
// проверяем правильность ввода символов из каптчи 
 if($_SERVER["REQUEST_METHOD"] == "POST")
{
	session_start();   
    if($_SESSION['img_captcha'] == strtolower($_POST['reg_captcha']))
    {
        echo 'true';   //  если каптча введена правильно то тру если нет то фолс
    } else { echo 'false'; }
}  

?>
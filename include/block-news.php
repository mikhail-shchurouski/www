<?php
	defined('mystorefirst') or die('Страница не найдена!');
?><div id="block-news">
<center><img id="news-prev"  src="/img/Up.jpg"/></center>
<div id="newsticker">
<ul>
<?php
	$result = mysql_query("SELECT * FROM news ORDER BY id DESC",$link); // создаем переменную и пишем SQL запрос ($link - переменная с результатом подключения к BD - взята из файла db_connect.php)
    
 if(mysql_num_rows($result) > 0){             // проверка есть ли в таблице что -то для отображения - если нет ничего не делаем если есть выдаем весь список.
    $row = mysql_fetch_array($result);                
    do{
  echo '      
<li>
<span>'.$row["date"].'</span>
<a href=" ">'.$row["title"].'</a>
<p>'.$row["text"].'</p>
</li>
';                     
    }
    while ($row = mysql_fetch_array($result));
    } // цикл выполняется до тех пор пока не закончаться все продукты в таблице
?>	
</ul>
</div>
<center><img id="news-next" src="/img/Down.jpg"/></center>
</div>
<?php
	defined('mystorefirst') or die('Страница не найдена!');
?>
<div id="block-category">
<p class="header-title">Категории товаров</p>
<ul>
<li><a id="index1"><img src="/img/kachalka.jpg" id="kachalka-images"/>Качалки</a>
<ul class="category-section">
<li><a href="view_cat.php? type=rocking"><b>Все модели:</b></a></li>

<?php
	$result = mysql_query("SELECT * FROM category WHERE type = 'rocking'",$link); // создаем переменную и пишем SQL запрос ($link - переменная с результатом подключения к BD - взята из файла db_connect.php)
    
 if(mysql_num_rows($result) > 0){             // проверка есть ли в таблице что -то для отображения - если нет ничего не делаем если есть выдаем весь список.
    $row = mysql_fetch_array($result);        // в переменной $row хранятся все наши товары
    do{
     echo '
 <li><a href="view_cat.php?cat='.strtolower($row["brand"]).'&type='.$row["type"].'">'.$row["brand"].'</a></li> 
     ';                                 // эта ссылка выводит из базы все брэнды которые == rocking - качалка
    }
    while ($row = mysql_fetch_array($result)); // цикл выполняется до тех пор пока не закончаться все продукты в таблице
 }
?>

</ul>
</li>


<li><a id="index2"><img src="/img/hockey.jpg" id="hockey-images"/>Аэрохоккеи</a>
<ul class="category-section">
<li><a href="view_cat.php? type=air_hockey"><b>Все модели:</b></a></li>
<?php
	$result = mysql_query("SELECT * FROM category WHERE type = 'air_hockey'",$link); // создаем переменную и пишем SQL запрос ($link - переменная с результатом подключения к BD - взята из файла db_connect.php)
    
 if(mysql_num_rows($result) > 0){             // проверка есть ли в таблице что -то для отображения - если нет ничего не делаем если есть выдаем весь список.
    $row = mysql_fetch_array($result);        // в переменной $row хранятся все наши товары
    do{
     echo '
 <li><a href="view_cat.php?cat='.strtolower($row["brand"]).'&type='.$row["type"].'">'.$row["brand"].'</a></li> 
     ';                                 // эта ссылка выводит из базы все брэнды которые == air_hockey - аэрохокей
    }
    while ($row = mysql_fetch_array($result)); // цикл выполняется до тех пор пока не закончаться все продукты в таблице
 }
?>
</ul>
</li>


<li><a id="index3"><img src="/img/simulator.jpg" id="simulator-images"/>Видеоaппараты</a>
<ul class="category-section">
<li><a href="view_cat.php? type=simulator"><b>Все модели:</b></a></li>
<?php
	$result = mysql_query("SELECT * FROM category WHERE type = 'simulator'",$link); // создаем переменную и пишем SQL запрос ($link - переменная с результатом подключения к BD - взята из файла db_connect.php)
    
 if(mysql_num_rows($result) > 0){             // проверка есть ли в таблице что -то для отображения - если нет ничего не делаем если есть выдаем весь список.
    $row = mysql_fetch_array($result);        // в переменной $row хранятся все наши товары
    do{
     echo '
 <li><a href="view_cat.php?cat='.strtolower($row["brand"]).'&type='.$row["type"].'">'.$row["brand"].'</a></li> 
     ';                                 // эта ссылка выводит из базы все брэнды которые == simulator - симуляторы видеоигр
    }
    while ($row = mysql_fetch_array($result)); // цикл выполняется до тех пор пока не закончаться все продукты в таблице
 }
?>
</ul>
</li>

</ul>

</div>
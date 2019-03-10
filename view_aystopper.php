<?php
    define('mystorefirst',true);
	include("include/db_connect.php"); // подключение БД к проекту.
    include("functions/functions.php");
    session_start(); 
    include("include/auth_cookie.php");
    
    
     $go = clear_string($_GET["go"]);       // вытаскиваем переменную go и начинаем реализацию сортировки новинки распродажи лидеры продаж
    
    switch ($go) {                                               // switch проверяет ключевые слова что бы в базу не сыпалось лишнее
	    case "news":     
	    $query_aystopper= " WHERE visible = '1' AND new = '1'"; // если ключевое слово news прошло проверку и в базе данных
        $name_aystopper = "Новинки товаров";                    // в столбце visible и new еденица значит выводим эти товары
	    break;
	    case "leaders":
	    $query_aystopper= " WHERE visible = '1' AND leader = '1'";
        $name_aystopper = "Лидеры продаж";
	    break;
	    case "sale":
	    $query_aystopper= " WHERE visible = '1' AND sale = '1'";
        $name_aystopper = "Распродажа товаров";
	    break;
        
        
	    default:
        $query_aystopper = "";    //  это случай если ключевое слово не соответствует имени переменной
	    break;
} 
    
     
    $sorting = $_GET["sort"];   // рализация сортировок.
switch ($sorting){
    case 'price-asc';
    $sorting = 'price ASC';
    $sort_name = 'От дешевых к дорогим';
    break;
    
    case 'price-desc';
    $sorting = 'price DESC';
    $sort_name = 'От дорогих к дешевым';
    break;
    
     case 'popular';
    $sorting = 'price DESC';
    $sort_name = 'Популярное';
    break;
    
     case 'news';
    $sorting = 'datetime DESC';
    $sort_name = 'Новинки';
    break;
    
     case 'brand';
    $sorting = 'brand';
    $sort_name = 'Брэнды';
    break;
    
    default:                         //проверка - для того что бы сортировка выполнялась по коду.. в ином случае режим Нет сортировки.
    $sorting ='products_id DESC';
    $sort_name = 'Нет сортировки';
    break;
}
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<meta http-equiv="content-type" content="text/html; charset=windows-1251" />   
    <link href="css/reset.css" rel="stylesheet" type="text/css" /> 
    <link href="css/style.css" rel="stylesheet" type="text/css" />
       <link href="trackbar/trackbar.css" rel="stylesheet" type="text/css" /> 
      <script type="text/javascript" src="/js/jquery-1.7.2.js"></script>
    <script type="text/javascript" src="/js/shop-script.js"></script>
    <script type="text/javascript" src="/js/jquery.cookie.js"></script>
    <script type="text/javascript" src="/js/jquery-ui.js"></script>
    <script type="text/javascript" src="/js/jquery.form.js"></script>
    <script type="text/javascript" src="/js/jquery.validate.js"></script>
    <script type="text/javascript" src="/js/TextChange.js"></script>
    <script type="text/javascript" src="/js/jcarousellite_1.0.1.js"></script>
    
	<title>Интернет-Магазин Развлекательного Оборудования</title>
</head>

<body>

<div id="block-body">

<?php
	include("include/block-header.php");
?>

<div id="block-right">

<?php
	include("include/block-category.php");
    	include("include/block-parameter.php");
        include("include/block-news.php");
?>

</div>

<div id="block-content">

<?php
	if ($query_aystopper != "")
    {
  
	$num = 6; // сколько хотим выводить товаров.
    $page = (int)$_GET['page'];              
    
	$count = mysql_query("SELECT COUNT(*) FROM table_products $query_aystopper",$link);
    $temp = mysql_fetch_array($count);
	If ($temp[0] > 0)
	{  
	$tempcount = $temp[0];
	// Находим общее число страниц
	$total = (($tempcount - 1) / $num) + 1;
	$total =  intval($total);
	$page = intval($page);
	if(empty($page) or $page < 0) $page = 1;  
       
	if($page > $total) $page = $total;
	 
	// Вычисляем с кокого номера следует выводить товар
   
	$start = $page * $num - $num;
	$qury_start_num = " LIMIT $start, $num"; 
	}
    
    	If ($temp[0] > 0)
	{  
	   
       ?>
       
       <div id="block-sorting">
<p id="nav-breadcrumbs"><a href="index.php">Главная станица</a> | <span> <?php echo $name_aystopper;?></span></p>
<ul id="option-list">
<li>Вид:</li>
<li><img id="style-grid" src="/img/grid.jpg" /></li>
<li><img id="style-list" src="/img/list.jpg" /></li>
<li>Сортировать</li>
<li><a id="select-sort">Без сортировки</a>                
<ul id="sorting-list">
<li><a href="view_aystopper.php?go=<?php echo $go;?>&sort=price-asc">От дешевых к дорогим</a></li>
<li><a href="view_aystopper.php?go=<?php echo $go;?>&sort=rice-desc">От дорогих к дешевым</a></li>
<li><a href="view_aystopper.php?go=<?php echo $go;?>&sort=popular">Популярное</a></li>
<li><a href="view_aystopper.php?go=<?php echo $go;?>&sort=news">Новинки</a></li>
<li><a href="view_aystopper.php?go=<?php echo $go;?>&sort=brand">От А до Я</a></li>
</ul>
</li>
</ul>
</div>
<ul id="block-tovar-grid">
       
       <?php

	$result = mysql_query("SELECT * FROM table_products $query_aystopper ORDER BY $sorting $qury_start_num",$link); // создаем переменную и пишем SQL запрос ($link - переменная с результатом подключения к BD - взята из файла db_connect.php)
    
 if(mysql_num_rows($result) > 0){             // проверка есть ли в таблице что -то для отображения - если нет ничего не делаем если есть выдаем весь список.
    $row = mysql_fetch_array($result);        // в переменной $row хранятся все наши товары
    do{
        
if  ($row["image"] !="" && file_exists("./uploads_images/".$row["image"]))     // Контроллер корректности вывода информации о товаре(размер изоброжениея наличие имени изображения вывод дежурного изображения в случае отсутствия штатного)(нужно убрать точку в пути к файлу изображения в том случае если сайт опубликуем в интернет))
{
$img_path = './uploads_images/'.$row["image"];  
$max_width = 200; 
$max_height = 200;
 list($width, $height) = getimagesize($img_path);
$ratioh = $max_height/$height;
$ratiow = $max_width/$width;
$ratio = min($ratioh, $ratiow);
$width = intval($ratio*$width);
$height = intval($ratio*$height); 
}
else
{
$img_path = "/img/no-image.jpg"; 
$width = 110;
$height = 200;   
}        
        
        echo                                  // указываем на то, что мы будем выводить циклом в нашем случае  это  (товары из бд оформленные с картинкой описанием колличеством просмотров коментариями и прочим)
        '
        <li>
        <div class="block-images-grid">                          
        <img src="'.$img_path.'" width="'.$width.'" height="'.$height.'"/>
        </div>
        <p class="style-title-grid"><a href="view_content.php?id='.$row["products_id"].'">'.$row["title"].'</a></p>
        <ul class="reviews-and-counts-grid">
        <li><img src="/img/eye.jpg"/><p>0</p></li>
        <li><img src="/img/commenticon.jpg"/><p>0</p></li>
        </ul>
        <a class="add-cart-style-grid" tid="'.$row["products_id"].'"></a>
        <p class="style-price-grid"><b>'.group_numerals($row["price"]).'</b>руб.</p>
        <div class="mini-features">
        '.$row["mini_features"].'
        </div>
        </li>              
        ' ;                              
    }
    while ($row = mysql_fetch_array($result)); // цикл выполняется до тех пор пока не закончаться все продукты в таблице
 }
?>

</ul>



<ul id="block-tovar-list">


<?php
	$result = mysql_query("SELECT * FROM table_products $query_aystopper ORDER BY $sorting $qury_start_num",$link); // создаем переменную и пишем SQL запрос ($link - переменная с результатом подключения к BD - взята из файла db_connect.php)
    
 if(mysql_num_rows($result) > 0){             // проверка есть ли в таблице что -то для отображения - если нет ничего не делаем если есть выдаем весь список.
    $row = mysql_fetch_array($result);        // в переменной $row хранятся все наши товары
    do{
        
if  ($row["image"] !="" && file_exists("./uploads_images/".$row["image"]))     // Контроллер корректности вывода информации о товаре(размер изоброжениея наличие имени изображения вывод дежурного изображения в случае отсутствия штатного)(нужно убрать точку в пути к файлу изображения в том случае если сайт опубликуем в интернет))
{
$img_path = './uploads_images/'.$row["image"];  
$max_width = 150; 
$max_height = 150;
 list($width, $height) = getimagesize($img_path);
$ratioh = $max_height/$height;
$ratiow = $max_width/$width;
$ratio = min($ratioh, $ratiow);
$width = intval($ratio*$width);
$height = intval($ratio*$height); 
}
else
{
$img_path = "/img/no-img.jpg"; 
$width = 80;
$height = 80;   
}        
        
        echo                                  // указываем на то, что мы будем выводить циклом в нашем случае  это  (товары из бд оформленные с картинкой описанием колличеством просмотров коментариями и прочим)
        '
        <li>
        <div class="block-images-list">                          
        <img src="'.$img_path.'" width="'.$width.'" height="'.$height.'"/>
        </div>
        
        <ul class="reviews-and-counts-list">
        <li><img src="/img/eye.jpg"/><p>0</p></li>
        <li><img src="/img/commenticon.jpg"/><p>0</p></li>
        </ul>
        
        <p class="style-title-list"><a href="view_content.php?id='.$row["products_id"].'">'.$row["title"].'</a></p>
        
        <a class="add-cart-style-list" tid="'.$row["products_id"].'"></a>
        <p class="style-price-list"><b>'.group_numerals($row["price"]).'</b>руб.</p>
        <div class="style-text-list">
        '.$row["mini_description"].'
        </div>
        </li>              
        ' ;                              
    }
    while ($row = mysql_fetch_array($result)); // цикл выполняется до тех пор пока не закончаться все продукты в таблице
 }
  
  echo '</ul>';
  
  }else{echo'<p>Товаров нет !</p>';}
  
   }
   else{
    echo'<p>Данная категория не найдена !</p>';
   }
  
  
if ($page != 1){ $pstr_prev = '<li><a class="pstr-prev" href="index.php?page='.($page - 1).'">&lt;</a></li>';}
if ($page != $total) $pstr_next = '<li><a class="pstr-next" href="view_aystopper.php?go='.$go.'&page='.($page + 1).'">&gt;</a></li>';
// формируем ссылки со страницами - постраничной навигации
if($page - 5 > 0) $page5left = '<li><a href="view_aystopper.php?go='.$go.'&page='.($page - 5).'">'.($page - 5).'</a></li>';
if($page - 4 > 0) $page4left = '<li><a href="view_aystopper.php?go='.$go.'&page='.($page - 4).'">'.($page - 4).'</a></li>';
if($page - 3 > 0) $page3left = '<li><a href="view_aystopper.php?go='.$go.'&page='.($page - 3).'">'.($page - 3).'</a></li>';
if($page - 2 > 0) $page2left = '<li><a href="view_aystopper.php?go='.$go.'&page='.($page - 2).'">'.($page - 2).'</a></li>';
if($page - 1 > 0) $page1left = '<li><a href="view_aystopper.php?go='.$go.'&page='.($page - 1).'">'.($page - 1).'</a></li>';
if($page + 5 <= $total) $page5right = '<li><a href="view_aystopper.php?go='.$go.'&page='.($page + 5).'">'.($page + 5).'</a></li>';
if($page + 4 <= $total) $page4right = '<li><a href="view_aystopper.php?go='.$go.'&page='.($page + 4).'">'.($page + 4).'</a></li>';
if($page + 3 <= $total) $page3right = '<li><a href="view_aystopper.php?go='.$go.'&page='.($page + 3).'">'.($page + 3).'</a></li>';
if($page + 2 <= $total) $page2right = '<li><a href="view_aystopper.php?go='.$go.'&page='.($page + 2).'">'.($page + 2).'</a></li>';
if($page + 1 <= $total) $page1right = '<li><a href="view_aystopper.php?go='.$go.'&page='.($page + 1).'">'.($page + 1).'</a></li>';
if ($page+5 < $total)
{
    $strtotal = '<li><p class="nav-point">...</p></li><li><a href="view_aystopper.php?go='.$go.'&page='.$total.'">'.$total.'</a></li>';
}else
{
    $strtotal = ""; 
}
if ($total > 1)
{
    echo '
    <div class="pstrnav">
    <ul>
    ';
    echo $pstr_prev.$page5left.$page4left.$page3left.$page2left.$page1left."<li><a class='pstr-active' href='view_aystopper.php?go=".$go."&page=".$page."'>".$page."</a></li>".$page1right.$page2right.$page3right.$page4right.$page5right.$strtotal.$pstr_next;
    echo '
    </ul>
    </div>
    ';
}
     
?>



</div>
<?php
	include("include/block-footer.php");
?>
</div>
</body>
</html>
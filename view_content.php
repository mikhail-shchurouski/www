<?php
    define('mystorefirst',true);
	include("include/db_connect.php"); // подключение БД к проекту.
    include("functions/functions.php");
    session_start(); 
    include("include/auth_cookie.php");  
   
   $id = clear_string($_GET["id"]);  // выводим товары , по ид.. 
   
    If ($id != $_SESSION['countid'])  // предотвратим возможность накрутить рейтинги через просмотры
{
$querycount = mysql_query("SELECT count FROM table_products WHERE products_id='$id'",$link);
$resultcount = mysql_fetch_array($querycount); 
$newcount = $resultcount["count"] + 1;
$update = mysql_query ("UPDATE table_products SET count='$newcount' WHERE products_id='$id'",$link);  
}
$_SESSION['countid'] = $id; 
     
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<meta http-equiv="content-type" content="text/html; charset=windows-1251" />   
    <link href="css/reset.css" rel="stylesheet" type="text/css" /> 
    <link href="css/style.css" rel="stylesheet" type="text/css" />
       <link href="trackbar/trackbar.css" rel="stylesheet" type="text/css" /> 
   <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>  
    <script type="text/javascript" src="/js/jquery-1.7.2.js"></script>
    <script type="text/javascript" src="/js/shop-script.js"></script>
    <script type="text/javascript" src="/js/jquery.cookie.js"></script>
    <script type="text/javascript" src="/js/jquery-ui.js"></script>
    <script type="text/javascript" src="/js/jquery.form.js"></script>
    <script type="text/javascript" src="/js/jquery.validate.js"></script>
    <script type="text/javascript" src="/js/TextChange.js"></script>
    <script type="text/javascript" src="/js/jcarousellite_1.0.1.js"></script>
    <script type="text/javascript" src="/js/jTabs.js"></script>
    
    <link rel="stylesheet" type="text/css" href="fancybox/jquery.fancybox.css"/>
    <script type="text/javascript" src="fancybox/jquery.fancybox.js"></script>
    
    
	<title>Интернет-Магазин Развлекательного Оборудования</title>
    
    <script type="text/javascript">
$(document).ready(function(){
 
    $("ul.tabs").jTabs({content: ".tabs_content", animate: true, effect:"fade"}); 
    $(".send-review").fancybox();
     $(".image-modal").fancybox(); 
	
});	
</script> 
    
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
$result1 = mysql_query("SELECT * FROM table_products WHERE products_id='$id' AND visible='1'",$link);
If (mysql_num_rows($result1) > 0)
{
$row1 = mysql_fetch_array($result1);
do
{   
if  (strlen($row1["image"]) > 0 && file_exists("./uploads_images/".$row1["image"]))
{
$img_path = './uploads_images/'.$row1["image"];
$max_width = 250; 
$max_height = 250; 
 list($width, $height) = getimagesize($img_path); 
$ratioh = $max_height/$height; 
$ratiow = $max_width/$width; 
$ratio = min($ratioh, $ratiow); 
$width = intval($ratio*$width); 
$height = intval($ratio*$height);    
}else
{
$img_path = "/img/no-image.jpg";
$width = 110;
$height = 200;
} 
// подсчет колличества отзывов
$query_reviews = mysql_query("SELECT * FROM table_reviews WHERE products_id = '$id' AND moderat='1'",$link);  
$count_reviews = mysql_num_rows($query_reviews);

echo  '
<div id="block-breadcrumbs-and-rating">
<p id="nav-breadcrumbs2"><a href="index.php?">Игровые аппараты</a> \ <span>'.$row1["brand"].'</span></p>
<div id="block-like">
<p id="likegood" tid="'.$id.'">Нравится</p><p id="likegoodcount">'.$row1["yes_like"].' <img src="/img/heart.jpg"/></p>
</div>
</div>

<div id="block-content-info">
<img src="'.$img_path.'" width="'.$width.'" height="'.$height.'" />
<div id="block-mini-description">
<p id="content-title">'.$row1["title"].'</p>
<ul class="reviews-and-counts-content">
<li><img src="/img/eye.jpg" /><p>'.$row1["count"].'</p></li>
<li><img src="/img/commenticon.jpg" /><p>'.$count_reviews.'</p></li>
</ul>
<p id="style-price" >'.group_numerals($row1["price"]).' руб.</p>
<a class="add-cart" id="add-cart-view" tid="'.$row1["products_id"].'" ></a>
<p id="content-text">'.$row1["mini_description"].'</p>
</div>
</div>
';
} 
while ($row = mysql_fetch_array($result1)); 
// вывод изображений (мини картинки которые можно увеличить и рассмотреть товар под разными ракурсами)
 $result = mysql_query("SELECT * FROM uploads_images WHERE products_id='$id'",$link);
If (mysql_num_rows($result) > 0)
{
$row = mysql_fetch_array($result);
echo '<div id="block-img-slide">
      <ul>';
do
{
    
$img_path = './uploads_images/'.$row["image"];
$max_width = 70; 
$max_height = 70; 
 list($width, $height) = getimagesize($img_path); 
$ratioh = $max_height/$height; 
$ratiow = $max_width/$width; 
$ratio = min($ratioh, $ratiow); 
$width = intval($ratio*$width); 
$height = intval($ratio*$height);    
    
    
echo '
<li>
<a class="image-modal" href="#image'.$row["id"].'"><img src="'.$img_path.'" width="'.$width.'" height="'.$height.'" /></a>
</li>
<a style="display:none;" class="image-modal" rel="group" id="image'.$row["id"].'" ><img  src="./uploads_images/'.$row["image"].'" /></a>
';
}
 while ($row = mysql_fetch_array($result));
 echo '
 </ul>
 </div>    
        ';
}
$result = mysql_query("SELECT * FROM table_products WHERE products_id='$id' AND visible='1'",$link);
$row = mysql_fetch_array($result);
// описания характеристики и видео товара
echo '
<ul class="tabs">
    <li><a class="active" href="#" >Описание</a></li>
    <li><a href="#" >Характеристики</a></li>
    <li><a href="#" >Видеообзор</a></li>  
    <li><a href="#" >Отзывы</a></li>  
</ul>


<div class="tabs_content">
<div>'.$row["description"].'</div>
<div>'.$row["features"].'</div>
<div><video width="600" height="380" controls="controls"><source src="/video/Outpost.mp4" type="video/mp4"/><a href="/video/Outpost.mp4">Скачайте видео</a></video></div>
<div>
<p id="link-send-review" ><a class="send-review" href="#send-review" >Написать отзыв</a></p>


';
// выводим отзывы
$query_reviews = mysql_query("SELECT * FROM table_reviews WHERE products_id='$id' AND moderat='1' ORDER BY reviews_id DESC",$link);
If (mysql_num_rows($query_reviews) > 0)
{
$row_reviews = mysql_fetch_array($query_reviews);
do
{
    
echo '
<div class="block-reviews" >
<p class="author-date" ><b>'.$row_reviews["name"].'</b>, '.$row_reviews["date"].'</p>
<img src="/img/plus-reviews.png" />
<p class="textrev" >'.$row_reviews["good_reviews"].'</p>
<img src="/img/minus-reviews.png" />
<p class="textrev" >'.$row_reviews["bad_reviews"].'</p>
<p class="text-comment">'.$row_reviews["comment"].'</p>
</div>
';
   
}
 while ($row_reviews = mysql_fetch_array($query_reviews));
}
else
{
    echo '<p class="title-no-info" >Отзывов нет</p>';
} 
// форма для публикации отзыва
echo'

</div>
</div>


  <div id="send-review" >
    
    <p align="right" id="title-review">Публикация отзыва производится после предварительной модерации.</p>
    
    <ul>
    <li><p align="right"><label id="label-name" >Имя<span>*</span></label><input maxlength="15" type="text"  id="name_review" /></p></li>
    <li><p align="right"><label id="label-good" >Достоинства<span>*</span></label><textarea id="good_review" ></textarea></p></li>    
    <li><p align="right"><label id="label-bad" >Недостатки<span>*</span></label><textarea id="bad_review" ></textarea></p></li>     
    <li><p align="right"><label id="label-comment" >Коментарий</label><textarea id="comment_review" ></textarea></p></li>     
    </ul>
    <p id="reload-img"><img src="/img/loading.gif"/></p> <p id="button-send-review" iid="'.$id.'" ></p>
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
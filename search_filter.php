<?php
    define('mystorefirst',true);
	include("include/db_connect.php"); // ����������� �� � �������.
    include("functions/functions.php");
    session_start(); 
    include("include/auth_cookie.php");
    
    $cat = clear_string ($_GET["cat"]);
    $type = clear_string ($_GET["type"]);
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
     
	<title>����� �� ����������</title>
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

if ($_GET["brand"])
{
    $check_brand = implode(',',$_GET["brand"]);
}

$start_price = (int)$_GET["start_price"];
$end_price = (int)$_GET["end_price"];

if(!empty($check_brand) || !empty($end_price))
{
    if(!empty($check_brand)) $query_brand = "AND brand_id IN($check_brand)";
    if(!empty($end_price)) $query_price = "AND price BETWEEN $start_price AND $end_price ";
}


	$result = mysql_query("SELECT * FROM table_products WHERE visible='1' $query_brand $query_price ORDER BY products_id DESC",$link); // ������� ���������� � ����� SQL ������ ($link - ���������� � ����������� ����������� � BD - ����� �� ����� db_connect.php)
    
 if(mysql_num_rows($result) > 0){             // �������� ���� �� � ������� ��� -�� ��� ����������� - ���� ��� ������ �� ������ ���� ���� ������ ���� ������.
    $row = mysql_fetch_array($result); 
     // � ���������� $row �������� ��� ���� ������
    
    echo '
    
    <div id="block-sorting">
<p id="nav-breadcrumbs"><a href="index.php">������� �������</a> | <span> ��� ������</span></p>
<ul id="option-list">
<li>���:</li>
<li><img id="style-grid" src="/img/grid.jpg" /></li>
<li><img id="style-list" src="/img/list.jpg" /></li>
<li><a id="select-sort">'.$sort_name.'</a>                
<ul id="sorting-list">
<li><a href="view_cat.php?'.$catlink.'&type='.$type.'&sort=price-asc">�� ������� � �������</a></li>
<li><a href="view_cat.php?'.$catlink.'&type='.$type.'&sort=rice-desc">�� ������� � �������</a></li>
<li><a href="view_cat.php?'.$catlink.'&type='.$type.'&sort=popular">����������</a></li>
<li><a href="view_cat.php?'.$catlink.'&type='.$type.'&sort=news">�������</a></li>
<li><a href="view_cat.php?'.$catlink.'&type='.$type.'&sort=brand">�� � �� �</a></li>
</ul>
</li>
</ul>
</div>

<ul id="block-tovar-grid">

     ';
     
               
    do{
        
if  ($row["image"] !="" && file_exists("./uploads_images/".$row["image"]))     // ���������� ������������ ������ ���������� � ������(������ ������������ ������� ����� ����������� ����� ��������� ����������� � ������ ���������� ��������)(����� ������ ����� � ���� � ����� ����������� � ��� ������ ���� ���� ���������� � ��������))
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
        
        echo                                  // ��������� �� ��, ��� �� ����� �������� ������ � ����� ������  ���  (������ �� �� ����������� � ��������� ��������� ������������ ���������� ������������ � ������)
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
        <p class="style-price-grid"><b>'.group_numerals($row["price"]).'</b>���.</p>
        <div class="mini-features">
        '.$row["mini_features"].'
        </div>
        </li>              
        ' ;                              
    }
    while ($row = mysql_fetch_array($result)); // ���� ����������� �� ��� ��� ���� �� ����������� ��� �������� � �������

?>

</ul>



<ul id="block-tovar-list">


<?php
	$result = mysql_query("SELECT * FROM table_products WHERE visible='1'$query_brand $query_price ORDER BY products_id DESC",$link); // ������� ���������� � ����� SQL ������ ($link - ���������� � ����������� ����������� � BD - ����� �� ����� db_connect.php)
    
 if(mysql_num_rows($result) > 0){             // �������� ���� �� � ������� ��� -�� ��� ����������� - ���� ��� ������ �� ������ ���� ���� ������ ���� ������.
    $row = mysql_fetch_array($result);        // � ���������� $row �������� ��� ���� ������
    do{
        
if  ($row["image"] !="" && file_exists("./uploads_images/".$row["image"]))     // ���������� ������������ ������ ���������� � ������(������ ������������ ������� ����� ����������� ����� ��������� ����������� � ������ ���������� ��������)(����� ������ ����� � ���� � ����� ����������� � ��� ������ ���� ���� ���������� � ��������))
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
        
        echo                                  // ��������� �� ��, ��� �� ����� �������� ������ � ����� ������  ���  (������ �� �� ����������� � ��������� ��������� ������������ ���������� ������������ � ������)
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
        <p class="style-price-list"><b>'.group_numerals($row["price"]).'</b>���.</p>
        <div class="style-text-list">
        '.$row["mini_description"].'
        </div>
        </li>              
        ' ;                              
    }
    while ($row = mysql_fetch_array($result)); // ���� ����������� �� ��� ��� ���� �� ����������� ��� �������� � �������
 }
 }else{
    echo '<h3>��������� �� �������� ��� �� �������.</h3>';
 }
?>

</ul>


</div>
<?php
	include("include/block-footer.php");
?>
</div>
</body>
</html>
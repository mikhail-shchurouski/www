<?php
	defined('mystorefirst') or die('�������� �� �������!');
?><div id="block-news">
<center><img id="news-prev"  src="/img/Up.jpg"/></center>
<div id="newsticker">
<ul>
<?php
	$result = mysql_query("SELECT * FROM news ORDER BY id DESC",$link); // ������� ���������� � ����� SQL ������ ($link - ���������� � ����������� ����������� � BD - ����� �� ����� db_connect.php)
    
 if(mysql_num_rows($result) > 0){             // �������� ���� �� � ������� ��� -�� ��� ����������� - ���� ��� ������ �� ������ ���� ���� ������ ���� ������.
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
    } // ���� ����������� �� ��� ��� ���� �� ����������� ��� �������� � �������
?>	
</ul>
</div>
<center><img id="news-next" src="/img/Down.jpg"/></center>
</div>
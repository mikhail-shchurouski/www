<?php
	defined('mystorefirst') or die('�������� �� �������!');
?>
<div id="block-category">
<p class="header-title">��������� �������</p>
<ul>
<li><a id="index1"><img src="/img/kachalka.jpg" id="kachalka-images"/>�������</a>
<ul class="category-section">
<li><a href="view_cat.php? type=rocking"><b>��� ������:</b></a></li>

<?php
	$result = mysql_query("SELECT * FROM category WHERE type = 'rocking'",$link); // ������� ���������� � ����� SQL ������ ($link - ���������� � ����������� ����������� � BD - ����� �� ����� db_connect.php)
    
 if(mysql_num_rows($result) > 0){             // �������� ���� �� � ������� ��� -�� ��� ����������� - ���� ��� ������ �� ������ ���� ���� ������ ���� ������.
    $row = mysql_fetch_array($result);        // � ���������� $row �������� ��� ���� ������
    do{
     echo '
 <li><a href="view_cat.php?cat='.strtolower($row["brand"]).'&type='.$row["type"].'">'.$row["brand"].'</a></li> 
     ';                                 // ��� ������ ������� �� ���� ��� ������ ������� == rocking - �������
    }
    while ($row = mysql_fetch_array($result)); // ���� ����������� �� ��� ��� ���� �� ����������� ��� �������� � �������
 }
?>

</ul>
</li>


<li><a id="index2"><img src="/img/hockey.jpg" id="hockey-images"/>����������</a>
<ul class="category-section">
<li><a href="view_cat.php? type=air_hockey"><b>��� ������:</b></a></li>
<?php
	$result = mysql_query("SELECT * FROM category WHERE type = 'air_hockey'",$link); // ������� ���������� � ����� SQL ������ ($link - ���������� � ����������� ����������� � BD - ����� �� ����� db_connect.php)
    
 if(mysql_num_rows($result) > 0){             // �������� ���� �� � ������� ��� -�� ��� ����������� - ���� ��� ������ �� ������ ���� ���� ������ ���� ������.
    $row = mysql_fetch_array($result);        // � ���������� $row �������� ��� ���� ������
    do{
     echo '
 <li><a href="view_cat.php?cat='.strtolower($row["brand"]).'&type='.$row["type"].'">'.$row["brand"].'</a></li> 
     ';                                 // ��� ������ ������� �� ���� ��� ������ ������� == air_hockey - ���������
    }
    while ($row = mysql_fetch_array($result)); // ���� ����������� �� ��� ��� ���� �� ����������� ��� �������� � �������
 }
?>
</ul>
</li>


<li><a id="index3"><img src="/img/simulator.jpg" id="simulator-images"/>�����a�������</a>
<ul class="category-section">
<li><a href="view_cat.php? type=simulator"><b>��� ������:</b></a></li>
<?php
	$result = mysql_query("SELECT * FROM category WHERE type = 'simulator'",$link); // ������� ���������� � ����� SQL ������ ($link - ���������� � ����������� ����������� � BD - ����� �� ����� db_connect.php)
    
 if(mysql_num_rows($result) > 0){             // �������� ���� �� � ������� ��� -�� ��� ����������� - ���� ��� ������ �� ������ ���� ���� ������ ���� ������.
    $row = mysql_fetch_array($result);        // � ���������� $row �������� ��� ���� ������
    do{
     echo '
 <li><a href="view_cat.php?cat='.strtolower($row["brand"]).'&type='.$row["type"].'">'.$row["brand"].'</a></li> 
     ';                                 // ��� ������ ������� �� ���� ��� ������ ������� == simulator - ���������� ��������
    }
    while ($row = mysql_fetch_array($result)); // ���� ����������� �� ��� ��� ���� �� ����������� ��� �������� � �������
 }
?>
</ul>
</li>

</ul>

</div>
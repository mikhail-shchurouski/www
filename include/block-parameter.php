<?php
	defined('mystorefirst') or die('�������� �� �������!');
?>
<script type="text/javascript">        
$(document).ready(function(){
    $('#blocktrackbar').trackbar({
        onMove : function(){
            document.getElementById("start-price").value = this.leftValue;
            document.getElementById("end-price").value = this.rightValue;
        },
        width : 160,
        leftLimit : 100,
        leftValue : <?php
        if ((int)$_GET["start_price"] >=100 AND (int)$_GET["start_price"] <= 30000)
{
    echo (int)$_GET["start_price"];
}	else{
    echo "10000";
}
?>,
        rightLimit : 30000,
        rightValue : <?php
        if ((int)$_GET["end_price"] >=100 AND (int)$_GET["end_price"] <= 30000)
{
    echo (int)$_GET["end_price"];
}	else{
    echo "20000";
}
?>,
        roundUp : 100
    });
    
});

</script>


<div id="block-parameter">
<p class="header-title">����� �� ����������</p>
<p class="title-filter">���������</p>
<form method="GET" action="search_filter.php">
<div id="block-input-price" >
<ul>
<li><p>��:</p></li>
<li><input type="text" id="start-price" name="start_price" value="100" /></li>
<li><p>��:</p></li>
<li><input type="text" id="end-price" name="end_price" value="30000" /></li>
<li><p>���.</p></li>
</ul>
</div>
<div id="blocktrackbar"></div>
<p class="title-filter">�������������</p>
<ul class="checkbox-brend">
<?php
	
    $result = mysql_query("SELECT * FROM category WHERE type='rocking'",$link);
    if (mysql_num_rows($result)>0)
    {
        $row = mysql_fetch_array($result);
        do{
            $checked_brand="";
            if ($_GET["brand"])
            {
                if(in_array($row["id"],$_GET["brand"]))
                {
                    $checked_brand = "checked";
                }
            }
           echo '
           <li><input '.$checked_brand.' type="checkbox" name = "brand[]" value="'.$row["id"].'" id="checkbrend'.$row["id"].'"/><label for="checkbrend'.$row["id"].'">'.$row["brand"].'</label></li>
           '; 
        }
        while ($row = mysql_fetch_array($result));
    }
?>

</ul>
<center><input type="submit" name="submit" id="button-param-search" value=" " /></center>
</form>
</div>
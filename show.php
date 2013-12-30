<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">	
	<style>
	#White{
		width: 100%;
		background-color: #ffffff;
	}
	#Fond{
		padding-top: 15;
		width: 100%;
		background-image: url("http://s2.goodfon.ru/image/577452-1366x768.jpg");
		height: 100%;
	}
	.p {font-size: 11pt;}
	</style>
	
</head>
<div id="Fond">
<body>
	
<h2>Художественные выставки</h2></h1>


<?php

/* Переменные для соединения с базой данных */
$hostname = "localhost";
$username = "root";
$password = "";
$dbName = "art_shows";
$pagename = 'show.php';
$num = 10;

if(isset($_GET["page"]))
{
$page = $_GET["page"];
//$_SESSION['page'] = $page;
}

function navigate($pagename, $page, $total)
{
if($page != 1) $firstpage = '<a href= ./'.$pagename.'?page=1><<</a> <a href= ./'.$pagename.'?page='.($page - 1).'><</a> ';
if($page != $total) $nextpage = ' <a href= ./'.$pagename.'?page='.($page + 1).'>></a></a>
<a href= ./'.$pagename.'?page='.$total.'>>></a></a>';
if($page - 2 > 0) $page2left = ' <a href= ./'.$pagename.'?page='.($page - 2).'>'.($page - 2).'</a> | ';
if($page - 1 > 0) $pageleft = ' <a href= ./'.$pagename.'?page='.($page - 1).'>'.($page - 1).'</a> | ';
if($page + 2 <= $total) $page2right = ' | <a href= ./'.$pagename.'?page='.($page + 2).'>'.($page + 2).'</a>';
if($page + 1 <= $total) $pageright = ' | <a href= ./'.$pagename.'?page='.($page + 1).'>'.($page + 1).'</a> ';
echo $firstpage.$page2left.$pageleft.'<b>'.$page.'</b>'.$pageright.$page2right.$nextpage;
}

/*создать соединение */
mysql_connect($hostname,$username,$password) OR DIE("Не могу создать соединение ");

/* выбрать базу данных. Если произойдет ошибка - вывести ее */
mysql_select_db($dbName) or die(mysql_error());  

mysql_query ("set_client='utf8'");
mysql_query ("set character_set_results='utf8'");
mysql_query ("set collation_connection='utf8_general_ci'");
mysql_query ("SET NAMES utf8");

// Выполняем SQL-запрос
$query = '
SELECT show_start,show_name,mus_name,mus_adds FROM art_show
JOIN museum on mus_id = show_mus_id
ORDER BY show_start ';

$result = mysql_query($query) or die('Запрос не удался: ' . mysql_error());
while ($line[] = mysql_fetch_array($result, MYSQL_ASSOC)) ;

$total = ((count($line)-1)/$num);
$page = intval($page);
if(empty($page) or $page < 0) $page = 1;
if($page > $total) $page = $total;
$start = $page * $num - $num;
if($start < 0)
$start = 0;
$qr_limit = " LIMIT $start,$num";

$result = mysql_query($query.$qr_limit) or die('query has dont work: ' . mysql_error());
while ($line1[] = mysql_fetch_array($result, MYSQL_ASSOC));

// Освобождаем память от результата
mysql_free_result($result);

// Закрываем соединение
mysql_close($link);
?>
<div id="White">
 <table border="1" width="100%" class=p>
				 <tr>
				   <th>Дата</th>
				   <th>Название мероприятия</th>
				   <th>Место проведения</th>
				   <th>Адрес</th>
				 </tr>
				 
<?php
// Выводим результаты в html
  
    foreach ($line1 as $col_value) {  
		echo "\t<tr>\n";
        echo "\t\t<td>$col_value[show_start]</td>\n";
        echo "\t\t<td><a href='show.php?show=$col_value[show_name]'</a>>$col_value[show_name]</a></td>\n";
        echo "\t\t<td>$col_value[mus_name]</td>\n";
        echo "\t\t<td>$col_value[mus_adds]</td>\n";
        echo "\t</tr>\n";
    }
    echo "</table>";
	echo '<center>';
	navigate($pagename, $page, (int)$total);
	echo '</center>';

?>


			   </table>	 

</div>
</div>




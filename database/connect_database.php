<?php

	$host = "localhost";
	$database = "_project";
	$user = "root";
	$password="";

	$link = mysqli_connect($host, $user, $password, $database) or die("Ошибка".mysqli_error($link));
	//$link -> set_charset(charset:'utf8');

	/*$query = "SELECT * FROM users";
	$result = mysqli_query($link, $query) or die("Ошибка".mysqli_error($link));

	echo "<H3>Категории товаров:</H3>";
	if($result)
	{
    	$rows = mysqli_num_rows($result);
	    for($i = 0; $i< $rows; ++$i)
	    {
	        $row = mysqli_fetch_row($result); //преобразует результат запроса в массив
	        echo "<p>".$row[0]."</p>"; //обращение к элементу массива (элементу-категории), если там будет 0, то к айдишникам
	    }
	    mysqli_free_result($result); //очистка результата
	}*/
	?>
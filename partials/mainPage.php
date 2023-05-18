<!DOCTYPE html>
	
<html lang="ru">
<head>
	<link rel="stylesheet" href="/css/mainStyle.css" type="text/css">
	<link rel="stylesheet" href="/css/logIn_style.css" type="text/css">
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title>Главная страница</title>
	<style type="text/css">
		body {
			background-image: url(/img/img_20.jpg);
			background-attachment:fixed;
			height: auto;
			background-repeat: no-repeat;
			background-size: 100% ;
		    display: flex;
		    align-items: center;
		    flex-direction: column;
		}
		.page_content {
			/*margin: auto auto;*/
			align-items: center;
		    display: flex;
		    flex-direction: column;
		    transform: translateY(200%);
		}
		.hello_user_div {
    		display: flex;
		}
		.hello_user {
			margin-right: 8px;
		}
		h2 {
			margin-bottom: 0;
		}
		button {
    		padding: 9px 25px;
		    border: 1px solid #075507;
		    background-color: #075507;
		    font-family: 'Lighthaus';
		    font-size: 12px;
		    color:white;
		    margin-top: 30px;
		}
		button:hover {
		    box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.15);
		    transform: scale(1.01);
		    transition: 0.5s;
		}
	</style>
</head>
<body>

	<?php
		session_start();
		$userName=$_SESSION["name"];

		//var_dump($_SESSION["name"])	
	?>
	


	<form action="" method="POST" class="page_content">
		<div class="hello_user_div">
			<h2 class="hello_user">Здравствуйте, </h2>
			<h2><?php echo $userName; ?></h2>
		</div>

		<h2 class="welcom_mainPage">Добро пожаловать на главную страницу сайта!</h2>
		<button type="submit" name="exit_btn">Выйти</button>
	</form>

	<?php


	if(isset($_POST['exit_btn'])) {
			unset($_SESSION["login"]);
			unset($_SESSION["name"]);

			// Возвращаем пользователя на ту страницу, на которой он нажал на кнопку выход.
			print "<script language='Javascript' type='text/javascript'>
			alert('все-ГО хо-РО-ше-го!');

			
			function reload(){ top.location = '/index.php'};
			setTimeout('reload()', 0);
			</script>";
		}
	?>

</body>
</html>





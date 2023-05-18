
<?php 
	session_start();
	include 'C:\OSPanel\domains\project\database\connect_database.php';

	function clearString($str) {
			$str = trim($str); //удаляем пробелы (или другие символы) из начала и конца строки
			$str = strip_tags($str); //удаляем теги HTML
			$str = stripslashes($str); //удаляем экранирование символов
			if(isset($str)) {
				return $str;
			}	
		}

	if(isset($_POST["login_btn"])) {
		$loginError = '';
		$login = $_POST["login"];
		clearString($login);
		if ($login == '') {
			$loginError .= "Заполните поле";
		} else {
			$query = "SELECT id FROM users WHERE login='$login'";
			$result = mysqli_query($link, $query) or die("Ошибка выполнения запроса" .
				mysqli_error($link));
			if ($result) {
				$row = mysqli_fetch_row($result);
				if (empty($row[0]))
					$loginError .= "Данный логин не зарегистрирован";
			}
		}

		$passwordError = '';
		$password = $_POST["password"];
		clearString($password);
		if($password == '') {
			$passwordError .= "Заполните поле";
		} 

	}

		


	if ($loginError.$passwordError == '') {
	
		$password=$_POST["password"];
		$passwordQuery="SELECT password FROM users WHERE login='$login'";
		$saltQuery="SELECT salt FROM users WHERE login='$login'";
		$passwordResult = mysqli_query($link, $passwordQuery) or die("Ошибка выполнения запроса" . mysqli_error($link));
		$saltResult = mysqli_query($link, $saltQuery) or die("Ошибка выполнения запроса" . mysqli_error($link));
		if ($passwordResult && $saltResult) {
			$passworsRow = mysqli_fetch_row($passwordResult);
			$saltRow = mysqli_fetch_row($saltResult);
			if(md5(md5($password).$saltRow[0]) == $passworsRow[0]) {
				$userExists = true; 
			} else if ($login=='' && $password==''){
				print "<script language='Javascript' type='text/javascript'>
				alert('Заполните форму для входа!');
				</script>";
			} else {
				$userExists = false; 
				print "<script language='Javascript' type='text/javascript'>
				alert('Пароль введён неверно!');
				</script>";

			}
		}
	}
	 
	if ($userExists) {
		$nameQuery="SELECT name FROM users WHERE login='$login'";
		$nameResult = mysqli_query($link, $nameQuery) or die("Ошибка выполнения запроса" . mysqli_error($link));
		if ($nameResult) {
			$nameRow = mysqli_fetch_row($nameResult);
			$_SESSION["name"] = $nameRow[0];
			$_SESSION["login"] = $nameRow[0];
			print "<script language='Javascript' type='text/javascript'>
				alert(`Вы успешно вошли в аккаунт!`);
				function reload(){top.location = '/partials/mainPage.php'};
       	             setTimeout('reload()', 200);
				</script>";
		}
		
	}

	?>


<!DOCTYPE html>
	
<html lang="ru">
<head>
	<link rel="stylesheet" href="/css/mainStyle.css" type="text/css">
	<link rel="stylesheet" href="/css/logIn_style.css" type="text/css">
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title>Авторизация</title>
	<style type="text/css">
		
	</style>
</head>
<body>

	<?php 
	require 'header.php' ;
	?>



	<section class="main-section main-section_logIn">
		<div class="container container_2">
			<h2>Авторизация</h2>
			<div class="form-wrapper">
				<form action="" method="post" class="form">
					<div class="box-input">
						<label>Введите логин</label>
						<input class="input" name="login" type="text" value="<?=@$login;?>" required>
						<span class="error"><?=@$loginError;?></span>
					</div>
					<div class="box-input">
						<label>Введите пароль</label>
						<input class="input" name="password" type="password" required>
						<span class="error"><?=@$passwordError;?></span>
					</div>
					<input type="hidden" name="go-auth" value="5">
					<input type="submit" class="button" value="Войти" name="login_btn">
				</form>
			</div>
			<a href="/index.php" class="goBack_href">Назад</a>
		</div>
		<img src="/img/img_6.jpg" class="image_logIn">
		
	</section>

	<?php require 'footer.php' ?>
</body>
</html>


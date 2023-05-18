<?php 

include 'C:\OSPanel\domains\project\database\connect_database.php';
session_start();

	//этой функцией будут обрабатываться все переменные
function clearString($str) {
		$str = trim($str); //удаляем пробелы (или другие символы) из начала и конца строки
		$str = strip_tags($str); //удаляем теги HTML
		$str = stripslashes($str); //удаляем экранирование символов
		if(isset($str)) {
			return $str;
		}	
	}

	if(isset($_POST["reg_btn"])) {


		//---------------------------name-----------------------

		$regex_name = '/[А-ЯA-Z]{1}[а-яa-z]{2,}\s[А-ЯA-Z]{1}[а-яa-z]{2,}\s[А-ЯA-Z]{1}[а-яa-z]{2,}/u';

		$nameError = '';
		$name = $_POST["name"];
		clearString($name);

		if($name == '') {
			$nameError .= "Заполните поле. ";
		} else if(!preg_match($regex_name, $name)) {
			$nameError .= "Введенное имя не соответствует требованиям. ";
		} 


		//---------------------------login-----------------------
		//Логин должен содержать не менее 5 символов, русские или английские символы, знак подчеркивания, не допускаются 3 подряд идущих одинаковых символа.


		$regex_login = '/(?=.{5,}$)(?!.*(.)\1\1)[a-zA-Zа-яА-Я]*\_+[a-zA-Zа-яА-Я]*/u';

		$loginError = '';
		$login = $_POST["login"];
		clearString($login);

		if($login == '') {
			$loginError .= "Заполните поле";
		} else if(!preg_match($regex_login, $login)) {
			$loginError .= "Введенный логин не соответствует требованиям";
		} else {
			$query="SELECT id FROM users WHERE login='$login'";
			$result = mysqli_query($link, $query) or die("Ошибка выполнения запроса" . 
				mysqli_error($link));
			if ($result){
				$row = mysqli_fetch_row($result);
				if (!empty($row[0])) $loginError .= "Данный логин занят"; 
			}
		}


		//---------------------------email-----------------------
		//В Email не допускается использовать почту имеющую доменную зону «.biz».


		$regex_email = '/^\w*\@\w{3,}\.\w*[^biz]$/u';

		$emailError = '';
		$email = $_POST["email"];
		clearString($email);

		if($email == '') {
			$emailError .= "Заполните поле";
		} else if(!preg_match($regex_email, $email)) {
			$emailError .= "Введенная почта не соответствует требованиям";
		} else {
			$query="SELECT id FROM users WHERE email='$email'";
			$result = mysqli_query($link, $query) or die("Ошибка выполнения запроса" . 
				mysqli_error($link));
			if ($result){
				$row = mysqli_fetch_row($result);
				if (!empty($row[0])) $emailError .= "Пользователь с данной почтой уже существует"; 
			}
		}


		//---------------------------password-----------------------
		//Пароль должен состоять из букв латинского и русского алфавита. Не должен содержать символы (#$%^&_=+-). Длина пароля должна быть не меньше 18 символов.

		$regex_password_1 = '/(?=.{18,}$)[[a-zA-Zа-яА-Я]+[^(\#\$\%\^\&\_\=\+\-)]*/';


		$password_1_Error = '';
		$password_1 = $_POST["password_1"];
		clearString($password_1);

		if($password_1 == '') {
			$password_1_Error .= "Заполните поле";
		} else if(!preg_match($regex_password_1, $password_1_Error) && strlen($password_1)<=7) {
			$password_1_Error .= "Введенный пароль не соответствует требованиям";
		}

		$password_2_Error = '';
		$password_2=$_POST['password_2'];
		clearString($password_2);

		if($password_2 == '') {
			$password_2_Error .= "Заполните поле";
		} else if($password_2 != $password_1) {
			$password_2_Error .= "Пароли не совпадают";
		}


		//---------------------------gender-----------------------
		$gender=$_POST['gender'];

		$genderError ='';
		if($gender == '') {
			$genderError .= "Выберите пол";
		} 


		//---------------------------captcha-----------------------
		//Капча должна содержать математическую операцию вычетания и два операнда записанные арабскими цифрами. Пользователь должен ввести результат операции.

		function checkCaptcha() {
			if ($_POST['captcha'] == $_SESSION['captcha']) {
				return true;
			} else {
				return false;
			}
		}

		if(checkCaptcha() == false) $captchaError = 'Неверно введены символы';


		function printLog($success) {
			$currentDate = date("d.m.y");
			$currentTime = date("H:i:s"); 

			$file = fopen('logs.txt', 'a+');
			if($success) {
				$log = "Регистрация прошла успешно (дата: $currentDate, время: $currentTime)\n";
			} else {
				$log = "Регистрация завершена ошибкой (дата: $currentDate, время: $currentTime)\n";
			}
			fwrite($file, $log);
			fclose($file); 
		}

		if ($nameError.$loginError.$emailError.$password_1_Error.$password_2_Error.$genderError.$captchaError== '') {

			$password = $password_1;
			$salt = mt_rand(100, 999);
			$password = md5(md5($password).$salt);
			$query="INSERT INTO users (name, login, email, password, gender, salt) 
			VALUES ('$name','$login','$email','$password','$gender','$salt')";
			$result = mysqli_query($link, $query) or die("Ошибка " . 
				mysqli_error($link));
			if ($result) 
			{
				$query="SELECT * FROM users WHERE login='$login'";
				$rez = mysqli_query($link, $query);
				if ($rez) {
					$row = mysqli_fetch_assoc($rez);
					$_SESSION['name']=$row['name'];
					mysqli_close($link);
				}
				print "<script language='Javascript' type='text/javascript'>
				alert('Вы успешно зарегистрировались! Спасибо!');
				function reload(){top.location = '/partials/loginPage.php'};
				setTimeout('reload()', 200);
				</script>";
				printLog(true);

			}
		} else if($name=='' && $login=='' && $email=='' && $password_1=='' && $password_2=='' && $gender=='' && $captcha==''){
			print "<script language='Javascript' type='text/javascript'>
			alert('Заполните все поля формы');
			</script>";
		} else {
			print "<script language='Javascript' type='text/javascript'>
			alert('Вы не были зарегистрированы.Проверьте данные формы и исправьте, где необходимо. ');
			</script>";
			printLog(false);

		}
	}
	
	?>
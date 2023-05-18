<link rel="stylesheet" href="css/mainStyle.css" type="text/css">

<section class="main-section">
	<img src="img/img_4.jpg" class="image">
	<div class="container">
		<div class="title">Регистрация</div>
		<div class="form-wrapper">
			<form action="index.php" method="post" class="form">
				<div class="box-input">
					<label>Введите ФИО</label>
					<input class="input input_2" name="name" type="text" value="<?=@$name;?>" required>
					<span class="error"><?=@$nameError;?></span>
				</div>
				<div class="box-input">
					<label>Введите логин</label>
					<input class="input input_2" name="login" type="text" value="<?=@$login;?>" required>
					<span class="error"><?=@$loginError;?></span>
				</div>
				<div class="box-input">
					<label>Введите E-mail</label>
					<input class="input input_2" name="email" type="text" value="<?=@$email;?>" required>
					<span class="error"><?=@$emailError;?></span>
				</div>
				<div class="box-input">
					<label>Придумайте пароль</label>
					<input class="input input_2" name="password_1" type="password" required>
					<span class="error"><?=@$password_1_Error;?></span>
				</div>
				<div class="box-input">
					<label>Повторите пароль</label>
					<input class="input input_2" name="password_2" type="password" required>
					<span class="error"><?=@$password_2_Error;?></span>
				</div>
				<div class="radio-box-input">
					<div class="radio-input-wrapper">
						<label>Выберите ваш пол</label>
						<div class="inputs-wrapper">
							<div class="radio-input">
								<input id="rbtn1" name="gender" type="radio" value="Мужской"
								<?=@$rdbtnCheckedMan;?>>
								<label for="rbtn1">Мужской</label>
							</div>
							<div class="radio-input">
								<input id="rbtn2" name="gender" type="radio" value="Женский"
								<?=@$rdbtnCheckedWoman;?>>
								<label for="rbtn1">Женский</label>
							</div>
						</div>
					</div>
					<span class="error"><?=@$genderError;?></span>
				</div>
				
				<div class="captcha-box-input">
					<img src='capcha/captcha.php' id='captcha'>
					<a href="javascript:void(0);" onclick="document.getElementById('captcha').src='capcha/captcha.php'" class="a_capcha">Обновить капчу</a>
					<div>
						<label>Введите ответ</label>
						<input type="text" name="captcha" />
					</div>

				</div>
					
				<div class="actionButtons">
					<!-- <input type="hidden" name="go-reg" value="5"> -->
					<input type="submit" class="button" value="Зарегистрироваться" name="reg_btn">
					<a href="partials/loginPage.php" class="login_href">Войти</a>
				</div>

			</form>

			
		</div>
	</div>
</section>
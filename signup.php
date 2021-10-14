<!DOCTYPE html>
<html lang="en">
<head>
	<title>Login V8</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
<!--===============================================================================================-->
</head>
<body>
	<?php 
		require 'db.php';

		$data = $_POST;

		// function captcha_show(){
		// 	// $questions = array(
		// 	// 	1 => 'Столица России',
		// 	// 	2 => 'Столица США',
		// 	// 	3 => '2 + 3',
		// 	// 	4 => '15 + 14',
		// 	// 	5 => '45 - 10',
		// 	// 	6 => '33 - 3'
		// 	// );
		// 	// $num = mt_rand( 1, count($questions) );
		// 	$_SESSION['captcha'] = $num;
		// 	echo $questions[$num];
		// }

		//если кликнули на button
		if ( isset($data['do_signup']) )
		{
		// проверка формы на пустоту полей
			$errors = array();
			if ( trim($data['login']) == '' )
			{
				$errors[] = 'Введите логин';
			}

			if ( trim($data['email']) == '' )
			{
				$errors[] = 'Введите Email';
			}

			if ( $data['password'] == '' )
			{
				$errors[] = 'Введите пароль';
			}

			if ( $data['password_2'] != $data['password'] )
			{
				$errors[] = 'Повторный пароль введен не верно!';
			}

			//проверка на существование одинакового логина
			if ( R::count('users', "login = ?", array($data['login'])) > 0)
			{
				$errors[] = 'Пользователь с таким логином уже существует!';
			}
		
		//проверка на существование одинакового email
			if ( R::count('users', "email = ?", array($data['email'])) > 0)
			{
				$errors[] = 'Пользователь с таким Email уже существует!';
			}

			// проверка капчи
			// $answers = array(
			// 	1 => 'москва',
			// 	2 => 'вашингтон',
			// 	3 => '5',
			// 	4 => '29',
			// 	5 => '35',
			// 	6 => '30'
			// );
			// if ( $_SESSION['captcha'] != array_search( mb_strtolower($_POST['captcha']), $answers ) )
			// {
			// 	$errors[] = 'Ответ на вопрос указан не верно!';
			// }


			if ( empty($errors) )
			{
				//ошибок нет, теперь регистрируем
				$user = R::dispense('users');
				$user->login = $data['login'];
				$user->email = $data['email'];
				$user->password = password_hash($data['password'], PASSWORD_DEFAULT); //пароль нельзя хранить в открытом виде, мы его шифруем при помощи функции password_hash для php > 5.6
				R::store($user);
				
				$_SESSION['logged_user'] = $user;
				ob_start();
				header('Location: /index.php');
				ob_end_flush();
				die();
			}else
			{
				echo '<div id="errors" style="color:red;">' .array_shift($errors). '</div><hr>';
			}

		}

	?>
	
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<form class="login100-form validate-form p-l-55 p-r-55 p-t-178" action="login.php" method="POST">
					<span class="login100-form-title">
						Регистрация
					</span>

					<div class="wrap-input100 validate-input m-b-16" data-validate="Введите логин">
						<input class="input100" type="text" name="login" placeholder="Логин" value="<?php echo @$data['login']; ?>">
						<span class="focus-input100"></span>
					</div>

					<div class="wrap-input100 validate-input m-b-16" data-validate="Введите Email">
						<input class="input100" type="text" name="login" placeholder="Email" value="<?php echo @$data['email']; ?>">
						<span class="focus-input100"></span>
					</div>

					<div class="wrap-input100 validate-input  m-b-16" data-validate = "Введите пароль">
						<input class="input100" type="password" name="password" placeholder="Пароль"  value="<?php echo @$data['password'];?>" >
						<span class="focus-input100"></span>
					</div>

					<div class="wrap-input100 validate-input  m-b-16" data-validate = "Повторите пароль">
						<input class="input100" type="password" name="password" placeholder="Повторите пароль"  value="<?php echo @$data['password_2']; ?>">
						<span class="focus-input100"></span>
					</div>

					<!-- <div class="text-right p-t-13 p-b-23">
						<span class="txt1">
							Forgot
						</span>

						<a href="#" class="txt2">
							Username / Password?
						</a>
					</div> -->

					<div class="container-login100-form-btn">
						<button class="login100-form-btn" type="submit" name="do_signup">
							Sign UP
						</button>
					</div>

					<div class="flex-col-c p-t-170 p-b-40">
						<span class="txt1 p-b-9">
							Уже есть аккаунт?
						</span>

						<a href="/login.php" class="txt3">
							Войти
						</a>
					</div>
				</form>
			</div>
		</div>
	</div>
	
	
<!--===============================================================================================-->
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/daterangepicker/moment.min.js"></script>
	<script src="vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
	<script src="js/main.js"></script>

</body>
</html>
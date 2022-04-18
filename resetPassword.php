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

		//если кликнули на button
		if ( isset($data['do_email']) )
		{
		// проверка формы на пустоту полей
			// $errors = array();
			// if ( trim($data['login']) == '' )
			// {
			// 	$errors[] = 'Введите логин';
			// }

            $tt = R::getAll( "SELECT email FROM users where email='" . $data['email'] ."'");
            if(count($tt) == 0) {
                $errors[] = 'Такого пользователя не существует';
            }
            
			if ( empty($errors) )
			{

                function randomPassword() {
                    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
                    $pass = array(); //remember to declare $pass as an array
                    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
                    for ($i = 0; $i < 8; $i++) {
                        $n = rand(0, $alphaLength);
                        $pass[] = $alphabet[$n];
                    }
                    return implode($pass); //turn the array into a string
                }

                $message = "Ваш новый пароль: " . randomPassword();

                var_dump($message);

                // На случай если какая-то строка письма длиннее 70 символов мы используем wordwrap()
                // $message = wordwrap($message, 70, "\r\n");

                // Отправляем
                mail($data['email'] , 'Восстановление пароля', $message);
				
				//ошибок нет, теперь регистрируем                
				// $user = R::dispense('users');
				
				// $user->login = $data['login'];
				// $user->email = $data['email'];
				// $user->password = password_hash($data['password'], PASSWORD_DEFAULT);
				// R::store($user);
				
				
				// $_SESSION['logged_user'] = $user;
				// ob_start();
				// header('Location: /index.php');
				// ob_end_flush();
				// die();
			}
            else
			{
				echo '<div id="errors" style="color:red;">' .array_shift($errors). '</div><hr>';
			}

		}

	?>
	
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<form class="login100-form validate-form p-l-55 p-r-55 p-t-178" action="/resetPassword.php" method="POST">
					<span class="login100-form-title">
						Восстановление пароля
					</span>

					<div class="wrap-input100 validate-input m-b-16" data-validate="Введите Email">
						<input class="input100" type="text" name="email" placeholder="Email" value="<?php echo @$data['email']; ?>">
						<span class="focus-input100"></span>
					</div>

					<div class="container-login100-form-btn">
						<button class="login100-form-btn" type="submit" name="do_email">
							Отправить письмо
						</button>
					</div>

					<div class="flex-col-c p-t-170 p-b-40">
                        
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
<?php
session_start();
$title = "Login";

include('page-master/head.php');
$loginError = '';
if (!empty($_POST['username']) && !empty($_POST['pwd'])) {
	include('Chat.php');
	$email_encode = base64_encode($_POST['username']);
	$chat = new Chat();
	$user = $chat->loginUsers($_POST['username'], md5($_POST['pwd'])); // Verificar la contraseña con md5
	if (!empty($user)) {
		if ($user[0]['is_verified'] == 1) {
			$_SESSION['username'] = $user[0]['username'];
			$_SESSION['userid'] = $user[0]['userid'];
			$chat->updateUserOnline($user[0]['userid'], 1);
			$lastInsertId = $chat->insertUserLoginDetails($user[0]['userid']);
			$_SESSION['login_details_id'] = $lastInsertId;
			header("Location: conectado");
		} else {
			header("Location: verify?asc=" . $email_encode);
		}
	} else {
		$loginError = "User and passowrd invalid";
	}
}
?>

<body>
	<div class="container-login">

		<div class="login-form">
			<div class="form-login-container">
				<!-- <div>
					<img src="textures/conectado_logo.webp" alt="logo" width="200px" height="auto" style="border-radius: 0px;">
					<p style="text-align: center; font-weight: 700; font-size: 24px;">Log In</p>

				</div> -->
				<form method="post">
					<div class="form-groups">
						<?php if ($loginError) { ?>
							<div class="alert-error"><?php echo $loginError; ?></div>
						<?php } ?>
					</div>
					<div class="form-groups">
						<label for="username">Email</label>
						<input type="text" class="form-login" name="username" placeholder="Email" required>
					</div>
					<div class="form-groups">
						<label for="pwd">Password</label>
						<input type="password" class="form-login" name="pwd" placeholder="Password" required id="password">
						<i class="icon-eye icon-eys" id="icon-eyes"></i>
					</div>
					<div class="form-groups recuperar">
						<div class="remember">
							<input type="checkbox"> <span class="remember_me">Remember me</span>
						</div>
						<div class="fogot">
							<a href="">Forgot Password</a>
						</div>
					</div>
					<div class="form-groups">
						<hr class="linea_home">
					</div>
					<div class="form-groups grupo_button">
						<button type="submit" name="login" class="btn-login">SIGN IN</button>
					</div>
				</form>
				<div class="form-groups opcion">
					<p class="opcion-registro">Don't have an account? <br><a href="./register">SIGN UP</a> </p>
				</div>
				<div class="form-groups copy_form">
					<span class="copy">Copyright © Conectado 2023 </span>
				</div>
			</div>
		</div>
	</div>


	<script src="./js/functions.js" type=""></script>

	<?php
	include "page-master/footer.php";
	?>
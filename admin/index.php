<?php
session_start();
$title = "Login";

include('page-master/head.php');
$loginError = '';
if (!empty($_POST['username']) && !empty($_POST['pwd'])) {
	include('Chat.php');
	$chat = new Chat();
	$user = $chat->loginUsers($_POST['username'], md5($_POST['pwd'])); // Verificar la contraseña con md5
	if (!empty($user)) {
		$_SESSION['username'] = $user[0]['username'];
		$_SESSION['userid'] = $user[0]['userid'];
		$lastInsertId = $chat->insertUserLoginDetails($user[0]['userid']);
		$_SESSION['login_details_id'] = $lastInsertId;
		header("Location: dashboard");
	} else {
		$loginError = "User and passowrd invalid";
	}
}
?>

<body class="login">
	<div class="container sm:px-10">
		<div class="block xl:grid grid-cols-2 gap-4">
			<!-- BEGIN: Login Info -->
			<div class="hidden xl:flex flex-col min-h-screen">

				<a href="" class="-intro-x flex items-center pt-5">
					<img alt="Midone - HTML Admin Template" class="w-20" src="images/conectado_logo.webp">
				</a>
				<div class="my-auto">
					<img alt="Midone - HTML Admin Template" class="-intro-x w-1/2 -mt-16" src="images/conectado_logo.webp">
					<div class="-intro-x text-white font-medium text-4xl leading-tight mt-10">
						Unos cuantos clics más para
						<br>
						iniciar sesión en su cuenta.
					</div>
					<div class="-intro-x mt-5 text-lg text-white text-opacity-70 dark:text-slate-400">Administre todas sus cuentas de comercio electrónico en un solo lugar</div>
				</div>
			</div>
			<!-- END: Login Info -->
			<div class="h-screen xl:h-auto flex py-5 xl:py-0 my-10 xl:my-0">
				<div class="my-auto mx-auto xl:ml-20 bg-white dark:bg-darkmode-600 xl:bg-transparent px-5 sm:px-8 py-8 xl:p-0 rounded-md shadow-md xl:shadow-none w-full sm:w-3/4 lg:w-2/4 xl:w-auto">
					<h2 class="intro-x font-bold text-2xl xl:text-3xl text-center xl:text-left">
						Iniciar sesión
					</h2>
					<form method="post">
						<div class="intro-x mt-2 text-slate-400 xl:hidden text-center">Unos cuantos clics más para
							iniciar sesión en su cuenta.</div>
						<div class="form-groups">
							<?php if ($loginError) { ?>
								<div class="alert-error"><?php echo $loginError; ?></div>
							<?php } ?>
						</div>
						<div class="intro-x mt-8">
							<input type="text" class="intro-x login__input form-control py-3 px-4 block" name="username" placeholder="Email" required>
							<input type="password" class="intro-x login__input form-control py-3 px-4 block mt-4" name="pwd" placeholder="Password" required id="password">
							<!-- <i class="icon-eye icon-eys" id="icon-eyes"></i> -->
						</div>
						<div class="intro-x mt-5 xl:mt-8 text-center xl:text-left">
							<button type="submit" name="login" class="btn btn-primary py-3 px-4 w-full xl:w-32 xl:mr-3 align-top">Log in</button>
							<!-- <button class="btn btn-outline-secondary py-3 px-4 w-full xl:w-32 mt-3 xl:mt-0 align-top">Register</button> -->
						</div>
					</form>
					
				</div>
			</div>
		</div>
	</div>


	<script src="./js/functions.js" type=""></script>

	<?php
	include "page-master/footer.php";
	?>	
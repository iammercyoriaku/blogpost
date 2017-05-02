<?php

session_start();

$title = "Blog: Login";

include'includes/db.php';
include 'includes/blog_header.php';
include 'includes/functions.php';



$errors = [];

if(array_key_exists('register', $_POST)){

		if(empty($_POST['email'])){
			$errors['email'] = "Please enter your Email Address";
		}

		if(empty($_POST['password'])){
			$errors['password'] = "Please enter your Password";
		}

		if(empty($errors)){

			$nice = array_map('trim', $_POST);

			$new = Utils::doLogin($conn, $nice);

				$_SESSION['admin_id'] = $new[1];

					Utils::redirect("view.php", "");

		}
}


?>

<!DOCTYPE html>
<html>
<head>
	<title>Register</title>
	<link rel="stylesheet" type="text/css" href="styles/styles.css">
</head>
<body>
	<section>
		<div class="mast">
			<h1>T<span>SSB</span></h1>
		</div>
	</section>

	<div class="wrapper">
		<h1 id="register-label">Admin Login</h1>
		<hr>
		<form id="register"  action ="" method ="POST">
			<div>
				<?php

					if(isset($errors['email'])){echo '<span class = "err">' .$errors['email'].'</span>'; }

				?>
				<label>email:</label>
				<input type="text" name="email" placeholder="email">
			</div>
			<div>
				<?php

					if(isset($errors['password'])){echo '<span class = "err">' .$errors['password'].'</span>'; }

				?>
				<label>password:</label>
				<input type="password" name="password" placeholder="password">
			</div>

			<input type="submit" name="register" value="login">
		</form>

		<h4 class="jumpto">Don't have an account? <a href="register.php">register</a></h4>
	</div>

	<section class="foot">
		<?php

			include 'includes/footer.php';

		 ?>

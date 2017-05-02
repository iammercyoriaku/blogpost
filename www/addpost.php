<?php

session_start();

include'includes/functions.php';

Utils::checkLogin();

$title = "Add Post";

include 'includes/dashboard.php';
include'includes/db.php';

   $id = $_SESSION['admin_id'];


	$errors = [];

	if(array_key_exists('add', $_POST)){


	if(empty($_POST['title'])){
		$errors['title'] = "Please enter Post's  title";
	}

	if(empty($_POST['header'])){
		$errors['header'] = "Please enter Post's Header";
	}

	if(empty($_POST['sub_header'])){
		$errors['sub_header'] = "Please enter Post's Sub Header";
	}

  if(empty($_POST['post'])){
		$errors['post'] = "Please type in Post";
	}


	if(empty($errors)){

		$clean = array_map('trim', $_POST);
    $clean['post'] = htmlspecialchars($clean['post']);

		Utils::addPost($conn, $clean, $id);

		Utils::redirect("addpost.php", "");

  }
}

?>


<html>

	<head>

		<title>Posts</title>

		<link rel="stylesheet" type="text/css" href="styles/styles.css">

	</head>

	<body>

		<div class="wrapper">
		<h1 id="register-label">ADD POST</h1>
		<hr>
		<form id="register"  action ="" method ="POST">
			<div>
				<?php
							Utils::displayErrors($errors, 'title');
				?>
				<label>Title:</label>
				<input type="text" name="title" placeholder="Title">
			</div>
			<div>
				<?php
							Utils::displayErrors($errors, 'header');
				?>
				<label>Header:</label>
				<input type="text" name="header" placeholder="Header">
			</div>
			<div>
				<?php
						Utils::displayErrors($errors, 'sub_header');
				?>
				<label>Sub Header:</label>
				<input type="text" name="sub_header" placeholder="Sub Header">
			</div>
      <div>
        <?php
            Utils::displayErrors($errors, 'post');
        ?>
        <label>Post:</label>
        <textarea width="20" height="50" name="post" placeholder="Post"></textarea>
      </div>
      <input type="submit" name="add" value="Add"/>
		</form>



<?php

#including the footer...

include 'includes/blog_footer.php';

?>

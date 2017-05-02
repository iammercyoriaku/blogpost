<?php

session_start();

include'includes/functions.php';

Utils::checkLogin();

$title = "View Posts";

include 'includes/dashboard.php';

include 'includes/db.php';

?>


<html>
<head>
	<title>TEST</title>
	<link rel="stylesheet" type="text/css" href="styles/styles.css">
</head>

<body>
	<div class="wrapper">
		<div id="stream">


			<table id="tab">
				<thead>
					<tr>
            <th>ADMIN ID</th>
						<th>TITLE</th>
						<th>HEADER</th>
						<th>SUB HEADER</th>
						<th>POST</th>
						<th>DATE</th>
            <th>EDIT</th>
            <th>DELETE</th>
					</tr>
					<tbody>

					<?php

				        $list = Utils::viewPost($conn);

									echo $list;

                    ?>



				</tbody>

			</table>
		</div>

		<div class="paginated">
			<a href="#">1</a>
			<a href="#">2</a>
			<span>3</span>
			<a href="#">2</a>
		</div>
	</div>

	<section class="foot">
		<div>
			<p>&copy; 2016;
		</div>
	</section>
</body>
</html>

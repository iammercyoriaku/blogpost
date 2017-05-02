<?php

  include 'includes/functions.php';

$title = "View Page";

  include 'includes/dashboard.php';

if(isset($_GET['admin_id'])){
  $adminid = $_GET['admin_id'];
}

    Utils::getAdminNameById($conn, $adminid);

  while($row = $stmt->fetch(PDO::FETCH_BOTH)){

 ?>



	<div class="wrapper">


    <?php

      echo  '<h2>Welcome'.$row['admin_name'].'</h2>';

     ?>

    <?php } ?> 

		<!--<div id="stream">
			<table id="tab">
				<thead>
					<tr>
						<th>TITLE</th>
						<th>AUTHOR</th>
						<th>PRICE</th>
						<th>YEAR OF PUBLICATION</th>
						<th>ISBN</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>the knowledge gap</td>
						<td>maja</td>
						<td>January, 10</td>
						<td><a href="#">edit</a></td>
						<td><a href="#">delete</a></td>
					</tr>
          		</tbody>
			</table>
		</div>

		<div class="paginated">
			<a href="#">1</a>
			<a href="#">2</a>
			<span>3</span>
			<a href="#">2</a>
		</div>-->
	</div>

	<<?php

    include 'includes/blog_footer.php';

   ?>

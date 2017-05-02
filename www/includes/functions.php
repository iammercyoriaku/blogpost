<?php

  class Utils{

    public static function checkLogin(){

      if(!isset($_SESSION['admin_id'])){
        static::redirect("login.php", "");
      }
    }

    public static function addCategory($dbconn, $input){

      $stmt = $dbconn->prepare("INSERT INTO category(category_name) VALUES(:c)");

      $stmt->bindParam(':c', $input['cat']);

      $stmt->execute();
    }

    public static function doAdminRegister($dbconn, $input) {

  		 #hash the password

  	#insert data
  	$stmt = $dbconn->prepare("INSERT INTO admin(firstname, lastname, email, hash) VALUES(:fn, :ln, :e, :h)");

  	#blind params...
  	$data = [

  		':fn' => $input['fname'],
  		':ln' => $input['lname'],
  		':e' => $input['email'],
  		':h' => $input['password']

  	];

  	$stmt->execute($data);

  	}

  	public static function doesEmailExist($dbconn, $email){
  		$result = false;

  		$stmt = $dbconn->prepare("SELECT email FROM admin WHERE email=:e");

  		#bind params
  		$stmt->bindParam(":e", $email);
  		$stmt->execute();

  		#get number of rows returned
  		$count = $stmt->rowCount();

  		if($count > 0){
  			$result = true;
    	}
  return $result;

  	}

  	public static function displayErrors($wrong, $name){


  				if(isset($wrong[$name])){echo '<span class = "err">' .$wrong[$name].'</span>'; }

  }


public static function doLogin($dbconn, $yes){

      $result = [];

        $stmt = $dbconn->prepare("SELECT admin_id, hash FROM admin WHERE email = :e");

        $stmt->bindParam(':e', $yes['email']);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_BOTH);

        if(($stmt->rowCount() != 1) || !password_verify($yes['password'], $row['hash'])){

          Utils::redirect("login.php?msg", "either username or password is wrong");

          exit();

        } else {

          $result[] = true;
          $result[] = $row['admin_id'];
        }

        return $result;

  }

  public static function redirect($log, $msg){

    header("Location:" .$log.$msg);
  }


public static function viewCategory($dbconn, $any = null, $cb){

  $stmt = $dbconn->prepare("SELECT * FROM category");
  $stmt->execute();

  # delegate to cb..
  $cb($stmt, $any);
}

public static function getCategoryByID($dbconn, $catid){

  $stmt = $dbconn->prepare("SELECT * FROM category WHERE category_id = :ci");

  $stmt->bindParam(':ci', $catid);

  $stmt->execute();

  $row = $stmt->fetch(PDO::FETCH_BOTH);

  return $row;
}

public static function editCategory($dbconn, $input){

  $stmt = $dbconn->prepare("UPDATE category SET category_name = :cn WHERE category_id = :ci ");

  $data = [

            ':cn' => $input['cat'],
            ':ci' => $input['cid']
  ];

  $stmt->execute($data);
}

public static function deleteCategory($dbconn, $catid){

    $stmt = $dbconn->prepare("DELETE FROM category WHERE category_id = :ci");

    $stmt->bindParam(':ci', $catid);

    $stmt->execute();
}


public static function curNav($page) {
  $curPage = basename($_SERVER['SCRIPT_FILENAME']);
  if($curPage == $page) {
    echo 'class="selected"';

    }

  }


  public static function doUpload($files, $name, $uploadir ){

    $data = [];

    $rnd = rand(0000000000, 999999999);

    $strip_name = str_replace(" ", "_", $files[$name]['name']);

    $filename = $rnd.$strip_name;

  $destination = $uploadir .$filename;

  if(!move_uploaded_file($files[$name]['tmp_name'], $destination)){

    $data[] = false;

  } else {

    $data[] = true;
    $data[] = $destination;
  }

    return $data;
   }

   public static function addProduct($dbconn, $input){

     $stmt = $dbconn->prepare("INSERT INTO books( title, author, category_id, price, year_of_publication, ISBN, filepath, flag) VALUES(:t, :a, :ci, :p, :y, :i, :f, :fl)");

 		$data = [

 				':t' => $input['title'],
 				':a' => $input['author'],
        ':ci'=> $input['cat'],
        ':p' => $input['price'],
        ':y' => $input['year'],
 				':i' => $input['isbn'],
 				':f' => $input['file'],
        ':fl' => $input['flag']


 		];

 		$stmt->execute($data);
 	}

  public static function viewProducts($dbconn){

    $result = "";

    $stmt = $dbconn->prepare("SELECT * FROM books");

    $stmt->execute();

    while($row = $stmt->fetch(PDO::FETCH_BOTH)){
      $result .='<tr><td>'.$row[1].'</td><td>'.$row[2].'</td><td>'.$row[3].'</td><td>'
      .$row[4].'</td><td>'.$row[5].'</td><td>'.$row[6].'</td><td><img src="'.$row[7].'" height="60" width="60"></td>
      <td><a href="edit.php?bid='.$row[0].'">edit</a></td></td>
      <td><a href="delete.php?bid='.$row[0].'">delete</a></td></tr>';

    }

      return $result;

  }


  public static function getBookByID($dbconn, $pid) {
    $stmt = $dbconn->prepare("SELECT * FROM book WHERE book_id=:bid");
    $stmt->bindParam(":bid", $pid);

    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_BOTH);

    return $row;
  }

  public static function editProduct($dbconn, $input){

    $stmt = $dbconn->prepare("UPDATE books SET title = :t, author = :a, price = :p, year_of_publication = :y, ISBN = :i WHERE book_id = :b");

    $data = [

          ':t' => $input['title'],
          ':a' => $input['author'],
          ':p' => $input['price'],
          ':y' => $input['year_of_publication'],
          ':i' => $input['ISBN'],
          ':b' => $input['bid']

    ];

    $stmt->execute($data);
  }

  public static function deleteProduct($dbconn, $bookid){

    $stmt = $dbconn->prepare("DELETE FROM books WHERE book_id = :bi");

    $stmt->bindParam(':bi', $bookid);

    $stmt->execute();
  }

  public static function doUserLogin($dbconn, $input){

    $result = [];

      $stmt = $dbconn->prepare("SELECT user_id, hash FROM users WHERE email = :e");

      $stmt->bindParam(':e', $input['email']);
      $stmt->execute();

      $row = $stmt->fetch(PDO::FETCH_BOTH);

      if(($stmt->rowCount() != 1) || !password_verify($input['password'], $row['hash'])){

        Utils::redirect("login.php?msg", "either username or password is wrong");

        exit();

      } else {

        $result[] = true;
        $result[] = $row['user_id'];
      }

      return $result;
  }

  public static function displayUserError($wrong, $name){

    if(isset($wrong[$name])){

      echo '<span class = "err">' .$wrong[$name].'</span>';

     }
  }

  public static function doRegisterUser($dbconn, $input){

    $stmt = $dbconn->prepare("INSERT INTO users(firstname, lastname, email, username, hash) VALUES(:fn, :ln, :e, :un, :h)");

    $data = [

              ':fn' => $input['firstname'],
              ':ln' => $input['lastname'],
              ':e' => $input['email'],
              ':un' => $input['username'],
              ':h' => $input['password']
    ];

    $stmt->execute($data);
  }

  public static function doesUserEmailExist($dbconn, $mail){
    $result = false;

    $stmt = $dbconn->prepare("SELECT email FROM user WHERE email=:e");

    #bind params
    $stmt->bindParam(":e", $mail);
    $stmt->execute();

    #get number of rows returned
    $count = $stmt->rowCount();

    if($count > 0){
      $result = true;
    }
return $result;

  }

public static function topSelling($dbconn, $cb){

      $top = "Top-Selling";
      $stmt = $dbconn->prepare("SELECT * FROM books WHERE flag = :flg");

      $stmt->bindParam(':flg', $top);
      $stmt->execute();

      $row = $stmt->fetch(PDO::FETCH_BOTH);

      $cb($row);

}

public static function trending($dbconn, $cb){

      $trending = "Trending";
      $stmt = $dbconn->prepare("SELECT * FROM books WHERE flag = :flg");

      $stmt->bindParam(':flg', $trending);
      $stmt->execute();

      $cb($stmt);
  }

  public static function recentlyViewed($dbconn, $bid, $uid){

              $stmt = $dbconn->prepare("SELECT * FROM recently_viewed WHERE book_id = :bi AND user_id = :ui");
              $stmt->bindParam(':bi', $bid);
              $stmt->bindParam(':ui', $uid);

              $stmt->execute();

  }

  public static function addPost($dbconn, $input, $adminID){

      $stmt = $dbconn->prepare("INSERT INTO post(admin_id, title, header, sub_header, post, date) VALUES(:ai, :t, :h, :sub, :p, now())");
      $data = [
                  ':ai' => $adminID,
                  ':t' => $input['title'],
                  ':h' => $input['header'],
                  ':sub' => $input['sub_header'],
                  ':p' => $input['post'],

      ];

      $stmt->execute($data);
  }

  public static function viewPost($dbconn){

    $result = "";

    $stmt = $dbconn->prepare("SELECT * FROM post");

    $stmt->execute();

    while($row = $stmt->fetch(PDO::FETCH_BOTH)){
      $result .='<tr><td>'.$row[1].'</td><td>'.$row[2].'</td><td>'.$row[3].'</td><td>'
      .$row[4].'</td><td>'.$row[5].'</td><td>'.$row[6].'</td>
      <td><a href="editpost.php?bid='.$row[0].'">edit</a></td></td>
      <td><a href="deletepost.php?bid='.$row[0].'">delete</a></td></tr>';

    }

      return $result;

  }

  public static function title($dbconn, $cb){

        $title = "Title";
        $stmt = $dbconn->prepare("SELECT * FROM post WHERE title = :ti");

        $stmt->bindParam(':ti', $title);
        $stmt->execute();

        $cb($stmt);



  }












 ?>

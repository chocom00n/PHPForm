<?php
// HEREDOC
//nl2br
error_reporting(E_ALL);
ini_set('display_errors', 1);

require("menu.php");

if (empty($_POST['username']) && empty($_POST['lastname']) && empty($_POST['firstname'])) {
?>
<HTML5>

<form method="POST" enctype="application/x-www-form-urlencoded" action="userAdd.php">

<p>
<label>Nickname
<input type="text" name="username">
</label>
</p>

<p>
<label>Password
<input type="password" name="password" >
</label>
</p>

<p>
<label>Last Name
<input type="text" name="lastname" >
</label>
</p>

<p>
<label>First Name
<input type="text" name="firstname" >
</label>
</p>
<p>
<label>Email
<input type="text" name="email" >
</label>
</p>

<p><button>Submit</button></p>

</form>
<?php
} else {
  require('./connect.php');
  $db = Connect();

  // https://www.owasp.org/index.php/Top_10-2017_Top_10

  // Avoid XSS injections
  // https://www.owasp.org/index.php/Top_10-2017_A7-Cross-Site_Scripting_(XSS)
  $args = [
    "nickname" => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
    "lastname" => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
    "firstname" => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
    "email"    => FILTER_SANITIZE_EMAIL
  ];

  // Replace $_POST by healthy $post
  $post = filter_input_array(INPUT_POST, $args);

  var_dump($post);
  // If the email is not valid redirect to form
  if (!filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL)) {
    header("location: userAdd.php");
    die();
  }

  try {
    // Quote input strings => No SQL injections
    // https://www.owasp.org/index.php/Top_10-2017_A1-Injection
    $query = $db->prepare("INSERT INTO `users` (`username`, `password`, `lastname`, `firstname`, `email`) VALUES (:username, md5(:password), :lastname, :firstname, :email);");
    $query->execute($_POST);

    // Keep input strings as they are typed => SQL injections
    /*$query = "INSERT INTO `users` (`nickname`,`lastname`,`firstname`,`email`) VALUES ('" . $post['nickname'] . "', '" . $post['lastname'] . "', '" . $post['firstname'] . "', '" . $post['email'] . "');";
    $valeurRetour = $db->exec($query);*/

  } catch (Exception $e) {
    echo $e->getMessage();
  }
  if ($valeurRetour) {
    echo "Success";
  } else {
    echo "fail";
  }
}
?>

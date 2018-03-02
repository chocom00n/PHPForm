<?php
// HEREDOC
//nl2br
require("menu.php");

error_reporting(E_ALL);
ini_set('display_errors', 1);
var_dump($_POST);
if (empty($_POST['submit'])) {
?>


<HTML5>

<form method="POST" action="private.php">
<input type="hidden" name="MyHi" value="1234">
<p>
<label>Username
<input type="text" name="username">
</label>
</p>

<p>
<label>Password
<input type="password" name="password" >
</label>
</p>

<p><input type="submit" name="submit" /></p>
<?php
 date_default_timezone_set('Europe/Zurich');
 echo date('Y-m-d H:i:s'); ?>
  </form>

<?php
} else {
  require_once("./connect.php");
  $db = Connect();
  //$query = "SELECT * FROM `access` WHERE `password` = '" . md5($_POST['password']) . "' AND `username` = '" . $_POST['username'] . "'";
  //$valeurRetour = $db->query($query);

  // $query = $db->prepare("SELECT * FROM `users` WHERE `password` = '" . md5($_POST['password']) . "' AND `username` = '" . $_POST['username'] . "'");
  $query = $db->prepare('SELECT * FROM `users` WHERE `password` = :password AND `username` = :username');
  $pwd = md5($_POST['password']);
  $query->bindParam(':password', $pwd, PDO::PARAM_STR, 32);
  $query->bindParam(':username', $_POST['username'], PDO::PARAM_STR);
  $query->execute();

  //var_dump($valeurRetour);
  //var_dump(md5($_POST['password']));

  if ($query->fetchAll()) {
    echo "Access granted";
  } else {
    echo "Denied, loser";
  }
}
?>

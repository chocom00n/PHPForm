<?php
//phpinfo();
require('./connect.php');
$db = Connect();
$reponse = $db->query('Select * from users');
$donnees = $reponse->fetchAll(PDO::FETCH_CLASS);
//var_dump($donnees);
?>
<HTML5>
<head>
</head>
  <body>
    <h1>Login</h1>
    <?php
    foreach ($donnees as $dkey => $user) {
      echo "<b>" . $user->username . ":</b>";
      echo "<ul>";
      foreach ($user as $ukey => $uval) {
        echo "<li>" . $ukey . " -> " . $uval . "</li>\n";
      }
      echo "</ul>\n";
    }
    ?>
  </body>
</html>

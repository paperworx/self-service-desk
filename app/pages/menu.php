<?php
  require_once __DIR__ . '\..\..\config.php';

  session_start();

  if(!isset($_SESSION['card']))
    die('User is not authenticated.');

  $_SESSION['page'] = "menu";
?>

<p>Hello, <strong><?php echo $_SESSION['name']; ?></strong>.<br>
What would you like to do?</p>

<div class="buttons">
  <a class="button big" onclick="loadPage('resetpassword'); return false;"><img src="resetpassword.png"><br>Reset Password</a>
</div>

<div class="subbuttons">
  <a class="button small" onclick="loadPage('logout'); return false;">Logout</a>
</div>
<?php
  require_once __DIR__ . '\..\..\config.php';

  session_start();

  $_SESSION['page'] = "menu";

  if(!isset($_SESSION['card']))
    die('User is not authenticated.');
?>

<p>Hello, <strong><?php echo $_SESSION['name']; ?></strong>.<br>
What would you like to do?</p>

<div class="buttons">
  <a class="button big" onclick="loadPage('resetpassword'); return false;"><img src="resetpassword.png"><br>Reset Password</a>
  <?php
    if(ENABLE_CHECK_CARD)
      echo '<a class="button big" onclick="loadPage(\'checkcard\'); return false;"><img src="/checkcard.png"><br>Check Card</a>';

    if(ENABLE_ASSOCIATE_CARD)
      echo '<a class="button big" onclick="loadPage(\'associatecard\'); return false;"><img src="/associatecard.png"><br>Associate Card</a>';
  ?>
</div>

<div class="subbuttons">
  <a class="button small" onclick="loadPage('logout'); return false;">Logout</a>
</div>
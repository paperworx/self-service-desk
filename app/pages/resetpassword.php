<?php
  require_once __DIR__ . '\..\..\config.php';

  session_start();

  $_SESSION['page'] = "resetpassword";

  if(!isset($_SESSION['card']))
    die('User is not authenticated.');

  require_once __DIR__ . '\..\..\backend\activedirectory.php';
?>

<p>You will be provided with a randomly generated password to login to your account, your previous password will become invalid.<br><br>
<strong>Do you wish to continue?</strong></p>

<div class="buttons">
  <a class="button big" onclick="loadPage('doresetpassword', true, { confirmed: true }); return false;">Yes</a>
</div>

<div class="subbuttons">
  <a class="button small" onclick="loadPage('menu'); return false;">Go Back</a>
</div>
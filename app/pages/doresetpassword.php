<?php
  require_once __DIR__ . '\..\..\config.php';

  session_start();

  $_SESSION['page'] = "doresetpassword";

  if(!isset($_SESSION['card']))
    die('User is not authenticated.');

  require_once __DIR__ . '\..\..\backend\activedirectory.php';

  if(!isset($_POST['confirmed']) || !$_POST['confirmed']) {
    header('Location: /pages/logout.php');
    return;
  }

  require_once __DIR__ . '\..\..\backend\servicelog.php';

  $activedirectory = new ActiveDirectory();

  $password = $activedirectory->generatePassword();

  $info = $activedirectory->updatePassword($_SESSION['username'], $password);
  $status = $info['status'];
?>

<style>
  #passwordinfo {
    font-size: 4rem;
    font-weight: bold;
  }
</style>

<?php
  if($status == "SUCCESS") {
    echo "<p>Your password has been reset to:<br>";
    echo "<span id=\"passwordinfo\">" . $password . "</span><br>";
    echo "Take a picture, memorize or write down the above.<br><br>";
    echo "You will be required to pick your own password again after logging in.<br><br>";
    echo "<strong>Press logout below to finish.</strong>";

    $servicelog = new ServiceLog();
    $servicelog->logEvent($_SESSION['name'] . " has reset their password.");
  } elseif($status == "DISABLED") {
    header('Location: /pages/logout.php');
    return;
  } elseif($status == "NO_CHANGE") {
    echo "<p><span style=\"color: red;\">An error has occurred, please notify your systems' administrator that the service account currently in use is likely not permitted to make changes for your user account.</span></p>";
  } else {
    echo "<p><span style=\"color: red;\">An unknown error has occurred, please notify your systems' administrator.</span></p>";
  }
?>

<div class="subbuttons">
  <a class="button small" onclick="loadPage('logout'); return false;">Logout</a>
</div>

<?php $password = ""; ?>
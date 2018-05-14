<?php
  require_once __DIR__ . '\..\..\config.php';

  session_start();

  $_SESSION['page'] = "login";

  require_once __DIR__ . '\..\..\backend\servicelog.php';

  $servicelog = new ServiceLog();

  require_once __DIR__ . '\..\..\backend\activedirectory.php';

  $error = "";

  if(isset($_POST['card']) && !empty($_POST['card'])) {
    $activedirectory = new ActiveDirectory();
    try {
      $user = $activedirectory->getUserByCard($_POST['card']);
    } catch(Exception $e) {
      $error = $e->getMessage();
    }

    if($user['status'] == "SUCCESS") {
      $_SESSION['name'] = $user['name'];
      $_SESSION['username'] = $user['username'];
      $_SESSION['card'] = $user['card'];

      $servicelog->logEvent($_SESSION['name'] . " logged in.");

      header('Location: /pages/menu.php');
      return;
    } elseif($user['status'] == "NOT_FOUND") {
      $error = "Unknown Card";
    } elseif($user['status'] == "DUPLICATES") {
      $error = "Duplicated Card";
    } elseif($user['status'] == "NO_CONNECTION") {
      $error = "Connection Failure";
    } elseif($user['status'] == "DISABLED") {
      $error = "Account Deactivated";
    } else {
      $error = "Unknown Error";
    }
  }
?>

<style>
  #scancardinfo {
    text-align: center;
    padding: 25px;
    margin: 25px;
    color: white;
    font-size: 5rem;
    background-color: <?php if($error != "") { echo "red"; } else { echo "black"; } ?>;
  }

  form,
  form input {
    opacity: 0;
    height: 0;
    width: 0;
  }
</style>

<p>Please scan your card to continue:</p>

<div id="scancardinfo">
  <?php
    if($error != "") {
      echo $error;
      echo <<<REDIRECT
      <script type="text/javascript">
        processing = true;

        var timeout = setTimeout(function() {
          processing = false;
          loadPage("login");
        }, 2500);
      </script>
REDIRECT;
    } else {
      echo 'Scan Card Now';
    }
  ?>
</div>

<form onsubmit="loadPage('login', true, { card: scancard.value }); return false;" method="post">
  <input id="scancard" type="password" autocomplete="off" autofocus>
  <input type="submit">
</form>

<div class="subbuttons">
  <a class="button small" onclick="loadPage('operatorlogin'); return false;">Operator Login</a>
</div>
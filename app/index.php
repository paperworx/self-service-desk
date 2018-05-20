<?php
  require_once __DIR__ . '\..\config.php';

  $isLocal = ($_SERVER['REMOTE_ADDR'] == $_SERVER['SERVER_ADDR']);
  $isApproved = false;

  if(!$isLocal && !empty(APPROVED_LIST)) {
    $ips = explode(";", APPROVED_LIST);

    foreach($ips as $ip) {
      if($_SERVER['REMOTE_ADDR'] == gethostbyname($ip)) {
        $isApproved = true;
        break;
      }
    }
  }

  if(!$isLocal && !$isApproved)
    die('Access has not been approved from this location, please contact your systems\' administrator for further information.');

  session_start();

  if(empty($_SESSION['page']))
    $_SESSION['page'] = "login";
?>

<!DOCTYPE html>

<html lang="en" oncontextmenu="return false">
  <head>
    <title>Self Service Desk - <?php echo COMPANY; ?></title>

    <link rel="stylesheet" type="text/css" href="stylesheet.css">
    <link rel="shortcut icon" type="image/ico" href="favicon.ico">

    <script src="jquery-3.3.1.min.js" type="text/javascript"></script>
  </head>
  <body>
    <div class="container">
      <div class="containerheader">Self Service Desk - <?php echo COMPANY; ?></div>
      <div class="containerbody">
        <div id="page">
          <noscript><strong>Javascript is required to access this system.</strong></noscript>
        </div>
      </div>
    </div>
    <script type="text/javascript">
      curpage = "<?php echo $_SESSION['page']; ?>";
    </script>
    <script src="script.js" type="text/javascript"></script>
  </body>
</html>
<?php
  require_once __DIR__ . '\..\config.php';

  session_start();

  if(empty($_SESSION['page']))
    $_SESSION['page'] = "login";

  require_once __DIR__ . '\..\backend\activedirectory.php';
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
        <div id="page"></div>
      </div>
    </div>
    <script type="text/javascript">
      curpage = "<?php echo $_SESSION['page']; ?>";
    </script>
    <script src="script.js" type="text/javascript"></script>
  </body>
</html>
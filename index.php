<?php
  session_start();

if (isset($_SESSION["logged"]) && $_SESSION["logged"]["session_id"] == session_id() && session_status() == 2) {
	header("location: ./logged.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Collegium Da Vinci Dziennik</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<body class="hold-transition login-page">
<div class="login-box">

	<?php
	if (isset($_SESSION["success"])){
		echo <<< ERROR
        <div class="callout callout-success">
           <h5>Gratulacje!</h5>
           <p>$_SESSION[success]</p>
        </div>
ERROR;

		unset($_SESSION["success"]);
	}

	if (isset($_SESSION["error_message"])){
		echo <<< ERROR
        <div class="callout callout-danger">
           <h5>Błąd!</h5>
           <p>$_SESSION[error_message]</p>
        </div>
ERROR;

		unset($_SESSION["error_message"]);
	}
	?>

  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="./" class="h1"><b>CDV</b> Dziennik</a>
    </div>
    <div class="card-body">
      <p class="login-box-msg">Zaloguj się aby rozpocząć sesję</p>
      <form action="scripts/login.php" method="post">
        <div class="input-group mb-3">
          <input type="email" class="form-control" placeholder="Podaj email" name="email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Podaj hasło" name="pass">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="remember">
              <label for="remember">
                Zapamiętaj mnie
              </label>
            </div>
          </div>
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
          </div>
        </div>
      </form>

      <p class="mb-1">
        <a href="forgot-password.php">Zapomniałem/am hasła</a>
      </p>
    </div>
  </div>
</div>
<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="dist/js/adminlte.min.js"></script>
</body>
</html>

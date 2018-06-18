<?php
	session_start();
	require_once("SimpleCSRFGuard.class.php");
	$csrfGuard = new SimpleCSRFGuard();
	$message = "Please enter your name in the field above.";
	if (isset($_POST["_csrf_token"])) {
		$message = $csrfGuard->validateToken($_POST["_csrf_token"]) ? "The CSRF token is valid." : "The CSRF token is invalid.";
	}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
	<head>
		<meta charset="utf-8">
		<title>CSRF implementation example</title>
	</head>
	<body>
		<h1>CSRF implementation example</h1>
		<form class="" action="" method="post">
			<input type="text" name="name" value="">
			<input type="hidden" name="_csrf_token" value="<?php echo $csrfGuard->generateToken(); ?>">
			<button type="submit" name="button">GO</button>
		</form>
		<div class="">
			<?php echo $message; ?>
		</div>
	</body>
</html>

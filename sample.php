<?php
// here we store the result from reCAPTCHA
$recaptcha = false;

// if the form is sent
if(isset($_POST)) {
	require_once 'recaptcha.php';

	// create new recaptcha object and set a secret
	$captcha = new reCaptcha();
	$captcha->setSecret('your-secret-key');

	// the site-verification itself
	$recaptcha = $captcha->verify();
}
?>
<!DOCTYPE>
<html>
<head>
	<script src='https://www.google.com/recaptcha/api.js' async defer></script>
</head>
<body>
<?php
	if($recaptcha) {
		echo "You're in";
	} else {
		echo <<< END
<form method="POST">
	<input type="text" name="name">
	<div class="g-recaptcha" data-sitekey="your-public-site-key"></div>
	<input type="submit">
</form>
END;
	}
?>
</body>
</html>

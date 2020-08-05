<html>
<head>
	<meta charset="utf-8">
	<title>Camagru</title>
	<!-- Р’СЃС‚Р°РІРёС‚СЊ РёРєРѕРЅРєСѓ
	<link rel="shortcut icon" type="image/png" href="favicon.ico"/> -->
	<!-- Add Bootstrap CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<script src="/public/js/register.js"></script>
</head>
<h1 class="display-4"> Change password </h1>
<form name="newpassword" method="post" action="" >
	Password:<br>
	<svg class="bi bi-lock" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
		<path fill-rule="evenodd" d="M11.5 8h-7a1 1 0 00-1 1v5a1 1 0 001 1h7a1 1 0 001-1V9a1 1 0 00-1-1zm-7-1a2 2 0 00-2 2v5a2 2 0 002 2h7a2 2 0 002-2V9a2 2 0 00-2-2h-7zm0-3a3.5 3.5 0 117 0v3h-1V4a2.5 2.5 0 00-5 0v3h-1V4z" clip-rule="evenodd"/>
	</svg>
	<input type="password" name="password" min="4" placeholder=" At least 4 characters" required><br>
	Re-enter password:<br>
	<svg class="bi bi-lock-fill" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
		<rect width="11" height="9" x="2.5" y="7" rx="2"/>
		<path fill-rule="evenodd" d="M4.5 4a3.5 3.5 0 117 0v3h-1V4a2.5 2.5 0 00-5 0v3h-1V4z" clip-rule="evenodd"/>
	</svg>
	<input type="password" name="password2"  required><br>
	<br><input class="btn btn-primary" type="submit" name="submit" value="SignUp"><br>
</form>

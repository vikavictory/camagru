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
<body>
	<h1 class="display-4">Account</h1>
	<p> Online <?php echo($_SESSION['user']);?> </p>
    <p> This page of <?php echo $_SESSION['page']['login'] ?></p>
    <p> Name: <?php echo $_SESSION['page']['name'] ?></p>
    <p> Surname: <?php echo $_SESSION['page']['surname'] ?></p>
    <p> Email: <?php echo $_SESSION['page']['email'] ?></p>
	<a href="/logout">Logout</a>
</body>
</html>

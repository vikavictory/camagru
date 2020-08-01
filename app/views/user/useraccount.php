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
    <?php if ($user['activated'] === "1")
    {
        echo "<p> This page of " . $user['login'] . "</p>";
        echo "<p> Name " . $user['name'] . "</p>";
        echo "<p> Surame " . $user['surname'] . "</p>";
        echo "<p> Email: " . $user['email'] . "</p>";
    }
	else
	    echo "<p> Доступ запрещен, пользователь не активирован </p>"; ?>
	<a href="/logout">Logout</a>
</body>
</html>

<html>
<?php require_once "app/views/header.php" ?>
<body>
<?php require_once "app/views/navbar.php" ?>
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

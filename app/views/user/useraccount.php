<html>
<?php require_once "app/views/header.php" ?>
<body>
<?php require_once "app/views/navbar.php" ?>
	<h1 class="display-4">Account</h1>
	<p> Online <?php echo($_SESSION['user']);?> </p>
    <?php if ($user['activated'] === "1")
    {
		if ($user['photo'] === NULL) {
			echo "<img src=\"/public/img/user.png\" alt=\"Фото пользователя\" width=150px>";
		} else {
			echo "<img src=\"" . $user['photo'] . "\" alt=\"Фото пользователя\" width=150px>";
		}
        echo "<p> This page of " . $user['login'] . "</p>";
        echo "<p> Name " . $user['name'] . "</p>";
        echo "<p> Surame " . $user['surname'] . "</p>";
        echo "<p> Email: " . $user['email'] . "</p>";
        if (isset($user['photos'])) {
            echo "<div id=\"gallery\">";
			foreach ($user['photos'] as $value) {
				echo "<p><a href=\"\photo\\" . $value['id'] . "\">
                        <img src=\"" . $value['photo'] . "\" alt=\"Фото пользователя\" width=150px>
                      </a></p>";
			}
			echo "</div>";
        }
    } else {
        echo "<p> Доступ запрещен, пользователь не активирован </p>";
    } ?>
</body>
</html>

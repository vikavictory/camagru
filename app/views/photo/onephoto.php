<html>
<?php require_once "app/views/header.php" ?>
<body>
<?php require_once "app/views/navbar.php" ?>

<?php if ($photo) {
	echo "<p> User " . "<a href=\"\user\\" . $photo['login'] . "\">" . $photo['login'] . "</a></p>";
	echo "<p> Description " . $photo['description'] . "</p>";
	echo "<p> Created at  " . $photo['created_at'] . "</p>";
	echo "<img src=\"" . $photo['photo'] . "\" alt=\"Фото пользователя\" width=300px>";
} ?>

</body>
</html>
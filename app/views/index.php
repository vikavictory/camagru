<html>
<?php require_once "app/views/header.php" ?>
<body>
<?php require_once "app/views/navbar.php" ?>
<h1 class="display-4"> Main </h1>
<div id="gallery">
	<?php foreach ($result as $value) {

	    echo "<img src=\"" . $value['photo'] . "\" alt=\"Фото пользователя\" width=150px>";

	} ?>
</div>
</body>
</html>



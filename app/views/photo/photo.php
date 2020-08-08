<html>
<?php require_once "app/views/header.php" ?>
<body>
<?php require_once "app/views/navbar.php" ?>


<video id="video" width="640" height="480" autoplay></video>
<button id="snap">Сделать снимок</button>
<canvas id="canvas" width="640" height="480"></canvas>


<form action="" method="post" enctype="multipart/form-data">
	<input type="file" name="image">
	<button type="submit">Загрузить</button>
</form>
</body>
</html>
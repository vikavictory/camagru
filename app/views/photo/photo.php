<html>
<?php require_once "app/views/header.php" ?>
<body>
<?php require_once "app/views/navbar.php" ?>
<link rel="stylesheet" type="text/css" href="/public/css/camera.css">

<div class="item">
    <span> video </span>
    <video id="video" width="320" height="240" autoplay="autoplay" ></video>
</div>

<div class="item">
    <span> canvas </span>
    <canvas id="canvas" width="320" height="240" ></canvas>
</div>

<input id="button" type="button" value="Snap" />

<script src="/public/js/camera.js"></script>

<form action="" method="post" enctype="multipart/form-data">
	<input type="file" name="image">
	<button type="submit">Загрузить</button>
</form>
</body>
</html>
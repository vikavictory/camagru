<html>
<?php require_once "app/views/header.php" ?>
<body>
<?php require_once "app/views/navbar.php" ?>
<div class="container">
    <div class="jumbotron">

<link rel="stylesheet" type="text/css" href="/public/css/camera.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<div class="item" id="videoId">
    <span> video </span>
    <video id="video" width="320" height="240" autoplay="autoplay" ></video>
</div>

<div class="item">
    <span> canvas </span>
    <canvas id="canvas" width="320" height="240" ></canvas>
</div>

<input id="button" type="button" value="Snap" />
<input id="saveButton" type="button" value="Save" />

<form action="" method="post" enctype="multipart/form-data">
	<input type="file" name="image">
	<input type="submit" name="submit" value="Download">
</form>
<?php require_once "app/views/photo/masks.php" ?>
    </div>
</div>
<script src="/public/js/camera.js"></script>
<?php require_once "app/views/footer.php" ?>
</body>
</html>
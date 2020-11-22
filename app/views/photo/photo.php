<html>
<?php require_once "app/views/header.php" ?>
<body>
<?php require_once "app/views/navbar.php" ?>
<div class="container">
    <div class="jumbotron">
        <link rel="stylesheet" type="text/css" href="/public/css/camera.css">
        <div id="videoBlock">
            <video id="video" width="448px" height="336px" autoplay="autoplay" ></video>
            <img id="image" height="336px" width="448px" style="display: none;"/>
            <div id="canvasVideo"></div>
            <canvas id="help" width="448px" height="336px"></canvas>
            <br><br><br><br>
            <input id="button" type="button" value="Сделать снимок" />
            <input id="increaseButton" type="button" value=" + " />
            <input id="decreaseButton" type="button" value=" - " />
            <input type='file' accept="image/*" onchange="uploadPic(this);" />
        </div>
        <div id="previewBlock">
            <canvas id="canvas" width="448px" height="336px"></canvas>
            <canvas id="canvasMasks" width="448px" height="336px"></canvas>
            <canvas id="help" width="448px" height="336px"></canvas>
            <br><br>
            <form name="description">
                <textarea id="comment" cols="40" rows="1.75" placeholder="Введите подпись..." ></textarea><br>
            </form>
            <input id="saveButton" type="button" value="Сохранить" />
            <input id="cleanButton" type="button" value="Отчистить" />
        </div>
        <br>
        <?php require_once "app/views/photo/masks.php" ?>
        <?php require_once "app/views/photo/randomphotos.php" ?>
    </div>
</div>
<script src="/public/js/camera.js"></script>
<?php require_once "app/views/footer.php" ?>
</body>
</html>
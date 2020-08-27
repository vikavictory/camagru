<html>
<?php require_once "app/views/header.php" ?>
<body>
<?php require_once "app/views/navbar.php" ?>

<?php if ($photo) { ?>
	<p> User  <a href="\user\"<?php echo $photo['login'];?>><?php echo $photo['login'];?></a></p>
    <p> Description <?php echo $photo['description'];?> </p>
    <p> Created at  <?php echo $photo['created_at'];?> </p>
    <img src="<?php echo $photo['photo'];?>" alt="Фото пользователя" width=300px>
    <form name="registration" method="post" action="">
        <input type="hidden" name="photo_id" value="<?php echo $photo['id'];?>"/>
        <input type="hidden" name="user_id" value="<?php echo $photo['user_id'];?>"/>
        <input type="submit" name="delete" value="Delete"/>
    </form>
    <br>
    <body onload="getComments();">
    <p> Комментарии </p>
    <script>
        function getComments(count = 0) {
            alert("here");
    }
    </script>

    </body>


    <br>
    <form name="newcomment" method="post">
        <input type="hidden" id="photo_id" value="<?php echo $photo['id'];?>"/>
        <input type="hidden" id="user_id" value="<?php echo $_SESSION['user_id'];?>"/>
        <span>Комментарий</span><br>
        <textarea id="comment" cols="30" rows="10"></textarea><br>
        <button id="commentButton">Отправить</button>
    </form>
    <script src="/public/js/newcomment.js"></script>
<?php } ?>

</body>
</html>
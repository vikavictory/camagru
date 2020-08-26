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
    <textarea id="comment" cols="40" rows="3"></textarea>
    <input id="newComment" type="button" value="Send" />
<?php } ?>

</body>
</html>
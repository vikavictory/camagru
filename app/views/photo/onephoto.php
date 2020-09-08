<html>
<?php require_once "app/views/header.php" ?>
<body>
<?php require_once "app/views/navbar.php" ?>

<?php if ($photo) { ?>
	<p> User  <a href="\user\<?php echo $photo['login'];?>"><?php echo $photo['login'];?></a></p>
    <p> Description <?php echo $photo['description'];?> </p>
    <p> Created at  <?php echo $photo['created_at'];?> </p>
    <img src="<?php echo $photo['photo'];?>" alt="Фото пользователя" width=300px>
    <br>
    <br>
    <script src="/public/js/getlikes.js"></script>
    <div class="likes">
        <button id="likeButton">
            <svg id="like" width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-heart-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314z"/>
            </svg>
            <span id="likesCount"></span>
        </button>
    </div>
    <br>
    <br>
    <?php if ($_SESSION["user_id"] === $photo['user_id']) { ?>
        <form name="delete" method="post" action="">
            <input type="hidden" name="photo_id" value="<?php echo $photo['id'];?>"/>
            <input type="hidden" name="user_id" value="<?php echo $photo['user_id'];?>"/>
            <input type="submit" name="delete" value="Delete"/>
        </form>
    <?php } ?>
    <br>
    <script src="/public/js/getcomments.js"></script>
    <div class="here">
    </div>
    <br>
    <?php if (isset($_SESSION["user"]) && isset($_SESSION["user_id"]) &&
		$_SESSION["user"] !== "" && $_SESSION["user_id"] !== "") { ?>
        <form name="newcomment" method="post">
            <input type="hidden" id="photo_id" value="<?php echo $photo['id'];?>"/>
            <input type="hidden" id="user_id" value="<?php echo $_SESSION['user_id'];?>"/>
            <span>Комментарий</span><br>
            <textarea id="comment" cols="30" rows="10"></textarea><br>
            <button id="commentButton">Отправить</button>
        </form>
        <script src="/public/js/newcomment.js"></script>
    <?php } } ?>
</body>
</html>
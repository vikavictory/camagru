<html>
<?php require_once "app/views/header.php" ?>
<body>
<?php require_once "app/views/navbar.php" ?>
    <?php if ($user['activated'] === "1")
    { ?>
        <div class="container">
            <div class="jumbotron">
				<?php if ($user['photo'] === NULL) { ?>
                    <img src="/public/img/user.png" alt="Фото пользователя" width=150px>
				<?php } else { ?>
                    <img src="<?php echo $user['photo'];?>" alt="Фото пользователя" width=150px>
				<?php } ?>
                <p>This page of <?php echo $user['login'];?>.</p>
                <p> Name: <?php echo $user['name'];?>.</p>
                <p> Surame: <?php echo $user['surname'];?>.</p>
                <p> Email: <?php echo $user['email'];?>.</p>
            </div>
        </div>

		<?php if (isset($user['photodata'])) { ?>
            <div id="gallery">
                <?php if (isset($user['photodata']['photos'])) {
					$index = 0;
                    foreach ($user['photodata']['photos'] as $value) {
                        if ($index === 0 || $index === 3) { ?>
                            <p>
                        <?php } ?>
                        <a href="\photo\<?php echo $value['id'];?>">
                                <img src="<?php echo $value['photo'];?>" alt="Фото пользователя" height=300px>
                        </a>
                        <?php if ($index === 2 || $index === count($user['photodata']['photos']) - 1) { ?>
                            </p>
					<?php }
					    $index += 1;
                    }
				} ?>
			</div>
        <nav aria-label="Page navigation example">
            <ul class="pagination">
				<?php
				if ($user['photodata']['pageCount'] > 1 && $user['photodata']['pageNumber'] > 1) { ?>
					<li class="page-item"><a class="page-link" href="/user/<?php echo $user['login'];?>?page=1">The first</a></li>
				<?php }
				if ($user['photodata']['pageCount'] > 1 && $user['photodata']['pageNumber'] > 1) {
					$previous =  $user['photodata']['pageNumber'] - 1; ?>
					<li class="page-item"><a class="page-link" href="/user/<?php echo $user['login'];?>?page=<?php echo $previous;?>">Previous</a></li>
				<?php }
				if ($user['photodata']['pageCount'] > 1 && $user['photodata']['pageNumber'] < $user['photodata']['pageCount']) {
					$next =  $user['photodata']['pageNumber'] + 1; ?>
					<li class="page-item"><a class="page-link" href="/user/<?php echo $user['login'];?>?page=<?php echo $next;?>">Next</a></li>
				<?php }
				if ($user['photodata']['pageCount'] > 1 && $user['photodata']['pageNumber'] !== $user['photodata']['pageCount']) { ?>
					<li class="page-item"><a class="page-link" href="/user/<?php echo $user['login'];?>?page=<?php echo $user['photodata']['pageCount'];?>">The last</a></li>
				<?php } ?>
            </ul>
        </nav>
		<?php }
    } else { ?>
        <p> Доступ запрещен, пользователь не активирован </p>
    <?php } ?>
</body>
<?php require_once "app/views/footer.php" ?>
</html>

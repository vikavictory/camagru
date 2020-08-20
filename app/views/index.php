<html>
<?php require_once "app/views/header.php" ?>
<body>
<?php require_once "app/views/navbar.php" ?>
<h1 class="display-4"> Main </h1>

<div id="gallery">
	<?php foreach ($result as $value) {

	    echo "<p><a href=\"\photo\\" . $value['id'] . "\">
                <img src=\"" . $value['photo'] . "\" alt=\"Фото пользователя\" width=150px>
             </a></p>";

	} ?>
</div>

<nav aria-label="Page navigation example">
    <ul class="pagination">
        <?php
        //если текущая страница больше трех, то показывать previous
        //если текущая страница меньше на три чем общее кол-во страниц, то показывать next
        //
        ?>
        <li class="page-item"><a class="page-link" href="">Previous</a></li>
        <li class="page-item"><a class="page-link" href="/?page=1">1</a></li>
        <li class="page-item"><a class="page-link" href="/?page=2">2</a></li>
        <li class="page-item"><a class="page-link" href="/?page=3">3</a></li>
        <li class="page-item"><a class="page-link" href="">Next</a></li>
    </ul>
</nav>

</body>
</html>



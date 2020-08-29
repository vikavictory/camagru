<html>
<?php require_once "app/views/header.php" ?>
<body>
<?php require_once "app/views/navbar.php" ?>
<h1 class="display-4"> Main </h1>

<div id="gallery">
	<?php if (isset($result["error"])) {
	        echo $result["error"];
	    } else {
	        foreach ($result['photos'] as $value) {
	            echo "<p><a href=\"\photo\\" . $value['id'] . "\">
	            <img src=\"" . $value['photo'] . "\" alt=\"Фото пользователя\" width=150px>
	            </a></p>";
		}
	} ?>
</div>

<nav aria-label="Page navigation example">
    <ul class="pagination">
        <?php
		if ($result['pageCount'] > 1 && $result['pageNumber'] > 1) {
			$previous =  $result['pageNumber'] - 1;
			echo "<li class=\"page-item\"><a class=\"page-link\" href=\"/?page=1\">The first</a></li>";
		}
        if ($result['pageCount'] > 1 && $result['pageNumber'] > 1) {
            $previous =  $result['pageNumber'] - 1;
            echo "<li class=\"page-item\"><a class=\"page-link\" href=\"/?page=" .
                $previous . "\">Previous</a></li>";
        }
		if ($result['pageCount'] > 1 && $result['pageNumber'] < $result['pageCount']) {
			$next =  $result['pageNumber'] + 1;
			echo "<li class=\"page-item\"><a class=\"page-link\" href=\"/?page=" .
				$next . "\">Next</a></li>";
		}
		if ($result['pageCount'] > 1 && $result['pageNumber'] !== $result['pageCount']) {
			echo "<li class=\"page-item\"><a class=\"page-link\" href=\"/?page=" .
				$result['pageCount'] . "\">The last</a></li>";
		}
        ?>
    </ul>
</nav>

</body>
</html>



<html>
<?php require_once "app/views/header.php" ?>
<body>
<?php require_once "app/views/navbar.php" ?>
<div class="container">
    <h1 class="display-4"> Gallery </h1>

<!--<div id="gallery">-->
<!--	--><?php //if (isset($result["error"])) {
//	        echo $result["error"];
//	    } else {
//	        $index = 0;
//	        foreach ($result['photos'] as $value) {
//	            if ($index === 0 || $index === 3) {
//	                echo "<p>";
//                }
//	            echo "<a href=\"\photo\\" . $value['id'] . "\">
//	            <img src=\"" . $value['photo'] . "\" alt=\"Фото пользователя\" height=300px>
//	            </a>";
//				if ($index === 2 || $index === count($result['photos']) - 1) {
//					echo "</p>";
//				}
//				$index += 1;
//		}
//	} ?>
<!--</div>-->

<!--<div id="gallery">-->
<!--	--><?php //if (isset($result["error"])) {
//		echo $result["error"];
//	} else {
//		$index = 0;
//		foreach ($result['photos'] as $value) {
//			if ($index === 0 || $index === 3) {
//				echo "<p>";
//			}
//			echo "<a href=\"\photo\\" . $value['id'] . "\">
//	            <img src=\"" . $value['photo'] . "\" alt=\"Фото пользователя\" height=300px>
//	            </a>";
//			if ($index === 2 || $index === count($result['photos']) - 1) {
//				echo "</p>";
//			}
//			$index += 1;
//		}
//	} ?>
<!--</div>-->
<?php if (isset($result["error"])) {
		echo $result["error"];
	} else { ?>

    <div class="row">
        <div class="col-lg-9">
            <div id="carouselExampleIndicators" class="carousel slide my-4">
                <div class="row">

                    <?php foreach ($result['photos'] as $value) { ?>
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card w-200">
                            <a href="\photo\<?php echo $value['id'];?>"><img class="card-img-top" src="<?php echo $value['photo'];?>" alt="" ></a>
<!--                            <div class="card-body">-->
<!--                                <h4 class="card-title">-->
<!--                                    <a href="#">Эко-Кружка</a></h4>30<p class="card-text"></h4>-->
<!--                            </div>-->
                            <div class="card-footer">
                                <small class="text-muted"><a href="\user\<?php echo $value['login'];?>"><?php echo $value['login'];?></a></small>
                            </div>
                        </div>
                    </div> <?php } ?>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.col-lg-9 -->
        </div>
        <!-- /.row -->
    </div>
</div> <?php } ?>

<nav aria-label="Page navigation example">
    <ul class="pagination">
        <?php
		if ($result['pageCount'] > 1 && $result['pageNumber'] > 1) {
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
<?php require_once "app/views/footer.php" ?>
</body>
</html>



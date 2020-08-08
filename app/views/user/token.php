<html>
<?php require_once "app/views/header.php"; ?>
<body>
<?php require_once "app/views/navbar.php" ?>
<h1 class="display-4">Token</h1>
<?php
if ($message !== "") {
	echo "<p>" . $message . "</p>";
	$message = "";
}
?>

</body>
</html>
<html>
<?php require_once "app/views/header.php" ?>
<body>
<?php require_once "app/views/navbar.php" ?>
<div class="container">
<h1 class="display-4"> Изменить пароль </h1>

<?php
if ($message !== "") {
	echo "<p>" . htmlspecialchars($message) . "</p>";
	$message = "";
}

if (isset($result['user_id'])) {
?>
    <form name="newpassword" method="post" action="" >
        Пароль:<br>
        <svg class="bi bi-lock" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" d="M11.5 8h-7a1 1 0 00-1 1v5a1 1 0 001 1h7a1 1 0 001-1V9a1 1 0 00-1-1zm-7-1a2 2 0 00-2 2v5a2 2 0 002 2h7a2 2 0 002-2V9a2 2 0 00-2-2h-7zm0-3a3.5 3.5 0 117 0v3h-1V4a2.5 2.5 0 00-5 0v3h-1V4z" clip-rule="evenodd"/>
        </svg>
        <input type="password" name="password" min="4" placeholder=" At least 4 characters" required><br>
        Повторите пароль:<br>
        <svg class="bi bi-lock-fill" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
            <rect width="11" height="9" x="2.5" y="7" rx="2"/>
            <path fill-rule="evenodd" d="M4.5 4a3.5 3.5 0 117 0v3h-1V4a2.5 2.5 0 00-5 0v3h-1V4z" clip-rule="evenodd"/>
        </svg>
        <input type="password" name="password2"  required><br>
        <br><input class="btn btn-primary" type="submit" name="submit" value="Сохранить пароль"><br>
    </form>
<?php } ?>
<?php require_once "app/views/footer.php" ?>
</div>
</body>
</html>

<html>
<?php require_once "app/views/header.php" ?>
<body>
<?php require_once "app/views/navbar.php" ?>
<script src="/public/js/show_notification.js"></script>
<div class="container">
    <h1 class="display-4"> Settings </h1>
    <div class="container">
        <div class="jumbotron" id="notification">
            <button id="notificationButton" class="btn btn-outline-secondary"></button>
        </div>
    </div>
    <?php require_once "app/views/photo/masks.php" ?>
</div>
</body>
<?php require_once "app/views/footer.php" ?>
</html>

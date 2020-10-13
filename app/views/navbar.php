<!-- Add navigation bar -->
<nav class="navbar navbar-expand-lg navbar-light" id="navcont">
	<!-- Brand -->
	<a class="navbar-brand" href="/">
		<!--  <img src="public/img/brand.png" width="100" height="100" class="d-inline-block align-top" alt="">-->
		Camagru
	</a>

	<!-- Navbar toggler -->
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>

	<!-- Collapsable area -->
	<div class="collapse navbar-collapse" id="navbarNav">
		<ul class="navbar-nav">
			<?php if (isset($_SESSION['user']) && $_SESSION['user'] !== "") { ?>
                <li class="nav-item">
                    <a class="nav-link" href="/photo">Camera</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/logout">Logout</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/user/<?php echo $_SESSION['user'];?>">My page</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/settings">Settings</a>
                </li>
			<?php } else {?>
			    <li class="nav-item">
				    <a class="nav-link" href="/registration">Registration</a>
			    </li>
			    <li class="nav-item">
				    <a class="nav-link" href="/login">Login</a>
			    </li>
                <li class="nav-item">
				    <a class="nav-link" href="/recovery">Reset password</a>
			    </li>
			<?php } ?>

		</ul>
	</div>
</nav>
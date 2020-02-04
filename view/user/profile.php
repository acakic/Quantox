		<div class="container">
			<h1>Your Profile page</h1>
			<a href="/pages/edit?id=<?php echo $_SESSION['user']['id_user']; ?>">Edit your Profile</a><br>
			<a href="/pages/edit?delete=<?php echo $_SESSION['user']['id_user']; ?>">Delete your Profile</a>
		</div>
		<div class="container">
			<!-- error msg displaying -->
			<?php if(isset($_GET['error'])) :?>
				<div class="error">
					<img src="../../pictures/shield-err.png" alt="shield error">
					<p><?php echo $_GET['error'];?></p>
				</div>
			<?php endif; ?>
			<!-- success msg displaying -->
			<?php if(isset($_GET['success'])) :?>
				<div class="success">
					<img src="../../pictures/checked.png" alt="checked success">
					<p><?php echo $_GET['success'];?></p>
				</div>
			<?php endif; ?>
			<div class="formContainer">
				<img class="avatar" src="../../pictures/avatar.png">
				<h1>Login form</h1>
				<div class="loginContainer">
					<form action="/pages/loginUser" method="post">
						<label for="email">Email:</label>
						<input type="email" name="email" placeholder="Enter Email">
						<label for="password">Password:</label>
						<input type="password" name="password" placeholder="Enter Password">
						<input type="submit" name="submit" value="Login">
					</form>
				</div>
			</div>
		</div>


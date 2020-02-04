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
			<?php //if (isset($_SESSION['user'])): ?>
			<div class="details">
				<h2>Current User data</h2>
				<?php foreach (View::$data['one_user'] as $user): ?>
					<hr>
					<p>Id:  <b><?php 		echo $user['id_user']; ?></p></b>
					<p>First Name:  <b><?php 	echo ucfirst($user['name']); ?></p></b>
					<p>Email:  <b><?php 		echo $user['email']; ?></p></b>
					<p>Role:  <b><?php 			echo ucfirst($user['description']); ?></p></b>
					<p>Subrole:  <b><?php 			echo ucfirst($user['sdescription']); ?></p></b>
					<p>Frame:  <b><?php 			echo ucfirst($user['ssdescription']); ?></p></b>
				<?php endforeach; ?>
			</div> <!-- end details -->
		</div> <!-- end container -->
		<div class="formContainer">
				<img class="avatar" src="../../pictures/avatar.png">
				<h1>Updating User</h1>
				<form action="/pages/update" method="post">
					<input type="hidden" name="id_user" value="<?php echo $_SESSION['user']['id_user']; ?>">

					<label for="name">Name</label>
					<input type="text" name="name" placeholder="Change Name" value="">	
											
					<label for="email">E-mail</label>
					<input type="email" name="email" placeholder="Change email" value="">
					
					<label for="password">Password</label>
					<input type="password" name="password" placeholder="Change Password">

					<label for="role_id">Type</label>
            					<select name="role_id" class="role">
				                    <option value="" disabled selected hidden>Select</option>
				                    <option value="2">BackEnd Developer</option>
				                    <option value="3">FrontEnd Developer</option>
				                </select>
				    <label for="subrole_id">Subrole</label>
            					<select name="subrole_id" class="subrole">
				                    <option value="" disabled selected hidden>Select</option>
				                </select>
				    <label for="sub_subrole_id">Frame</label>
            					<select name="sub_subrole_id" class="subsubrole">
				                    <option value="" disabled selected hidden>Select</option>
				                </select>
					<input type="submit" name="edit_user" value="Send">
				</form>
			</div> <!-- end formContainer -->

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
				<h1>Registrate User</h1>
				<form action="/pages/registration" method="post">

					<label for="name">Name</label>
					<input type="text" name="name" placeholder="Enter Name" value="">	
								
					<label for="email">E-mail</label>
					<input type="email" name="email" placeholder="johndoe@xmpl.com" value="">
		
					<label for="password">Password</label>
					<input type="password" name="password" placeholder="Enter Password">

					<label for="re_password">Re-Type Password</label>
					<input type="password" name="re_password" placeholder="Enter Password">

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

					<input type="submit" name="registrate" value="Registrate">
				</form>
			</div>	<!-- formContainer end -->
		</div> <!-- container end  -->

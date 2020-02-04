			<div class="container">
				<div class="containerMiddle">
					<aside>
						<h1>Filters</h1>
						<form class="listForm" name="sortProducts" action="/pages/filterUser" method="post">
							<input type="checkbox" name="role[]" value="3">Front End Developer<br>
							<input type="checkbox" name="role[]" value="2">Back End Developer<br>
							<?php foreach ($_SESSION['subroles'] as $subrole) : ?>
							<input type="checkbox" name="subrole[]" value="<?php echo $subrole['id_subroles'] ?>"><?php echo $subrole['sdescription'] ?><br>
							<?php endforeach; ?>
							<?php foreach ($_SESSION['ssubroles'] as $subsubrole) : ?>
							<input type="checkbox" name="subsubrole[]" value="<?php echo $subsubrole['id_sub_subroles'] ?>"><?php echo $subsubrole['ssdescription'] ?><br>
							<?php endforeach; ?>
							<input class="listFormtBtn" type="submit" name="filter">
						</form>
					</aside>
					<main>
						<?php if(isset($_SESSION['searchedUser'])): ?>
							<h1>Users</h1>
							<?php foreach ($_SESSION['searchedUser'] as $user) : ?>
							<div class="cardContainer">
								<h4><?php echo ucfirst($user['name']); ?></h4>
								<p><?php echo $user['email']; ?></p>
								<p><?php echo ucfirst($user['description']); ?></p>
								<p><?php echo ucfirst($user['sdescription']); ?></p>
								<p><?php echo ucfirst($user['ssdescription']); ?></p>
							</div>
					    	<?php endforeach; ?>
				    	<?php else: ?>
				    		<h4><?php echo 'User not found!'; ?></h4>
				    	<?php endif; ?>

					</main>
				</div>
			</div>

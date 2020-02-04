<!DOCTYPE html>
<html>
	<head>
		<title>Quantox</title>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="../assets/css/main.css">
	</head>
	<body>
		<div class="navigation">
			<nav>
				<ul>
					<li><a href="/pages/home">Home</a></li>
					<li><a href="/pages/resultscreen">Result screen</a></li>
					<?php if (isset($_SESSION['user'])): ?>
						<li><a href="/user/profile"><?php echo $_SESSION['user']['name']; ?></a></li>
						<li><a href="/$_SESSION['user']/logout">Logout</a></li>			
					<?php else: ?>
						<li><a href="/user/login">Login</a></li>
					<li><a href="/user/register">Registrate</a></li>
					<?php endif; ?>
					<li class="last">
						<div class="search">
							<form action="/pages/resultscreen" method="post" name="search-form">
								<input type="text" name="searched_text" placeholder="Search">
            					<select name="role_name">
				                    <option value="" disabled selected hidden>Select type</option>
				                    <option value="2">BackEnd Developer</option>
				                    <option value="3">FrontEnd Developer</option>
				                </select>
				                <input type="submit" name="search" value="Search">
							</form>
						</div>		
					</li>
				</ul>
			</nav>
			<h1><?php if(isset($_SESSION['user'])){
					echo 'Welcome  ' . $_SESSION['user']['name'] ; }?></h1>
		</div>

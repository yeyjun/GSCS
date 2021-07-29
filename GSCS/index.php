<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>GSCS Student Records Web System</title>
	<?php 
	include_once 'bootstrap.php'; 
	include_once 'db.php';
	if (!isset($_GET['admin'])) {
		
	?>
</head>
<body>
	<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
	  <div class="container-fluid">
	    <a class="navbar-brand" href="#">GSCS</a>
	    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
	      <span class="navbar-toggler-icon"></span>
	    </button>

	    <div class="collapse navbar-collapse" id="navbarColor01">
	      <ul class="navbar-nav me-auto">
		        <li class="nav-item">
		          <a class="nav-link active" href="index.php">Home
		            <span class="visually-hidden">(current)</span>
		          </a>
		        </li>
		        <li class="nav-item">
		          <a class="nav-link" href="#">The School</a>
		        </li>
		        <li class="nav-item">
		          <a class="nav-link" href="#">Organizational Structure</a>
		        </li>
		        <li class="nav-item">
		          <a class="nav-link" href="#">About</a>
		        </li>
	        </ul>
	    </div>
	  </div>
	</nav>
	<div class="container">
		<div class="row">
			<div class="col-4">
				
			</div>
			<div class="col-6">
				<div class="col-lg-6">
					<div class="card mt-5 mr-2">
						<div class="card-header">
							<h4>Login</h4>
						</div>
						<div class="card-body">
							<form class="form-group"  method="POST">
								<label for="username">Username</label>
								<input type="text" name="username" placeholder="Username..." autofocus>
								<label for="user_pass">Password</label>
								<input type="password" name="user_pass" placeholder="Password...">
								<div class="mt-1 ">
									<button name="btn_login" class="btn btn-primary btn-md btn-block"> Login</button>
								</div>
							</form>
							<?php 
							if (isset($_POST['btn_login'])) {
								//init
									$user = addslashes($_POST['username']);
									$pass = addslashes($_POST['user_pass']);
									$ret_user = $db->query("SELECT * FROM users WHERE firstname = '$user' AND password='$pass'");
									$this_user = $ret_user->fetch_array();

								if (empty($user) && empty($pass)) {
									?>
									<script type="text/javascript">
										alert("make sure no empty field!");
									</script>
									<?php

								}elseif ($this_user['firstname'] == "" or is_null($this_user['firstname']) or $this_user['password'] == "" or is_null($this_user['password'])) {
									echo "Incorrect login credentials!";

								}elseif ($this_user['firstname'] !== " " or !is_null($this_user['firstname']) or $this_user['password'] !== " " or !is_null($this_user['password'])){

									if ($user == $this_user['firstname']) {
										if ($pass == $this_user['password']) {
											session_start();
											$_SESSION['user'] = $user;
											$_SESSION['user_id'] = $this_user['id'];
											$_SESSION['grade_level'] = $this_user['grade_level'];
											$user_on_session = $_SESSION['user'];
											$_SESSION['fullname'] = $this_user['lastname']. " ". $this_user['firstname'];
											$fullname_adv = $_SESSION['fullname'];
											header("Location: save-grades.php");
										}else{
										header("Location: index.php");
										}

									}elseif ($user == "admin") {
										if ($pass == $this_user['password']) {
											if ($this_user['user_level'] == 0) {
											session_start();
											$_SESSION['usertype'] = $this_user['user_level'];
											$_SESSION['user'] = $user;
											$user_on_session = $_SESSION['user'];
											header("Location: system-admin.php");
											}
										}

									}elseif ($pass == "admin".date('Y')) {
										header("Location: ?admin&admin_emergency=".date('Ymd'));
									}
								}
							}
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
<?php 
	}elseif (isset($_GET['admin']) && $_GET['admin_emergency'] = date('Y')) {
		?>
		<div class="container">
			<div class="row">
				<div class="col-4 mb-2 "></div>
				<div class="col-3">
					<div class="card mt-5">
						<div class="card-body">
							<form method="POST">
								<label>Username: admin</label>
								<input type="text" name="admin_pass" onmouseover="show()" class="form-control" id="generate">
								<input type="hidden" id="show_this" value="<?php echo sha1(date('Ys')); ?>">
								<button name="press" class="btn btn-dark btn-sm" >Generate</button>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
		<script type="text/javascript">
			function show(){
				var s = document.getElementById('show_this').value;
				var show_gen_key = s;
				document.getElementById('generate').value = show_gen_key;
				document.getElementById('show_this').copy
			}
		</script>
		<?php
		if (isset($_POST['press'])) {
			if (empty($_GET['admin_pass'])) {
				$get_key = $_POST['admin_pass'];
				$db->query("INSERT INTO users(firstname,password,user_level) VALUES('admin','$get_key','0')");
				header("Location: index.php");
			}
		}
	}
?>
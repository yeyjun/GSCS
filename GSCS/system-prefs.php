<?php 
	if (session_start() && $_SESSION['user'] == "admin") {
		include_once "db.php";
		?>
		<!DOCTYPE html>
		<html>
		<head>
			<meta charset="utf-8">
			<title>GSCS Student Records Web System</title>
			<?php 
			include_once 'bootstrap.php'; 
			include_once 'db.php';
			?>
		</head>
		<body class="">
			<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
			  <div class="container-fluid">
			    <a class="navbar-brand" href="#">GSCS</a>
			    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
			      <span class="navbar-toggler-icon"></span>
			    </button>

			    <div class="collapse navbar-collapse" id="navbarColor01">
			       <ul class="navbar-nav me-auto">
			        <li class="nav-item">
			          <a class="nav-link active" href="system-home.php">Home
			            <span class="visually-hidden">(current)</span>
			          </a>
			        </li>
			        <li class="nav-item">
			          <a class="nav-link" href="system-admin.php">Users</a>
			        </li>
			        <li class="nav-item">
			          <a class="nav-link" href="system-prefs.php">Preferences</a>
			        </li>
			        <li class="nav-item">
			          <a class="nav-link" href="#">About</a>
			        </li>
			        </ul>
				    <ul class="navbar-nav me-right">
				    	<?php 
				        if ($_SESSION['user'] = "admin") {
				        	?>
				        	<li class="nav-item">
					          <a class="nav-link" href="save-grades.php">Switch to teaching staff</a>
					        </li>
					        <li class="nav-item">
					          <a class="nav-link" href="?back-updb">Back-up DB</a>
					        </li>
				        	<?php
				        }
				        ?>
				        <li class="nav-item">
				          <a class="nav-link" href=""><?php echo $_SESSION['user']; ?></a>
				        </li>
				    	<li class="nav-item">
				          <a class="nav-link active" href="logout.php">Logout</a>
				        </li>
				    </ul>
			    </div>
			    </div>
			  </div>
			</nav>
			<div class="container ">
				<div class="row">
					<div class="col-6">
						<div class="card border-primary mt-1">
							<div class="card-header">
								<h3>Set general search preferences</h3>
							</div>
							<div class="card-body">
								<div class="">
									<form method="POST">
										<label for="prefs">Search Preference:</label>
										<select name="prefs" class="form-control">
											<option></option>
											<option>LRN</option>
											<option>Lastname</option>
										</select>
										<div style="text-align: right;" class="mt-1">
											<button name="btn_add_user" class="btn btn-primary">Add</button>
										</div>
									</form>
								</div>
								<?php 
								if (isset($_POST['btn_add_user'])) {
									if (!empty($_POST['add_user_name'])) {
										$db->query("INSERT INTO users(firstname, password, user_level) VALUES('".$_POST['add_user_name']."','".$_POST['add_user_pass']."','2') ");
										echo "<script>alert('New user added!')</script>";
									}
								}
								?>
							</div>
						</div>
					</div>
					<div class="col-6">
							<div class="card border-primary mt-1">
								<div class="card-header">
									<h3>Set security preferences</h3>
									<p>Recommended: <strong><?php echo sha1(md5(date('his'))); ?></strong></p>
								</div>
								<div class="card-body">
									<div class="">
										<form method="POST">
											<label for="prefs">Security Mode:</label>
											<input type="text" name="add_security" class="form-control" placeholder="Add password Key..." >
											<div style="text-align: right;" class="mt-1">
												<button name="btn_add_user" class="btn btn-primary">Set</button>
											</div>
										</form>
									</div>
									<?php 
									if (isset($_POST['btn_add_user'])) {
										if (!empty($_POST['add_security'])) {
											$db->query("UPDATE systemdependencies SET description='".$_POST['add_security']."' WHERE remarks='security'");
											echo "<script>alert('System secuirty added!')</script>";
										}
									}
									?>
								</div>
							</div>
						</div>
				</div>
			</div>
		</body>
		</html>
		<?php
		if (isset($_GET['back-updb'])) {
			system("mkdir db");
			$db->query("SELECT * INTO OUTFILE '/db/gscs.sql' FROM users");
			header("Location:system-prefs.php");
		}
	}
?>
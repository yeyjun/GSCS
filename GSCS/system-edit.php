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
				<div class="col-12">
					<div class="row">
						<div class="col-6">
							<div class="card border-primary mt-1">
								<div class="card-header">
									<h3>Edit</h3>
									<a href="system-admin.php" class="text-info">View Users</a>
								</div>
								<div class="card-body">
									<div class="">
										<form method="POST">
											<?php 
											$edit = $db->query("SELECT * FROM users WHERE id='".$_GET['user']."'");
											$fetch_user2edit = $edit->fetch_array();

											if (isset($_POST['btn_save_edit'])) {
												$db->query("UPDATE users SET lastname = '".$_POST['edit_user_lastname']."', firstname = '".$_POST['edit_user_firstname']."', user_level='".$_POST['user_role']."', grade_level = '".$_POST['grdlvel']."', password='".$_POST['pass']."' WHERE id = '".$_GET['user']."' ");
												?>
												<p class="text-sm alert alert-info">Successfully Update!</p>
												<?php
												header("Location: system-admin.php");
											}
											 ?>
											<label for="edit_user_lastname">Last Name</label>
											<input type="text" name="edit_user_lastname" placeholder="Edit..." class="form-control" value="<?php echo $fetch_user2edit['lastname']; ?>">
											<label for="edit_user_firstname">First Name</label>
											<input type="text" name="edit_user_firstname" placeholder="Edit..." class="form-control" value="<?php echo $fetch_user2edit['firstname']; ?>">
											<label for="edit_user_role">
												User Role 
												<?php 
													if ($fetch_user2edit['user_level'] == 1) {
														echo "(current: Student)"; 
													}elseif ($fetch_user2edit['user_level'] == 2) {
														echo "(current: Student)"; 
													}elseif ($fetch_user2edit['user_level'] == 0){
														echo "(current: sys-admin)"; 
													}
												?>
											</label>
											<select name="user_role" class="form-control">
												<option value="2">Teaching Staff</option>
												<option value="1">Student</option>
												<option value="0">Administrator</option>
											</select>
											<label for="grdlvel">
												Grade
												(current: <?php echo $fetch_user2edit['grade_level']; ?>)
											</label>
											<select name="grdlvel" class="form-control">
												<option>
													<b>
														<?php echo $fetch_user2edit['grade_level']; ?>
													</b>
												</option>
												<?php 
													for ($i=1; $i <= 6; $i++) { 
														if ($i != $fetch_user2edit['grade_level'] ) {
															// code...
															echo "<option value='$i'>$i</option>";
														}
													}
												 ?>
											</select>
											<label for="pass">Password</label>
											<input type="text" name="pass" placeholder="Edit..." class="form-control" value="<?php echo $fetch_user2edit['password']; ?>">
											<div style="text-align: right;" class="mt-1">
												<a href="system-home.php" class="text-sm text-info">Cancel</a>
												<button name="btn_save_edit" class="btn btn-primary">Update</button>
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
						<div class="card border-info mt-1">
							<div class="card-header">
								<h3>Set System Background Color</h3>
							</div>
							<div class="card-body">
								<form method="POST">
									<select name="bg-pref" class="form-control">
										<option>bg-primary</option>
										<option>bg-secondary</option>
										<option>bg-info</option>
										<option>bg-dark</option>
										<option>bg-light</option>
									</select>
									<div style="text-align: right;" class="mt-1">
										<button name="btn_search_user" class="btn btn-primary">Search</button>
									</div>
								</form>
								<?php 
								if (isset($_POST['btn_search_user'])) {
									if (!empty($_POST['user'])) {
										echo "Searching for: &apos;". $_POST['user']. "&apos;";
										echo "<table class='table'>";
										echo "<th> Full Name</th>";
										echo "<th> Year Level</th>";
										echo "<th> Role</th>";
										echo "<th> Operation</th>";
										$show = $db->query("SELECT * FROM users WHERE user_level !='0' and  firstname LIKE '%".$_POST['user']."%'");
										while ($show_data = $show->fetch_array()) {
											
											if (count($show_data) != 0) {
												?>
												<tr>
												<td><?php echo $show_data['firstname']. " ". $show_data['lastname']; ?></td>
												<td><?php echo($show_data['grade_level']); ?></td>
												
												<td>
													<?php 
													if ($show_data['user_level']==1) {
														echo "Student";
													}elseif ($show_data['user_level']==2) {
														echo "Teaching Staff";
													}elseif ($show_data['user_level']==3) {
														echo "Principal";
													}
												?>
												</td>
												<td>
													<a href="" class="btn btn-sm btn-success">Info</a>
													<a href="#" name="edit" class="btn btn-sm btn-info">Edit</a>
													<a href="" class="text-danger">Delete</a>
												</td>
											</tr>
												<?php
											}else{ echo "no data!";}
										}
										echo "</table>";
									}
								}
								?>
							</div>
						</div>
						</div>
					</div>
				</div>
				<?php 
					if (isset($_GET['edit'])) {
						?>
						<div class="col-4">
							<div class="card">
								<div class="card-header">
									<h2>Hello</h2>
								</div>
							</div>
						</div>
						<?php
					}
				 ?>
			</div>
		</body>
		</html>
		<?php
	}
?>
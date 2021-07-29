<?php 
	if (session_start()) {

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
				        <li class="nav-item">
				          <a class="nav-link" href=""><?php echo $_SESSION['user']; ?></a>
				        </li>
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
				          <a class="nav-link active" href="logout.php">Logout</a>
				        </li>
				    </ul>
			    </div>
			    </div>
			  </div>
			</nav>
			<div class="container ">
				<div class="col-12">
					<div class="row mb-3">
						<div class="col-6">
							<div class="card border-primary mt-1">
								<div class="card-header">
									<h3>Add User</h3>
								</div>
								<div class="card-body">
									<div class="">
										<form method="POST">
											<label for="add_user_name">Username</label>
											<input type="text" name="add_user_name" placeholder="Username..." class="form-control">
											<label for="add_user_pass">Password</label>
											<input type="password" name="add_user_pass" placeholder="Password..." class="form-control mt-1">
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
									<h3>Add Subject</h3>
									<a href="system-subjects.php" class="text-sm text-danger">View Subjects</a>
								</div>
								<div class="card-body">
									<div class="">
										<form method="POST">
											<?php 
											if (isset($_POST['btn_add_subject'])) {
												if (!empty($_POST['add_subject'])) {
												$existing_subj = $db->query("SELECT * FROM systemdependencies WHERE remarks = 'subject' AND title='".$_POST['add_subject']."'");
												$exist = $existing_subj->fetch_array();
													if ($exist['title'] == $_POST['add_subject']) {
														?>
														<div class="alert alert-info alert-sm">
															<p>Existing Subject!</p>
														</div>
														<?php
													}elseif($exist['title'] != $_POST['add_subject']) {
														$db->query("INSERT INTO systemdependencies(title,description,remarks) VALUES('".$_POST['add_subject']."','".$_POST['add_subject']."','subject') ");
														?>
														<div class="alert alert-info alert-sm">
															<p>New Subject Created!</p>
														</div>
														<?php
														echo "<script>location.reload()</script>";
													}else{ echo "error";}
												}else{
													?>
													<div class="alert alert-info alert-sm">
														<p>make sure no field is empty!</p>
													</div>
													<?php
												}
											} 
											?>
											<label for="add_subject">Learning Area</label>
											<input type="text" name="add_subject" placeholder="Learning Area..." class="form-control">
											<div style="text-align: right;" class="mt-1">
												<button name="btn_add_subject" class="btn btn-primary">Add</button>
											</div>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="row-2">
						<div class="col-12">
							<div class="card border-info mt-1">
								<div class="card-header">
									<h3>Users</h3>
									<?php 
									$count_teachers = $db->query("SELECT COUNT(*) from users WHERE user_level = 2");
									$count = $count_teachers->fetch_array();
									
									#init student
									$count_student = $db->query("SELECT COUNT(*) from users WHERE user_level = 1");
									$count_a = $count_student->fetch_array();
									?>
									<p>Registered Teaching Staff: <?php echo $count['0'] ?> <br> Registered Users: <?php echo $count_a['0'] ?></p>
								</div>
								<div class="card-body">
									<form method="POST">
										<input type="text" name="user" placeholder="Username..." class="form-control" title="Enter last name of the user and click search or press Enter. ">
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
											$show = $db->query("SELECT * FROM users WHERE firstname LIKE '%".$_POST['user']."%' ORDER BY grade_level ASC");
											while ($show_data = $show->fetch_array()) {
												
												if ($show_data['user_level'] != "0") {
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
														}else{
															echo "Administrator";
														}
													?>
													<script type="text/javascript">
														function show_info(){
															alert(" User Fullname: <?php echo $show_data['lastname'] ?>");
														}
													</script>
													</td>
													<td>
														<a href="" onclick="show_info()" class="btn btn-sm btn-success">Info</a>
														<a href="system-edit.php?user=<?php echo $show_data['id']; ?>" name="edit" class="btn btn-sm btn-info">Edit</a>
														<a href="" class="text-danger">Delete</a>
													</td>
												</tr>
													<?php
												}else{ 
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
															}else{
																echo "Administrator";
															}
														?>
														</td>
														<td>
															<a href="system-prefs.php" class="btn btn-sm btn-warning">System Preferences</a>
															<a href="system-edit.php?user=<?php echo $show_data['id']; ?>" name="edit" class="btn btn-sm btn-info">Edit</a>
														</td>
													</tr>
													<?php
												}
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
			</div>
		</body>
		</html>
		<?php
	}
?>
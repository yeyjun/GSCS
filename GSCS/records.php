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
			          <a class="nav-link active" href="save-grades.php">Home
			            <span class="visually-hidden">(current)</span>
			          </a>
			        </li>
			        <li class="nav-item">
			          <a class="nav-link" href="records.php">Records</a>
			        </li>
			        <li class="nav-item">
			          <a class="nav-link" href="grades.php">Grades</a>
			        </li>
			        <li class="nav-item">
			          <a class="nav-link" href="#">About</a>
			        </li>
			        </ul>
				    <ul class="navbar-nav me-right">
				        <li class="nav-item">
				          <a class="nav-link" href=""><?php echo $_SESSION['user']; ?></a>
				        </li>
				    	<li class="nav-item">
				          <a class="nav-link active" href="logout.php">Logout</a>
				        </li>
				    </ul>
			    </div>
			  </div>
			</nav>
			<div class="container">
				<div class="row">
					
				</div>
				<div class="row-2">
					<div class="col-12">
						<div class="card mt-1">
							<div class="card-header">
								<h3>View Students</h3>
								<div style="text-align:right;" class="mb-2">
									<a href="add-student.php" class="btn btn-success btn-sm text-sm" >New Student</a>
								</div>
								<form method="POST">
									<label for="student_name">Enter Last Name of Student</label>
									<input type="text" name="student_name" placeholder="Enter Last Name of Student..." class="form-control">
									<div style="text-align: right;" class="mt-1">
										<button name="btn_search_student" class="btn btn-primary">Search</button>
									</div>
								</form>
							</div>
							<div class="card-body">
								<?php 
								if (isset($_POST['btn_search_student'])) {
									if (!empty($_POST['student_name'])) {
										$grade_level = $_SESSION['grade_level'];
										echo "Searching for: &apos;". $_POST['student_name']. "&apos;";
										echo "<table class='table'>";
										echo "<th> Full Name</th>";
										echo "<th> Year Level</th>";
										echo "<th> Operation</th>";
										$show = $db->query("SELECT * FROM users WHERE user_level ='1' and grade_level=$grade_level and lastname LIKE '%".$_POST['student_name']."%' ");
										while ($show_data = $show->fetch_array()) {
											
											if (count($show_data) != 0) {
												?>
												<tr>
													<td>
													<?php echo $show_data['firstname']. " ". $show_data['lastname']; ?>
															</td>
													<td><?php echo $show_data['grade_level']; ?></td>
													<td>
														<a href="?info" class="text-info">Info</a>
														<a href="" class="text-danger">Edit</a>
														<a href="export-permanent-record.php?export=<?php echo  $show_data['id']; ?>" class="btn btn-sm btn-primary">Export</a>
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
				<div class="row">
					<div class="col-4">
						
					</div>
					
				</div>
			</div>
		</body>
		</html>
		<?php
	}
?>
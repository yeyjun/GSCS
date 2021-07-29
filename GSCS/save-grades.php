<?php 
	if (session_start() and $_SESSION['user']!= "admin") {
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
			          <a class="nav-link active" href="#">Home
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
				    	<?php 
				        if ($_SESSION['user'] == "admin") {
				        	?>
				        	<li class="nav-item">
					          <a class="nav-link" href="system-admin.php">Switch to Administrator</a>
					        </li>
				        	<?php
				        }
				        ?>
				        <li class="nav-item">
				          <div class="btn btn-secondary btn-sm">
				          	<a class="nav-link" href="#"><strong><?php echo strtoupper($_SESSION['user']); ?></strong></a>
				          </div>
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
					
				</div>
				<div class="row">
					<div class="col-4">
						
					</div>
					<div class="col-6">
						<div class="col-lg-6">
							<div class="card mt-2">
								<div class="card-header">
									<h4>Enter Grade</h4>
									<?php 
									if ($_SESSION['grade_level'] == 0) {
									echo "<p class='text-danger'>Grade Level: <u><em>Need to set-up</em></u></p>";
									}else{
										echo "<p>Grade Level: <u>". $_SESSION['grade_level']."</u></p>";
									}
									 ?>
									
								</div>
								<div class="card-body">
									<form class="form-group"  method="POST">
										<?php 
										$ret_studes_on_grde_level = $db->query("SELECT * FROM users WHERE user_level = 1 AND grade_level = '". $_SESSION['grade_level']."'");

										?>
										<label for="quarter">Quarter</label>
										<select name="quarter" class="form-control mt-1 mb-1">
											<option></option>
											<?php 
												for ($i=1; $i <= 4 ; $i++) { 
													echo "<option>$i</option>";
												}
											?>
										</select>
										<label for="name_of_student">Full Name</label>
										<select name="lastname_of_gradee" class="form-control mt-1 mb-1">
											<option></option>
											<?php 
												while ($insert = $ret_studes_on_grde_level->fetch_array()) {
													$GLOBALS['firstname'] = $insert['firstname'];
													$GLOBALS['lastname'] = $insert['lastname'];
													echo "<option>" . $insert['firstname']. " ". $insert['lastname'] ."</option>";
												}
											?>
										</select>
										<input type="hidden" name="hid_finame" value="<?php echo $firstname;  ?>">
										<input type="hidden" name="hid_lasname" value="<?php echo $lastname; ?>">
										<?php 
										$ret_subjects_on_grde_level = $db->query("SELECT * FROM systemdependencies WHERE remarks = 'subject'");
										?>
										<label for="name_of_subject">Subject</label>
										<select name="subject" class="form-control mt-1 mb-1">
											<option></option>
											<?php 
												while ($subj = $ret_subjects_on_grde_level->fetch_array()) {
													echo "<option value='".$subj['title']."'>" . $subj['title']."</option>";
												}
											?>
										</select>
										<label for="grade">Grade</label>
										<input type="number" name="grade" placeholder="Grade...">
										<div class="mt-1 ">
											<button name="btn_savegrade" class="btn btn-primary btn-md btn-block"> Save</button>
											<a href="grades.php" class="btn btn-info btn-sm">View Grades</a>
										</div>
									</form>
									<?php 
									if (isset($_POST['btn_savegrade'])) {
										//init
											$firstname = $_POST['hid_finame'];
											$lastname = $_POST['hid_lasname'];
											$subj = $_POST['subject'];
											$grade = $_POST['grade'];
											$date_now = date('m d y h:i:s');
											$adv = $_SESSION['user'];
											$yrlvl = $_SESSION['grade_level'];
											$quarter = $_POST['quarter'];
											$sy = date('Y');
										if (empty($_POST['lastname_of_gradee']) || empty($_POST['subject']) || empty($_POST['grade'])) {
											?>
											<script type="text/javascript">
												alert("make sure no empty field!");
											</script>
											<?php
										}else{
											if ($quarter == 1) {
												$db->query("INSERT into grades(firstname, lastname, subject, grade, time_stamp, adviser, year_level, quarter,school_year) VALUES('".$firstname."','".$lastname."','".$subj."','".$grade."','".$date_now."','".$adv."','".$yrlvl."','".$quarter."','".$sy."')");
											?>
											<script type="text/javascript">
												alert("Data inserted!");
											</script>
											<?php
											}elseif ($quarter==2) {
												$db->query("UPDATE grades SET grade_q2='".$grade."' WHERE lastname = '$lastname' AND firstname = '$firstname'");
											?>
											<script type="text/javascript">
												alert("Data inserted!");
											</script>
											<?php
											}elseif ($quarter==3) {
												$db->query("UPDATE grades SET grade_q3='".$grade."' WHERE lastname = '$lastname' AND firstname = '$firstname'");
											?>
											<script type="text/javascript">
												alert("Data inserted!");
											</script>
											<?php
											}elseif ($quarter==4) {
												$db->query("UPDATE grades SET grade_q4='".$grade."' WHERE lastname = '$lastname' AND firstname = '$firstname'");
											?>
											<script type="text/javascript">
												alert("Data inserted!");
											</script>
											<?php
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
	}elseif ($_SESSION['usertype'] == 0) {
		header("Location: system-admin.php");
	}else{
		header("Location: index.php");
	}
?>
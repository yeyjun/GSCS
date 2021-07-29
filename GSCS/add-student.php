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
				          <a class="nav-link" href="logout.php"><?php echo $_SESSION['user']; ?></a>
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
								<h3>Add Student</h3>
								<div style="text-align:right;" class="mb-2">
									<a href="records.php" class="btn btn-success btn-sm text-sm" >View Students</a>
								</div>
							</div>
							<div class="card-body">
								<form method="POST" class="form-group">
									<div class="row">
										<div class="col-6">
											<fieldset>
												<legend>Learners Personal Information</legend>
													<label for="lastname"> Last Name <span class="text-danger">*</span></label>
													<input type="text" name="lastname" placeholder="Last Name..." class="form-control mt-1">
													<label for="firstname"> First Name <span class="text-danger">*</span></label>
													<input type="text" name="firstname" placeholder="First Name..." class="form-control mt-1">
													<label for="middlename"> Middle Name <span class="text-danger">*</span></label>
													<input type="text" name="middlename" placeholder="Middle Name..." class="form-control mt-1">
													<label for="name_extn"> Name Extension</label>
													<input type="text" name="name_extn" placeholder="Name Extn..." class="form-control mt-1">
													<label for="sex"> Sex <span class="text-danger">*</span></label>
													<input type="text" name="sex" placeholder="Sex..." class="form-control mt-1">
													<label for="LRN"> Learner Reference Number <span class="text-danger">*</span></label>
													<input type="text" name="LRN" placeholder="LRN..." class="form-control mt-1">
											</fieldset>
											<div class="col-12">
												<fieldset>
													<legend>Birth Details </legend>
													<label for="byear">Year</label>
													<select name="byear" class="form-control mt-1">
														<option> </option>
														<?php 
														for ($i=2010; $i < date('Y'); $i++) { 
															echo "<option>".$i."</option>";
														}
														 ?>
													</select>
													<label for="bmonth">Month <span class="text-danger">*</span></label>
													<select name="bmonth" class="form-control mt-1">
														<option> </option>
														<option>January</option>
														<option>February</option>
														<option>March</option>
														<option>April</option>
														<option>May</option>
														<option>June</option>
														<option>July</option>
														<option>August</option>
														<option>September</option>
														<option>October</option>
														<option>November</option>
														<option>December</option>
													</select>
													<label for="bday">Day <span class="text-danger">*</span></label>
													<select name="bday" class="form-control mt-1">
														<option> </option>
														<?php 
														for ($i=1; $i < 31; $i++) { 
															echo "<option>".$i."</option>";
														}
														 ?>
													</select>
												</fieldset>
											</div>
										</div>
										<div class="col-6">
											<fieldset>
												<legend>ELIGIBILITY FOR ELEMENTARY SCHOOL ENROLMENT</legend>
													<label for="creds">Primary Credential Submitted<span class="text-danger">*</span></label>
													<select class="form-control mt-1" name="creds">
														<option></option>
														<option>Kinder Progress Report</option>
														<option>ECCD Checklist</option>
														<option>Kindergarten Certificate of Completion</option>
													</select>
													<label for="name_of_school">Name of School <span class="text-danger">*</span></label>
													<input type="text" name="name_of_school" class="form-control mt-1" placeholder="Name of School...">
													<label for="name_of_school">School ID <span class="text-danger">*</span></label>
													<input type="text" name="sch_id" class="form-control mt-1" placeholder="School ID...">
													<label for="addr_of_school">Address of School <span class="text-danger">*</span></label>
													<input type="text" name="addr_of_school" class="form-control mt-1" placeholder="Address of School...">
											</fieldset>
											<fieldset>
												<legend>Other Credential Presented</legend>
													<select class="form-control mt-1" name="creds_other">
														<option></option>
														<option>PEPT Passer Rating</option>
													</select>
													<input type="text" name="date_of_exam" class="form-control mt-1" placeholder="Date of Examination...">
													<input type="text" name="name_of_testing_center" class="form-control mt-1" placeholder="Name of Testing Center...">
													<input type="text" name="addr_of_testing_center" class="form-control mt-1" placeholder="Address of Testing Center...">
													<label for="others_submitted">Document submitted<span class="text-danger">*</span></label>
													<input type="text" name="others_submitted" class="form-control mt-1" placeholder="Specify here other documets submitted...">
											</fieldset>
										</div>
									</div>
									<div style="text-align: right;" class="mt-1">
										<button name="btn_save_student" class="btn btn-primary">Save</button>
									</div>
								</form>
								<?php 
								if (isset($_POST['btn_save_student'])) {
									$fname = addslashes($_POST['firstname']);
									$lname = addslashes($_POST['lastname']);
									$mname = addslashes($_POST['middlename']);
									$name_extn = addslashes($_POST['name_extn']);
									$sex = addslashes($_POST['sex']);
									$lrn = addslashes($_POST['LRN']);
									$bday = addslashes($_POST['bday']);
									$bmonth = addslashes($_POST['bmonth']);
									$byear = addslashes($_POST['byear']);
									$cred_submted = addslashes($_POST['creds']);
									$name_of_school = addslashes($_POST['name_of_school']);
									$sch_id = addslashes($_POST['sch_id']);
									$address_school = addslashes($_POST['addr_of_school']);
									$cred_other_submitted = addslashes($_POST['creds_other']);
									$date_of_exam = addslashes($_POST['date_of_exam']);
									$testing_center_name = addslashes($_POST['name_of_testing_center']);
									$testing_center_addr = addslashes($_POST['addr_of_testing_center']);
									$others_submited = addslashes($_POST['others_submitted']);
									$grade_level = $_SESSION['grade_level'];
									
									if (!empty($fname) && !empty($lname) && !empty($lrn) && !empty($sex) && !empty($cred_submted) && !empty($sch_id) && !empty($address_school)) {
										$db->query("INSERT into users(lastname,firstname, mname, name_extn, user_level, sex, LRN, bday, bmonth, byear, credentials_submitted, testing_center_name, 	testing_center_addr,  date_of_exam, other_creds_1, grade_level,name_of_school, school_id, address_of_school ) VALUES('".$lname."','". $fname."','".$mname."','".$name_extn."','1','".$sex."','".$lrn."','".$bday."','".$bmonth."','".$byear."','".$cred_submted."','".$testing_center_name."','".$testing_center_addr."','".$date_of_exam."','".$others_submited."','".$grade_level."','".$name_of_school."','".$sch_id."','".$address_school."')");
										// $db->query("INSERT into users(lastname)VALUES('".$lname."')");
										echo "<script> alert('Data inserted!'); </script>";
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
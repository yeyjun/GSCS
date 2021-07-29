<?php 
	if (session_start()) {
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
			          <a class="nav-link" href="#"><?php echo $_SESSION['user']; ?></a>
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
				<div class="col-12">
					<div class="col-lg-12">
						<div class="card mt-2">
							<div class="card-header">
								<a href="save-grades.php" class="btn btn-success btn-sm">Enter Grades</a>
								<h4>Export Learning Progress and Achievement Report</h4>
								<p>Year Level: <?php echo $_SESSION['grade_level']; ?> </p>
							</div>
							<div class="card-body">
								<form style="text-align: right;"  method="GET">
									<label for="name_of_student">Last Name of Student</label>
									<input type="text" name="name_of_student" placeholder="Enter Last Name of Student...">
									<button name="btn_exportgrade" class="btn btn-primary btn-md btn-block"> Show</button>
								</form>
								<?php 
								if (isset($_GET['btn_exportgrade'])) {
									//init
										$stud_name = $_GET['name_of_student'];
									if (!empty($_GET['name_of_student'])) {
										$show_learners_data = $db->query("SELECT DISTINCT subject as sub_di, grade, grade_q2, grade_q3, grade_q4, lastname, firstname, id,final_rating  FROM grades WHERE  year_level='".$_SESSION['grade_level']."' AND lastname LIKE '%". $stud_name ."%'");
										?>
										<table class="table table-hover table-striped">
											<th>Fullname</th>
											<th>Learning Area</th>
											<th>Grade (Q1)</th>
											<th>Grade (Q2)</th>
											<th>Grade (Q3)</th>
											<th>Grade (Q4)</th>
											<th>Final Rating</th>
											<?php 
											while($data = $show_learners_data->fetch_array()){
												$GLOBALS['firstname'] = $data['firstname'];
												$GLOBALS['lastname'] = $data['lastname'];
												$GLOBALS['gwa'] = $data['grade']+$data['grade_q2']+$data['grade_q3']+$data['grade_q4'];
												$d = $gwa / 4;
												$GLOBALS['id'] = $data['id'];
												$GLOBALS['dgwa'] = $d;

											?>
											<tr>
												<td>
													<a href="view_record.php?user=<?php echo($data['id']); ?>">
														<?php echo $data['firstname'] . " ". $data['lastname']; ?>
													</a>
												</td>
												<td><?php echo $data['sub_di']; ?></td>
												<td><?php echo $data['grade']; ?></td>
												<td><?php echo $data['grade_q2']; ?></td>
												<td><?php echo $data['grade_q3']; ?></td>
												<td><?php echo $data['grade_q4']; ?></td>
												<td>
													<?php 
													if ($data['final_rating'] != "") {
														echo $data['final_rating'];
														if ($data['final_rating'] <= 75) {
														echo $data['final_rating'];
														?>
														<a href="?generate_final_rating=<?php echo $data['id']?>&final_rating=<?php echo $d; ?>" class="btn btn-sm btn-success">Re-enerate Final Rating</a>
														<?php
													}
													}else{
													?>
													<a href="?generate_final_rating=<?php echo $data['id']?>&final_rating=<?php echo $d; ?>" class="btn btn-sm btn-success">Generate Final Rating</a>
												</td>
											</tr>
											<?php
												}
											}
											// $get_avg = $db->query("SELECT AVG(final_rating) FROM grades WHERE lastname=")
											?>
											<tr>
												<td colspan="6" style="text-align: right;"><b>General Weighted Average: </b> </td>
												<td colspan="1" style="text-align: left;">
													<?php 
													if (isset($_GET['data'])) {
														echo $_GET['data'];
													}else{
														?>
														<a href="?firstname=<?php echo $firstname ?>&lastname=<?php echo $lastname ?>&key=<?php echo$stud_name ?>">GENERATE GWA</a>
														<?php
													}
													?>
												</td>
											</tr>
										</table>
										<div style="text-align:right;">
											<a href="export.php?id=<?php echo($id); ?>" class="btn btn-sm btn-primary"> Export</a>
											<a href="export -inside.php?student_fname=<?php echo($firstname); ?>&student_lname=<?php echo($lastname); ?>" class="btn btn-sm btn-success"> Export</a>
										</div>
										<?php
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
	if (isset($_GET['generate_final_rating']) && isset($_GET['final_rating'])) {
		$gen = $_GET['generate_final_rating'];
		$fr = $_GET['final_rating'];
		$db->query("UPDATE grades SET final_rating = '$fr' WHERE id = '$gen' ");
		header("Location: grades.php");
	}elseif (isset($_GET['lastname']) && isset($_GET['firstname']) && isset($_GET['key'])) {
		$lastname = $_GET['lastname'];
		$firstname = $_GET['firstname'];
		$show_avg = $db->query("SELECT AVG(final_rating) as rating FROM grades WHERE lastname='$lastname' AND firstname='$firstname'");
		$data_avg = $show_avg->fetch_array();
		header("Location: grades.php?name_of_student=".$_GET['key']."&btn_exportgrade=&data=".$data_avg['rating']);
	}
}
?>
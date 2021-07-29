<?php
	if (session_start() and isset($_GET['export'])) {
		include_once 'bootstrap.php';
		include_once 'db.php';
		$id_A = $_GET['export'];
		$get_data = $db->query("SELECT * FROM users WHERE id = '$id_A'");
		$fetch_data = $get_data->fetch_array();
		$lastname_on_records = $fetch_data['lastname'];
		$firstname_on_records = $fetch_data['firstname'];
		$mname_on_records = $fetch_data['mname'];
?>
	<!DOCTYPE html>
	<html>
	<head>
		<meta charset="utf-8">
		<title>Export</title>
	</head>
	<body>
	<div class="container mt-5">
		<center>
			<strong>Republic of the Philippines</strong>  <br>
			Department of Education <br>
			Learner Permanent Record for Elementary School (SF10-ES)<br><br>
			<sup>(Formerly Form 137)</sup>
		</center>
		<table class="table">
			<th colspan="4"><center>LEARNER&apos;S PERSONAL INFORMATION</center></th>
			<tr>
				<td>Last Name: <b><?php echo $fetch_data['lastname'] ?></b></td>
				<td>First Name: <b><?php echo $fetch_data['firstname'] ?></td>
				<td>Name Extn: <b><?php echo $fetch_data['name_extn'] ?></td>
				<td>Middle Name: <b><?php echo $fetch_data['mname'] ?></td>
			</tr>
			<tr>
				<td>Learner Reference Number (LRN): <b><?php echo $fetch_data['LRN'] ?></td>
				<td>Birthdate (mm/dd/yyyy): <b><?php echo $fetch_data['bmonth'] . "/". $fetch_data['bday'] . "/". $fetch_data['byear'] ?></td>
				<td>Sex: <b><?php echo $fetch_data['sex'] ?></td>
			</tr>
		</table>
		<table class="table">
			<th colspan="4"><center>ELIGIBILITY FOR ELEMENTARY SCHOOL ENROLMENT</center></th>
			<tr>
				<td>Credential Presented for Grade 1:</td>
				<td>
					<?php if ($fetch_data['credentials_submitted'] != "") {
						echo "-";
					} ?>
					<b><?php echo $fetch_data['credentials_submitted'] ?></b></td>
			</tr>
			<tr>
				<td>Name of School: <b><?php echo $fetch_data['name_of_school'] ?></td>
				<td>School ID: <b><?php echo $fetch_data['school_id'] ?></td>
				<td>Address of School: <b><?php echo $fetch_data['address_of_school'] ?></td>
			</tr>
			<tr>
				<td>Other Credentials Presented</td>
				<td>PEPT Passer  Rating: 
					<?php if ($fetch_data['pept_passer_rating'] != 0) {
						?><b><?php echo $fetch_data['pept_passer_rating'] ?></b><?php
					} ?>
					</td>
				<td>Date of Examination/Assessment (mm/dd/yyyy): <b><?php echo $fetch_data['date_of_exam'] ?></b></td>
				<td>Others (Pls. Specify):  <b><?php echo $fetch_data['other_creds_1'] ?></b></td>
			</tr>
			<tr>
				<td>Name and Address of Testing Center: <b><?php echo $fetch_data['testing_center_name'] . " ".  $fetch_data['testing_center_addr']  ?></td>
				<td>Remark:</td>
			</tr>
		</table>
		<div class="row">
		<center><strong>SCHOLASTIC RECORD</strong></center>
			<div class="col-6">
				<table class="table" border="2">
					<?php 
					$get_grades = $db->query("SELECT DISTINCT quarter as distinct_quarter, grade,subject,adviser,year_level,school_year,school_id,school,district,division,region, grade_q2, grade_q3, grade_q4, final_rating FROM grades WHERE lastname = '".$lastname_on_records."' AND firstname='".$firstname_on_records."' AND year_level = '5'");
					$get_grades_on_grades_tbl = $get_grades->fetch_array();
					?>
					<tr>
						<td>School</td>
						<td><b><u><?php echo $get_grades_on_grades_tbl['school']; ?></u></b></td>
						<td>School ID</td>
						<td><b><u><?php echo $get_grades_on_grades_tbl['school_id']; ?></u></b></td>
					</tr>
					<tr>
						<td>District <b><u><?php echo $get_grades_on_grades_tbl['district']; ?></u></b></td>
						<td>Division <b><u><?php echo $get_grades_on_grades_tbl['division']; ?></u></b></td>
						<td>Region <b><u><?php echo $get_grades_on_grades_tbl['region']; ?></u></b></td>
					</tr>
					<tr>
						<td>Classified as Grade: </td>
						<td>Section</td>
						<td>School Year <b><u><?php echo $get_grades_on_grades_tbl['school_year']; ?></u></b></td>
					</tr>
					<tr>
						<td>Name of Adviser/Teacher: <b><u><?php echo $get_grades_on_grades_tbl['adviser']; ?></u></b></td>
						<td>Signature</td>
					</tr>
					<tr>
						<td rowspan="2"><strong>Learning Areas</strong></td>
						<td colspan="4"><center>Quarterly Rating</center></td>
						<td rowspan="2">Final Rating</td>
						<td rowspan="2">Remarks</td>
					</tr>
					<tr>
						<td>1</td>
						<td>2</td>
						<td>3</td>
						<td>4</td>
					</tr>
					<?php 
					while ($grades = $get_grades->fetch_array()) {
						?>
						<tr>
							<td><?php echo $grades['subject']; ?></td>
							<td><?php echo $grades['grade']; ?></td>
							<td><?php echo $grades['grade_q2']; ?></td>
							<td><?php echo $grades['grade_q3']; ?></td>
							<td><?php echo $grades['grade_q4']; ?></td>
							<td><?php echo $grades['final_rating']; ?></td>
							<td>
								<?php 
								if ($grades['final_rating'] >= 75) {
									echo "PASSED";
								}else{
									echo "FAILED";
								}
								?>
							</td>
						</tr>
						<?php
					}
					?>
				</table>
				<table>
						<th>Remedial Classes</th>
						<th>Conducted from: __ to ____</th>
						<tr>
							<td>Learning Areas</td>
							<td>Final Rating</td>
							<td>Remedial Class Mark</td>
							<td>Recomputed Final Grade</td>
							<td>Remarks</td>
						</tr>
						<tr>
							<td>0</td>
							<td>0</td>
							<td>0</td>
							<td>0</td>
							<td>0</td>
						</tr>
					</table>
			</div>
			<div class="col-6">
				<table class="table" border="2">
					<?php 
					$get_grades = $db->query("SELECT DISTINCT quarter as distinct_quarter, grade,subject,adviser,year_level,school_year,school_id,school,district,division,region, grade_q2, grade_q3, grade_q4, final_rating FROM grades WHERE lastname = '".$lastname_on_records."' AND firstname='".$firstname_on_records."' AND year_level = '5'");
					$get_grades_on_grades_tbl = $get_grades->fetch_array();
					?>
					<tr>
						<td>School</td>
						<td><b><u><?php echo $get_grades_on_grades_tbl['school']; ?></u></b></td>
						<td>School ID</td>
						<td><b><u><?php echo $get_grades_on_grades_tbl['school_id']; ?></u></b></td>
					</tr>
					<tr>
						<td>District <b><u><?php echo $get_grades_on_grades_tbl['district']; ?></u></b></td>
						<td>Division <b><u><?php echo $get_grades_on_grades_tbl['division']; ?></u></b></td>
						<td>Region <b><u><?php echo $get_grades_on_grades_tbl['region']; ?></u></b></td>
					</tr>
					<tr>
						<td>Classified as Grade: </td>
						<td>Section</td>
						<td>School Year <b><u><?php echo $get_grades_on_grades_tbl['school_year']; ?></u></b></td>
					</tr>
					<tr>
						<td>Name of Adviser/Teacher: <b><u><?php echo $get_grades_on_grades_tbl['adviser']; ?></u></b></td>
						<td>Signature</td>
					</tr>
					<tr>
						<td rowspan="2"><strong>Learning Areas</strong></td>
						<td colspan="4"><center>Quarterly Rating</center></td>
						<td rowspan="2">Final Rating</td>
						<td rowspan="2">Remarks</td>
					</tr>
					<tr>
						<td>1</td>
						<td>2</td>
						<td>3</td>
						<td>4</td>
					</tr>
					<?php 
					while ($grades = $get_grades->fetch_array()) {
						?>
						<tr>
							<td><?php echo $grades['subject']; ?></td>
							<td><?php echo $grades['grade']; ?></td>
							<td><?php echo $grades['grade_q2']; ?></td>
							<td><?php echo $grades['grade_q3']; ?></td>
							<td><?php echo $grades['grade_q4']; ?></td>
							<td><?php echo $grades['final_rating']; ?></td>
							<td>
								<?php 
								if ($grades['final_rating'] >= 75) {
									echo "PASSED";
								}else{
									echo "FAILED";
								}
								?>
							</td>
						</tr>
						<?php
					}
					?>
				</table>
				<table>
						<th>Remedial Classes</th>
						<th>Conducted from: __ to ____</th>
						<tr>
							<td>Learning Areas</td>
							<td>Final Rating</td>
							<td>Remedial Class Mark</td>
							<td>Recomputed Final Grade</td>
							<td>Remarks</td>
						</tr>
						<tr>
							<td>0</td>
							<td>0</td>
							<td>0</td>
							<td>0</td>
							<td>0</td>
						</tr>
					</table>
			</div>
		</div>
		<br><br><br><br><br><br>
		<br><br><br><br><br><br>
		<div class="row mt-5">
			<div class="col-6">
				<table class="table" border="2">
					<?php 
					$get_grades = $db->query("SELECT DISTINCT quarter as distinct_quarter, grade,subject,adviser,year_level,school_year,school_id,school,district,division,region, grade_q2, grade_q3, grade_q4, final_rating FROM grades WHERE lastname = '".$lastname_on_records."' AND firstname='".$firstname_on_records."' AND year_level = '5'");
					$get_grades_on_grades_tbl = $get_grades->fetch_array();
					?>
					<tr>
						<td>School</td>
						<td><b><u><?php echo $get_grades_on_grades_tbl['school']; ?></u></b></td>
						<td>School ID</td>
						<td><b><u><?php echo $get_grades_on_grades_tbl['school_id']; ?></u></b></td>
					</tr>
					<tr>
						<td>District <b><u><?php echo $get_grades_on_grades_tbl['district']; ?></u></b></td>
						<td>Division <b><u><?php echo $get_grades_on_grades_tbl['division']; ?></u></b></td>
						<td>Region <b><u><?php echo $get_grades_on_grades_tbl['region']; ?></u></b></td>
					</tr>
					<tr>
						<td>Classified as Grade: </td>
						<td>Section</td>
						<td>School Year <b><u><?php echo $get_grades_on_grades_tbl['school_year']; ?></u></b></td>
					</tr>
					<tr>
						<td>Name of Adviser/Teacher: <b><u><?php echo $get_grades_on_grades_tbl['adviser']; ?></u></b></td>
						<td>Signature</td>
					</tr>
					<tr>
						<td rowspan="2"><strong>Learning Areas</strong></td>
						<td colspan="4"><center>Quarterly Rating</center></td>
						<td rowspan="2">Final Rating</td>
						<td rowspan="2">Remarks</td>
					</tr>
					<tr>
						<td>1</td>
						<td>2</td>
						<td>3</td>
						<td>4</td>
					</tr>
					<?php 
					while ($grades = $get_grades->fetch_array()) {
						?>
						<tr>
							<td><?php echo $grades['subject']; ?></td>
							<td><?php echo $grades['grade']; ?></td>
							<td><?php echo $grades['grade_q2']; ?></td>
							<td><?php echo $grades['grade_q3']; ?></td>
							<td><?php echo $grades['grade_q4']; ?></td>
							<td><?php echo $grades['final_rating']; ?></td>
							<td>
								<?php 
								if ($grades['final_rating'] >= 75) {
									echo "PASSED";
								}else{
									echo "FAILED";
								}
								?>
							</td>
						</tr>
						<?php
					}
					?>
				</table>
				<table>
						<th>Remedial Classes</th>
						<th>Conducted from: __ to ____</th>
						<tr>
							<td>Learning Areas</td>
							<td>Final Rating</td>
							<td>Remedial Class Mark</td>
							<td>Recomputed Final Grade</td>
							<td>Remarks</td>
						</tr>
						<tr>
							<td>0</td>
							<td>0</td>
							<td>0</td>
							<td>0</td>
							<td>0</td>
						</tr>
					</table>
			</div>
			<div class="col-6">
				<table class="table" border="2">
					<?php 
					$get_grades = $db->query("SELECT DISTINCT quarter as distinct_quarter, grade,subject,adviser,year_level,school_year,school_id,school,district,division,region, grade_q2, grade_q3, grade_q4, final_rating FROM grades WHERE lastname = '".$lastname_on_records."' AND firstname='".$firstname_on_records."' AND year_level = '5'");
					$get_grades_on_grades_tbl = $get_grades->fetch_array();
					?>
					<tr>
						<td>School</td>
						<td><b><u><?php echo $get_grades_on_grades_tbl['school']; ?></u></b></td>
						<td>School ID</td>
						<td><b><u><?php echo $get_grades_on_grades_tbl['school_id']; ?></u></b></td>
					</tr>
					<tr>
						<td>District <b><u><?php echo $get_grades_on_grades_tbl['district']; ?></u></b></td>
						<td>Division <b><u><?php echo $get_grades_on_grades_tbl['division']; ?></u></b></td>
						<td>Region <b><u><?php echo $get_grades_on_grades_tbl['region']; ?></u></b></td>
					</tr>
					<tr>
						<td>Classified as Grade: </td>
						<td>Section</td>
						<td>School Year <b><u><?php echo $get_grades_on_grades_tbl['school_year']; ?></u></b></td>
					</tr>
					<tr>
						<td>Name of Adviser/Teacher: <b><u><?php echo $get_grades_on_grades_tbl['adviser']; ?></u></b></td>
						<td>Signature</td>
					</tr>
					<tr>
						<td rowspan="2"><strong>Learning Areas</strong></td>
						<td colspan="4"><center>Quarterly Rating</center></td>
						<td rowspan="2">Final Rating</td>
						<td rowspan="2">Remarks</td>
					</tr>
					<tr>
						<td>1</td>
						<td>2</td>
						<td>3</td>
						<td>4</td>
					</tr>
					<?php 
					while ($grades = $get_grades->fetch_array()) {
						?>
						<tr>
							<td><?php echo $grades['subject']; ?></td>
							<td><?php echo $grades['grade']; ?></td>
							<td><?php echo $grades['grade_q2']; ?></td>
							<td><?php echo $grades['grade_q3']; ?></td>
							<td><?php echo $grades['grade_q4']; ?></td>
							<td><?php echo $grades['final_rating']; ?></td>
							<td>
								<?php 
								if ($grades['final_rating'] >= 75) {
									echo "PASSED";
								}else{
									echo "FAILED";
								}
								?>
							</td>
						</tr>
						<?php
					}
					?>
				</table>
				<table>
						<th>Remedial Classes</th>
						<th>Conducted from: __ to ____</th>
						<tr>
							<td>Learning Areas</td>
							<td>Final Rating</td>
							<td>Remedial Class Mark</td>
							<td>Recomputed Final Grade</td>
							<td>Remarks</td>
						</tr>
						<tr>
							<td>0</td>
							<td>0</td>
							<td>0</td>
							<td>0</td>
							<td>0</td>
						</tr>
					</table>
			</div>
			<div class="col-6">
				<table class="table" border="2">
					<?php 
					$get_grades = $db->query("SELECT DISTINCT quarter as distinct_quarter, grade,subject,adviser,year_level,school_year,school_id,school,district,division,region, grade_q2, grade_q3, grade_q4, final_rating FROM grades WHERE lastname = '".$lastname_on_records."' AND firstname='".$firstname_on_records."' AND year_level = '5'");
					$get_grades_on_grades_tbl = $get_grades->fetch_array();
					?>
					<tr>
						<td>School</td>
						<td><b><u><?php echo $get_grades_on_grades_tbl['school']; ?></u></b></td>
						<td>School ID</td>
						<td><b><u><?php echo $get_grades_on_grades_tbl['school_id']; ?></u></b></td>
					</tr>
					<tr>
						<td>District <b><u><?php echo $get_grades_on_grades_tbl['district']; ?></u></b></td>
						<td>Division <b><u><?php echo $get_grades_on_grades_tbl['division']; ?></u></b></td>
						<td>Region <b><u><?php echo $get_grades_on_grades_tbl['region']; ?></u></b></td>
					</tr>
					<tr>
						<td>Classified as Grade: </td>
						<td>Section</td>
						<td>School Year <b><u><?php echo $get_grades_on_grades_tbl['school_year']; ?></u></b></td>
					</tr>
					<tr>
						<td>Name of Adviser/Teacher: <b><u><?php echo $get_grades_on_grades_tbl['adviser']; ?></u></b></td>
						<td>Signature</td>
					</tr>
					<tr>
						<td rowspan="2"><strong>Learning Areas</strong></td>
						<td colspan="4"><center>Quarterly Rating</center></td>
						<td rowspan="2">Final Rating</td>
						<td rowspan="2">Remarks</td>
					</tr>
					<tr>
						<td>1</td>
						<td>2</td>
						<td>3</td>
						<td>4</td>
					</tr>
					<?php 
					while ($grades = $get_grades->fetch_array()) {
						?>
						<tr>
							<td><?php echo $grades['subject']; ?></td>
							<td><?php echo $grades['grade']; ?></td>
							<td><?php echo $grades['grade_q2']; ?></td>
							<td><?php echo $grades['grade_q3']; ?></td>
							<td><?php echo $grades['grade_q4']; ?></td>
							<td><?php echo $grades['final_rating']; ?></td>
							<td>
								<?php 
								if ($grades['final_rating'] >= 75) {
									echo "PASSED";
								}else{
									echo "FAILED";
								}
								?>
							</td>
						</tr>
						<?php
					}
					?>
				</table>
				<table>
						<th>Remedial Classes</th>
						<th>Conducted from: __ to ____</th>
						<tr>
							<td>Learning Areas</td>
							<td>Final Rating</td>
							<td>Remedial Class Mark</td>
							<td>Recomputed Final Grade</td>
							<td>Remarks</td>
						</tr>
						<tr>
							<td>0</td>
							<td>0</td>
							<td>0</td>
							<td>0</td>
							<td>0</td>
						</tr>
					</table>
			</div>
			<div class="col-6">
				<table class="table" border="2">
					<?php 
					$get_grades = $db->query("SELECT DISTINCT quarter as distinct_quarter, grade,subject,adviser,year_level,school_year,school_id,school,district,division,region, grade_q2, grade_q3, grade_q4, final_rating FROM grades WHERE lastname = '".$lastname_on_records."' AND firstname='".$firstname_on_records."' AND year_level = '5'");
					$get_grades_on_grades_tbl = $get_grades->fetch_array();
					?>
					<tr>
						<td>School</td>
						<td><b><u><?php echo $get_grades_on_grades_tbl['school']; ?></u></b></td>
						<td>School ID</td>
						<td><b><u><?php echo $get_grades_on_grades_tbl['school_id']; ?></u></b></td>
					</tr>
					<tr>
						<td>District <b><u><?php echo $get_grades_on_grades_tbl['district']; ?></u></b></td>
						<td>Division <b><u><?php echo $get_grades_on_grades_tbl['division']; ?></u></b></td>
						<td>Region <b><u><?php echo $get_grades_on_grades_tbl['region']; ?></u></b></td>
					</tr>
					<tr>
						<td>Classified as Grade: </td>
						<td>Section</td>
						<td>School Year <b><u><?php echo $get_grades_on_grades_tbl['school_year']; ?></u></b></td>
					</tr>
					<tr>
						<td>Name of Adviser/Teacher: <b><u><?php echo $get_grades_on_grades_tbl['adviser']; ?></u></b></td>
						<td>Signature</td>
					</tr>
					<tr>
						<td rowspan="2"><strong>Learning Areas</strong></td>
						<td colspan="4"><center>Quarterly Rating</center></td>
						<td rowspan="2">Final Rating</td>
						<td rowspan="2">Remarks</td>
					</tr>
					<tr>
						<td>1</td>
						<td>2</td>
						<td>3</td>
						<td>4</td>
					</tr>
					<?php 
					while ($grades = $get_grades->fetch_array()) {
						?>
						<tr>
							<td><?php echo $grades['subject']; ?></td>
							<td><?php echo $grades['grade']; ?></td>
							<td><?php echo $grades['grade_q2']; ?></td>
							<td><?php echo $grades['grade_q3']; ?></td>
							<td><?php echo $grades['grade_q4']; ?></td>
							<td><?php echo $grades['final_rating']; ?></td>
							<td>
								<?php 
								if ($grades['final_rating'] >= 75) {
									echo "PASSED";
								}else{
									echo "FAILED";
								}
								?>
							</td>
						</tr>
						<?php
					}
					?>
				</table>
				<table>
						<th>Remedial Classes</th>
						<th>Conducted from: __ to ____</th>
						<tr>
							<td>Learning Areas</td>
							<td>Final Rating</td>
							<td>Remedial Class Mark</td>
							<td>Recomputed Final Grade</td>
							<td>Remarks</td>
						</tr>
						<tr>
							<td>0</td>
							<td>0</td>
							<td>0</td>
							<td>0</td>
							<td>0</td>
						</tr>
					</table>
			</div>
		<br><br><br><br><br><br><br><br><br>
		<div class="row">
			<strong>For transfer Out/Elementary School Completer Only</strong>
			<table class="table" border="1">
				<th colspan="3"><center>CERTIFICATION</center></th>
				<tr>
					<td colspan="2"><center>I CERTIFY that this is a true record of __________ with LRN _____ and that he/she is eligible for addmision to Grade ____</center></td>
				</tr>
				<tr>
					<td colspan="2"> <center>School Name: _____________ School ID _________ Division: _________ Last School Year Attended: _____________ </center></td>
				</tr>

				<tr>
					<td>
						<center>_______________ <br> Date</center>
					</td>
					<td>
						<center>_____________________________________________ <br>Signature of Principal/School Head over Printed Name</center>
					</td>
				</tr>
			</table>
		</div>
	</div>
	</body>
	</html>
<?php
	}
?>
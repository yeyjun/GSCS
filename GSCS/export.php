<?php 
	include_once 'bootstrap.php';
	include_once 'db.php';
	if (session_start() && isset($_GET['id'])) {
		$id = $db->query("SELECT * FROM grades WHERE id ='".$_GET['id']."' ");
		$export_data = $id->fetch_array();
		$fname = $export_data['firstname'];
		$lastname = $export_data['lastname'];
		#init from user tbl
		$get_data = $db->query("SELECT * FROM users WHERE firstname = '$fname'");
		$d = $get_data->fetch_array();
		$d_age = date('Y')-$d['byear'];
		$GLOBALS['age'] = $d_age;  

		#init teacher
		$adv_id = $_SESSION['user_id'];
		$adv = $db->query("SELECT * FROM users WHERE id='".$adv_id."'");
		$fetch_adv = $adv->fetch_array();
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Export</title>
</head>
<body>
	<div class="container">
		<div class="row mt-2">
			<div class="col-6">
				<center>Attendance Record</center>
				<table class="table" border="2">
					<tr>
						<td></td>
						<td>Jun</td>
						<td>Jul</td>
						<td>Aug</td>
						<td>Sep</td>
						<td>Oct</td>
						<td>Nov</td>
						<td>Dec</td>
						<td>Jan</td>
						<td>Feb</td>
						<td>Mar</td>
						<td>Apr</td>
						<td>Total</td>
					</tr>
					<tr>
						<td>No. of School Days</td>
					</tr>
					<tr>
						<td>No. of Days Present</td>
					</tr>
					<tr>
						<td>No. of Times Absent</td>
					</tr>
				</table>
				<br><br>
				<center>
					<b>PARENT/GUARDIAN&apos;S SIGNATURE</b>
				</center>
				1st Quarter______________________ <br>
				2nd Quarter______________________ <br>
				3rd Quarter______________________ <br>
				4th Quarter______________________
			</div>
			<div class="col-6">
				<img src="img/2.png" height="50 px" width="50 px">
				<center>
					Republic of the Philippines <br>
					DEPARTMENT OF EDUCATION <br>
					Region <u>2</u> <br>
					Division <u>Cagayan</u> <br>
					District <u>Gonzaga West</u> <br>
					School <u>Gonzaga South Central School</u> <br>
					<strong>LEARNER&apos;S PROGRESS REPORT CARD</strong> <br>
					School Year <?php echo date('Y')-1 . "-" . date('Y'); ?> <br>
					<br>
					Name: <u><b><?php echo strtoupper($export_data['lastname']) . ", " . strtoupper($export_data['firstname']) . " " . strtoupper($d['mname']); ?></b></u> <br>
					Age: <u><b><?php echo $age; ?> &#9; &#9; &#9;</b></u>Sex: <?php echo $d['sex'] ?> <br>
					Grade: <u><b><?php echo $d['grade_level']; ?></b></u>  Section:_____ LRN: <u><b><?php echo $d['LRN']; ?></b></u> <br><br>
				</center>
				<p>
					Dear Parent, <br><br>
					This report card shows the ability and the progress your child has 	made in the different learning areas as well as his/her progress in core values. <br>
					    The school welcomes you should you desire to know more about your 	child’s progress.
					<table class="table" border="1">
						<tr>
							<td>
								<u><b>LOREEN LOLITA CUBERO</b></u> <br> Head Teacher
							</td>
							<td>
								<b><u><?php echo  strtoupper($fetch_adv['firstname'])." ".strtoupper($fetch_adv['lastname']); ?></u></b> <br> Teacher
							</td>
						</tr>
					</table>
				</p>
					<center>
						CERTIFICATE OF TRANSFER
					</center>
				<p>
					Admitted to Grade _____________ Section____________ Room____________ <br>Eligible fo Admission to Grade ___________ <br>
					Approved: 
					<table class="table" border="1">
						<tr>
							<td>
								________________ <br> Head Teacher
							</td>
							<td>
								________________ <br> Teacher
							</td>
						</tr>
					</table>
					<center>
						Cancellation of Eligibility to Transfer <br>
					</center>
						Admitted in______________________________ <br>
						Date: ____________ <br>
					<div style="text-align: right;">
						___________ <br>Principal
					</div>

				</p>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		window.print();
		window.open("grades.php","_self");
	</script>
</body>
</html>

<?php 
}
 ?>
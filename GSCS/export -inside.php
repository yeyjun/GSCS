<?php 
	include_once 'bootstrap.php';
	include_once 'db.php';
	if (session_start() && isset($_GET['student_fname']) && isset($_GET['student_lname'])) {
		$student_lname = $_GET['student_lname'];
		$student_finame = $_GET['student_fname'];
		$id = $db->query("SELECT DISTINCT quarter as distinct_quarter, grade,grade_q2,grade_q3,grade_q4,subject FROM grades WHERE lastname = '".$student_lname."' AND firstname='".$student_finame."'");

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
				<strong>GRADE <u><?php echo $_SESSION['grade_level']; ?></u></strong>
				<center>
					<strong>REPORT ON LEARNING PROGRESS AND ACHIEVEMENT </strong>
				</center>
				<table border="2" class="table">
					<tr>
						<td rowspan="2">LEARNING AREAS</td>
						<td colspan="4"><center>Quarter</center></td>
						<td rowspan="2" style="text-align:center;">Final Rating</td>
						<td rowspan="2">Remarks</td>
					</tr>
					<tr>
						<td>1</td>
						<td>2</td>
						<td>3</td>
						<td>4</td>
					</tr>
					<?php 

					while ($fetch_grades = $id->fetch_array()) {
						$gwa = $fetch_grades['grade'] + $fetch_grades['grade_q2'] + $fetch_grades['grade_q3'] + $fetch_grades['grade_q4'];

						?>
						<tr>
							<td><?php echo $fetch_grades['subject']; ?></td>
							<td><?php echo $fetch_grades['grade']; ?></td>
							<td><?php echo $fetch_grades['grade_q2']; ?></td>
							<td><?php echo $fetch_grades['grade_q3']; ?></td>
							<td><?php echo $fetch_grades['grade_q4']; ?></td>
							<td><?php echo $gwa/4; ?></td>
							<td>
								<?php 
								if ($gwa/4 >= 75) {
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
						<td></td>
						<td colspan="4">General Average</td>
						<td></td>
					</tr>
				</table>
				
				<table class="table">
					<th>Descriptors</th>
					<th>Grading Scale</th>
					<th>Remarks</th>
					<tr>
						<td>Outstanding</td>
						<td>90-100</td>
						<td>Passed</td>
					</tr>
					<tr>
						<td>Very Satisfactory</td>
						<td>85-89</td>
						<td>Passed</td>
					</tr>
					<tr>
						<td>Satisfactory</td>
						<td>80-84</td>
						<td>Passed</td>
					</tr>
					<tr>
						<td>Fairly Satisfactory</td>
						<td>75-79</td>
						<td>Passed</td>
					</tr>
					<tr>
						<td>Did Not Meet Expectations</td>
						<td>Below 75</td>
						<td>Failed</td>
					</tr>
				</table>
			</div>
			<div class="col-6">
				<center><strong>REPORT ON LEARNER&apos;S OBSERVED VALUES</strong></center>
				<table class="table">
					<th rowspan="2">Core Values</th>
					<th rowspan="2">Behavior Statements</th>
					<th colspan="4">Quarter</th>
					<tr>
						<td>1</td>
						<td>2</td>
						<td>3</td>
						<td>4</td>
					</tr>
					<tr>
						<td>1. Maka-Diyos</td>
						<td>Expresses one’s spiritual beliefs while respecting the spiritual beliefs of others</td>
					</tr>
					<tr>
						<td>2. Makatao</td>
						<td>Shows adherence to ethical principles by upholding truth</td>
					</tr>
					<tr>
						<td>3. Maka-kalikasan</td>
						<td>Cares for the environment and utilizes resources wisely, judiciously, and economically</td>
					</tr>
					<tr>
						<td rowspan="2">4. Makabansa</td>
						<td>Demonstrates pride in being a Filipino; exercises the rights and responsibilities of a Filipino citizen</td>
					</tr>
					<tr>
						<td>Demonstrates appropriate behavior in carrying out activities in the school, community, and country</td>
					</tr>
				</table>
				<table class="table">
					<th>Marking</th>
					<th>Non-numerical Rating</th>
					<tr>
						<td>AO</td>
						<td>Always Observed</td>
					</tr>
					<tr>
						<td>SO</td>
						<td>Sometimes Observed</td>
					</tr>
					<tr>
						<td>RO</td>
						<td>Rarely Observed</td>
					</tr>
					<tr>
						<td>NO</td>
						<td>Not Observed</td>
					</tr>
				</table>
			</div>
		</div>
	</div>
</body>
</html>
<?php 
	}
?>
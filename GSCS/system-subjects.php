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
		<body class="" onload="show_time()">
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
			</nav>
			<div class="container ">
				<div class="">
					<div class="row">
						<div class="col-3"></div>
						<div class="col-6">
							<div class="card border-primary mt-1">
								<div class="card-header">
									<h3>Subjects</h3>
								</div>
								<div class="card-body">
									<table class="table table-hover">
										<th>Learning Area</th>
										<th colspan="2">Operation</th>
										<?php 
										$subjects = $db->query("SELECT * FROM systemdependencies WHERE remarks= 'subject' ");
										while ($get_subjk = $subjects->fetch_array()) {
											?>
											<tr>
												<td><?php echo $get_subjk['title']; ?></td>
												<td>
													<a href="" class="btn btn-sm btn-primary">Edit</a><a href="?delete=<?php echo $get_subjk['id'] ?>" class="btn btn-sm text-danger">Delete</a>
												</td>
											</tr>
											<?php
										}
										?>
										
									</table>
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
		<script type="text/javascript">
			var s = setInterval(show_time, 1000);
			function show_time(){
				var t = new Date();
				var h = t.getHours();
				var s = t.getSeconds();
				var minute = t.getMinutes();
				document.getElementById('show_time').innerHTML = h +":"+ minute + ":" + s ;
			}
		</script>
		<?php
		if (isset($_GET['delete'])) {
			$id=$_GET['delete'];
			echo "<script>alert('Subject with id $id deleted!')";
			echo "<script> location.reload()</script>";
			$db->query("DELETE FROM systemdependencies WHERE id = '$id' ");
		}
	}
?>
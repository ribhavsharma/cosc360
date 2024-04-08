<?php 
require __DIR__ . '/../../core/init.php';

// session_start();

// Database connection
$host = DBHOST;
$db   = DBNAME;
$user = DBUSER;
$pass = DBPASS;

// Create connection
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}

// Query the tracking data
$sql = "SELECT page, COUNT(*) as visits FROM tracking GROUP BY page";
$result = $conn->query($sql);

$data = array();
$pageNames = array();
$visitCounts = array();

while ($row = $result->fetch_assoc()) {
    $data[] = $row;
    $pageNames[] = basename($row['page']);
    $visitCounts[] = $row['visits'];
}

// Convert the arrays to JSON so they can be used in JavaScript
$pageNamesJson = json_encode($pageNames);
$visitCountsJson = json_encode($visitCounts);

$conn->close();
?>

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>

	<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
	<div class="row justify-content-center">
		
		<div class="m-1 col-md-4 bg-light rounded shadow border text-center">
			<h1><i class="bi bi-person-video3"></i></h1>
			<div>
				Admins
			</div>
			<?php 

				$query = "select count(id) as num from users where role = 'admin'";
				$res = queryRow($query);
			?>
			<h1 class="text-primary"><?=$res['num'] ?? 0?></h1>	</div>
		
		<div class="m-1 col-md-4 bg-light rounded shadow border text-center">
			<h1><i class="bi bi-person-circle"></i></h1>
			<div>
				Users
			</div>
			<?php 

				$query = "select count(id) as num from users where role = 'user'";
				$res = queryRow($query);
			?>
			<h1 class="text-primary"><?=$res['num'] ?? 0?></h1>	</div>

		<div class="m-1 col-md-4 bg-light rounded shadow border text-center">
			<h1><i class="bi bi-tags"></i></h1>
			<div>
				Categories
			</div>
			<?php 

				$query = "select count(id) as num from categories";
				$res = queryRow($query);
			?>
			<h1 class="text-primary"><?=$res['num'] ?? 0?></h1>	</div>

		<div class="m-1 col-md-4 bg-light rounded shadow border text-center">
			<h1><i class="bi bi-file-post"></i></h1>
			<div>
				Posts
			</div>
			<?php 

				$query = "select count(id) as num from posts";
				$res = queryRow($query);
			?>
			<h1 class="text-primary"><?=$res['num'] ?? 0?></h1>
		</div>

		<h3 class="mt-5">Tracking Data</h3>
		<div class="container mt-5">
			<!-- <h1 class="text-center">Tracking Data</h1> -->
			<table class="table table-striped">
				<thead>
					<tr>
						<th scope="col">Page</th>
						<th scope="col">Visits</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($data as $row): ?>
						<tr>
							<td><?php echo basename($row['page']); ?></td>
							<td><?php echo $row['visits']; ?></td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>

		<div class="container mt-5">
			<canvas id="trackingChart"></canvas>
		</div>

		<script>
		var ctx = document.getElementById('trackingChart').getContext('2d');
		var chart = new Chart(ctx, {
			type: 'bar',
			data: {
				labels: <?php echo $pageNamesJson; ?>,
				datasets: [{
					label: 'Visits',
					data: <?php echo $visitCountsJson; ?>,
					backgroundColor: 'rgba(75, 192, 192, 0.2)',
					borderColor: 'rgba(75, 192, 192, 1)',
					borderWidth: 1
				}]
			},
			options: {
				scales: {
					y: {
						beginAtZero: true
					}
				}
			}
		});
		</script>



</body>
</html>


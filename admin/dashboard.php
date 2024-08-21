<?php 
require_once "include/header.php";
require_once "../connection.php";

// database connection
$currentDay = date('Y-m-d', strtotime("today"));
$tomarrow = date('Y-m-d', strtotime("+1 day"));

$today_leave = 0;
$tomarrow_leave = 0;
$this_week = 0;
$next_week = 0;
$i = 1;

// total admin
$select_admins = "SELECT * FROM admin";
$total_admins = mysqli_query($conn, $select_admins);

// total employee
$select_emp = "SELECT * FROM employee";
$total_emp = mysqli_query($conn, $select_emp);

// employee on leave
$emp_leave = "SELECT * FROM emp_leave";
$total_leaves = mysqli_query($conn, $emp_leave);

if (mysqli_num_rows($total_leaves) > 0) {
    while ($leave = mysqli_fetch_assoc($total_leaves)) {
        $leave_date = $leave["start_date"];

        //daywise
        if ($currentDay == $leave_date) {
            $today_leave += 1;
        } elseif ($tomarrow == $leave_date) {
            $tomarrow_leave += 1;
        }
    }
}

// highest paid employee
$sql_highest_salary = "SELECT * FROM employee ORDER BY salary DESC";
$emp_ = mysqli_query($conn, $sql_highest_salary);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard CV.Immanuel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
        }
        .card:hover {
            transform: translateY(-5px);
        }
        .card-header {
            background-color: #007bff;
            color: white;
            border-radius: 10px 10px 0 0;
        }
        .table {
            border-radius: 10px;
            overflow: hidden;
        }
        .table thead th {
            background-color: #007bff;
            color: white;
        }
    </style>
</head>
<body>

<div class="container mt-4">
    <h1 class="text-center mb-4">Dashboard CV.Immanuel</h1>

    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0"><i class="fas fa-user-tie me-2"></i>Admin</h5>
                </div>
                <div class="card-body">
                    <h2 class="card-text"><?php echo mysqli_num_rows($total_admins); ?></h2>
                    <p class="card-text">Total Admin</p>
                    <a href="manage-admin.php" class="btn btn-primary btn-sm">Lihat Semua Admin</a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0"><i class="fas fa-users me-2"></i>Karyawan</h5>
                </div>
                <div class="card-body">
                    <h2 class="card-text"><?php echo mysqli_num_rows($total_emp); ?></h2>
                    <p class="card-text">Total Karyawan</p>
                    <a href="manage-employee.php" class="btn btn-primary btn-sm">Lihat Semua Karyawan</a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0"><i class="fas fa-calendar-alt me-2"></i>Karyawan Cuti</h5>
                </div>
                <div class="card-body">
                    <p class="card-text">Hari Ini: <?php echo $today_leave; ?></p>
                    <p class="card-text">Besok: <?php echo $tomarrow_leave; ?></p>
                </div>
            </div>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-header">
            <h5 class="card-title mb-0"><i class="fas fa-list me-2"></i>List Karyawan CV.Immanuel</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">S.No.</th>
                            <th scope="col">Id Karyawan</th>
                            <th scope="col">Nama Karyawan</th>
                            <th scope="col">Email Karyawan</th>
                            <th scope="col">Gaji Pokok</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $i = 1;
                        while ($emp_info = mysqli_fetch_assoc($emp_)) {
                            $salary = number_format($emp_info["salary"], 0, ',', '.'); // Format gaji sebagai angka yang jelas
                            echo "<tr>";
                            echo "<th>" . $i . ".</th>";
                            echo "<th>" . $emp_info["id"] . "</th>";
                            echo "<td>" . $emp_info["name"] . "</td>";
                            echo "<td>" . $emp_info["email"] . "</td>";
                            echo "<td>Rp " . $salary . "</td>"; // Menambahkan prefix Rp untuk format mata uang Indonesia
                            echo "</tr>";
                            $i++;
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php 
require_once "include/footer.php";
?>
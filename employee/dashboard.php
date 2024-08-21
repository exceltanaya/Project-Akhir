<?php
require_once "include/header.php";
require_once "../connection.php";

$i = 1;

// Initialize counters
$total_accepted = $total_pending = $total_canceled = $total_applied = 0;

// Fetch applied leaves
$leave_query = "SELECT * FROM emp_leave WHERE email = '$_SESSION[email_emp]'";
$leave_result = mysqli_query($conn, $leave_query);

if (mysqli_num_rows($leave_result) > 0) {
    $total_applied = mysqli_num_rows($leave_result);

    while ($leave_info = mysqli_fetch_assoc($leave_result)) {
        $status = $leave_info["status"];

        if ($status == "pending") {
            $total_pending += 1;
        } elseif ($status == "Accepted") {
            $total_accepted += 1;
        } elseif ($status == "Canceled") {
            $total_canceled += 1;
        }
    }
} else {
    $total_accepted = $total_pending = $total_canceled = $total_applied = 0;
}

// Get leave status
$currentDay = date('Y-m-d');
$last_leave_status = "Tidak Ada Cuti Yang Diajukan";
$upcoming_leave_status = "";

// Last leave status
$last_leave_query = "SELECT * FROM emp_leave WHERE email = '$_SESSION[email_emp]'";
$last_leave_result = mysqli_query($conn, $last_leave_query);

if (mysqli_num_rows($last_leave_result) > 0) {
    while ($info = mysqli_fetch_assoc($last_leave_result)) {
        $last_leave_status = $info["status"];
    }
}

// Next leave date
$next_leave_query = "SELECT * FROM emp_leave WHERE email = '$_SESSION[email_emp]' ORDER BY start_date ASC";
$next_leave_result = mysqli_query($conn, $next_leave_query);

if (mysqli_num_rows($next_leave_result) > 0) {
    while ($info = mysqli_fetch_assoc($next_leave_result)) {
        $date = $info["start_date"];
        $last_leave = $info["status"];
        if ($date > $currentDay && $last_leave == "Accepted") {
            $upcoming_leave_status = date('jS F', strtotime($date));
            break;
        }
    }
}

// Total employees
$total_emp_query = "SELECT * FROM employee";
$total_emp_result = mysqli_query($conn, $total_emp_query);

// Highest paid employee
$highest_salary_query = "SELECT * FROM employee ORDER BY salary DESC";
$highest_salary_result = mysqli_query($conn, $highest_salary_query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - CV. IMMANUEL</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .card-header {
            background-color: #007bff;
            color: white;
            border-radius: 10px 10px 0 0;
        }
        .card-body {
            padding: 1.5rem;
        }
        .table thead th {
            background-color: #007bff;
            color: white;
        }
    </style>
</head>
<body>

<div class="container mt-4">
    <div class="row mb-4">
        <div class="col-md-4 mb-3">
            <div class="card shadow">
                <div class="card-header text-center">
                    <h5 class="mb-0">Tinggalkan Status</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Cuti mendatang: <?php echo $upcoming_leave_status; ?></li>
                        <li class="list-group-item">Status Cuti Terakhir: <?php echo ucwords($last_leave_status); ?></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card shadow">
                <div class="card-header text-center">
                    <h5 class="mb-0">Pengajuan Cuti</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Total Diterima: <?php echo $total_accepted; ?></li>
                        <li class="list-group-item">Total Ditolak: <?php echo $total_canceled; ?></li>
                        <li class="list-group-item">Total Ditunda: <?php echo $total_pending; ?></li>
                        <li class="list-group-item">Total Diajukan: <?php echo $total_applied; ?></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card shadow">
                <div class="card-header text-center">
                    <h5 class="mb-0">Karyawan</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Total Karyawan: <?php echo mysqli_num_rows($total_emp_result); ?></li>
                        <li class="list-group-item text-center">
                            <a href="view-employee.php"><b>Lihat semua karyawan</b></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="text-center my-3">
                <h4>Daftar Karyawan</h4>
            </div>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Id Karyawan</th>
                            <th scope="col">Nama Karyawan</th>
                            <th scope="col">Email Karyawan</th>
                            <th scope="col">Gaji Pokok</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php while ($emp_info = mysqli_fetch_assoc($highest_salary_result)) {
                            $emp_id = $emp_info["id"];
                            $emp_name = $emp_info["name"];
                            $emp_email = $emp_info["email"];
                            $emp_salary = number_format($emp_info["salary"], 2, ',', '.'); // Format salary
                        ?>
                        <tr>
                            <th scope="row"><?php echo $i++; ?></th>
                            <td><?php echo $emp_id; ?></td>
                            <td><?php echo $emp_name; ?></td>
                            <td><?php echo $emp_email; ?></td>
                            <td>Rp <?php echo $emp_salary; ?></td> <!-- Display salary with currency symbol -->
                        </tr>
                        <?php } ?>
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

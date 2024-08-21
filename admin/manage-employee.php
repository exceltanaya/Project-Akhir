<?php 
require_once "include/header.php";
require_once "../connection.php";

$sql = "SELECT * FROM employee";
$result = mysqli_query($conn, $sql);

$i = 1;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Employees - CV. IMMANUEL</title>
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
        .btn-action {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
        }
        .btn-action i {
            margin-right: 0.25rem;
        }
        .table td, .table th {
            vertical-align: middle;
        }
    </style>
</head>
<body>

<div class="container mt-4">
    <div class="card">
        <div class="card-header">
            <h4 class="mb-0">Karyawan CV. IMMANUEL</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>S.No.</th>
                            <th>ID Karyawan</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Jenis Kelamin</th>
                            <th>Tanggal Lahir</th>
                            <th>Usia di Tahun Ini</th>
                            <th>Gaji</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        if (mysqli_num_rows($result) > 0) {
                            while ($rows = mysqli_fetch_assoc($result)) {
                                $name = $rows["name"];
                                $email = $rows["email"];
                                $dob = $rows["dob"];
                                $gender = $rows["gender"];
                                $id = $rows["id"];
                                $salary = $rows["salary"];

                                $gender = $gender ?: "Not Defined";
                                
                                if ($dob == "") {
                                    $dob = "Not Defined";
                                    $age = "Not Defined";
                                } else {
                                    $dob = date('jS F, Y', strtotime($dob));
                                    $dateOfBirth = new DateTime($rows["dob"]);
                                    $today = new DateTime();
                                    $age = $today->diff($dateOfBirth)->y;
                                }

                                $salary = $salary ? number_format($salary, 0, ',', '.') : "Not Defined";
                        ?>
                        <tr>
                            <td><?php echo $i++; ?></td>
                            <td><?php echo $id; ?></td>
                            <td><?php echo $name; ?></td>
                            <td><?php echo $email; ?></td>
                            <td><?php echo $gender; ?></td>
                            <td><?php echo $dob; ?></td>
                            <td><?php echo $age; ?></td>
                            <td>Rp <?php echo $salary; ?></td>
                            <td>
                                <a href='edit-employee.php?id=<?php echo $id; ?>' class='btn btn-primary btn-action me-2'>
                                    <i class='fas fa-edit'></i>Edit
                                </a>
                                <a href='delete-employee.php?id=<?php echo $id; ?>' class='btn btn-danger btn-action'>
                                    <i class='fas fa-trash'></i>Delete
                                </a>
                            </td>
                        </tr>
                        <?php 
                            }
                        } else {
                            echo "<tr><td colspan='9' class='text-center'>No Employees Found!</td></tr>";
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

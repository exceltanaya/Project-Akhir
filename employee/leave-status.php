<?php
require_once "include/header.php";
require_once "../connection.php";

$email = $_SESSION["email_emp"];
$sql = "SELECT * FROM emp_leave WHERE email = '$email'";
$result = mysqli_query($conn, $sql);

$i = 1;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Cuti - CV. IMMANUEL</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .table thead th {
            background-color: #007bff;
            color: white;
        }
        .table td, .table th {
            text-align: center;
        }
    </style>
</head>
<body>
<div class="container bg-white shadow mt-5">
    <div class="py-4">
        <h4 class="text-center pb-3">Status Cuti</h4>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal Mulai</th>
                    <th>Tanggal Berakhir</th>
                    <th>Total Hari</th>
                    <th>Alasan</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (mysqli_num_rows($result) > 0) {
                    while ($rows = mysqli_fetch_assoc($result)) {
                        $start_date = $rows["start_date"];
                        $last_date = $rows["last_date"];
                        $reason = $rows["reason"];
                        $status = $rows["status"];
                        $date1 = date_create($start_date);
                        $date2 = date_create($last_date);
                        $diff = date_diff($date1, $date2);
                ?>
                    <tr>
                        <td><?php echo $i++; ?></td>
                        <td><?php echo date("jS F", strtotime($start_date)); ?></td>
                        <td><?php echo date("jS F", strtotime($last_date)); ?></td>
                        <td><?php echo $diff->format("%a days"); ?></td>
                        <td><?php echo htmlspecialchars($reason); ?></td>
                        <td><?php echo htmlspecialchars($status); ?></td>
                    </tr>
                <?php
                    }
                } else {
                ?>
                    <tr>
                        <td colspan="6" class="text-center">Tidak Ada Cuti Yang Diajukan!</td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
require_once "include/footer.php";
?>

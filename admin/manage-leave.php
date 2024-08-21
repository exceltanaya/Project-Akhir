<?php
require_once "include/header.php";
require_once "../connection.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request Cuti - CV. IMMANUEL</title>
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
        .pdf-icon {
            display: flex;
            justify-content: flex-start;
            align-items: center;
            margin-bottom: 20px;
        }
        .pdf-icon a {
            display: flex;
            align-items: center;
        }
        .pdf-icon i {
            margin-right: 0.5rem;
        }
    </style>
</head>
<body>

<div class="container mt-4">
    <div class="card">
        <div class="card-header">
            <h4 class="mb-0">Request Cuti</h4>
        </div>
        <div class="card-body">
            <div class="pdf-icon mb-4">
                <a href="generate-pdf.php" class="btn btn-outline-danger">
                    <i class="fas fa-file-pdf"></i> Generate PDF
                </a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Email Karyawan</th>
                            <th>Tanggal Mulai</th>
                            <th>Tanggal Berakhir</th>
                            <th>Total Hari</th>
                            <th>Alasan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT * FROM emp_leave ORDER BY status DESC";
                        $result = mysqli_query($conn, $sql);
                        $i = 1;
                        if (mysqli_num_rows($result) > 0) {
                            while ($rows = mysqli_fetch_assoc($result)) {
                                $id = $rows["id"];
                                $email = $rows["email"];
                                $start_date = $rows["start_date"];
                                $last_date = $rows["last_date"];
                                $reason = $rows["reason"];
                                $status = $rows["status"];
                                
                                // Format tanggal
                                $start_date_formatted = date("jS F, Y", strtotime($start_date));
                                $last_date_formatted = date("jS F, Y", strtotime($last_date));
                                
                                // Hitung total hari
                                $date1 = new DateTime($start_date);
                                $date2 = new DateTime($last_date);
                                $diff = $date1->diff($date2);
                                $total_days = $diff->days;

                                // Tampilkan baris tabel
                                ?>
                                <tr>
                                    <td><?php echo $i++; ?></td>
                                    <td><?php echo $email; ?></td>
                                    <td><?php echo $start_date_formatted; ?></td>
                                    <td><?php echo $last_date_formatted; ?></td>
                                    <td><?php echo $total_days . ' days'; ?></td>
                                    <td><?php echo $reason; ?></td>
                                    <td><?php echo ucfirst($status); ?></td>
                                    <td>
                                        <?php
                                        if ($status == 'pending') {
                                            echo "<a href='accept-leave.php?id={$id}' class='btn btn-sm btn-outline-primary me-2'>Accept</a>";
                                            echo "<a href='cancel-leave.php?id={$id}' class='btn btn-sm btn-outline-danger me-2'>Cancel</a>";
                                        }
                                        echo "<a href='delete-leave.php?id={$id}' class='btn btn-sm btn-outline-danger' onclick='return confirm(\"Are you sure you want to delete this record?\");'>Delete</a>";
                                        ?>
                                    </td>
                                </tr>
                                <?php
                            }
                        } else {
                            echo "<tr><td colspan='8' class='text-center'>No Leave Requests Found</td></tr>";
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

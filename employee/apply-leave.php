<?php
require_once "include/header.php";

$reasonErr = $startdateErr = $lastdateErr = "";
$reason = $startdate = $lastdate = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_REQUEST["reason"])) {
        $reasonErr = "<div class='text-danger'>* Alasan Diperlukan</div>";
    } else {
        $reason = $_REQUEST["reason"];
    }

    if (empty($_REQUEST["startDate"])) {
        $startdateErr = "<div class='text-danger'>* Tanggal Mulai Diperlukan</div>";
    } else {
        $startdate = $_REQUEST["startDate"];
    }

    if (empty($_REQUEST["lastDate"])) {
        $lastdateErr = "<div class='text-danger'>* Tanggal Berakhir Diperlukan</div>";
    } else {
        $lastdate = $_REQUEST["lastDate"];
    }

    if (!empty($reason) && !empty($startdate) && !empty($lastdate)) {
        // database connection 
        require_once "../connection.php";

        $sql = "INSERT INTO emp_leave(reason, start_date, last_date, email, status) VALUES('$reason', '$startdate', '$lastdate', '$_SESSION[email_emp]', 'pending')";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            $reason = $startdate = $lastdate = "";
            echo "<script>
                $(document).ready(function(){
                    $('#showModal').modal('show');
                    $('#addMsg').text('Cuti Diajukan, Tunggu Konfirmasi!');
                    $('#linkBtn').attr('href', 'leave-status.php');
                    $('#linkBtn').text('Cek Status Cuti');
                    $('#closeBtn').text('Ajukan Lagi');
                });
            </script>";
        }
    }
}
?>

<!-- Include Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container h-100 mt-5">
    <div class="row justify-content-center align-items-center h-100">
        <div class="col-md-6">
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white text-center">
                    <h4>Mengajukan Cuti</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                        <div class="mb-3">
                            <label for="reason" class="form-label">Alasan:</label>
                            <input type="text" class="form-control" id="reason" name="reason" value="<?php echo $reason; ?>">
                            <?php echo $reasonErr; ?>
                        </div>
                        <div class="mb-3">
                            <label for="startDate" class="form-label">Tanggal Mulai:</label>
                            <input type="date" class="form-control" id="startDate" name="startDate" value="<?php echo $startdate; ?>">
                            <?php echo $startdateErr; ?>
                        </div>
                        <div class="mb-3">
                            <label for="lastDate" class="form-label">Tanggal Berakhir:</label>
                            <input type="date" class="form-control" id="lastDate" name="lastDate" value="<?php echo $lastdate; ?>">
                            <?php echo $lastdateErr; ?>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Ajukan Sekarang</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include Bootstrap JS and dependencies -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<?php 
require_once "include/footer.php";
?>

<?php 
    require_once "include/header.php";
    require_once "../connection.php";

    $sql = "SELECT * FROM employee";
    $result = mysqli_query($conn, $sql);

    $i = 1;
?>

<!-- Include Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-5">
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white text-center">
            <h4>Semua Karyawan</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover text-center">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th>No</th>
                            <th>Id Karyawan</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Jenis Kelamin</th>
                            <th>Tanggal Lahir</th>
                            <th>Usia</th>
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

                                if ($gender == "") {
                                    $gender = "Not Defined";
                                }

                                if ($dob == "") {
                                    $dob = "Not Defined";
                                    $age = "Not Defined";
                                } else {
                                    $date1 = date_create($dob);
                                    $date2 = date_create("now");
                                    $diff = date_diff($date1, $date2);
                                    $age = $diff->format("%y Years");
                                }

                                if ($email == $_SESSION["email_emp"]) {
                                    $name = "{$name} (You)";
                                }
                        ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo $id; ?></td>
                                <td><?php echo $name; ?></td>
                                <td><?php echo $email; ?></td>
                                <td><?php echo $gender; ?></td>
                                <td><?php echo $dob; ?></td>
                                <td><?php echo $age; ?></td>
                            </tr>
                        <?php 
                                $i++;
                            }
                        } else {
                            echo "<tr><td colspan='7'>No employees found</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Include Bootstrap JS and dependencies -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<?php 
    require_once "include/footer.php";
?>

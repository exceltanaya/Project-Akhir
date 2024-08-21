<?php
require_once "include/header.php";
?>

<?php
// database connection
require_once "../connection.php";

$session_email =  $_SESSION["email"];
$sql = "SELECT * FROM admin WHERE email= '$session_email' ";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    while ($rows = mysqli_fetch_assoc($result)) {
        $name = $rows["name"];
        $email = $rows["email"];
        $dob = $rows["dob"];
        $gender = $rows["gender"];
    }
}

$nameErr = $emailErr = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty($_REQUEST["gender"])) {
        $gender = "";
    } else {
        $gender = $_REQUEST["gender"];
    }

    if (empty($_REQUEST["dob"])) {
        $dob = "";
    } else {
        $dob = $_REQUEST["dob"];
    }

    if (empty($_REQUEST["name"])) {
        $nameErr = "<p style='color:red'> * Nama Diperlukan</p>";
        $name = "";
    } else {
        $name = $_REQUEST["name"];
    }

    if (empty($_REQUEST["email"])) {
        $emailErr = "<p style='color:red'> * Email Diperlukan</p> ";
        $email = "";
    } else {
        $email = $_REQUEST["email"];
    }

    if (!empty($name) && !empty($email)) {
        // Check if the email already exists in the database except for the current user's email
        $sql_select_query = "SELECT email FROM admin WHERE email = '$email' AND email != '$session_email' ";
        $r = mysqli_query($conn, $sql_select_query);

        if (mysqli_num_rows($r) > 0) {
            $emailErr = "<p style='color:red'> * Email Already Register</p>";
        } else {
            $sql = "UPDATE admin SET name = '$name', email = '$email', dob = '$dob', gender= '$gender' WHERE email='$session_email' ";
            $result = mysqli_query($conn, $sql);
            if ($result) {
                $_SESSION['email'] = $email;
                echo "<script>
                        $(document).ready( function(){
                            $('#showModal').modal('show');
                            $('#modalHead').hide();
                            $('#linkBtn').attr('href', 'profile.php');
                            $('#linkBtn').text('Lihat Profil');
                            $('#addMsg').text('Profil Berhasil Di Ubah!!');
                            $('#closeBtn').hide();
                        })
                    </script>";
            }
        }
    }
}
?>

<div style="">
    <div class="login-form-bg h-100">
        <div class="container mt-5 h-100">
            <div class="row justify-content-center h-100">
                <div class="col-xl-6">
                    <div class="form-input-content">
                        <div class="card login-form mb-0">
                            <div class="card-body pt-5 shadow">
                                <h4 class="text-center">Ubah Profil Anda</h4>
                                <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                                    <div class="form-group">
                                        <label>Nama Lengkap :</label>
                                        <input type="text" class="form-control" value="<?php echo $name; ?>" name="name">
                                        <?php echo $nameErr; ?>
                                    </div>

                                    <div class="form-group">
                                        <label>Email :</label>
                                        <input type="email" class="form-control" value="<?php echo $email; ?>" name="email">
                                        <?php echo $emailErr; ?>
                                    </div>

                                    <div class="form-group">
                                        <label>Tanggal Lahir :</label>
                                        <input type="date" class="form-control" value="<?php echo $dob; ?>" name="dob">
                                    </div>

                                    <div class="form-group form-check form-check-inline">
                                        <label class="form-check-label">Jenis kelamin :</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="gender" <?php if ($gender == "Male") {
                                                                                                        echo "checked";
                                                                                                    } ?> value="Male" selected>
                                        <label class="form-check-label">Pria</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="gender" <?php if ($gender == "Female") {
                                                                                                        echo "checked";
                                                                                                    } ?> value="Female">
                                        <label class="form-check-label">Wanita</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="gender" <?php if ($gender == "Other") {
                                                                                                        echo "checked";
                                                                                                    } ?> value="Other">
                                        <label class="form-check-label">Lainnya</label>
                                    </div>

                                    <div class="btn-toolbar justify-content-between" role="toolbar" aria-label="Toolbar with button groups">
                                        <div class="btn-group">
                                            <input type="submit" value="Simpan Perubahan" class="btn btn-primary w-20" name="save_changes">
                                        </div>
                                        <div class="input-group">
                                            <a href="profile.php" class="btn btn-primary w-20">Tutup</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
require_once "include/footer.php";
?>
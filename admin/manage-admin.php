<?php 
require_once "include/header.php";
require_once "../connection.php";

$sql = "SELECT * FROM admin";
$result = mysqli_query($conn, $sql);

$i = 1;
?>

<!-- Menggunakan Bootstrap untuk styling -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ4u7Iu4HcUqA6Q55zBLM4zFmlH8yXy/JEdFTU15J5iP9tPz4yGmZlA1lB" crossorigin="anonymous">

<div class="container my-5 bg-light p-4 rounded shadow">
    <div class="text-center mb-4">
        <h4>Kelola Admin</h4>
        <a href="add-admin.php" class="btn btn-primary">Tambah Admin</a>
    </div>

    <?php if (mysqli_num_rows($result) > 0): ?>
        <table class="table table-hover table-striped text-center">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Jenis Kelamin</th>
                    <th>Tanggal Lahir</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($rows = mysqli_fetch_assoc($result)): ?>
                    <?php
                    $name = $rows["name"];
                    $email = $rows["email"];
                    $dob = $rows["dob"];
                    $gender = $rows["gender"];
                    $id = $rows["id"];

                    $gender = $gender ?: "Not Defined";
                    $dob = $dob ? date('jS F, Y', strtotime($dob)) : "Not Defined";
                    ?>
                    <tr>
                        <td><?php echo $i++; ?></td>
                        <td><?php echo $name; ?></td>
                        <td><?php echo $email; ?></td>
                        <td><?php echo $gender; ?></td>
                        <td><?php echo $dob; ?></td>
                        <td>
                            <?php if ($email !== $_SESSION["email"]): ?>
                                <a href='edit-admin.php?id=<?php echo $id; ?>' class='btn btn-warning btn-sm me-2'>
                                    <i class='fa fa-edit'></i> Edit
                                </a>
                                <a href='delete-admin.php?id=<?php echo $id; ?>' class='btn btn-danger btn-sm'>
                                    <i class='fa fa-trash'></i> Delete
                                </a>
                            <?php else: ?>
                                <a href='profile.php' class='btn btn-info btn-sm'>
                                    <i class='fa fa-user'></i> Profile
                                </a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="alert alert-warning text-center" role="alert">
            Tidak ada admin yang ditemukan. <a href="add-admin.php" class="btn btn-primary ms-2">Tambah Admin</a>
        </div>
    <?php endif; ?>
</div>

<!-- Memuat JavaScript Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-8MOhF67K6Y5yfCRLZhZT8B6PtJOFy9tFymQ5rK9i6IX5vD6Kj9vCF5g5gU8gm4Z8" crossorigin="anonymous"></script>

<?php 
require_once "include/footer.php";
?>

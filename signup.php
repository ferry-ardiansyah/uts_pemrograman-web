# codingan signup.php
```php
<?php
require 'connect.php';

function signUp($data)
{
    global $connect;

    $username = $data["username_member"];
    $nama = strtolower($data["nama_member"]);
    $password = mysqli_real_escape_string($connect, $data["password"]);
    $confirmPw = mysqli_real_escape_string($connect, $data["confirmPw"]);
    $jk = $data["jenis_kelamin"];
    $pekerjaan = $data["pekerjaan"];
    $jabatan = $data["jabatan"];
    $noTlp = $data["no_telepon"];

    // cek username sudah ada atau belum
    $nisnResult = mysqli_query($connect, "SELECT username_member FROM member WHERE username_member = '$username'");
    if (mysqli_fetch_assoc($nisnResult)) {
        echo "<script>
        alert('Username sudah terdaftar, silahkan gunakan Username lain!');
        </script>";
        return 0;
    }

    // Pengecekan kesamaan confirm password dan password
    if ($password !== $confirmPw) {
        echo "<script>
        alert('password / confirm password tidak sesuai');
        </script>";
        return 0;
    }

    // Enkripsi password
    $password = password_hash($password, PASSWORD_DEFAULT);

    $querySignUp = "INSERT INTO member (username_member, nama_member, password, jenis_kelamin, pekerjaan, jabatan, no_telepon) 
                    VALUES ('$username', '$nama', '$password', '$jk', '$pekerjaan', '$jabatan', '$noTlp')";
    mysqli_query($connect, $querySignUp);
    return mysqli_affected_rows($connect);
}

if (isset($_POST["signUp"])) {
    if (signUp($_POST) > 0) {
        echo "<script>
        alert('Sign Up berhasil!');
        window.location.href = 'login.php';
        </script>";
    } else {
        echo "<script>
        alert('Sign Up gagal!');
        </script>";
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign Up</title>
    <link rel="stylesheet" href="../style/signup.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <div class="wrapper">
        <form class="needs-validation justify-content-center" action="signup.php" method="post" novalidate>
            <h1>SIGN <span style="color:white">UP</span></h1>
            <div class="input-box">
                <input type="text" name="username_member" placeholder="Username/Email" required>
                <div class="invalid-feedback">Username/Email is required.</div>
            </div>
            <div class="input-box">
                <input type="text" name="nama_member" placeholder="Nama" required>
                <div class="invalid-feedback">Nama is required.</div>
            </div>
            <div class="input-box">
                <input type="password" name="password" placeholder="Password" id="validationCustom02" required>
                <div class="invalid-feedback">Password is required.</div>
            </div>
            <div class="input-box">
                <input type="password" name="confirmPw" placeholder="Confirm Password" id="validationCustom02" required>
                <div class="invalid-feedback">Confirm Password is required.</div>
            </div>
            <div class="input-box">
                <select id="gender" name="jenis_kelamin" required>
                    <option value="" disabled selected class="text-black"
                        style="background-color: white; color: black;">Pilih jenis kelamin</option>
                    <option value="male" style="background-color: white; color: black;">Laki-Laki</option>
                    <option value="female" style="background-color: white; color: black;">Perempuan</option>
                </select>
                <div class="invalid-feedback">Jenis kelamin harus dipilih.</div>
            </div>
            <div class="input-box">
                <input type="text" name="pekerjaan" placeholder="Pekerjaan" required>
                <div class="invalid-feedback">Fakultas is required.</div>
            </div>
            <div class="input-box">
                <input type="text" name="jabatan" placeholder="Jabatan" required>
                <div class="invalid-feedback">Prodi is required.</div>
            </div>
            <div class="input-box">
                <input type="text" name="no_telepon" placeholder="Nomor Telpon" required>
                <div class="invalid-feedback">Nomor Telpon is required.</div>
            </div>
            <button type="submit" class="btn" name="signUp">Sign Up</button>
            <div class="register-link">
                <p>Sudah Memiliki Akun? <a href="login.php">Login</a></p>
            </div>
        </form>
    </div>

    <script>
    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (() => {
        'use strict';

        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        const forms = document.querySelectorAll('.needs-validation');

        // Loop over them and prevent submission
        Array.from(forms).forEach(form => {
            form.addEventListener('submit', event => {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }

                form.classList.add('was-validated');
            }, false);
        });
    })();
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $name = htmlspecialchars($_POST['name']);
    $testimoni = htmlspecialchars($_POST['testimoni']);

    // Proses upload file jika ada
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["photo"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Periksa apakah file yang diupload adalah gambar
    if (!empty($_FILES["photo"]["tmp_name"])) {
        $check = getimagesize($_FILES["photo"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            echo "File bukan gambar.";
            $uploadOk = 0;
        }

        // Periksa apakah file sudah ada
        if (file_exists($target_file)) {
            echo "Maaf, file sudah ada.";
            $uploadOk = 0;
        }

        // Batasi ukuran file
        if ($_FILES["photo"]["size"] > 500000) {
            echo "Maaf, file terlalu besar.";
            $uploadOk = 0;
        }

        // Hanya izinkan format gambar tertentu
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif") {
            echo "Maaf, hanya file JPG, JPEG, PNG & GIF yang diizinkan.";
            $uploadOk = 0;
        }

        // Cek apakah tidak ada kesalahan dan upload file
        if ($uploadOk == 1) {
            if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
                echo "File " . htmlspecialchars(basename($_FILES["photo"]["name"])) . " berhasil diupload.";
            } else {
                echo "Maaf, terjadi kesalahan saat mengupload file.";
            }
        }
    }

    // Simpan testimoni ke dalam file (atau ke database)
    $file = fopen("testimoni.txt", "a");
    fwrite($file, "Nama: $name\nTestimoni: $testimoni\n\n");
    fclose($file);

    echo "Terima kasih atas testimoni Anda!";
}
?>

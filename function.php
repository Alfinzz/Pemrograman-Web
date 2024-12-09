<?php
session_start();
$env = parse_ini_file('.env');
$dbHost = $env["DB_HOST"];
$dbUsername = $env["DB_USERNAME"];
$dbPassword = $env["DB_PASSWORD"];
$dbName = $env["DB_NAME"];

$conn = mysqli_connect($dbHost, $dbUsername, $dbPassword, $dbName);

// tambah barang baru
if (isset($_POST['tambahbarangbaru'])) {
    $namabarang = $_POST['namabarang'];
    $deskripsi = $_POST['deskripsi'];
    $stock = $_POST['stock'];

    //  soal gambar
    $allowed_exstension = array('png', 'jpg');
    $nama = $_FILES['file']['name']; //ambil nama file gambar
    $dot = explode('.', $nama); //ngambil ekstensi
    $ekstensi = strtolower(end($dot));  //ngambil ekstensi
    $ukuran = $_FILES['file']['size']; //ngambil size fil
    $file_tmp = $_FILES['file']['tmp_name']; //ngambil lokasi filenya

    //penamaan file -> enkripsi
    $image = md5(uniqid($nama, true) . time()) . '.' . $ekstensi; // menggabungkan nama file yg dienkrpipsi dgn ekstensi
    // validasi udah ada atau belum
    $cek = mysqli_query($conn, "select *from stock where namabarang='$namabarang'");
    $hitung = mysqli_num_rows($cek);

    if ($hitung < 1) {
        // jika belum ada
        // proses upload gambar
        if (in_array($ekstensi, $allowed_exstension) == true) {
            //validasi ukuran filenya
            if ($ukuran < 15000000) {
                if (move_uploaded_file($file_tmp, 'images/' . $image)) {
                    $addtotable = mysqli_query($conn, "INSERT INTO stock (namabarang, deskripsi, stock, image) VALUES ('$namabarang', '$deskripsi', '$stock', '$image')");

                    if ($addtotable) {
                        header('Location: index.php');
                        exit();
                    } else {
                        echo '<script>
                            alert("Gagal menambahkan data.");
                            window.location.href="index.php";
                        </script>';
                        exit();
                    }
                } else {
                    echo '<script>
                        alert("Gagal mengunggah gambar.");
                        window.location.href="index.php";
                    </script>';
                }
            } else {
                // jika file lebih dari 15 MB
                echo '<script>
                    alert("Ukuran Terlalu Besar");
                    window.location.href="index.php";
                </script>';
            }
        } else {
            // file harus png jpg
            echo '<script>
                alert("File Harus png/jpg");
                window.location.href="index.php";
            </script>';
        }
    } else {
        echo '
    <script>
        alert("Nama barang sudah terdaftar");
        window.location.href="index.php";
    </?script>    
    ';
    }


    $addtotable = mysqli_query($conn, "insert into stock (namabarang, deskripsi, stock) values('$namabarang','$deskripsi', '$stock')");
    if ($addtotable) {
        header('location:index.php');
    } else {
        echo 'Gagal';
        header('location:index.php ');
    }
};
// tambah barang masuk
if (isset($_POST['barangmasuk'])) {
    $barangnya = $_POST['barangnya'];
    $penerima = $_POST['penerima'];
    $qty = $_POST['qty'];

    $cekstocksekarang = mysqli_query($conn, "SELECT * FROM stock WHERE idbarang='$barangnya'");
    $ambildatanya = mysqli_fetch_array($cekstocksekarang);

    $stocksekarang = $ambildatanya['stock'];
    $tambahkanstocksekarangdenganquantity = $stocksekarang + $qty;

    $addtomasuk = mysqli_query($conn, "INSERT INTO masuk (idbarang, keterangan, qty) VALUES ('$barangnya', '$penerima', '$qty')");

    $updatestockmasuk = mysqli_query($conn, "UPDATE stock SET stock = '$tambahkanstocksekarangdenganquantity' WHERE idbarang='$barangnya'");

    if ($addtomasuk && $updatestockmasuk) {
        header('Location: masuk.php');
        exit;
    } else {
        echo 'Gagal';
        exit;
    }
}
// tambah barang keluar
if (isset($_POST['tambahbarangkeluar'])) {
    $barangnya = $_POST['barangnya'];
    $penerima = $_POST['penerima'];
    $qty = $_POST['qty'];

    $cekstocksekarang = mysqli_query($conn, "SELECT * FROM stock WHERE idbarang='$barangnya'");
    $ambildatanya = mysqli_fetch_array($cekstocksekarang);

    $stocksekarang = $ambildatanya['stock'];

    if ($stocksekarang >= $qty) {
        $tambahkanstocksekarangdenganquantity = $stocksekarang - $qty;

        $addtokeluar = mysqli_query($conn, "INSERT INTO keluar (idbarang, penerima, qty) VALUES ('$barangnya', '$penerima', '$qty')");

        $updatestockmasuk = mysqli_query($conn, "UPDATE stock SET stock = '$tambahkanstocksekarangdenganquantity' WHERE idbarang='$barangnya'");

        if ($addtokeluar && $updatestockmasuk) {
            header('Location: keluar.php');
            exit;
        } else {
            echo 'Gagal';
            exit;
        }
    } else {
        echo '
      <script>
        alert("Stock daat ini tidak mencukupi")
        window.location.href="keluar.php"
      </script>
      ';
    }
}

// update info barang
if (isset($_POST['updatebarang'])) {
    $idb = $_POST['idb'];
    $namabarang = $_POST['namabarang'];
    $deskripsi = $_POST['deskripsi'];
    $allowed_exstension = array('png', 'jpg');
    $nama = $_FILES['file']['name']; //ambil nama file gambar
    $dot = explode('.', $nama); //ngambil ekstensi
    $ekstensi = strtolower(end($dot));  //ngambil ekstensi
    $ukuran = $_FILES['file']['size']; //ngambil size fil
    $file_tmp = $_FILES['file']['tmp_name']; //ngambil lokasi filenya

    //penamaan file -> enkripsi
    $image = md5(uniqid($nama, true) . time()) . '.' . $ekstensi; // menggabungkan nama file yg dienkrpipsi dgn ekstensi

    if ($ukuran == 0) {
        //jika tidak ingin upload
        $update = mysqli_query($conn, "update stock set namabarang='$namabarang', deskripsi='$deskripsi' where idbarang = '$idb'");
        if ($update) {
            header('Location: index.php');
            exit;
        } else {
            echo 'Gagal: ' . mysqli_error($conn);
            exit;
        }
    } else {
        // jika ingin
        if (move_uploaded_file($file_tmp, 'images/' . $image)) {
            $update = mysqli_query($conn, "update stock set namabarang='$namabarang', deskripsi='$deskripsi', image='$image' where idbarang = '$idb'");
            if ($update) {
                header('Location: index.php');
                exit;
            } else {
                echo 'Gagal: ' . mysqli_error($conn);
                exit;
            }
        } else {
            echo 'gagal upload gambar';
            exit;
        }
    }
}
// hapus barang stock
if (isset($_POST['deletebarang'])) {
    $idb = $_POST['idbarang'];

    $gambar = mysqli_query($conn, "select * from stock where idbarang='$idb'");
    $get = mysqli_fetch_array($gambar);
    $img = 'images/' . $get['image'];
    unlink($img);

    $hapus = mysqli_query($conn, "delete from stock where idbarang = '$idb'");
    if ($hapus) {
        header('Location: index.php');
        exit;
    } else {
        echo 'Gagal: ' . mysqli_error($conn);
        exit;
    }
}

// ubah data barang masuk
if (isset($_POST['updatebarangmasuk'])) {
    $idb = $_POST['idb'];
    $idm = $_POST['idm'];
    $deskripsi = $_POST['keterangan'];
    $qty = $_POST['qty'];

    $lihatstock = mysqli_query($conn, "SELECT * FROM stock WHERE idbarang = '$idb'");
    $stocknya = mysqli_fetch_array($lihatstock);
    $stockskrg = $stocknya['stock'];

    $qtyskrg = mysqli_query($conn, "SELECT * FROM masuk WHERE idmasuk = '$idm'");
    $qtynya = mysqli_fetch_array($qtyskrg);
    $qtyskrg = $qtynya['qty'];

    if ($qty > $qtyskrg) {
        $selisih = $qty - $qtyskrg;
        $kurangin = $stockskrg + $selisih;

        $kurangistocknya = mysqli_query($conn, "UPDATE stock SET stock='$kurangin' WHERE idbarang='$idb'");
        $updatenya = mysqli_query($conn, "UPDATE masuk SET qty='$qty', keterangan='$deskripsi' WHERE idmasuk='$idm'");

        if ($kurangistocknya && $updatenya) {
            header('Location: masuk.php');
            exit;
        } else {
            echo 'Gagal: ' . mysqli_error($conn);
            exit;
        }
    } else {
        $selisih = $qtyskrg - $qty;
        $kurangin = $stockskrg - $selisih;

        $kurangistocknya = mysqli_query($conn, "UPDATE stock SET stock='$kurangin' WHERE idbarang='$idb'");
        $updatenya = mysqli_query($conn, "UPDATE masuk SET qty='$qty', keterangan='$deskripsi' WHERE idmasuk='$idm'");

        if ($kurangistocknya && $updatenya) {
            header('Location: masuk.php');
            exit;
        } else {
            echo 'Gagal: ' . mysqli_error($conn);
            exit;
        }
    }
}


// menghapus barang masuk
if (isset($_POST['deletebarangmasuk'])) {
    $idb = $_POST['idb'];
    $qty = $_POST['kty'];
    $idm = $_POST['idm'];

    $getdatastock = mysqli_query($conn, "select * from stock where idbarang='$idb'");
    $data = mysqli_fetch_array($getdatastock);
    $stock = $data['stock'];

    $selisih = $stock - $qty;

    $update = mysqli_query($conn, "Update stock Set stock='$selisih' Where idbarang='$idb'");
    $hapusdata = mysqli_query($conn, "delete from masuk where idmasuk='$idm'");

    if ($update && $hapusdata) {
        header('Location: masuk.php');
        exit;
    } else {
        echo 'Gagal: ' . mysqli_error($conn);
        exit;
    }
}
// mengubah data barang keluar
if (isset($_POST['updatebarangkeluar'])) {
    // Ambil data dari form
    $idk = mysqli_real_escape_string($conn, $_POST['idk']);
    $idb = mysqli_real_escape_string($conn, $_POST['idb']);
    $qty = intval($_POST['qty']);
    $penerima = mysqli_real_escape_string($conn, $_POST['penerima']);

    // Ambil data stok saat ini
    $result = mysqli_query($conn, "SELECT * FROM stock WHERE idbarang = '$idb'");
    $stockData = mysqli_fetch_assoc($result);
    $stockskrg = $stockData['stock'];

    // Ambil data qty saat ini dari tabel keluar
    $resultKeluar = mysqli_query($conn, "SELECT * FROM keluar WHERE idkeluar = '$idk'");
    $qtyData = mysqli_fetch_assoc($resultKeluar);
    $qtyskrg = $qtyData['qty'];

    // Hitung selisih qty
    if ($qty > $qtyskrg) {
        $selisih = $qty - $qtyskrg;
        if ($selisih <= $stockskrg) {
            $stokBaru = $stockskrg - $selisih;
        } else {
            echo '<script>alert("Stock tidak mencukupi"); window.location.href="keluar.php";</script>';
            exit;
        }
    } else {
        $selisih = $qtyskrg - $qty;
        $stokBaru = $stockskrg + $selisih;
    }

    // Update stok dan data barang keluar
    $updateStok = mysqli_query($conn, "UPDATE stock SET stock = '$stokBaru' WHERE idbarang = '$idb'");
    $updateQty = mysqli_query($conn, "UPDATE keluar SET qty = '$qty', penerima = '$penerima' WHERE idkeluar = '$idk'");

    if ($updateStok && $updateQty) {
        header('Location: keluar.php');
        exit;
    } else {
        echo 'Gagal: ' . mysqli_error($conn);
        exit;
    }
}


// menghapus barang keluar
if (isset($_POST['deletebarangkeluar'])) {
    $idb = $_POST['idb'];
    $qty = $_POST['kty'];
    $idk = $_POST['idk'];

    $getdatastock = mysqli_query($conn, "select * from stock where idbarang='$idb'");
    $data = mysqli_fetch_array($getdatastock);
    $stock = $data['stock'];

    $selisih = $stock + $qty;

    $update = mysqli_query($conn, "Update stock Set stock='$selisih' Where idbarang='$idb'");
    $hapusdata = mysqli_query($conn, "delete from keluar where idkeluar='$idk'");

    if ($update && $hapusdata) {
        header('Location: keluar.php');
        exit;
    } else {
        echo 'Gagal: ' . mysqli_error($conn);
        exit;
    }
}

// menambah admin baru
if (isset($_POST['addadmin'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $queryinsert = mysqli_query($conn, "insert into login(email,password) values('$email','$password')");

    if ($queryinsert) {
        header('location:admin.php');
    } else {
        header('location:admin.php');
    }
}


// edit data admin
if (isset($_POST['updateadmin'])) {
    $emailbaru = $_POST['emailadmin'];
    $passwordbaru = $_POST['passwordbaru'];
    $idnya = $_POST['iduser'];

    $queryupdate = mysqli_query($conn, "update login set email='$emailbaru', password='$passwordbaru' where iduser='$idnya'");

    if ($queryupdate) {
        header('location:admin.php');
    } else {
        header('location:admin.php');
    }
}

// hapus data admin
if (isset($_POST['hapusadmin'])) {
    $id = $_POST['iduser'];

    $querydelete = mysqli_query($conn, "delete from login where iduser='$id'");
    if ($querydelete) {
        header('location:admin.php');
    } else {
        header('location:admin.php');
    }
}

// meminjam barang
if (isset($_POST['pinjam'])) {
    $idbarang = $_POST['barangnya']; // mengambil barang dari form
    $qty = $_POST['qty']; // mengambil jumlah quantity
    $penerima = $_POST['penerima']; // mengambil nama penerima

    // ambil stock sekarang
    $stock_saat_ini = mysqli_query($conn, "SELECT * FROM stock WHERE idbarang='$idbarang'");
    $stock_nya = mysqli_fetch_array($stock_saat_ini);
    $stock = $stock_nya['stock']; // nilai stok saat ini

    // kurangin stocknya
    $new_stock = $stock - $qty;

    // mulai query insert
    $insertpinjam = mysqli_query($conn, "INSERT INTO peminjaman (idbarang, qty, peminjam) VALUES ('$idbarang', '$qty', '$penerima')");

    // mengurangi stock di table stock
    $kurangistock = mysqli_query($conn, "UPDATE stock SET stock='$new_stock' WHERE idbarang='$idbarang'");

    if ($insertpinjam && $kurangistock) {
        // jika berhasil
        echo '
        <script>
            alert("Berhasil");
            window.location.href="peminjaman.php";
        </script>
        ';
    } else {
        // jika gagal
        echo '
        <script>
            alert("Gagal");
            window.location.href="peminjaman.php";
        </script>
        ';
    }
}

// menyelesaikan pinjaman
if (isset($_POST['barangkembali'])) {
    $idpinjam = $_POST['idpinjam'];
    $idbarang = $_POST['idbarang'];

    // update status peminjaman
    $update_status = mysqli_query($conn, "UPDATE peminjaman SET status='Kembali' WHERE idpeminjaman='$idpinjam'");

    // ambil stock sekarang
    $stock_saat_ini = mysqli_query($conn, "SELECT * FROM stock WHERE idbarang='$idbarang'");
    $stock_nya = mysqli_fetch_array($stock_saat_ini);
    $stock = $stock_nya['stock']; // nilai stok saat ini

    // ambil qty dari id peminjam sekarang
    $stock_saat_ini1 = mysqli_query($conn, "SELECT * FROM peminjaman WHERE idpeminjaman='$idpinjam'");
    $stock_nya1 = mysqli_fetch_array($stock_saat_ini1);
    $stock1 = $stock_nya1['qty']; // nilai qty yang dipinjam

    // kembalikan stock
    $new_stock = $stock + $stock1;
    $kembalikan_stock = mysqli_query($conn, "UPDATE stock SET stock='$new_stock' WHERE idbarang='$idbarang'");

    if ($update_status && $kembalikan_stock) {
        // jika berhasil
        echo '
        <script>
            alert("Berhasil");
            window.location.href="peminjaman.php";
        </script>
        ';
    } else {
        // jika gagal
        echo '
        <script>
            alert("Gagal");
            window.location.href="peminjaman.php";
        </script>
        ';
    }
}

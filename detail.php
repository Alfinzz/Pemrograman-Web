<?php
require 'function.php'; 
require 'cek.php'; 
// dapetin id barang sebelumnya
$idbarang= $_GET['id']; //get id barang
//get informasi barang berdasarkan database
$get = mysqli_query($conn, "SELECT * FROM stock WHERE idbarang = '$idbarang'");
$fetch = mysqli_fetch_assoc($get);
$namabarang = $fetch['namabarang'];
$deskripsi = $fetch ['deskripsi'];
$stock = $fetch ['stock'];

$gambar = $fetch['image'];
if($gambar==null){

    $img = 'No Photo';
}else{
    $img = '<img src="images/'.$gambar.'" class="zoomable">';

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Stock - Detail Barang</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.css" />
    <link href="css/styles.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <style>
        .zoomable{
           width:  200px;
           height: 200px;
        }
        .zoomable:hover{
            transform: scale(1.5);
            transition: 0.3s ease;
        }

    </style>
</head>
<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand ps-3" href="index.php">Gudang Buah MR</a>
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle"><i class="fas fa-bars"></i></button>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <a class="nav-link" href="index.php">
                            <div class="sb-nav-link-icon"><i class="bi bi-truck"></i></div>
                            Stock Barang
                        </a>
                        <a class="nav-link" href="masuk.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-box-open"></i></div>
                            Barang Masuk
                        </a>
                        <a class="nav-link" href="keluar.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-box"></i></div>
                            Barang Keluar
                        </a>
                        <a class="nav-link" href="admin.php">
                            <div class="sb-nav-link-icon"><i class="bi bi-person-fill"></i></div>
                            Kelola Admin
                        </a>
                        <a class="nav-link" href="logout.php">
                            <div class="sb-nav-link-icon"><i class="bi bi-power"></i></div>
                            Logout
                        </a>
                    </div>
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Detail Barang</h1>
                    
                    <div class="card mb-4 mt-4">
                        <div class="card-header">
                            <div class="d-flex flex-column">
                                <h2><?=$namabarang;?></h2>
                                <?=$img;?>
                            </div>
                        </div>
                        <div class="card-body">
                        <div class="row">
                         <div class="col-md-3"><strong>Deskripsi</strong></div>
                         <div class="col-md-9"><strong>: <?=$deskripsi;?></strong></div>
                        </div>

                        <div class="row">
                         <div class="col-md-3"><strong>Stock</strong></div>
                         <div class="col-md-9"><strong>: <?=$stock;?></strong> </div>
                        </div>

                        <br>
                            
                            <h3>Barang Masuk</h3>
                            <table class="table" id="Barang masuk">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>                                    
                                        <th class="text-center">tanggal</th>
                                        <th class="text-center">keterangan</th>
                                        <th class="text-center">Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $ambildatamasuk = mysqli_query($conn, "select * from masuk where idbarang='$idbarang'");
                                    $i=1;

                                    while($fetch=mysqli_fetch_array($ambildatamasuk)){
                                         $tanggal = $fetch['tanggal'];
                                         $keterangan = $fetch['keterangan'];
                                         $qty = $fetch['qty'];
                                    ?>

                                    <tr>
                                        <td class="text-center"><?= $i++; ?></td>
                                        <td class="text-center"><?= $tanggal; ?></td>
                                        <td class="text-center"><?= $keterangan; ?></td>
                                        <td class="text-center"><?= $qty; ?></td>
                                    </tr>
                                    <?php 
                                     } 
                                    ?>
                                </tbody>
                            </table>
                            <br>
                            <h3>Barang Keluar</h3>
                            <table class="table" id="Barang keluar">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>                                    
                                        <th class="text-center">tanggal</th>
                                        <th class="text-center">Penerima</th>
                                        <th class="text-center">Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $ambildatakeluar = mysqli_query($conn, "select * from keluar where idbarang='$idbarang'");
                                    $i=1;
                                    while($fetch=mysqli_fetch_array($ambildatakeluar)){
                                         $tanggal = $fetch['tanggal'];
                                         $penerima = $fetch['penerima'];
                                         $qty = $fetch['qty'];
                                    ?>

                                    <tr>
                                        <td class="text-center"><?= $i++; ?></td>
                                        <td class="text-center"><?= $tanggal; ?></td>
                                        <td class="text-center"><?= $penerima; ?></td>
                                        <td class="text-center"><?= $qty; ?></td>
                                    </tr>
                                    <?php 
                                     } 
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Your Website 2024</div>
                        <div>
                            <a href="#">Privacy Policy</a>
                            &middot;
                            <a href="#">Terms &amp; Conditions</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <!-- Modal Tambah Barang -->
    <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Tambah Barang</h4>                    
                </div>
                <form method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <input type="hidden" name="tambahbarangbaru" value="true">
                        <input type="text" name="namabarang" placeholder="Nama Barang" class="form-control mb-3" required>
                        <input type="text" name="deskripsi" placeholder="Deskripsi Barang" class="form-control mb-3" required>
                        <input type="number" name="stock" placeholder="Stock" class="form-control mb-3" required>
                        <input type="file" name="file" placeholder="file" class="form-control mb-3" required>
                        <button type="submit" class="btn btn-primary" name="addbarang">Submit</button>
                    </div>
                </form>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
   <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
    <!-- <script src="js/datatables-simple-demo.js"></script> -->


    <script>
        window.addEventListener('DOMContentLoaded', event => {
            const datatablesSimple = document.getElementById('datatablesSimple');
            if (datatablesSimple){
                new DataTable(datatablesSimple, {
                    "paging": false, 
                    "info": false, 
                    "searching": true 
                });
            }
        });
    </script>
</body>
</html>

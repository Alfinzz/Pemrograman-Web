<?php
require 'function.php'; 
require 'cek.php';

//get data
$get1 = mysqli_query($conn,"select * from peminjaman");
$count1 = mysqli_num_rows($get1); //menghitung semua kolom

//ambil data peminjaman yang status dipinjam
$get2 = mysqli_query($conn,"select * from peminjaman where status='Dipinjam'");
$count2 = mysqli_num_rows($get2); //menghitung seluruh kolom status dipinjam

//ambil data peminjaman yg statusnya kembali
$get3 = mysqli_query($conn,"select * from peminjaman where status='Kembali'");
$count3 = mysqli_num_rows($get3); //menghitung seluruh kolom status dipinjam

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Stock - Peminjaman Barang</title>
        <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
        <style>
        .zoomable{
           width:  100px;
        }
        .zoomable:hover{
            transform: scale(2.5);
            transition: 0.3s ease;
        }
    </style>
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3" href="index.php">Gudang Buah MR</a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
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
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Barang Masuk
                            </a>
                            <a class="nav-link" href="keluar.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Barang Keluar
                            </a>
                            <a class="nav-link" href="peminjaman.php">
                                <div class="sb-nav-link-icon"><i class="bi bi-bank"></i></div>
                                Peminjaman Barang
                            </a>
                            <a class="nav-link" href="admin.php">
                                <div class="sb-nav-link-icon"><i class="bi bi-person-fill"></i></div>
                                Kelola Login
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
                        <h1 class="mt-4">Peminjaman Barang</h1>
                        <div class="card mb-4">
                        <div class="card-header">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">
                                Tambah Data
                            </button>
                             <br>
                             <div class="row mt-4">
                                <div class="col">
                                    <div class="card bg-info text-white p-3"><h3>Total Data: <?=$count1;?></h3></div>
                                </div>
                                <div class="col">
                                    <div class="card bg-danger text-white p-3"><h3>Total Dipinjam: <?=$count2;?></h3></div>
                                </div>
                                <div class="col">
                                    <div class="card bg-success text-white p-3"><h3>Total kembali: <?=$count3;?></h3></div>
                                </div>
                             </div>
                            <div class="row mt-4">
                                <div class="col-3">
                                    <form method="post" class="d-flex align-items-center">
                                        <input type="date" name="tgl_mulai" class="form-control mx-1">  
                                        <input type="date" name="tgl_selesai" class="form-control mx-1">  
                                        <button type="submit" name="filter_tgl" class="btn btn-info">Filter</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="datatablesSimple" class="table">
                                <thead>
                                    <tr>
                                        <th class="text-center">Tanggal</th>
                                        <th class="text-center">Gambar</th>
                                        <th class="text-center">Nama Barang</th>
                                        <th class="text-center">Jumlah</th>
                                        <th class="text-center">Kepada</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if(isset($_POST['filter_tgl'])){
                                    $mulai =  $_POST['tgl_mulai'];
                                    $selesai =  $_POST['tgl_selesai'];

                                    if($mulai!=null || $selesai!=null ){

                                      $ambilsemuadatastock = mysqli_query($conn, "SELECT * FROM peminjaman p, stock s where s.idbarang = p.idbarang and tanggal BETWEEN '$mulai' and DATE_ADD('$selesai',INTERVAL 1 DAY) order by idpeminjaman DESC");
                                    }else{
                                      $ambilsemuadatastock = mysqli_query($conn, "SELECT * FROM peminjaman p, stock s where s.idbarang = p.idbarang order by idpeminjaman DESC");  
                                    }

                                    }else{
                                        $ambilsemuadatastock = mysqli_query($conn, "SELECT * FROM peminjaman p, stock s where s.idbarang = p.idbarang order by idpeminjaman DESC ");
                                    }
                                    
                                     while ($data = mysqli_fetch_array($ambilsemuadatastock)) {
                                        $idk = $data['idpeminjaman'];
                                        $idb = $data['idbarang'];
                                        $tanggal = $data['tanggalpinjam'];
                                        $namabarang = $data['namabarang'];
                                        $qty = $data['qty'];
                                        $penerima = $data['peminjam'];
                                        $status = $data['status'];
                                          // cek ada gambar atau tidak
                                        $gambar = $data['image'];
                                        if($gambar==null){

                                            $img = 'No Photo';
                                        }else{
                                            $img = '<img src="images/'.$gambar.'" class="zoomable">';

                                        }
                                    ?>
                                    <tr>
                                        <td class="text-center"><?= $tanggal; ?></td>
                                        <td class="text-center"><?= $img; ?></td>
                                        <td class="text-center"><?= $namabarang; ?></td>
                                        <td class="text-center"><?= $qty; ?></td>
                                        <td class="text-center"><?= $penerima; ?></td>
                                        <td class="text-center"><?= $status; ?></td>
                                        <td class="text-center">

                                        <?php 
                                        // cek validasi 
                                        if($status == 'Dipinjam') {
                                            echo '<button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#editModal'.$idk.'">
                                                    Selesai
                                                  </button>';
                                        } else {
                                            // jika statusnya bukan 'Dipinjam' (sudah kembali)
                                            echo 'Barang telah Kembali';
                                        }
                                        ?>
                                        </td>
                                    </tr>
                                    <div class="modal fade" id="editModal<?= $idk; ?>" tabindex="-1" aria-labelledby="editModalLabel<?= $idk; ?>" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editModalLabel<?= $idb; ?>">Selesaikan</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form method="POST">
                                                    <div class="modal-body">
                                                     Apakah Barang ini Sudah Selesai Dipinjam
                                                     <br>
                                                     <input type="hidden" name="idpinjam" value="<?=$idk;?>">
                                                     <input type="hidden" name="idbarang" value="<?=$idb;?>">
                                                     <button type="submit" class="btn btn-primary" name="barangkembali">Iya Bos</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
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

         <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header d-flex justify-content-center">
                    <h4 class="modal-title" id="myModalLabel">Tambah Data Peminjaman</h4>                    
                </div>
               <form method="post">
                <div class="modal-body">
                    <select name="barangnya" id="barangnya" class="form-control">
                        <?php
                            $ambilsemuadatanya = mysqli_query($conn, "SELECT * FROM stock");
                            while ($fetcharray = mysqli_fetch_array($ambilsemuadatanya)) {
                                $namabarangnya = $fetcharray['namabarang'];
                                $idbarangnya = $fetcharray['idbarang'];
                        ?>
                        <option value="<?= $idbarangnya; ?>"><?= $namabarangnya; ?></option>
                        <?php
                            }
                        ?>
                    </select>
                    <br>
                    <input type="number" name="qty" placeholder="Quantity" class="form-control mb-3" required>
                    <input type="text" name="penerima" class="form-control mt-3" placeholder="Kepada" required>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" name="pinjam">Submit</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
            </div>
        </div>
    </div>

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

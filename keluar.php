<?php
require 'function.php'; 
require 'cek.php'; 
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Barang Keluar</title>
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
                        <h1 class="mt-4">Barang Keluar</h1>
                        <div class="card mb-4">
                        <div class="card-header">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">
                                Tambah Barang
                            </button>
                             <br>
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
                                        <th class="text-center">Penerima</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if(isset($_POST['filter_tgl'])){
                                    $mulai =  $_POST['tgl_mulai'];
                                    $selesai =  $_POST['tgl_selesai'];

                                    if($mulai!=null || $selesai!=null ){

                                        $ambilsemuadatastock = mysqli_query($conn, "SELECT * FROM keluar k, stock s where s.idbarang = k.idbarang and tanggal BETWEEN '$mulai' and DATE_ADD('$selesai',INTERVAL 1 DAY)");
                                    }else{
                                      $ambilsemuadatastock = mysqli_query($conn, "SELECT * FROM keluar k, stock s where s.idbarang = k.idbarang");  
                                    }

                                    }else{
                                        $ambilsemuadatastock = mysqli_query($conn, "SELECT * FROM keluar k, stock s where s.idbarang = k.idbarang");
                                    }
                                    
                                     while ($data = mysqli_fetch_array($ambilsemuadatastock)) {
                                        $idk = $data['idkeluar'];
                                        $idb = $data['idbarang'];
                                        $tanggal = $data['tanggal'];
                                        $namabarang = $data['namabarang'];
                                        $qty = $data['qty'];
                                        $penerima = $data['penerima'];
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
                                        <td class="text-center">
                                            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editModal<?= $idk; ?>">
                                                Edit
                                            </button>
                                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal<?= $idk; ?>">
                                                Delete
                                            </button>
                                        </td>
                                    </tr>
                                    <div class="modal fade" id="editModal<?= $idk; ?>" tabindex="-1" aria-labelledby="editModalLabel<?= $idk; ?>" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editModalLabel<?= $idb; ?>">Edit Barang</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form method="POST">
                                                    <div class="modal-body">
                                                        <input type="hidden" name="idb" value="<?= $idb; ?>">
                                                        <div class="mb-3">
                                                            <label for="penerima<?= $idb; ?>" class="form-label">Penerima</label>
                                                            <input type="text" id="penerima<?= $idb; ?>" name="penerima" value="<?= $penerima; ?>" class="form-control" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="qty<?= $idb; ?>" class="form-label">Qty</label>
                                                            <input type="number" id="qty<?= $idb; ?>" name="qty" value="<?= $qty; ?>" class="form-control" required>
                                                        </div>
                                                        <input type="hidden" name="idb" value="<?=$idb;?>">
                                                        <input type="hidden" name="idk" value="<?=$idk;?>">
                                                        <button type="submit" class="btn btn-primary" name="updatebarangkeluar">Submit</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Modal Hapus -->
                                    <div class="modal fade" id="deleteModal<?= $idk; ?>" tabindex="-1" aria-labelledby="deleteModalLabel<?= $idk; ?>" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="deleteModalLabel<?= $idb; ?>">Hapus Barang: <?= $namabarang; ?></h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Apakah Anda yakin ingin menghapus barang ini?
                                                    <p><strong>Nama Barang:</strong> <?= $namabarang; ?></p>
                                                    <p><strong>penerima:</strong> <?= $penerima; ?></p>
                                                </div>
                                                <div class="modal-footer">
                                                    <form method="POST">
                                                        <input type="hidden" name="idb" value="<?= $idb; ?>">
                                                        <input type="hidden" name="kty" value="<?= $qty; ?>">
                                                        <input type="hidden" name="idk" value="<?= $idk; ?>">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-danger" name="deletebarangkeluar">Hapus</button>
                                                    </form>
                                                </div>
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
                    <h4 class="modal-title" id="myModalLabel">Tambah Barang Keluar</h4>                    
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
                    <input type="text" name="penerima" class="form-control mt-3" placeholder="Penerima" required>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" name="tambahbarangkeluar">Submit</button>
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

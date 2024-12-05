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
    <title>Stock Barang</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.css" />
    <link href="css/styles.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <style>
        .zoomable{
           width:  100px;
        }
        .zoomable:hover{
            transform: scale(2.5);
            transition: 0.3s ease;
        }

        a{
            text-decoration: 0;
            color:black;
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
            <nav class="sb-sidenav accordion sb-sidenav-dark " id="sidenavAccordion">
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
                    <h1 class="mt-4">Stock Barang</h1>
                    <div class="card mb-4">
                        <div class="card-header">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">
                                Tambah Barang
                            </button>
                            <a href="export.php" class="btn btn-info">Export Data</a>
                        </div>
                        <div class="card-body">
                        <?php 
                            $ambildatastock = mysqli_query($conn, "select * from stock where stock < 1");

                            while($fetch=mysqli_fetch_array($ambildatastock)){
                                $barang = $fetch['namabarang'];
                            
                        ?>    
                        <div class="alert alert-danger" role="alert">
                            Perhatian! <a href="#" class="alert-link"></a> Stock <?=$barang;?> Telah Habis
                        </div>
                        <?php 
                            
                            }

                        ?>
                            <table class="table" id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center">Gambar</th>
                                        <th class="text-center">Nama Barang</th>
                                        <th class="text-center">Deskripsi</th>
                                        <th class="text-center">Stock</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $ambilsemuadatastock = mysqli_query($conn, "SELECT * FROM stock");
                                    $i = 1;

                                    while ($data = mysqli_fetch_array($ambilsemuadatastock)) {
                                        $namabarang = $data['namabarang'];
                                        $deskripsi = $data['deskripsi'];
                                        $stock = $data['stock'];
                                        $idb = $data['idbarang'];
                                        // cek ada gambar atau tidak
                                        $gambar = $data['image'];
                                        if($gambar==null){

                                            $img = 'No Photo';
                                        }else{
                                            $img = '<img src="images/'.$gambar.'" class="zoomable">';

                                        }
                                    ?>

                                    <tr>
                                        <td class="text-center"><?= $i++; ?></td>
                                        <td class="text-center"><?= $img; ?></td>
                                        <td class="text-center"><strong><a href="detail.php?id=<?=$idb;?>"><?= $namabarang; ?></a></strong></td>
                                        <td class="text-center"><?= $deskripsi; ?></td>
                                        <td class="text-center"><?= $stock; ?></td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editModal<?= $idb; ?>">
                                                Edit
                                            </button>
                                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal<?= $idb; ?>">
                                                Delete
                                            </button>
                                        </td>
                                    </tr>

                                    <!-- Modal Edit -->
                                    <div class="modal fade" id="editModal<?= $idb; ?>" tabindex="-1" aria-labelledby="editModalLabel<?= $idb; ?>" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editModalLabel<?= $idb; ?>">Edit Barang</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>

                                                <form method="POST" enctype="multipart/form-data">
                                                    <div class="modal-body" >
                                                        <input type="hidden" name="idb" value="<?= $idb; ?>">
                                                        <div class="mb-3">
                                                            <label for="namabarang<?= $idb; ?>" class="form-label">Nama Barang</label>
                                                            <input type="text" id="namabarang<?= $idb; ?>" name="namabarang" value="<?= $namabarang; ?>" class="form-control" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="deskripsi<?= $idb; ?>" class="form-label">Deskripsi</label>
                                                            <input type="text" id="deskripsi<?= $idb; ?>" name="deskripsi" value="<?= $deskripsi; ?>" class="form-control" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="image">Gambar</label>
                                                            <input type="file"  name="file" class="form-control" required>
                                                        </div>
                                                        <button type="submit" class="btn btn-primary" name="updatebarang">Submit</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Modal Hapus -->
                                    <div class="modal fade" id="deleteModal<?= $idb; ?>" tabindex="-1" aria-labelledby="deleteModalLabel<?= $idb; ?>" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="deleteModalLabel<?= $idb; ?>">Hapus Barang: <?= $namabarang; ?></h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Apakah Anda yakin ingin menghapus barang ini?
                                                    <p><strong>Nama Barang:</strong> <?= $namabarang; ?></p>
                                                    <p><strong>Deskripsi:</strong> <?= $deskripsi; ?></p>
                                                </div>
                                                <div class="modal-footer">
                                                    <form method="POST">
                                                        <input type="hidden" name="idbarang" value="<?= $idb; ?>">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-danger" name="deletebarang">Hapus</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php } ?>
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

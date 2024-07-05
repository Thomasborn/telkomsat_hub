<?= $this->extend('template/main') ?>

<!-- Place your HTML code here -->
<!-- All the HTML code you provided should be placed here -->

<?php $this->section('content'); ?> 
        <!-- Success Toast -->
     
        <!-- End Success Toast -->
    <section class="content">
    <?php if(session()->has('success')): ?>
    <div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="successModalLabel">Berhasil!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?= session('success') ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>


        <div class="container-fluid">
    <div class="row clearfix">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="header">
                              
                        <div class="card-header">
    <div class="col-md-8 mb-2">
      
    </div>
    <div class="row m-t-15 m-b--20">
    <div class="col-md-8">
        <div class="col-md-2">
        <button type="button" class="btn btn-primary m-3" data-toggle="modal" data-target="#tambahModal">Tambah</button>
        </div>
        <div class="col-md-2">
        <button type="button" class="btn btn-success m-3" data-toggle="modal" data-target="#importModal">Import</button>
        </div>
        <div class="col-md-2">
        <button type="button" class="btn btn-success m-3" data-toggle="modal" data-target="#exportModal">Export</button>
        </div>
    </div>
    </div>
    <hr>
</div>
    <div class="card-body">
    <table id="datatablesSimple" class="table">
        <thead>
            <tr>
                <th>No</th>    
                <th>Platform</th>
                <th>HUB ID</th>
                <th>Tanggal Instalasi</th>
                <th>HUB Status</th>
                <th>TTR</th>
                <th>AV (%)</th>
                <th>Create At</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $i=1;
         foreach ($items as $item): ?>
    <tr>
        <td><?= $i++; ?></td>
        <td><?= esc($item['platform']); ?></td>
        <td><?= esc($item['id']); ?></td>
        <td><?= esc($item['tanggal_instalasi']); ?></td>
        <td><?= esc($item['hub_status']); ?></td>
        <td><?= esc($item['ttr']); ?></td>
        <td><?= esc($item['av_percentage']); ?></td>
        <td><?= esc($item['create_at']); ?></td>
        <td> 
            <div class="btn-group" role="group">
                <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#edit<?= esc($item['hub_id']); ?>">
                    <i class="material-icons">edit</i>
                </button>
                
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#hapus<?= esc($item['hub_id']); ?>">
                        <i class="material-icons">delete</i>
                    </button>
                </div>
            </div>
        </td>
    </tr>
          <!--  Modal Edit-->
    <div class="modal fade" id="edit<?= esc($item['hub_id']); ?>">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Edit Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <!-- Modal body -->
                <form id="addDataForm"action="/hub/edit/<?= esc($item['hub_id']); ?>" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="platform">Platform</label>
                            <input type="text" name="platform" value="<?= esc($item['platform']); ?>" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="id">ID</label>
                            <input type="text" name="id" value="<?= esc($item['id']); ?>" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="tanggal_instalasi">Tanggal Instalasi</label>
                            <input type="date" name="tanggal_instalasi" value="<?= esc($item['tanggal_instalasi']); ?>" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="hub_status">Hub Status</label>
                            <input type="text" name="hub_status" value="<?= esc($item['hub_status']); ?>" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="ttr">TTR</label>
                            <input type="number" name="ttr" value="<?= esc($item['ttr']); ?>" class="form-control">
                        </div>
                        <input type="hidden" name="hub_id" value="<?= esc($item['hub_id']); ?>">
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" name="updatesla">Submit</button>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" data-dismiss="modal">Close</button>
                    </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
            
    <!--  Modal Hapus-->
    <div class="modal fade" id="hapus<?= esc($item['hub_id']); ?>">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">Hapus Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <!-- Modal body -->
                <form id="addDataForm"action="/hub/delete/<?= esc($item['hub_id']); ?>" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <p>Apakah anda yakin ingin menghapus data ini?</p>
                        <input type="hidden" name="hub_id" value="<?= esc($item['hub_id']); ?>">
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger" name="deletesla">Hapus</button>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endforeach; ?>

        </tbody>
    </table>
</div>

    </div>
    </div>
    </div>
</div>
<!-- Add modals at the end of your HTML content -->
<!-- Tambah Modal -->
<?= $this->include('template/modal') ?>

<?php $this->endSection(); ?>

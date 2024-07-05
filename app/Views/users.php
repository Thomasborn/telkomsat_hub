<?= $this->extend('template/main') ?>

<!-- Place your HTML code here -->
<!-- All the HTML code you provided should be placed here -->

<?php $this->section('content'); ?>
     <!-- Success Toast -->
     
        <!-- End Success Toast -->
       

        <section class="content">

        <div class="container-fluid">
    <div class="row clearfix">
        
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="header">
                              
    <div class="card-header">
    <div class="col-md-8">
      
    </div>
    <!-- <div class="col-md-1">
    <button type="button" class="btn btn-primary m-3" data-toggle="modal" data-target="#tambahModal">
        Tambah
    </button>
</div> -->
<!-- <div class="col-md-1"> -->
    <!-- <button type="button" class="btn btn-success m-3" data-toggle="modal" data-target="#importModal">
        Imports
    </button> -->
<!-- </div> -->

    </div>
    <div class="col-md-8">
        <div class="col-md-2">
            <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#tambahModal">Tambah</button>
        </div>
    </div>
    <hr>
    <table id="datatablesSimple" class="table">
    <thead>
        <tr>
            <th>No</th>
            <th>Email</th>
            <th>Username</th>
            <th>Role</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $i=1;
        foreach ($users as $user): ?>
            <tr>
                <td><?= $i++; ?></td>
                <td><?= esc($user['email']); ?></td>
                <td><?= esc($user['username']); ?></td>
                <td><?= $user['role'] ?></td>
                <td>
                    <div class="btn-group" role="group">
                        <!-- Button trigger modal for editing a user -->
                        <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#editModal<?= esc($user['id']); ?>">
                        <i class="material-icons">edit</i>
                        </button>
                        <div class="btn-group" role="group">
                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#hapusModal<?= esc($user['id']); ?>">
                        <i class="material-icons">delete</i>
                        </button>
                </div>
                        <!-- Button trigger modal for deleting a user -->
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>

        <!-- Edit Modal -->
<?php foreach ($users as $user): ?>
<div class="modal fade" id="editModal<?= esc($user['id']); ?>" tabindex="-1" role="dialog" aria-labelledby="editModalLabel<?= esc($user['id']); ?>" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel<?= esc($user['id']); ?>">Edit User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Form for editing user -->
                <form action="/users/edit/<?= esc($user['id']); ?>" method="post">
                    <div class="form-group">
                    <div class="form-line">
                        <label for="editEmail<?= esc($user['id']); ?>">Email</label>
                        <input type="email" class="form-control" id="editEmail<?= esc($user['id']); ?>" name="email" value="<?= esc($user['email']); ?>">
                    </div>
                    </div>
                    <div class="form-group">
                    <div class="form-line">
                        <label for="editUsername<?= esc($user['id']); ?>">Username</label>
                        <input type="text" class="form-control" id="editUsername<?= esc($user['id']); ?>" name="username" value="<?= esc($user['username']); ?>">
                    </div>
                    </div>
                    <div class="form-group">
        <div class="form-line">
            <label for="role">Role</label>
            <select class="form-control" id="role" name="role" required>
                <?php foreach ($roles as $role): ?>
                    <option value="<?= $role['id'] ?>" <?= ($role['id'] == $user['role_id']) ? 'selected' : '' ?>><?= $role['nama'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

                    <div class="form-group">
                    <div class="form-line">
                        <label for="editPassword<?= esc($user['id']); ?>">Password</label>
                        <input type="password" class="form-control" id="editPassword<?= esc($user['id']); ?>" name="password" value="<?= esc($user['password']); ?>">
                    </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php endforeach; ?>
<!-- Delete Modal -->
<?php foreach ($users as $user): ?>
<div class="modal fade" id="hapusModal<?= esc($user['id']); ?>" tabindex="-1" role="dialog" aria-labelledby="hapusModalLabel<?= esc($user['id']); ?>" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="hapusModalLabel<?= esc($user['id']); ?>">Delete User</h5>
                </button>
            </div>
            <div class="modal-body">
              Anda yakin ingin menghapus user ini?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <a href="/users/delete/<?= esc($user['id']); ?>" class="btn btn-danger">Hapus</a>
            </div>
        </div>
    </div>
</div>
<?php endforeach; ?>

    </tbody>
</table>
</div>
<?= $this->include('template/modalUser') ?>

</div>
</div>
</div>
</div>
    <?php $this->endSection(); ?>
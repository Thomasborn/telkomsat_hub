<!-- Add User Modal -->
<div class="modal fade" id="tambahModal" tabindex="-1" role="dialog" aria-labelledby="tambahModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahModalLabel">Add User</h5>
                </button>
            </div>
            <div class="modal-body">
                <form action="/users/add" method="post">
                    <div class="form-group">
                    <div class="form-line">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                    </div>
                    <div class="form-group">
                    <div class="form-line">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                    </div>
                    <div class="form-group">
    <div class="form-line">
        <label for="role">Role</label>
        <select class="form-control" id="role" name="role" required>
            <?php foreach ($roles as $role): ?>
                <option value="<?= $role['id'] ?>"><?= $role['nama'] ?></option>
            <?php endforeach; ?>
        </select>
    </div>
</div>
<div class="form-group">
    <div class="form-line">
        <label for="password">Password</label>
        <div class="input-group">
            <input type="password" class="form-control" id="password" name="password" required>
           
        </div>
    </div>
</div>

                    <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                    
                    
                </form>
            </div>
        </div>
    </div>
</div>



<!-- Your HTML content for the success page -->
<!-- This could be whatever content you want to display after successful data addition -->

<!-- Import Modal -->
<div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="importModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="importModalLabel">Import Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="importForm">
                    <div class="form-group">
                        <label for="importFile">Choose File</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="importFile">
                            <label class="custom-file-label" for="importFile">Choose file...</label>
                        </div>
                    </div>
                    <!-- Add other fields as needed -->
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="importButton">Import</button>
            </div>
        </div>
    </div>
</div>


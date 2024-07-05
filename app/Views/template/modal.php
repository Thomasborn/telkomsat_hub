<div class="modal fade" id="tambahModal" tabindex="-1" role="dialog" aria-labelledby="tambahModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahModalLabel">Tambah Data</h5>
            </div>
            <div class="modal-body">
                <form id="addDataForm" action="/hub/add" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <div class="form-line">
                            <label for="platform">Platform</label>
                            <input type="text" class="form-control" id="platform" name="platform" placeholder="Platform" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-line">
                            <label for="id">ID</label>
                            <input type="text" class="form-control" id="id" name="id" placeholder="ID" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-line">
                            <label for="tanggal_instalasi">Tanggal Instalasi</label>
                            <input type="date" class="form-control" id="tanggal_instalasi" name="tanggal_instalasi" placeholder="Tanggal Instalasi" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-line">
                            <label for="hub_status">Hub Status</label>
                            <input type="text" class="form-control" id="hub_status" name="hub_status" placeholder="Hub Status" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-line">
                            <label for="ttr">TTR</label>
                            <input type="number" class="form-control" id="ttr" name="ttr" placeholder="TTR" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="submitForm">Submit</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="importModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="importModalLabel">Import Data</h5>
            </div>
            <div class="modal-body">
                <form id="importForm" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="importFile">Pilih File</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="importFile" name="importFile" required>
                            <label class="custom-file-label" for="importFile">Pilih file</label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="importButton">Import</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Export Modal -->
<div class="modal fade" id="exportModal" tabindex="-1" role="dialog" aria-labelledby="exportModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exportModalLabel">Export Data</h5>
                </button>
            </div>
            <div class="modal-body">
                <p>Pilih tipe export</p>
            </div>
            <div class="modal-footer">
            <a href="<?= base_url('hub/export') ?>" class="btn btn-success">
    <i class="material-icons">insert_drive_file</i> Excel
</a>
<a href="<?= base_url('hub/exportcsv') ?>" class="btn btn-success">
    <i class="material-icons">insert_drive_file</i> Csv
</a>

                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
<script>
    // Function to show success notification
    function showSuccessNotification(message) {
        toastr.success(message, 'Success', {
            closeButton: true,
            progressBar: true,
            positionClass: "toast-top-right",
            timeOut: 5000,
        });
    }

    // Function to show error notification
    function showErrorNotification(message) {
        toastr.error(message, 'Error', {
            closeButton: true,
            progressBar: true,
            positionClass: "toast-top-right",
            timeOut: 5000,
        });
    }

    // Function to close modal
    function closeModal() {
        $('#importModal').modal('hide'); // Bootstrap modal hide method
    }

    // Event listener for import button
    document.getElementById('importButton').addEventListener('click', function () {
        var fileInput = document.getElementById('importFile');
        var file = fileInput.files[0];

        if (file) {
            var formData = new FormData();
            formData.append('file', file);

            fetch('<?= base_url('hub/import') ?>', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                console.log(data);
                if (data.success) {
                    showSuccessNotification(data.message);
                    closeModal(); // Close modal on success
                } else {
                    showErrorNotification(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showErrorNotification('Gagal mengimpor data!');
            });
        } else {
            alert('Pilih file terlebih dahulu!');
        }
    });
</script>
<div class="modal fade" id="tambahModal" tabindex="-1" role="dialog" aria-labelledby="tambahModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahModalLabel">Tambah Data</h5>
                <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> -->
            </div>
            <div class="modal-body">
                <form id="addDataForm"action="/hub/add" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <div class="form-line">
                            <label for="platform">Platform</label>
                            <input type="text" class="form-control" id="platform" name="platform" placeholder="Platform">
                        </div>
                    </div>
                    <div class="form-group">
                    <div class="form-line">
                        <label for="id">ID</label>
                        <input type="text" class="form-control" id="id" name="id" placeholder="ID">
                     </div>
                    </div>
                    <div class="form-group">
                    <div class="form-line">
                        <label for="tanggal_instalasi">Tanggal Instalasi</label>
                        <input type="date" class="form-control" id="tanggal_instalasi" name="tanggal_instalasi" placeholder="Tanggal Instalasi">
                        </div>
                    </div>
                    <div class="form-group">
                    <div class="form-line">
                        <label for="hub_status">Hub Status</label>
                        <input type="text" class="form-control" id="hub_status" name="hub_status" placeholder="Hub Status">
                        </div>
                    </div>
                    <div class="form-group">
                    <div class="form-line">
                        <label for="ttr">TTR</label>
                        <input type="number" class="form-control" id="ttr" name="ttr" placeholder="TTR">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="submitForm">Submit</button>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



<!-- Import Modal -->
<div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="importModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="importModalLabel">Import Data</h5>
                </button>
            </div>
            <div class="modal-body">
                <form id="importForm" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="importFile">Pilih File</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="importFile" name="importFile">
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
                <a href="<?= base_url('hub/export') ?>" class="btn btn-success">Excel</a>
                <a href="<?= base_url('hub/export') ?>" class="btn btn-success">Csv</a>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script>
    // Handle file input change event
    document.getElementById('importFile').addEventListener('change', function (event) {
        var fileName = event.target.files[0].name;
        var label = document.getElementById('importFile').nextElementSibling;
        label.innerHTML = fileName;
    });

    // Handle import button click event
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
            .then(response => response.json())
            .then(data => {
                // Handle response here
                console.log(data);
                if (data.success) {
                    alert('Data berhasil diimpor!');
                } else {
                    alert('Gagal mengimpor data!');
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        } else {
            alert('Pilih file terlebih dahulu!');
        }
    });
</script>

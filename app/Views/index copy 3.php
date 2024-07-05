<div class="row clearfix">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="header">
                              
    <div class="card-header">
    <div class="col-md-8">
      
    </div>
    <div class="col-md-1">
        <button type="button" class="btn btn-primary m-3" data-toggle="modal" data-target="#myModal">
            Tambah
        </button>
        <button type="button" class="btn btn-success m-3" data-toggle="modal" data-target="#import">
            Import
        </button>
    </div>
    <div class="col-md-1">
       
        <button type="button" class="btn btn-success m-3" data-toggle="modal" data-target="#import">
            Import
        </button>
    </div>
    </div>
    <div class="card-body">
        <table id="datatablesSimple">
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
                <?php foreach ($items as $item): ?>
                <tr>
                    <td><?= esc($item['id']); ?></td>
                    <td><?= esc($item['platform']); ?></td>
                    <td><?= esc($item['hub_id']); ?></td>
                    <td><?= esc($item['tanggal_instalasi']); ?></td>
                    <td><?= esc($item['hub_status']); ?></td>
                    <td><?= esc($item['ttr']); ?></td>
                    <td><?= esc($item['av_percentage']); ?></td>
                    <td><?= esc($item['create_at']); ?></td>
                    <td> 
                        <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#edit<?= esc($item['hub_id']); ?>">
                            Edit
                        </button>
                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#hapus<?= esc($item['hub_id']); ?>">
                            Hapus
                        </button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    </div>
    </div>
    </div>
    </div>
</div>
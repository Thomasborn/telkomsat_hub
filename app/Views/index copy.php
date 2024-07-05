<section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2><b> SLA</b></h2>
            </div>
            
            <div class="mt-2"> <!-- Add margin-top for space above the form -->
    <form method="post" action="<?= base_url('chart') ?>">
        <div class="row justify-content-center">
            <div class="col-md-2">
                <div class="form-group">
                    <label for="bulan">Bulan:</label>
                    <select name="bulan" id="bulan" class="form-select">
                        <!-- Populate options dynamically -->
                        <?php for ($i = 1; $i <= 12; $i++): ?>
                            <?php $selected = ($bulan == $i) ? 'selected' : ''; ?>
                            <option value="<?= str_pad($i, 2, '0', STR_PAD_LEFT) ?>" <?= $selected ?>>
                                <?= date('F', mktime(0, 0, 0, $i, 1)) ?>
                            </option>
                        <?php endfor; ?>
                    </select>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="tahun">Tahun:</label>
                    <select name="tahun" id="tahun" class="form-select">
                        <!-- Populate options dynamically -->
                        <?php for ($i = date('Y'); $i >= 2000; $i--): ?>
                            <option value="<?= $i ?>" <?= $tahun == $i ? 'selected' : '' ?>><?= $i ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group mt-2">
                    <button type="submit" class="btn btn-primary w-100">Filter</button>
                </div>
            </div>
        </div>
    </form>
</div> <!-- End of margin-top -->
</div> <!-- End of margin-top -->

            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box bg-green hover-expand-effect">
                        <div class="icon">
                             <i class="material-icons">router</i>
                        </div>
                        <div class="content">
                            <div class="text">HUB</div>
                            <div class="number count-to" data-from="0" data-to="42" data-speed="15" data-fresh-interval="20"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box bg-cyan hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons">done</i>
                        </div>
                        <div class="content">
                            <div class="text">Availabilitys</div>
                            <div class="number count-to" data-from="0" data-to="40" data-speed="1000" data-fresh-interval="20"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box bg-pink hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons">close</i>
                        </div>
                        <div class="content">
                            <div class="text">TTR</div>
                            <div class="number count-to" data-from="0" data-to="2" data-speed="1000" data-fresh-interval="20"></div>
                        </div>
                    </div>
                </div>
            <!-- CPU Usage -->
            
            <div class="row clearfix">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12-mt-2">
                    <div class="card">
              <div class="container">
        <!-- Filter form -->
   



        <!-- AV Chart -->
        <canvas id="avChart" width="600" height="200"></canvas>

        <!-- TTR Chart -->
        <canvas id="ttrChart" width="600" height="200"></canvas>
    </div>

    <script>
        // AV Chart
        var avCtx = document.getElementById('avChart').getContext('2d');
        var avChart = new Chart(avCtx, {
            type: 'bar',
            data: {
                labels: <?= json_encode($avData['labels']) ?>,
                datasets: [{
                    label: 'Availability',
                    data: <?= json_encode($avData['persentaseData']) ?>,
                    backgroundColor: 'rgba(0, 80, 255, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100
                    }
                }
            }
        });

        // TTR Chart
        var ttrCtx = document.getElementById('ttrChart').getContext('2d');
        var ttrChart = new Chart(ttrCtx, {
            type: 'bar',
            data: {
                labels: <?= json_encode($ttrData['labels']) ?>,
                datasets: [{
                    label: 'TTR',
                    data: <?= json_encode($ttrData['ttrData']) ?>,
                    backgroundColor: 'rgba(255, 59, 73, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100
                    }
                }
            }
        });
    </script>
    
            </div>
            </div>
            <!-- #END# CPU Usage -->
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
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

    </div>
    </div>
    </div>
</div>

                <!-- #END# Browser Usage -->
    </section>
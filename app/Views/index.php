<?= $this->extend('template/main') ?>

<!-- Place your HTML code here -->
<!-- All the HTML code you provided should be placed here -->

<?php $this->section('content'); ?>
    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2><b> Dashboard</b></h2>
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

<?php
$bulan = date('m');
$tahun = date('Y');
$mysqli = mysqli_connect("localhost", "root", "", "web");
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bulan = $_POST['bulan'];
    $tahun = $_POST['tahun'];
  
    //HUB
    // Construct filtered query
    $sql = "SELECT * FROM data_sla WHERE MONTH(create_at) = $bulan AND YEAR(create_at) = $tahun";
    $datasla = mysqli_query($mysqli, $sql);
  
    // Update jumlah_id with filtered count
    $jumlah_id = mysqli_num_rows($datasla);
  } else {
    // Default query (without filter)
    $bulan_terkini = date('m');
  $sql = "SELECT * FROM data_sla WHERE MONTH(create_at) = $bulan_terkini AND YEAR(create_at) = " . date('Y');
  $datasla = mysqli_query($mysqli, $sql);
  $jumlah_id = mysqli_num_rows($datasla);
  }
  //END

  //AV
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bulan = $_POST['bulan'];
    $tahun = $_POST['tahun'];
    // Construct filtered query
    $sql = "SELECT COUNT(*) AS av_percentage
            FROM data_sla
            WHERE av_percentage = 100.00
            AND MONTH(create_at) = $bulan
            AND YEAR(create_at) = $tahun";
    $datasla = mysqli_query($mysqli, $sql);
  
    // Update jumlah_ttr with filtered count
    $result = mysqli_fetch_assoc($datasla);
    $jumlah_av = $result['av_percentage'];
} else {
    // Default query (without filter)
    $bulan_terkini = date('m');
    $tahun_terkini = date('Y');
    $sql = "SELECT COUNT(*) AS av_percentage
            FROM data_sla
            WHERE av_percentage = 100.00
            AND MONTH(create_at) = $bulan_terkini
            AND YEAR(create_at) = $tahun_terkini";
    $datasla = mysqli_query($mysqli, $sql);
    $result = mysqli_fetch_assoc($datasla);
    $jumlah_av = $result['av_percentage'];
}
  //END

  //TTR
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bulan = $_POST['bulan'];
    $tahun = $_POST['tahun'];
    // Construct filtered query
    $sql = "SELECT COUNT(*) AS ttr
            FROM data_sla
            WHERE ttr > 0
            AND MONTH(create_at) = $bulan
            AND YEAR(create_at) = $tahun";
    $datasla = mysqli_query($mysqli, $sql);
  
    // Update jumlah_ttr with filtered count
    $result = mysqli_fetch_assoc($datasla);
    $jumlah_ttr = $result['ttr'];
} else {
    // Default query (without filter)
    $bulan_terkini = date('m');
    $tahun_terkini = date('Y');
    $sql = "SELECT COUNT(*) AS ttr
            FROM data_sla
            WHERE ttr > 0
            AND MONTH(create_at) = $bulan_terkini
            AND YEAR(create_at) = $tahun_terkini";
    $datasla = mysqli_query($mysqli, $sql);
    $result = mysqli_fetch_assoc($datasla);
    $jumlah_ttr = $result['ttr'];
}
  //END
?>

            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box bg-green hover-expand-effect">
                        <div class="icon">
                             <i class="material-icons">router</i>
                        </div>
                        <div class="content">
                            <div class="text">HUB</div>
                            <div class="number count-to" data-from="0" data-to="<?= $jumlah_id ?>" data-speed="15" data-fresh-interval="20"></div>
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
                            <div class="number count-to" data-from="0" data-to="<?= $jumlah_av ?>" data-speed="1000" data-fresh-interval="20"></div>
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
                            <div class="number count-to" data-from="0" data-to="<?= $jumlah_ttr ?>" data-speed="1000" data-fresh-interval="20"></div>
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
<!-- Add modals at the end of your HTML content -->
<!-- Tambah Modal -->
<?= $this->include('template/modal') ?>


</div>
    <?php $this->endSection(); ?>
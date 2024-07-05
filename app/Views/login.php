<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Sistem Informasi Dashboard SLA Report</title>
    <!-- Favicon-->
    <link rel="icon" href="../../favicon.ico" type="image/x-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="https://gurayyarar.github.io/AdminBSBMaterialDesign/plugins/bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="https://gurayyarar.github.io/AdminBSBMaterialDesign/plugins/node-waves/waves.css" />

    <!-- Animation Css -->
    <link href="https://gurayyarar.github.io/AdminBSBMaterialDesign/plugins/animate-css/animate.css" rel="stylesheet" />

    <!-- Custom Css -->
    <link href="https://gurayyarar.github.io/AdminBSBMaterialDesign/css/style.css" rel="stylesheet">
</head>

<body class="login-page">
<div class="login-box">
    <div class="logo">
        <a href="javascript:void(0);"><b>TELKOMSAT</b></a>
        <small>Sistem Informasi Dashboard SLA Report</small>
    </div>
    <div class="card">
        <div class="body">
            <form action="<?= site_url('processLogin') ?>" method="post">
                <div class="msg">Sign in to start your session</div>
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="material-icons">person</i>
                    </span>
                    <div class="form-line">
                        <input type="text" class="form-control" id="email" name="email" placeholder="Email" required />
                    </div>
                </div>
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="material-icons">lock</i>
                    </span>
                    <div class="form-line">
                        <input type="password" class="form-control" id="password" name="password" placeholder="Password" required />
                    </div>
                </div>
                <div class="col-xs-8 p-t-5">
                    <input type="checkbox" name="showpassword" id="showpassword" class="filled-in chk-col-pink" onclick="togglePassword()">
                    <label for="showpassword">Show Password</label>
                </div>
    
                <div class="row">
                    <div class="col-xs-4">
                        <button class="btn btn-block bg-pink waves-effect" type="submit" id="do_login" value="LOGIN">LOGIN</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function togglePassword() {
    var passwordField = document.getElementById("password");
    if (passwordField.type === "password") {
        passwordField.type = "text";
    } else {
        passwordField.type = "password";
    }
}
</script>

    <!-- Jquery Core Js -->
    <script src="https://gurayyarar.github.io/AdminBSBMaterialDesign/plugins/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core Js -->
    <script src="https://gurayyarar.github.io/AdminBSBMaterialDesign/plugins/bootstrap/js/bootstrap.js"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="https://gurayyarar.github.io/AdminBSBMaterialDesign/plugins/node-waves/waves.js"></script>

    <!-- Validation Plugin Js -->
    <script src="https://gurayyarar.github.io/AdminBSBMaterialDesign/plugins/jquery-validation/jquery.validate.js"></script>

    <!-- Custom Js -->
    <script src="https://gurayyarar.github.io/AdminBSBMaterialDesign/js/admin.js"></script>
    <script src="https://gurayyarar.github.io/AdminBSBMaterialDesign/js/pages/examples/sign-in.js"></script>
</body>

</html>

<?php
    
    include "../../config/navigation.php";
    check_session();

?>

<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Purchasing</title>

        <link rel="icon" href="<?php echo base_url; ?>assets/logo/logo.png" size="200x200" />

        <!-- Bootstrap core CSS-->
        <link href="<?php echo base_url; ?>assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

        <!-- Custom fonts for this template-->
        <link href="<?php echo base_url; ?>assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

        <!-- Page level plugin CSS-->
        <link href="<?php echo base_url; ?>assets/vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">

        <!-- Custom styles for this template-->
        <link href="<?php echo base_url; ?>assets/css/sb-admin.css" rel="stylesheet">

        <!-- Page level plugin CSS-->
        <link href="<?php echo base_url; ?>assets/vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">

        <!-- izi Modal -->
        <link href="<?php echo base_url; ?>assets/vendor/iziModal-master/css/iziModal.min.css" rel="stylesheet">
        <link href="<?php echo base_url; ?>assets/vendor/iziModal-master/css/iziModal.css" rel="stylesheet">

        <!-- Customize CSS -->
        <link href="<?php echo base_url; ?>assets/css/custom.css" rel="stylesheet">

        <!-- Animate CSS -->
        <link href="<?php echo base_url; ?>assets/css/animate.css" rel="stylesheet">

        <!-- Datetime Picker -->
        <link href="<?php echo base_url; ?>assets/vendor/datepicker/bootstrap-datepicker.css" rel="stylesheet">

        <!-- AlertifyJS -->
        <link href="<?php echo base_url; ?>assets/vendor/alertifyjs/css/alertify.css" rel="stylesheet">
        <link href="<?php echo base_url; ?>assets/vendor/alertifyjs/css/alertify.min.css" rel="stylesheet">

        <!-- Allan Malupet Responsive CSS TEMPLATE-->
        <link href="<?php echo base_url; ?>assets/css/purchasingportal.css" rel="stylesheet">

        <!-- Wait Me JS -->
        <link href="<?php echo base_url; ?>assets/vendor/waitme/waitMe.css" rel="stylesheet">


    </head>

    <body id="page-top">

        <nav class="navbar navbar-expand navbar-dark bg-dark static-top">
            <div class="container col-lg-12">
                <div class="container col-lg-2">
                    <div class="text-center d-flex  justify-content">
                        <a class="navbar-brand  mr-1" href="<?php echo base_url ?>application/view/admin"><i class="fas fa-fw fa-handshake"></i> Purchasing</a>
                        <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
                            <i class="fas fa-bars"></i>
                        </button>
                    </div>
                </div>
                <div class="container col-lg-10 ">
                    <div class="float-right">
                        <ul class="navbar-nav navbar-nav-right">

                            <!-- Online -->
                            <li class="nav-item dropdown d-none d-xl-inline-block">
                                <a class="nav-link " id="OnlineDropdown" href="#" data-toggle="dropdown" aria-expanded="false"> 
                                    <button class="btn btn-link btn-sm text-white order-1 order-sm-0 " id="sidebarToggle" href="#">
                                        <i class="fab fa-font-awesome-flag fa-2x"></i>                                       
                                    </button>
                                    <span class="badge badge-danger" style="font-size: 10px;"> 1 </span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="OnlineDropdown">
                                    <button class="dropdown-item mt-2" onclick="Login.manageAccounts();">
                                        PUR-SUR-18-1321
                                    </button>

                                </div>
                            </li>

                            <!-- Notification -->
                            <li class="nav-item dropdown d-none d-xl-inline-block">
                                <a class="nav-link " id="NotificationDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
                                    <button class="btn btn-link btn-sm text-white order-1 order-sm-0 " id="sidebarToggle" href="#">
                                        <i class="fas fa-users fa-2x"></i>
                                    </button>
                                    <span class="badge badge-danger" style="font-size: 10px;"> 1 </span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="NotificationDropdown">
                                    <button class="dropdown-item" onclick="">
                                        <i class="fas fa-circle" style="color: #28a745;"></i> ONLINE USER
                                    </button>
                                </div>
                            </li>


                            <!-- Settings -->
                            <li class="nav-item dropdown d-none d-xl-inline-block">
                                <a class="nav-link " id="SettingsDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
                                    <img class="img-xs rounded-circle top-profile-image"  src="<?php echo $_SESSION['employee_picture']; ?>" alt="Profile image" /> 
                                </a>

                                <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="SettingsDropdown">
                                    <button class="dropdown-item mt-2" onclick="Login.manageAccounts();">
                                        Manage Accounts
                                    </button>
                                    <button class="dropdown-item" onclick="Login.changePassword();">
                                        Change Password
                                    </button>
                                    <button class="dropdown-item" onclick="Login.signOut();">
                                        Sign Out
                                    </button>
                                </div>
                            </li>

                        </ul>
                    </div>
                </div>
            </div>


        </nav>

        <div id="wrapper">

            <!-- Sidebar -->
            <ul class="sidebar navbar-nav">
                <li class="nav-item nav-profile">
                    <div class="nav-link">
                        <div class="user-wrapper">
                            <div class="profile-image">
                                <img  src="<?php echo $_SESSION['employee_picture']; ?>" alt="profile image">
                            </div>
                            <div class="text-wrapper">
                                <p class="profile-name"><span><?php echo $_SESSION["name"]; ?></span></p>
                                <small class="designation"><span><?php echo $_SESSION["position"]; ?></span></small>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="nav-item ">
                    <a class="nav-link dropdown-toggle" href="#" id="drDropDown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-fw fa-file-invoice"></i>
                        <span class="menu-title">Delivery Receipt</span>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="drDropDown">
                        <a class="dropdown-item" href="<?php echo base_url ?>application/view/deliveryreceipt/monitoring.php">Monitoring</a>
                        <a class="dropdown-item" href="<?php echo base_url ?>application/view/deliveryreceipt/request.php">Request</a>
                        <a class="dropdown-item" href="<?php echo base_url ?>application/view/deliveryreceipt/receiving.php">Receiving</a>
                        <a class="dropdown-item" href="<?php echo base_url ?>application/view/deliveryreceipt/reports.php">Reports</a>
                    </div>
                </li>
                <li class="nav-item ">
                    <a class="nav-link dropdown-toggle" href="#" id="drpodown_po" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-fw fa-hand-paper"></i>
                        <span class="menu-title">I & C Order System</span>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="drpodown_po">
                        <a class="dropdown-item" href="<?php echo base_url ?>application/view/cancellationorder/dashboard.php">Dashboard</a>
                        <a class="dropdown-item" href="<?php echo base_url ?>application/view/cancellationorder/request.php">Request</a>
                        <a class="dropdown-item" href="<?php echo base_url ?>application/view/cancellationorder/receiving.php">Receiving</a>
                        <a class="dropdown-item" href="<?php echo base_url ?>application/view/cancellationorder/reports.php">Reports</a>
                    </div>
                </li>
                <li class="nav-item ">
                    <a class="nav-link  side-btn-link" href="#" onclick="Login.signOut();">
                        <i class="fas fa-fw fa-sign-out-alt"></i>
                        <span>Sign Out</span>
                    </a>
                </li>
            </ul>

            

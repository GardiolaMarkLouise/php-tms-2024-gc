
<div class="main-header">
    <!-- Logo Header -->
    <div class="logo-header" data-background-color="blue">
        
        <a href="dashboard" class="logo">
            <img src="assets/img/app-logo.png" alt="navbar brand" class="navbar-brand" style = "max-width: 50px;"> <span class="text-light ml-2 fw-bold" style="font-size:20px">GC-TMS</span>
        </a>
        <button class="navbar-toggler sidenav-toggler ml-auto" type="button" data-toggle="collapse" data-target="collapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon">
                <i class="icon-menu"></i>
            </span>
        </button>
        <div class="nav-toggle">
            <button class="btn btn-toggle toggle-sidebar">
                <i class="icon-menu"></i>
            </button>
        </div>
    </div>
    <!-- End Logo Header -->

    <!-- Navbar Header -->
    <nav class="navbar navbar-header navbar-expand-lg" data-background-color="blue2">
        <div class="container-fluid">
            <ul class="navbar-nav topbar-nav ml-md-auto align-items-center">
                <li class="nav-item dropdown hidden-caret">
                    <a class="nav-link" href="model/logout" id="messageDropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        <?php if(isset($_SESSION['role'])):?>
                            <i class="fas fa-sign-out-alt" style="font-size:24px"></i>
                        <?php else: ?>
                            <i class="icon-login"></i>
                        <?php endif ?>
                    </a>
                </li>
            </ul>
        </div>
        
    </nav>
    <!-- End Navbar -->
</div>
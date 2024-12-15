<?php // function to get the current page name
function PageName()
{
    return substr($_SERVER["SCRIPT_NAME"], strrpos($_SERVER["SCRIPT_NAME"], "/") + 1);
}

$current_page = PageName();
?>

<style>
    @media only screen and (max-width: 990px) {
        .log-out-btn {
            width: 80%;
            margin-top: 20%;
        }
    }

    @media only screen and (min-width: 990px) {
        .log-out-btn {
            display: none;
        }
    }
</style>


<div class="sidebar sidebar-style-2">
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <div class="user">
                <div class="avatar-sm float-left mr-2">
                    <?php if (!empty($_SESSION['avatar'])) : ?>
                        <img src="<?= preg_match('/data:image/i', $_SESSION['avatar']) ? $_SESSION['avatar'] : 'assets/uploads/avatar/' . $_SESSION['avatar'] ?>" alt="..." class="avatar-img rounded-circle">
                    <?php else : ?>
                        <img src="assets/img/person.png" alt="..." class="avatar-img rounded-circle">
                    <?php endif ?>

                </div>
                <div class="info">
                    <a data-toggle="collapse" href="<?= isset($_SESSION['username']) && isset($_SESSION['acc_name']) && ($_SESSION['role'] == 'administrator' || $_SESSION['role'] == 'team leader') ? '#collapseExample' : 'javascript:void(0)' ?>" aria-expanded="true">
                        <span>
                            <?= isset($_SESSION['acc_name']) ? ucfirst($_SESSION['acc_name']) : 'Guest User' ?>
                            <span class="user-level"><?= isset($_SESSION['role']) ? ucfirst($_SESSION['role']) : 'Guest' ?></span>
                            <?php
                            if (isset($_SESSION['acc_name']) && ($_SESSION['role'] == 'administrator' || $_SESSION['role'] == 'team leader')) {
                                echo '<span class="caret"></span>';
                            }
                            ?>
                        </span>
                    </a>
                    <div class="clearfix"></div>
                    <div class="collapse in" id="collapseExample">
                        <ul class="nav">
                            <li>
                                <a href="#changepass" data-toggle="modal">
                                    <span class="link-collapse">Change Password</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <ul class="nav nav-primary">
                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                    </span>
                </li>
                <li class="nav-item">
                    <a href="dashboard">
                        <i class="fas fa-home"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="employees">
                        <i class="fa fa-users"></i>
                        <p>Employees</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="teams">
                        <i class="fa fa-sitemap"></i>
                        <p>Teams</p>
                    </a>
                </li>

                <!-- ======================================== -->
                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <h4 class="text-section">Others</h4>
                </li>
                <!-- ======================================== -->


                <li class="nav-item <?= $current_page == 'manage_users' ? 'active' : null ?>">
                    <a href="manage_users">
                        <i class="fas fa-user-secret"></i>
                        <p>Manage Users</p>
                    </a>
                </li>

                <li class="nav-item <?= $current_page == 'manage_depts' ? 'active' : null ?>">
                    <a href="manage_depts">
                        <i class="fas fa-building"></i>
                        <p>Manage Departments</p>
                    </a>
                </li>

                <li class="nav-item <?= $current_page == 'manage_sports' ? 'active' : null ?>">
                    <a href="manage_sports">
                        <i class="fas fa-volleyball-ball"></i>
                        <p>Manage Sports</p>
                    </a>
                </li>

                <li class="nav-item <?= $current_page == 'manage_teams' ? 'active' : null ?>">
                    <a href="manage_teams">
                        <i class="fas fa-list-ul"></i>
                        <p>Manage Teams</p>
                    </a>
                </li>


                <!-- ======================================== -->
                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <h4 class="text-section">Template</h4>
                </li>
                <!-- ======================================== -->


                <li class="nav-item">
                    <a onclick="exportTemplate()" >
                        <i class="fa fa-file"></i>
                        <p>Export Template</p>
                    </a>
                </li>

                <center>
                <a href = "model/logout">
                    <button type="button" class="btn btn-danger log-out-btn">Sign Out</button>
                </a>
                </center>


            </ul>
        </div>
    </div>
</div>

<script>
    function validatePassword() {
        var password = document.getElementById("new_pass").value;
        var uppercaseRegex = /[A-Z]/;
        var symbolRegex = /[!@#$%^&*()_+{}\[\]:;<>,.?~\\]/;

        if (password.length < 8) {
            alert("Password must be at least 8 characters long.");
            return false;
        }
        
        if (!uppercaseRegex.test(password)) {
            alert("Password must contain at least one uppercase letter.");
            return false;
        }

        if (!symbolRegex.test(password)) {
            alert("Password must contain at least one symbol (!@#$%^&*()_+{}[]:;<>,.?~\\).");
            return false;
        }

        return true;
    }
</script>

<script>
    function exportTemplate() {
        console.log("test");
        // Make an AJAX request to a PHP script
        $.ajax({
            url: 'model/export_template_csv.php',
            method: 'POST',
            data: {
                id: null,
            },
            success: function(response) {
                // Create a Blob from the CSV data
                var blob = new Blob([response], { type: 'data:text/csv;charset=utf-8;' });

                // Generate a filename based on the current date and time
                var currentDate = new Date();
                var formattedDate = currentDate.getFullYear() + '-' + padNumber(currentDate.getMonth() + 1) + '-' + padNumber(currentDate.getDate());
                // var formattedTime = padNumber(currentDate.getHours()) + padNumber(currentDate.getMinutes()) + padNumber(currentDate.getSeconds());
                var filename = 'Template_' + formattedDate + '.csv';

                // Create a temporary link and trigger the download
                var link = document.createElement('a');
                link.href = window.URL.createObjectURL(blob);
                link.download = filename;
                link.click();
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }

    // Function to pad single-digit numbers with a leading zero
    function padNumber(num) {
        return num < 10 ? '0' + num : num;
    }
</script>
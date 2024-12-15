<style>
    /* Chrome, Safari, Edge, Opera */
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /* Firefox */
    input[type=number] {
        -moz-appearance: textfield;
    }
</style>

<!-- Modal -->
<div class="modal fade" id="changepass" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Change Password</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="model/change_password.php" onsubmit="return validatePassword()">
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" class="form-control" placeholder="Enter Name" readonly name="username" value="<?= $_SESSION['username'] ?>" required>
                    </div>
                    <div class="form-group form-floating-label">
                        <label>Current Password</label>
                        <input type="password" id="cur_pass" class="form-control" placeholder="Enter Current Password" name="cur_pass" required>
                        <span toggle="#cur_pass" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                    </div>
                    <div class="form-group form-floating-label">
                        <label>New Password</label>
                        <input type="password" id="new_pass" class="form-control" placeholder="Enter New Password" name="new_pass" required>
                        <span toggle="#new_pass" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                    </div>
                    <div class="form-group form-floating-label">
                        <label>Confirm Password</label>
                        <input type="password" id="con_pass" class="form-control" placeholder="Confirm Password" name="con_pass" required>
                        <span toggle="#con_pass" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">Change</button>
            </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Import CSV</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="model/importData.php" id="importFrm" enctype="multipart/form-data">
                    <input type="hidden" name="size" value="1000000">
                    <div class="form-group form-floating-label">
                        <input type="file" name="file" />
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <input type="submit" class="btn btn-primary" name="importSubmit" value="Import">
            </div>
            </form>
        </div>
    </div>
</div>

<!-- Restore -->
<div class="modal fade" id="restore" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <?php if (isset($_SESSION['username'])) : ?>
                <form method="POST" action="model/restore_employee.php">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Restore Database</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group form-floating-label">
                            <label>Are you sure you want to restore all the archived data?</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" action="model/restore_employee.php" class="btn btn-primary" name="restore_data_btn">Restore</button>
                    </div>
                </form>
            <?php endif ?>
        </div>
    </div>
</div>
</form>

<!-- Edit Profile -->
<div class="modal fade" id="edit_profile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create System User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="model/edit_profile.php" enctype="multipart/form-data">
                    <input type="hidden" name="size" value="1000000">
                    <div class="text-center">
                        <div id="my_camera" style="height: 250;" class="text-center">
                            <?php if (empty($_SESSION['avatar'])) : ?>
                                <img src="assets/img/person.png" alt="..." class="img img-fluid" width="250">
                            <?php else : ?>
                                <img src="<?= preg_match('/data:image/i', $_SESSION['avatar']) ? $_SESSION['avatar'] : 'assets/uploads/avatar/' . $_SESSION['avatar'] ?>" alt="..." class="img img-fluid" width="250">
                            <?php endif ?>
                        </div>
                        <div class="form-group d-flex justify-content-center">
                            <button type="button" class="btn btn-danger btn-sm mr-2" id="open_cam">Open Camera</button>
                            <button type="button" class="btn btn-secondary btn-sm ml-2" onclick="save_photo()">Capture</button>
                        </div>
                        <div id="profileImage">
                            <input type="hidden" name="profileimg">
                        </div>
                        <div class="form-group">
                            <input type="file" class="form-control" name="img" accept="image/*">
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <input type="hidden" value="<?= $_SESSION['id']; ?>" name="id">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
            </form>
        </div>
    </div>
</div>


<!-- Add Employee -->
<div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add New Employee</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="model/save_employee.php">
                    <input type="hidden" name="size" value="1000000">
                    <div class="row">
                        <div class="col-md-4">


                            <div class="form-group">
                                <label>Employee ID No.</label>
                                <input type="number" class="form-control" name="emp_id_no" placeholder="Enter Employee ID" min="1" required>
                            </div>
                            <div class="form-group">
                                <label>First Name</label>
                                <input type="text" class="form-control" name="fname" placeholder="Enter First Name" required>
                            </div>
                            <div class="form-group">
                                <label>Middle Name</label>
                                <input type="text" class="form-control" name="mname" placeholder="Enter Middle Name">
                            </div>
                            <div class="form-group">
                                <label>Last Name</label>
                                <input type="text" class="form-control" name="lname" placeholder="Enter Last Name" required>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label>Department</label>
                                        <select class="form-control" required name="dept">
                                            <option disabled selected>Select Department</option>
                                            <?php foreach ($dept as $row) : ?>
                                                <option value="<?= ucwords($row['name']) ?>"><?= $row['name'] ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label>Contact No. (+63)</label>
                                        <input type="number" class="form-control" name="contact" placeholder="Ex: 9876543210" min="9000000001" max="9999999999">
                                    </div>
                                </div>
                            </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label>Age</label>
                                        <input type="number" class="form-control" placeholder="Enter Age" name="age" min="21" max="65" required>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label>Sex</label>
                                        <select class="form-control" required name="gender">
                                            <option disabled selected value="">Select Sex</option>
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Status</label>
                                        <select class="form-control" name="stat" id="stat" required>
                                        <option disabled selected value="">Select Status</option>
                                            <option value="Fit">Fit</option>
                                            <option value="On-Leave">On Leave</option>
                                            <option value="On Official Time">On Official Time</option>
                                            <option value="On Official Business">On Official Business</option>
                                            <option disabled value=""  class="text-danger">     ---Health Condition---</option>
                                            <option value="PWD">PWD</option>
                                            <option value="Fever">Fever</option>
                                            <option value="Asthma">Asthma</option>
                                            <option value="Pregnant">Pregnant</option>
                                            <option value="Allergies">Allergies</option>
                                            <option value="Heart Disease">Heart Disease</option>
                                            <option value="Cancer">Cancer</option>
                                            <option value="Cardiovascular Disease">Cardiovascular Disease</option>
                                            <option value="Diabetes">Diabetes</option>
                                            <option value="Hypertension">Hypertension</option>
                                            <option value="Injuries">Injuries</option>
                                            <option value="Stroke">Stroke</option>
                                        </select>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label>Sports</label>
                                        <select class="form-control" name="sportsAdd[]" id="sportsAdd" size="5" multiple>
                                            <!-- <option disabled selected>Select Sports</option> -->
                                            <?php foreach ($sports as $row) : ?>
                                                <option value="<?= $row['name'] ?>"><?= $row['name'] ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col">
                                    <div class="form-group">
                                        <!-- leave this blank for spacing -->
                                    </div> 
                                </div>
                            </div>
                            
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Employee -->
<div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit/View Employee Information</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="model/edit_employee.php" enctype="multipart/form-data">
                    <input type="hidden" name="size" value="1000000">
                    <div class="row">
                        <div class="col-md-4">
                            <!-- id of edit keep hidden -->
                            <input class="form-control" name="page" id="page" hidden> 
                            <input class="form-control" name="real_id" id="id" hidden> 

                            <div class="form-group">
                                <label>Employee ID No.</label>
                                <input type="number" class="form-control" name="emp_id_no" id="emp_id_no" placeholder="Enter Employee ID" min="1" required>
                            </div>
                            <div class="form-group">
                                <label>First Name</label>
                                <input type="text" class="form-control" name="fname" id="fname" placeholder="Enter First Name" required>
                            </div>
                            <div class="form-group">
                                <label>Middle Name</label>
                                <input type="text" class="form-control" name="mname" id="mname" placeholder="Enter Middle Name">
                            </div>
                            <div class="form-group">
                                <label>Last Name</label>
                                <input type="text" class="form-control" name="lname" id="lname" placeholder="Enter Last Name" required>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label>Department</label>
                                        <!-- <input name="dept" id="deptInput"> -->
                                        <select class="form-control" name="department" id="department" required>
                                            <!-- <option disabled selected>Select Department</option> -->
                                            <?php foreach ($dept as $row) : ?>
                                                <option value="<?= ucwords($row['name']) ?>"><?= $row['name'] ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div> 
                                <div class="col">
                                    <div class="form-group">
                                        <label>Contact No. (+63)</label>
                                        <input type="number" class="form-control" placeholder="Ex: 9876543210" name="contact" id="contact" min="9000000001" max="9999999999">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label>Age</label>
                                        <input type="number" class="form-control" placeholder="Enter Age" name="age" id="age" min="21" max="65">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label>Sex</label>
                                        <select class="form-control" name="gender" id="gender" required>
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Status</label>
                                        <select class="form-control" name="stat" id="statedit" required>
                                            <option value="Fit">Fit</option>
                                            <option value="On-Leave">On Leave</option>
                                            <option value="On Official Time">On Official Time</option>
                                            <option value="On Official Business">On Official Business</option>
                                            <option disabled value=""  class="text-danger">     ---Health Condition---</option>
                                            <option value="PWD">PWD</option>
                                            <option value="Fever">Fever</option>
                                            <option value="Asthma">Asthma</option>
                                            <option value="Pregnant">Pregnant</option>
                                            <option value="Allergies">Allergies</option>
                                            <option value="Heart Disease">Heart Disease</option>
                                            <option value="Cancer">Cancer</option>
                                            <option value="Cardiovascular Disease">Cardiovascular Disease</option>
                                            <option value="Diabetes">Diabetes</option>
                                            <option value="Hypertension">Hypertension</option>
                                            <option value="Injuries">Injuries</option>
                                            <option value="Stroke">Stroke</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Sports</label>
                                        <select class="form-control" name="sports[]" id="sports" size="5" multiple>
                                            <!-- <option disabled selected>Select Sports</option> -->
                                            <?php foreach ($sports as $row) : ?>
                                                <option value="<?= $row['name'] ?>"><?= $row['name'] ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div> 
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Team</label>
                                        <select class="form-control" name="team" id="team">
                                            <option disabled selected>Select Team</option>
                                            <?php foreach ($teams as $row) : ?>
                                                <option value="<?= $row['team_name'] ?>"><?= $row['team_name'] ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                    <label>Team Leader</label>
                                        <select class="form-control" name="team_leader" id="team_leader">
                                            <option value="Yes">Yes</option>
                                            <option value="No">No</option>
                                        </select>
                                    </div>
                                </div>
                            </div> -->

                            <div class="row">
                                <div class="form-group">
                                    <label>Team Leader</label>
                                    <select class="form-control" name="team_leader" id="team_leader">
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
                                </div>
                            </div>



                            </div>
                        </div>
            </div>
            <div class="modal-footer">
                <input type="hidden" name="id" id="emp_id">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <?php if (isset($_SESSION['username'])) : ?>
                    <button type="submit" class="btn btn-primary">Update</button>
                <?php endif ?>
            </div>
            </form>
        </div>
    </div>
</div>

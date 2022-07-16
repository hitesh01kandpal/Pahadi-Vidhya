<?php
include "../includes/config.php";
include "../includes/random_color.php";
if (!isset($_SESSION['user_id']) || !isset($_SESSION['type']) || $_SESSION['user_id'] == Null || $_SESSION['type'] == Null ||  $_SESSION['type'] != 'admin') {
    header("Location:../login.php");
}
$flag = 0;
$exception_occur = 0;
$role = $_SESSION['type'];
$pageName = basename($_SERVER['PHP_SELF']);
$exception_cause = new Exception();
try {
    if (isset($_POST["submit_add_teacher"])) {
        $f = mysqli_real_escape_string($conn,stripcslashes($_GET["f"]));
        $f_id =  mysqli_real_escape_string($conn,stripcslashes($_POST["f_id"]));
        $f_name =  mysqli_real_escape_string($conn,stripcslashes($_POST["f_name"]));
        $d_id =  mysqli_real_escape_string($conn,stripcslashes($_POST["d_id"]));
        $f_email =   mysqli_real_escape_string($conn,stripcslashes($_POST["f_email"]));
        if (isset($_POST["isAdmin"]))
            $isAdmin = 1;
        else
            $isAdmin = 0;
        if ($f) {
            mysqli_query($conn, "update admin set name='$f_name',dept_id='$d_id',`isAdmin`='$isAdmin',`email`='$f_email' where id='$f_id'");
            mysqli_query($conn, "UPDATE `login` SET `email`='$f_email' WHERE `reg_id`='$f_id'");
        } else {
            mysqli_query($conn, "insert into admin (`id`, `name`, `dept_id`,`email`,`isAdmin`)values('$f_id','$f_name','$d_id','$f_email','$isAdmin')");
            mysqli_query($conn, "insert into login values('$f_id','68e445b4745a37fb5a133fa0fa728400','admin','$f_email',0)");
        }
    } else if (isset($_POST["submit_update_teacher"])) {
        $f_id =   mysqli_real_escape_string($conn,stripcslashes($_POST["f_id"]));
        $res = mysqli_query($conn, "Select id,name,dept_id,email,isAdmin from admin where id='$f_id'");
        $row = mysqli_fetch_array($res);
        $flag = 1;
    } else if (isset($_POST["submit_drop_teacher"])) {
        $f_id =  mysqli_real_escape_string($conn,stripcslashes($_POST["f_id"]));
        mysqli_query($conn, "DELETE FROM `admin` where id='$f_id'");
        mysqli_query($conn, "DELETE FROM `login` where `reg_id`='$f_id'");
    } else if (isset($_POST["csv"])) {
        $handle = fopen($_FILES['filename']['tmp_name'], "r");
        $data=fgetcsv($handle, 1000, ",");
        if( !$data || $data[0]!='id' || $data[1]!='name' || $data[2]!='email' || $data[3]!='dept_id' || $data[4]!='isAdmin' ){
            throw new Exception("The order of Column in CSV file should be : id , name , email , dept_id, isAdmin");
        }
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            mysqli_query($conn, "insert into admin (`id`, `name`,`email`,`dept_id`,`isAdmin`) values('$data[0]','$data[1]','$data[2]','$data[3]','$data[4]')");
            mysqli_query($conn, "insert into login values('$data[0]','68e445b4745a37fb5a133fa0fa728400','admin','$data[2]',0)");
        }
        fclose($handle);
    }
} catch (Exception $except) {
    $exception_occur = 1;
    $exception_cause = $except;
}
?>
<html>

<head>
    <title>
        Manage Admin
    </title>
    <?php include '../includes/cdn.php'; ?>
    <link rel="stylesheet" href="../CSS/admin.css">
    <link rel="stylesheet" href="../CSS/sidebar.css">
    <link rel="stylesheet" href="../CSS/footer.css">
</head>

<body>
    <?php
    if ($exception_occur) : ?>
        <script>
            alert("<?php echo $exception_cause->getMessage() ?>");
        </script>
    <?php endif;
    if ($flag) : ?>
        <script type='text/javascript'>
            $(document).ready(function() {
                $('#modal1').modal('show');
            });
        </script>
    <?php endif;
    include '../includes/sidebar.php'; ?>
    <section class="home">
        <div class="modal fade" id="modal1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" style="margin:0 auto;" id="exampleModalLabel"><?php if ($flag) echo "Update Admin";
                                                                                                else echo "Add Admin"; ?></h5>
                    </div>
                    <div class="modal-body">
                        <form role="form" action="manage_admin.php?f=<?php echo $flag ?>" method="POST" enctype="multipart/form-data" autocomplete="off">
                            <div class="form-group">
                                <label>Admin Id</label>
                                <input type="text" class="form-control input1" name="f_id" placeholder="Enter Admin id" value="<?php if ($flag) echo $row['id'];
                                                                                                                                else echo ""; ?>" required>
                            </div>
                            <div class="form-group">
                                <label> Admin Name</label>
                                <input type="text" class="form-control input1" placeholder="Enter Admin name" name="f_name" value="<?php if ($flag) echo $row['name'];
                                                                                                                                    else echo ""; ?>" required>
                            </div>
                            <div class="form-group">
                                <label> Email</label>
                                <input type="email" class="form-control input1" placeholder="Enter Admin email" name="f_email" value="<?php if ($flag) echo $row['email'];
                                                                                                                                        else echo ""; ?>" required>
                            </div>
                            <div class="form-group">
                                <label>Department Id</label>
                                <select type="text" class="form-control input1" name="d_id" required>
                                    <option value="Administrative" selected>Administrative</option>
                                </select>
                            </div>
                            <!-- <div class="form-group mt-1">
                                <input class="input1" type="checkbox" name="isAdmin" <?php if ($flag && $row['isAdmin']) echo "checked" ?>>
                                <label> Super Admin</label>
                            </div> -->
                            <?php if (!$flag) : ?>
                                <!-- <div class="form-group mt-2">
                                    <input type="checkbox" id="check" name="check" onclick="csvInput(this)">
                                    <label>Update Using CSV File</label>
                                </div> -->
                                <!-- <div class="form-group">
                                    <input class="input1" size="50" type="file" id="file" name="filename" accept=".csv" required hidden disabled>
                                </div> -->
                            <?php endif; ?>
                            <div class="modal-footer">
                                <input type="submit" class="btn btn-default btn-success input1" name="submit_add_teacher" value="<?php if ($flag) echo "Update";
                                                                                                                                    else echo "Add"; ?>" />
                                <button type="submit" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modal2" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" style="margin:0 auto;" id="exampleModalLabel">Update Admin</h5>
                    </div>
                    <div class="modal-body">
                        <form role="form" action="manage_admin.php" method="POST" autocomplete="off">
                            <div class="form-group">
                                <label>Admin Id</label>
                                <input type="text" class="form-control" id="t_id" name="f_id" placeholder="Enter teacher id" required>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-default btn-success" name="submit_update_teacher" value="Proceed" />
                        <button type="submit" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modal3" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" style="margin:0 auto;" id="exampleModalLabel">Drop Admin</h5>
                    </div>
                    <form role="form" action="manage_admin.php" method="POST" autocomplete="off">
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Admin Id</label>
                                <input type="text" class="form-control" id="t_id" name="f_id" placeholder="Enter teacher id" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="submit" class="btn btn-default btn-success" name="submit_drop_teacher" value="Delete" />
                            <button type="submit" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <section id="gallery" style="min-height: calc(100vh - 155px);">
            <div class="container mt-4 ">
                <h1 class="text-center pt-2 pb-2 text">
                    MANAGE ADMIN
                </h1>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 mt-4">
                        <a href="#" data-bs-toggle="modal" data-bs-target="#modal1" style="color:black">
                            <div class="card">
                                <img src="../images/1.png" alt="" class="card-img-top" style="background-color:<?php echo randomhex(); ?>">
                                <div class="card-body">
                                    <h5 class="card-title text-center">Add Admin </h5>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-4 mt-4">
                        <a href="#" data-bs-toggle="modal" data-bs-target="#modal2" style="color:black">
                            <div class="card">
                                <img src="../images/1.png" alt="" class="card-img-top" style="background-color:<?php echo randomhex(); ?>">
                                <div class="card-body">
                                    <h5 class="card-title text-center">Update Admin</h5>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-4 mt-4">
                        <a href="#" data-bs-toggle="modal" data-bs-target="#modal3" style="color:black">
                            <div class="card">
                                <img src="../images/1.png" alt="" class="card-img-top" style="background-color:<?php echo randomhex(); ?>">
                                <div class="card-body">
                                    <h5 class="card-title text-center">Drop Admin</h5>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="form-outline mb-4 mt-5 form-check form-switch">
                    <label>
                        <h6 class="text">View Data</h6>
                    </label>
                    <input class="form-check-input" type="checkbox" id="view_data" onclick="view_toggle()">
                </div>
                <?php
                $id = $_SESSION['user_id'];
                $data = mysqli_query($conn, "Select `id`,`name`,`dept_id`,`email`,`isAdmin` from `admin`where `id`!='$id'"); ?>
                <div class="row mt-4" id="table" style="height: 400px; overflow:auto" hidden>
                    <table class="text-center table table-light" style="height: 10px;">
                        <thead style="position: sticky; top:0;">
                            <tr>
                                <th>Id</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Department</th>
                                <!-- <th>Super Admin</th> -->
                                <th></th>
                            </tr>
                        </thead>
                        <?php
                        while ($row = mysqli_fetch_array($data)) :
                        ?>
                            <tr>
                                <td><?php echo $row['id'] ?></td>
                                <td><?php echo $row['name'] ?></td>
                                <td><a href="mailto: <?php echo $row['email'] ?>" target="_blank"><?php echo $row['email'] ?></a></td>
                                <td><?php echo $row['dept_id'] ?></td>
                                <td><?php if ($row['isAdmin']) echo "Yes";
                                    else echo "No"; ?></td>
                                <td><button class="btn btn-secondary" title="Update"><i class="bx bxs-edit-alt icon " data-id="<?php echo $row['id']; ?>" onclick="update_data(this)"></i></button>
                                    <button class="btn btn-danger" title="Delete"><i class="bx bx-trash-alt icon " data-id="<?php echo $row['id']; ?>" onclick="delete_data(this)"></i></button>
                                </td>
                            </tr>
                        <?php
                        endwhile;
                        ?>
                    </table>
                </div>
        </section>
        <?php include '../includes/footer.php'; ?>
    </section>
    <script type="text/javascript" src="../js/sidebar.js"></script>
    <script>
        // function csvInput(checkBox) {
        //     let tmp = document.querySelectorAll(".input1");
        //     if (checkBox.checked) {
        //         tmp[0].disabled = true;
        //         tmp[1].disabled = true;
        //         tmp[2].disabled = true;
        //         tmp[3].disabled = true;
        //         tmp[4].disabled = true;
        //         tmp[5].hidden = false;
        //         tmp[5].disabled = false;
        //         tmp[6].setAttribute("name", "csv");
        //     } else {
        //         tmp[0].disabled = false;
        //         tmp[1].disabled = false;
        //         tmp[2].disabled = false;
        //         tmp[3].disabled = false;
        //         tmp[4].disabled = false;
        //         tmp[5].disabled = true;
        //         tmp[5].hidden = true;
        //         tmp[6].setAttribute("name", "submit_add_teacher");
        //     }
        // }

        function view_toggle(a) {
            var a = document.getElementById("view_data");
            var x = document.getElementById("table");
            if (a.checked == true)
                x.hidden = false;
            else
                x.hidden = true;
        }

        function update_data(a) {
            var str = $(a).attr("data-id");
            console.log(str);
            $("#modal2 .modal-body #t_id").val(str);
            $('#modal2').modal('show');
        }

        function delete_data(a) {
            var str = $(a).attr("data-id");
            console.log(str);
            $("#modal3 .modal-body #t_id").val(str);
            $('#modal3').modal('show');
        }
    </script>
    <?php include '../includes/checkDarkTheme.php'; ?>
</body>

</html>
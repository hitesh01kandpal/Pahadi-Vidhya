<?php
include "../includes/config.php";
include "../includes/random_color.php";
if(!isset($_SESSION['user_id']) || !isset($_SESSION['type']) || $_SESSION['user_id']==Null || $_SESSION['type']==Null ||  $_SESSION['type']!='admin'){
  header("Location:../login.php");
}
$flag = 0;
$exception_occur = 0;
$role = $_SESSION['type'];
$pageName = basename($_SERVER['PHP_SELF']);
$exception_cause = new Exception();
try {
  if (isset($_POST["submit_add_department"])) {
    $f = mysqli_real_escape_string($conn,stripcslashes( $_GET["f"]));
    $d_id =  mysqli_real_escape_string($conn,stripcslashes($_POST["d_id"]));
    $d_name =  mysqli_real_escape_string($conn,stripcslashes($_POST["d_name"]));
    if ($f) {
      mysqli_query($conn, "update department set dept_name='$d_name' where dept_id='$d_id'");
    } else {
      mysqli_query($conn, "insert into department values('$d_id','$d_name')");
    }
  } else if (isset($_POST["submit_update_department"])) {
    $d_id =  mysqli_real_escape_string($conn,stripcslashes($_POST["d_id"]));
    $res = mysqli_query($conn, "Select dept_id,dept_name from department where dept_id='$d_id'");
    $row = mysqli_fetch_array($res);
    $flag = 1;
  } else if (isset($_POST["submit_drop_department"])) {
    $d_id =  mysqli_real_escape_string($conn,stripcslashes($_POST["d_id"]));
    mysqli_query($conn, "DELETE FROM `department` where dept_id='$d_id'");
  } else if (isset($_POST["csv"])) {
    $handle = fopen($_FILES['filename']['tmp_name'], "r");
    $data=fgetcsv($handle, 1000, ",");
    if( !$data || $data[0]!='dept_id' || $data[1]!='dept_name' ){
        throw new Exception("The order of Column in CSV file should be : dept_id , dept_name");
    }
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
      mysqli_query($conn, "insert into department values('$data[0]','$data[1]')");
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
    Manage Department
  </title>

  <?php include '../includes/cdn.php'; ?>
  <link rel="stylesheet" href="../CSS/admin.css">
  <link rel="stylesheet" href="../CSS/sidebar.css">
  <link rel="stylesheet" href="../CSS/footer.css">

</head>

<body>
  <?php if ($exception_occur) : ?>
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
            <h5 class="modal-title" style="margin:0 auto;" id="exampleModalLabel"><?php if ($flag) echo "Update Department";
                                                                                  else echo "Add Department"; ?></h5>
          </div>
          <div class="modal-body">
            <form role="form" action="manage_department.php?f=<?php echo $flag ?>" method="POST" enctype="multipart/form-data" autocomplete="off">
              <div class="form-group">
                <label>Department Id</label>
                <input type="text" class="form-control input1" name="d_id" placeholder="Enter Department id" value="<?php if ($flag) echo $row['dept_id'];
                                                                                                                    else echo ""; ?>" required>
              </div>
              <div class="form-group">
                <label> Department Name</label>
                <input type="text" class="form-control input1" placeholder="Enter Department name" name="d_name" value="<?php if ($flag) echo $row['dept_name'];
                                                                                                                        else echo ""; ?>" required>
              </div>
              <?php if (!$flag) : ?>
                <!-- <div class="form-group">
                  <input type="checkbox" id="check" name="check" onclick="csvInput(this)">
                  <label>Update Using CSV File</label>
                </div> -->
                <div class="form-group">
                  <input class="input1" size="50" type="file" id="file" name="filename" accept=".csv" required hidden disabled>
                </div>
              <?php endif; ?>
              <div class="modal-footer">
                <input type="submit" class="btn btn-default btn-success input1" name="submit_add_department" value="<?php if ($flag) echo "Update";
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
              <h5 class="modal-title" style="margin:0 auto;" id="exampleModalLabel">Update Department</h5>
            </div>
            <div class="modal-body">
              <form role="form" action="manage_department.php" method="POST" autocomplete="off">
                <div class="form-group">
                  <label>Department Id</label>
                  <input type="text" class="form-control" name="d_id" id="t_id" placeholder="Enter Department id" required>
                </div>
                <div class="modal-footer">
                  <input type="submit" class="btn btn-default btn-success" name="submit_update_department" value="Proceed" />
                  <button type="submit" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
              </form>
            </div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="modal3" role="dialog">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" style="margin:0 auto;" id="exampleModalLabel">Drop Department</h5>
              </div>
              <div class="modal-body">
                <form role="form" action="manage_department.php" method="POST" autocomplete="off">
                  <div class="form-group">
                    <label>Department Id</label>
                    <input type="text" class="form-control" name="d_id" id="t_id" placeholder="Enter Department id" required>
                  </div>
                  <div class="modal-footer">
                    <input type="submit" class="btn btn-default btn-success" name="submit_drop_department" value="Delete" />
                    <button type="submit" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  </div>
                </form>
              </div>
              </div>
            </div>
          </div>
          <section id="gallery" style="min-height: calc(100vh - 155px);">
            <div class="container">
              <div class="container mt-4 ">
                <h1 class="text-center pt-2 pb-2 text">
                  MANAGE DEPARTMENT
                </h1>
              </div>
              <div class="row">
                <div class="col-lg-4 mt-4">
                  <a href="#" data-bs-toggle="modal" data-bs-target="#modal1" style="color:black">
                    <div class="card">
                      <img src="../images/1.png" alt="" class="card-img-top" style="background-color:<?php echo randomhex(); ?>">
                      <div class="card-body">
                        <h5 class="card-title text-center">Add Department </h5>
                  </a>
                </div>
              </div>
            </div>
            <div class="col-lg-4 mt-4">
              <a href="#" data-bs-toggle="modal" data-bs-target="#modal2" style="color:black">
                <div class="card">
                  <img src="../images/1.png" alt="" class="card-img-top" style="background-color:<?php echo randomhex(); ?>">
                  <div class="card-body">
                    <h5 class="card-title text-center">Update Depratment</h5>
                  </div>
                </div>
              </a>
            </div>
            <div class="col-lg-4 mt-4">
              <a href="#" data-bs-toggle="modal" data-bs-target="#modal3" style="color:black">
                <div class="card">
                  <img src="../images/1.png" alt="" class="card-img-top" style="background-color:<?php echo randomhex(); ?>">
                  <div class="card-body">
                    <h5 class="card-title text-center">Drop Depratment</h5>
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
        <?php $data = mysqli_query($conn, "Select * from department"); ?>
        <div class="row mt-4" id="table" style="height: 400px; overflow:auto" hidden>
          <table class="text-center table table-light" style="height: 10px;">
            <thead style="position: sticky; top:0;">
              <tr>
                <th>ID</th>
                <th>Name</th>
                <th></th>
              </tr>
            </thead>
            <?php
            while ($row = mysqli_fetch_array($data)) :
            ?>
              <tr>
                <td><?php echo $row['dept_id'] ?></td>
                <td><?php echo $row['dept_name'] ?></td>
                <td><button class="btn btn-secondary" title="Update"><i class="bx bxs-edit-alt icon " data-id="<?php echo $row['dept_id']; ?>" onclick="update_data(this)"></i></button>
                  <button class="btn btn-danger" title="Delete"><i class="bx bx-trash-alt icon " data-id="<?php echo $row['dept_id']; ?>" onclick="delete_data(this)"></i></button>
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
    //   let tmp = document.querySelectorAll(".input1");
    //   if (checkBox.checked) {
    //     tmp[0].disabled = true;
    //     tmp[1].disabled = true;
    //     tmp[2].hidden = false;
    //     tmp[2].disabled = false;
    //     tmp[3].setAttribute("name", "csv");
    //   } else {
    //     tmp[0].disabled = false;
    //     tmp[1].disabled = false;
    //     tmp[2].hidden = true;
    //     tmp[2].disabled = true;
    //     tmp[3].setAttribute("name", "submit_add_department");
    //   }
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
      $(".modal-body #t_id").val(str);
      $('#modal2').modal('show');
    }

    function delete_data(a) {
      var str = $(a).attr("data-id");
      console.log(str);
      $(".modal-body #t_id").val(str);
      $('#modal3').modal('show');
    }
  </script>
  <?php include '../includes/checkDarkTheme.php'; ?>
</body>

</html>
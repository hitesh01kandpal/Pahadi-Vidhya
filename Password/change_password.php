<?php
include "../includes/config.php";
if (isset($_SESSION['user_id']))
  $id = $_SESSION['user_id'];
else
  $id = mysqli_real_escape_string($conn, stripcslashes($_GET["id"]));
$same_pass = 0;
$wrong_pass = 0;
$def_pass=0;
$password_changed = 0;
$exception_occur = 0;
$check_profile = 0;
$exception_cause = new Exception();
try {
  if (isset($_POST["submit"])) {
    $pass1 =  md5(mysqli_real_escape_string($conn, stripcslashes($_POST['pass1'])));
    $pass2 = md5(mysqli_real_escape_string($conn, stripcslashes($_POST['pass2'])));
    if ($pass1 == $pass2) {
      if ($pass1 != "68e445b4745a37fb5a133fa0fa728400") {
        $cur_pass = mysqli_query($conn, "SELECT  `password` FROM `login` WHERE `reg_id`='$id'");
        $cur_pass = mysqli_fetch_array($cur_pass);
        
        if($cur_pass['password']!=$pass1){     
          if ($cur_pass['password'] == "68e445b4745a37fb5a133fa0fa728400") {
          $check_profile = 1;
        }
        mysqli_query($conn, "update `login` set password='$pass2' where reg_id='$id'");
        $password_changed = 1;
      } else {
        $same_pass = 1;
      }
    }
    else{
      $def_pass=1;

    }
    } else {
      $wrong_pass = 1;
    }
  }
} catch (Exception $except) {
  $exception_occur = 1;
  $exception_cause = $except;
}
?>


<html>

<head>

  <link rel="stylesheet" href="../CSS/login.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.16/dist/sweetalert2.all.min.js"></script>
  <script type="text/javascript" src="../js/login.js"></script>

  <title>Change Password</title>
  <link rel="icon" href="../images/favicon.ico" type="image/x-icon">

</head>

<body id="change_pass">
  <?php if ($exception_occur) : ?>
    <script>
      alert("<?php echo $exception_cause->getMessage() ?>");
    </script>
  <?php endif;
  if ($password_changed && $check_profile) : ?>
    <script>
      window.location = '../includes/profile.php';
    </script>
  <?php elseif ($password_changed) : ?>
    <script>
      Swal.fire({
        icon: 'success',
        title: 'Password Changed Successfully!',
        timer: 10000
      }).then(function() {
        window.location = '../includes/logout.php'; 
      });
    </script>
  <?php endif; ?>
  <section class="h-100 gradient-form">
    <div class="container h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-xl-10">
          <div class="card rounded-3 text-black">
            <div class="row g-0">
              <div class="col-lg-6">
                <div class="card-body p-md-5 mx-md-4">

                  <div class="text-center mb-4">
                    <img src="../images/logo.png" id="logo" style="width: 180px;" alt="logo">
                  </div>

                  <form method="POST" action="change_password.php?id=<?php echo $id;?>" autocomplete="off">
                    <?php if ($same_pass) : ?>
                      <div class="alert alert-danger" role="alert">Cannot use previous password!</div>
                    <?php endif; ?>
                    <?php if ($wrong_pass) : ?>
                      <div class="alert alert-danger" role="alert">Password does not match!</div>
                    <?php endif; ?>
                    <?php if ($def_pass) : ?>
                      <div class="alert alert-danger" role="alert">Cannot Use Default password!</div>
                    <?php endif; ?>
                    <p><strong>Enter New Password</strong></p>
                    <div class="form-outline mb-4">
                      <input type="password" name="pass1" class="form-control pass_toggle" placeholder="New Password" required/>
                    </div>

                    <div class="form-outline mb-4">
                      <input type="password" name="pass2" class="form-control pass_toggle" placeholder="Confirm Password" required/>
                    </div>
                    <div class="form-outline mb-4 form-check form-switch">
                      <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault " onclick="pass_toggle()">
                      <h6>Show password</h6>
                    </div>
                    <div class="text-center pt-1 mb-5 pb-1">
                      <input class="btn btn-primary btn-sm gradient-custom-2 mb-3" type="submit" name="submit" value="Submit" />
                    </div>

                  </form>

                </div>
              </div>
              <div class="col-lg-6 d-flex align-items-center">
                <div class="mySlides fade">
                  <img src="../images/quote1.jpg" alt="logo" style="width: 100%;">
                </div>
                <div class="mySlides fade">
                  <img src="../images/quote2.png" alt="logo" style="width: 100%;">
                </div>
                <div class="mySlides fade">
                  <img src="../images/quote3.jpg" alt="logo" style="width: 100%;">
                </div>
                <div class="mySlides fade">
                  <img src="../images/quote4.jpg" alt="logo" style="width: 100%;">
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <script>
    var slideIndex = 0;
    showSlides();
  </script>
</body>

</html>
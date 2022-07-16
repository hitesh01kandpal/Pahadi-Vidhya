<?php
include "includes/config.php";
$wrong_pass = 0;
$default_pass = 0;
$exception_occur = 0;
$exception_cause = new Exception();
try {
  if (isset($_SESSION['user_id']) && $_SESSION['type']) {
    if ($_SESSION['type'] == "teacher" || $_SESSION['type'] == "student")
      header("Location:NonAdmin/dashboard.php");
    elseif ($_SESSION['type']  == "admin")
      header("Location:Admin/admin_dashboard.php");
  } else if (isset($_POST["submit"])) {
    $registration_Id =  mysqli_real_escape_string($conn,stripcslashes($_POST["id"]));
    $passwordCopy =   mysqli_real_escape_string($conn,stripcslashes($_POST["password"]));
    $password= md5($passwordCopy);
    $res = mysqli_query($conn, "select role from login where reg_id='$registration_Id' and password='$password'");
    $row = mysqli_fetch_array($res);
    if ($row) {
      if(isset($_POST['remember']))
        $remember = 1;
      else
        $remember=0;
      $_SESSION['user_id'] = $registration_Id;
      $_SESSION['type'] = $row['role'];
      if ($remember) {
        setcookie('username', $registration_Id, time() + (86400 * 7));
        setcookie('password', $passwordCopy, time() + (86400 * 7));
      }
      if ($password == "68e445b4745a37fb5a133fa0fa728400") {
        $default_pass = 1;
      } elseif ($row['role'] == "teacher" || $row['role'] == "student")
        header("Location:NonAdmin/dashboard.php");
      elseif ($row['role'] == "admin")
        header("Location:Admin/admin_dashboard.php");
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
  <link rel="stylesheet" href="CSS/login.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.16/dist/sweetalert2.all.min.js"></script>
  <script type="text/javascript" src="js/login.js"></script>
  <title>Pahadi Vidhya</title>
  <link rel="icon" href="images/LOGO1.webp" type="image/x-icon">
</head>

<body>
  <?php
if (isset($_COOKIE['theme'])) {
         $theme= $_COOKIE['theme'];
         $_SESSION['theme']=$theme;
      } else {
        $_SESSION['theme'] = 'light';
      }?>
  <?php if ($exception_occur) : ?>
    <script>
      alert("<?php echo $exception_cause->getMessage() ?>");
    </script>
  <?php endif;
  if ($default_pass) : ?>
    <script>
      Swal.fire({
        icon: 'warning',
        title: 'Login Successfull Buddy!',
        text: 'Update your default password',
        timer: 10000
      }).then(function() {
        window.location = 'Password/change_password.php';
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
                  <div class="text-center">
                    <img src="images/LOGO1.webp" id="logo" style="width: 180px;" alt="logo">
                  </div>
                  <p id="error"></p>
                  <form method="POST" action="login.php" autocomplete="off">
                    <p><strong>Please login to your account</strong></p>

                    <div class="form-outline mb-4">
                      <input type="integer" name="id" required class="form-control" placeholder="Registration Number" value="<?php if (isset($_COOKIE['username'])) echo $_COOKIE['username']; ?>" />
                    </div>

                    <div class="form-outline mb-4">
                      <input type="password" name="password" required class="form-control pass_toggle" placeholder="Password" value="<?php if (isset($_COOKIE['password'])) echo $_COOKIE['password']; ?>" />
                      <p id="error_pass"></p>
                    </div>
                    <div class="form-outline mb-4 form-check form-switch">
                      <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault " onclick="pass_toggle()">
                      <h6>Show password</h6>
                      <input class="form-check-input" type="checkbox" name="remember">
                      <h6>Remember me</h6>
                    </div>
                    <div class="text-center pt-1 mb-5 pb-1">
                      <input class="btn btn-primary btn-sm gradient-custom-2 mb-3" type="submit" name="submit" value="Log In" />
                      <br>
                      <a class="text-muted" href="Password/forget.php">Forgot password?</a>
                    </div>

                  </form>

                </div>
              </div>
              <div class="col-lg-6 d-flex align-items-center">
                <div class="mySlides fade">
                  <img src="images/graphichill.jpeg" alt="logo" style="width: 100%;">
                </div>
                <div class="mySlides fade">
                  <img src="images/academics.jpeg" alt="logo" style="width: 100%;">
                </div>
                <div class="mySlides fade">
                  <img src="images/qw.jpeg" alt="logo" style="width: 100%;">
                </div>
                <div class="mySlides fade">
                  <img src="images/quote4.jpg" alt="logo" style="width: 100%;">
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

  <?php if ($wrong_pass == 1) : ?>
    <script>
      document.getElementById("error").innerHTML +=
        '<div class="alert alert-danger" role="alert">Invalid login, please try again</div>';
    </script>
  <?php endif; ?>
</body>

</html>
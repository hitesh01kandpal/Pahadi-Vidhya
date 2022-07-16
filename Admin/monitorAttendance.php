<?php
include "../includes/config.php";
if (!isset($_SESSION['user_id']) || !isset($_SESSION['type']) || $_SESSION['user_id'] == Null || $_SESSION['type'] == Null ||  $_SESSION['type'] != 'admin') {
    header("Location:../login.php");
}
$id = $_SESSION['user_id'];
$role = $_SESSION['type'];
$pageName = basename($_SERVER['PHP_SELF']);
$exception_occur = 0;
$exception_cause = new Exception();
try {
$res = mysqli_query($conn, "SELECT `course_name`,`course_id` FROM `courses`");
}catch (Exception $except) {
    $exception_occur = 1;
    $exception_cause = $except;
  }
?>
<html>

<head>
    <title>
        Monitor Attendance
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
     include '../includes/sidebar.php'; ?>
    <section class="home">
        <div class="container mt-4 ">
            <h1 class="text-center pt-2 pb-2 text">
                Monitor Attendance
            </h1>
        </div>
        <div class="container mt-4" style="min-height: calc(100vh - 230px);">
            <div class="container mt-2 ">
                <?php
                $c = 0;
                while ($row = mysqli_fetch_array($res)) :
                    if ($c % 3 == 0) : ?>
                        <div class="row">
                        <?php endif;
                    $c = $c + 1;
                    $counter = $row['course_id'];
                    $t = $row['course_name'];
                        ?>
                        <div class="col-lg-4 mb-4 mt-4 ">
                            <a href="../Attendance/attendance.php?course=<?php echo $counter ?>" style="color:black; text-decoration: none;">
                                <div class="card">
                                    <h5 class="card-title text-center mt-2"><b><?php echo $t ?></b></h5>
                                    <img src="https://news.miami.edu/life/_assets/images/images-stories/2019/08/faculty-new-year-940x529.jpg" alt="" class="card-img-top">
                                    <div class="card-body">
                                        <h5 class="card-title text-center"><b><?php echo strtoupper($counter); ?></b></h5>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <?php if ($c % 3 == 0) : ?>
                        </div>
                <?php endif;
                    endwhile; ?>
            </div>
        </div>
        </div>
        <?php include '../includes/footer.php'; ?>
    </section>
    <script type="text/javascript" src="../js/sidebar.js"></script>
    <?php include '../includes/checkDarkTheme.php'; ?>
</body>

</html>
<?php
include "../includes/config.php";
if (!isset($_SESSION['user_id']) || !isset($_SESSION['type']) || $_SESSION['user_id'] == Null || $_SESSION['type'] == Null ||  $_SESSION['type'] == 'admin') {
  header("Location:../login.php");
}
$id = $_SESSION['user_id'];
$role = $_SESSION['type'];
$exception_occur = 0;
$exception_cause = new Exception();
try {
$pageName = basename($_SERVER['PHP_SELF']);
if ($role == 'student') {
  $res = mysqli_query($conn, "SELECT course_id FROM `assign` WHERE student_id='$id'");
} else {
  $res = mysqli_query($conn, "SELECT course_id FROM `teaches` WHERE teacher_id='$id'");
}
}catch (Exception $except) {
  $exception_occur = 1;
  $exception_cause = $except;
}
?>
<html>

<head>
  <title>
    <?php if ($role == 'teacher') : ?>
      Teacher Dashboard
    <?php else : ?>
      Student Dashboard
    <?php endif; ?>
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
        DASHBOARD
      </h1>
    </div>
    <div class="container border border-3 d-grid gap-3 px-4 mt-4" style="min-height: calc(100vh - 231px);">
      <div class="container mt-2 ">
        <?php
        $c = 0;
        while ($row = mysqli_fetch_array($res)) :
          if ($c % 3 == 0) : ?>
            <div class="row">
          <?php endif;
          $c = $c + 1;
          $counter = $row['course_id'];
          $t = mysqli_query($conn, "SELECT `course_name` FROM `courses` where course_id='$counter'");
          $t = mysqli_fetch_array($t);
          $t = $t["course_name"];
          if ($role == 'student') {
            $totalLectures = 0;
            $selectedLectures = 0;
            $progress_name = $counter .'p';
            $colname = $id . 'S';
            $progress = mysqli_query($conn, "SELECT `$colname` FROM `$progress_name`");
            while ($checked = mysqli_fetch_array($progress)) {
              $totalLectures++;
              if ($checked[$colname]!=date("0000-00-00 00:00:00")) {
                $selectedLectures++;
              }
            }
            if ($totalLectures == 0) {
              $percentage = 100;
            } else {
              $percentage = round(($selectedLectures / $totalLectures) * 100);
            }
          } ?>
            <div class="col-lg-4 mb-4 mt-4 ">
              <a href="../Courses/template.php?course=<?php echo $counter ?>&course_name=<?php echo $t ?>" style="color:black; text-decoration: none;">
                <div class="card">
                  <h5 class="card-title text-center mt-2"><b><?php echo $t ?></b></h5>
                  <img src="https://news.miami.edu/life/_assets/images/images-stories/2019/08/faculty-new-year-940x529.jpg" alt="" class="card-img-top">
                  <div class="card-body">
                    <?php if ($role == "student") : ?>
                      <div class="progressBar" style="height: 15px;background-color: lightgray;border-radius: 30px;">
                        <div class="progressBarFill" style=" width: <?php echo $percentage ?>%;height: 15px;background-color: green;border-radius: 30px;"></div>
                      </div>
                      <div style="height: 15px; text-align: center; margin-bottom:1px;"><?php echo $percentage . '%'; ?></div>
                    <?php else : ?>
                      <h5 class="card-title text-center"><b><?php echo strtoupper($counter); ?></b></h5>
                    <?php endif; ?>
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
<?php
include "../includes/config.php";
if(!isset($_SESSION['user_id']) || !isset($_SESSION['type']) || $_SESSION['user_id']==Null || $_SESSION['type']==Null ||  $_SESSION['type']=='student'){
  header("Location:../login.php");
}
$role = $_SESSION['type'];
$pageName = basename($_SERVER['PHP_SELF']);
$course = $_GET["course"];
$exception_occur = 0;
$exception_cause = new Exception();
try {
if($role=='teacher'){
  $id=$_SESSION['user_id'];
  $allowed= mysqli_query($conn, "SELECT `course_id` FROM `teaches` WHERE `course_id`='$course' AND `teacher_id`='$id' ");
  if(!mysqli_num_rows($allowed)){
    header("Location:../login.php");
  }
}
$courseAttendance = $course . 'p';
}catch (Exception $except) {
  $exception_occur = 1;
  $exception_cause = $except;
}
?>
<html>
<head>
  <title>Attendance</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php include '../includes/cdn.php'; ?>
  <link rel="stylesheet" href="../CSS/discussion.css">
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
        ATTENDANCE (<?php echo strtoupper($course); ?>)
      </h1>
    </div>
    <div class="container" style="min-height: calc(100vh - 231px);">
      <?php
      $columns = mysqli_query($conn, "SELECT `COLUMN_NAME` 
                FROM `INFORMATION_SCHEMA`.`COLUMNS` 
                WHERE `TABLE_NAME`='$courseAttendance'");
      mysqli_fetch_array($columns);
      ?>
      <div class="row mt-4" id="table" style="height: 400px; overflow:auto">
        <table class="text-center table table-light" style="height: 10px;">
          <thead style="position: sticky; top:0;">
            <tr>
              <th>Registration Id</th>
              <th>Name</th>
              <th>Email</th>
              <th>Phone No</th>
              <th>Attendance % </th>
            </tr>
          </thead>
          <?php
          while ($id = mysqli_fetch_array($columns)) :
            $studentId = $id['COLUMN_NAME'];
            $totalLectures = 0;
            $selectedLectures = 0;
            $progress = mysqli_query($conn, "SELECT `$studentId` FROM `$courseAttendance`");
            $attendanceTime = mysqli_query($conn, "SELECT `attendanceTime` FROM `$course`");
            while ( ($studentCheckedTime = mysqli_fetch_array($progress) ) && ($courseCheckedTime = mysqli_fetch_array($attendanceTime)) ) {
              $totalLectures++;
              if ( ($studentCheckedTime[$studentId]!=date("0000-00-00 00:00:00")) && ($courseCheckedTime['attendanceTime'] >=$studentCheckedTime[$studentId] ) ) {
                $selectedLectures++;
              }
            }
            if ($totalLectures == 0) {
              $percentage = 100;
            } else {
              $percentage = round(($selectedLectures / $totalLectures) * 100);
            }
            $studentId = substr($studentId, 0, strlen($studentId) - 1);
            $student = mysqli_query($conn, "SELECT `name`, `phone`, `email` FROM `student` WHERE `id`='$studentId' ");
            $student = mysqli_fetch_array($student);
          ?>
            <tr>
              <td><?php echo $studentId ?></td>
              <td><?php echo $student['name'] ?></td>
              <td><a href="mailto: <?php echo $student['email']?>" target="_blank"><?php echo $student['email'] ?></a></td>
              <td><?php echo $student['phone'] ?></td>
              <td><?php echo $percentage ?> %</td>
            </tr>
          <?php endwhile; ?>
        </table>
      </div>
    </div>
    <?php include '../includes/footer.php'; ?>
  </section>
  <script type="text/javascript" src="../js/sidebar.js"></script>
  <?php include '../includes/checkDarkTheme.php'; ?>
</body>
</html>
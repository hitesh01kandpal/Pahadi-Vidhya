<?php
include "../includes/config.php";
if (!isset($_SESSION['user_id']) || !isset($_SESSION['type']) || $_SESSION['user_id'] == Null || $_SESSION['type'] == Null) {
  header("Location:../login.php");
}
$pageName = basename($_SERVER['PHP_SELF']);
$course = $_GET["course"];
$id = $_SESSION['user_id'];
$role = $_SESSION['type'];
$exception_occur = 0;
$exception_cause = new Exception();
try {
  if ($role == 'admin') {
    $isAdmin = mysqli_query($conn, "SELECT `isAdmin` FROM `admin` WHERE `id`='$id' ");
    $isAdmin = mysqli_fetch_array($isAdmin);
    $isAdmin = $isAdmin['isAdmin'];
  } else {
    if ($role == 'teacher') {
      $allowed = mysqli_query($conn, "SELECT `course_id` FROM `teaches` WHERE `course_id`='$course' AND `teacher_id`='$id' ");
    } else if ($role == 'student') {
      $allowed = mysqli_query($conn, "SELECT `course_id` FROM `assign` WHERE `course_id`='$course' AND `student_id`='$id' ");
    }
    if (!mysqli_num_rows($allowed)) {
      header("Location:../login.php");
    }
  }
  $username = mysqli_query($conn, "SELECT name FROM $role WHERE id='$id'");
  $username = mysqli_fetch_array($username);
  $username = $username['name'];
  $courseDiscussion = $course . "d";
  if (isset($_POST["save"])) {
    $pid = mysqli_real_escape_string($conn, stripcslashes($_POST['id']));
    $name = mysqli_real_escape_string($conn, stripcslashes($_POST['name']));
    $msg =  mysqli_real_escape_string($conn, stripcslashes($_POST['msg']));
    if ($role == 'admin' && $isAdmin) {
      $checkedRole = 'superAdmin';
    } else {
      $checkedRole = $role;
    }
    if ($name != "" && $msg != "") {
      mysqli_query($conn, "INSERT INTO $courseDiscussion (`parent_comment`,`student`,`user_id`, `role`, `post`) VALUES ('$pid', '$name','$id','$checkedRole', '$msg')");
    }
  } else if (isset($_POST["btnreply"])) {
    $pid =  mysqli_real_escape_string($conn, stripcslashes($_POST['pid']));
    $name =  mysqli_real_escape_string($conn, stripcslashes($_POST['name']));
    $msg = mysqli_real_escape_string($conn, stripcslashes($_POST['msg']));
    if ($role == 'admin' && $isAdmin) {
      $checkedRole = 'superAdmin';
    } else {
      $checkedRole = $role;
    }
    if ($name != "" && $msg != "") {
      mysqli_query($conn, "INSERT INTO $courseDiscussion (`parent_comment`,`student`,`user_id`,`role`, post) VALUES ('$pid', '$name','$id','$checkedRole', '$msg')");
    }
  } else if (isset($_POST["btnEdit"])) {
    $pid = mysqli_real_escape_string($conn, stripcslashes($_POST['pid']));
    $msg = mysqli_real_escape_string($conn, stripcslashes($_POST['msg']));
    mysqli_query($conn, "UPDATE `$courseDiscussion` SET `post`='$msg' WHERE `id`='$pid' ");
  } else if (isset($_POST["delete"])) {
    $pid =  mysqli_real_escape_string($conn, stripcslashes($_POST['id']));
    mysqli_query($conn, "DELETE  FROM $courseDiscussion where `parent_comment`='$pid' OR `id`='$pid' ");
  }
} catch (Exception $except) {
  $exception_occur = 1;
  $exception_cause = $except;
}
?>
<html>

<head>
  <title>Discussion</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php include '../includes/cdn.php'; ?>
  <link rel="stylesheet" href="../CSS/discussion.css">
  <link rel="stylesheet" href="../CSS/sidebar.css">

</head>

<body>
  <?php if ($exception_occur) : ?>
    <script>
      alert("<?php echo $exception_cause->getMessage() ?>");
    </script>
  <?php endif;
  include '../includes/sidebar.php'; ?>
  <section class="home">
    <div id="ReplyModal" class="modal fade" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header" id="header">
            <h5 class="modal-title" style="margin:0 auto;" id="exampleModalLabel">Reply</h5>
          </div>
          <div class="modal-body">
            <form name="frm1" method="post" action="discussion.php?course=<?php echo $course; ?>">
              <input type="number" id="pid" name="pid" hidden>
              <div class="form-group">
                <input type="text" class="form-control" name="name" value="<?php echo $username; ?>" hidden>
              </div>
              <div class="form-group">
                <label for="comment">Write your reply:</label>
                <textarea class="form-control" rows="5" name="msg" required></textarea>
              </div>
          </div>
          <div class="modal-footer">
            <input type="submit" name="btnreply" class="btn btn-primary" value="Reply">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          </div>
          </form>
        </div>
      </div>
    </div>
    <div id="editModal" class="modal fade" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header" id="header">
            <h5 class="modal-title" style="margin:0 auto;" id="exampleModalLabel">Edit</h5>
          </div>
          <div class="modal-body">
            <form name="frm2" method="post" action="discussion.php?course=<?php echo $course; ?>">
              <div class="form-group">
                <input type="number" id="pid" name="pid" hidden>
              </div>
              <div class="form-group">
                <label for="comment">Edit your Post:</label>
                <textarea class="form-control" rows="5" name="msg" id="post" required></textarea>
              </div>
          </div>
          <div class="modal-footer">
            <input type="submit" name="btnEdit" class="btn btn-primary" value="Edit">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          </div>
          </form>
        </div>
      </div>
    </div>
    <div class="container">
      <div class="panel panel-default" style="margin-top:50px">
        <div class="panel-body">
          <h3 class="text">Discussion forum</h3>
          <hr class="horizontal">
          <form name="frm3" method="post" action="discussion.php?course=<?php echo $course; ?>">
            <input type="hidden" id="id" name="id" value="0">
            <div class="form-group">
              <input type="text" class="form-control" name="name" value="<?php echo $username; ?>" hidden>
            </div>
            <div class="form-group">
              <label for="comment" class="text">Write your question:</label>
              <textarea class="form-control" rows="5" name="msg" required></textarea>
            </div>
            <input type="submit" name="save" class="btn btn-primary mt-2" value="Send">
          </form>
        </div>
      </div>
      <div class="panel panel-default">
        <h3 class="text" style="margin-top: 50px;">Recent Questions</h3>
        <div class="panel-body" id="chat" style="height: 500px; overflow:auto" data='<?php echo $course; ?>'>

        </div>
      </div>
    </div>
  </section>
  <script type="text/javascript" src="../js/sidebar.js"></script>
  <script type="text/javascript">
    function reply(a) {
      var str = $(a).attr("data-id");
      $("#ReplyModal .modal-body #pid").val(str);
      $('#ReplyModal').modal('show');
    }

    function edit(a) {
      var str = $(a).attr("data-id");
      var content = document.getElementById(str).innerHTML;
      $("#editModal .modal-body #pid").val(str);
      $("#editModal .modal-body #post").val(content);
      $('#editModal').modal('show');
    }

    function getchat() {
      let content = document.getElementById('chat');
      courseId = content.getAttribute('data');
      jQuery.ajax({
        url: '../includes/chatting.php',
        type: 'POST',
        data: {
          'course_id': courseId
        },
        success: function(result) {
          jQuery("#chat").html(result)
        }
      });
    }
    getchat();
    setInterval(function() {
      getchat();

    }, 1000);
  </script>
  <?php include '../includes/checkDarkTheme.php'; ?>
</body>

</html>
<?php
?>
<style>
  .modal_user {
    position: fixed;
    margin: auto;
    width: 320px;
    height: 100%;
    right: 0px;
  }

  .modal_user_content {
    height: 100%;
  }

  #user {
    font: sans-serif;
  }
</style>
<div class="modal fade" id="onlineUser" role="dialog">
  <div class="modal-dialog modal_user">
    <div class="modal-content modal_user_content">
      <div class="modal-header" sytle="background-color: grey;">
        <h5 id="user" class="modal-title" style="margin:0 auto; text-align: left;" id="exampleModalLabel"><b>Online Users</b></h5>
      </div>
      <div class="modal-body" id="userData">
      </div>
    </div>
  </div>
</div>
<nav class="sidebar close">
  <header>
    <div class="image-text">
      <span class="image">
        <img src="../images/LOGO1.webp" alt="logo">
      </span>

      <div class="text logo-text">
        <span class="name">Pahadi</span>
        <span class="profession">Vidhya</span>
      </div>
    </div>
    <i class='bx bx-chevron-right toggle'></i>
  </header>
  <div class="menu-bar">
    <div class="menu">
      <li class="">
        <?php if ($role == "admin") : ?>
          <a href="../Admin/admin_dashboard.php">
          <?php elseif ($role == "teacher" || $role == "student") : ?>
            <a href="../NonAdmin/dashboard.php">
            <?php endif; ?>
            <i class='bx bx-home-alt icon'></i>
            <span class="text nav-text">Home</span>
            </a>
      </li>
      <li class="">
        <a href="<?php if(isset($_SERVER['HTTP_REFERER'])) echo $_SERVER['HTTP_REFERER']; else echo $pageName; ?>">
          <i class='bx bx-undo icon'></i>
          <span class="text nav-text">Previous</span>
        </a>
      </li>
      <li class="">
        <a href="../includes/profile.php">
          <i class='bx bx-user icon'></i>
          <span class="text nav-text">Profile</span>
        </a>
      </li>
      <li class="">
        <a href="#" data-bs-toggle="modal" data-bs-target="#onlineUser" style="color:black">
          <i class='bx bx-group icon'></i>
          <span class="text nav-text">Users</span>
        </a>
      </li>
      <?php if ($pageName == 'template.php') : ?>
        <?php if ($role == 'student') : ?>
          <li class="">
            <a href="#" onclick="getAssignment(this)" course="<?php echo $course; ?>" data-bs-toggle="modal" data-bs-target="#assignments" style="color:black">
              <i class='bx bx-bell icon'></i>
              <span class="text nav-text">Assigment</span>
            </a>
          </li>
        <?php endif; ?>
        <!-- <li class="">
          <a href="../discussion/discussion.php?course=<?php echo $courseDiscussion; ?>">
            <i class='bx bx-pie-chart-alt icon'></i>
            <span class="text nav-text">Discussion</span>
          </a>
        </li> -->
        <?php if ($role == "teacher") : ?>
          <li class="">
            <a data-bs-toggle="modal" data-bs-target="#modal1" href="#modal1">
              <i class='bx bx-plus-medical icon'></i>
              <span class="text nav-text">Add Material</span>
            </a>
          </li>
          <?php
          $secret_key = mysqli_query($conn, "SELECT `api_key`FROM `teacher` WHERE `id`='$user_id'");
          $secret_key = mysqli_fetch_array($secret_key);
          ?>
          <li class="">
            <!-- <a data-bs-toggle="modal" data-bs-target="<?php if ($secret_key['api_key']) echo '#modal2';
                                                      else echo '#modal3'; ?>" href="<?php if ($secret_key['api_key']) echo '#modal2';
                                                                                      else echo '#modal3'; ?>">
              <i class='bx bx-video icon'></i>
              <span class="text nav-text">Add Video Lecture</span>
            </a> -->
          </li>
          <li class="">
            <a href="../Attendance/attendance.php?course=<?php echo $courseDiscussion; ?>">
              <i class='bx bxs-bar-chart-alt-2 icon'></i>
              <span class="text nav-text">Attendance</span>
            </a>
          </li>
        <?php endif; ?>
      <?php endif;
      if ($role == 'admin') : ?>
        <!-- <li class="">
          <a href="../discussion/discussion.php?course=<?php echo 'admin'; ?>">
            <i class='bx bx-pie-chart-alt icon'></i>
            <span class="text nav-text">Discussion</span>
          </a>
        </li> -->
      <?php endif; ?>
    </div>
    <div class="bottom-content">
      <li class="">
        <a href="../includes/logout.php">
          <i class='bx bx-log-out icon'></i>
          <span class="text nav-text">Logout</span>
        </a>
      </li>
      <li class="mode">
        <div class="sun-moon">
          <i class='bx bx-moon icon moon'></i>
          <i class='bx bx-sun icon sun'></i>
        </div>
        <span class="mode-text text">Dark mode</span>

        <div class="toggle-switch">
          <span class="switch"></span>
        </div>
      </li>
    </div>
  </div>
  </div>
</nav>